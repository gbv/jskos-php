<?php
/**
 * Implements a basic JSKOS concepts endpoint for Wikidata.
 *
 * This wrapper converts Wikidata JSON format to JSKOS.
 *
 * @package JSKOS
 */

include_once realpath(__DIR__.'/..') . '/src/JSKOS.php';

use JSKOS\Service, JSKOS\Server, JSKOS\Concept, JSKOS\Page;

$wrapper = function($query) {

    if (isset($query['uri'])) {
        if (preg_match('/^http:\/\/www\.wikidata\.org\/entity\/([PQ][0-9]+)$/', $query['uri'], $match)) {
            $id = $match[1];
        }
    }
        
    if (isset($query['notation'])) {
        if (preg_match('/^[QP][0-9]+$/i', $query['notation'])) {
            $notation = strtoupper($query['notation']);
            if (isset($id) and $id != $notation) {
                unset($id);
            } else {
                $id = $notation;
            }
        }
    }

    if (isset($id)) {
        try {
            $json = @file_get_contents("https://www.wikidata.org/wiki/Special:EntityData/$id.json");
            $data = @json_decode($json);
            $data = $data->entities->{$id};
        } catch (Exception $e) {
            error_log($e);
        }
    }

    if (!isset($data)) {
        return new Page();
    }

    $concept = new Concept(["uri" => "http://www.wikidata.org/entity/$id"]);
    $concept->modified = $data->modified;
    
    foreach ($data->labels as $language => $value) {
        $concept->prefLabel[$language] = $value->value;
    }

    foreach ($data->descriptions as $language => $value) {
        $concept->scopeNote[$language] = $value->value;
    }

    foreach ($data->aliases as $language => $values) {
        foreach ($values as $value) {
            $concept->altLabel[$language][] = $value->value;
        }
    }
    
    # TODO: type (item or property) wikibase:Item / wikibase:Property
    
    # TODO: more claims

    # depiction
    if (isset($data->claims->P18)) {
        # TODO: only use "truthy" statements
        foreach ($data->claims->P18 as $statement) {
            $snak = $statement->mainsnak;
            if ($snak->datatype == "commonsMedia") {
                $concept->depiction = "http://commons.wikimedia.org/wiki/Special:FilePath/"
                    . rawurlencode($snak->datavalue->value);
            }
        }
    }

    # subclass of (TODO: reverse)
    if (isset($data->claims->P279)) {
        foreach ($data->claims->P279 as $statement) {
            $snak = $statement->mainsnak;
            if ($snak->datatype == "wikibase-item") {
                $id = $snak->datavalue->value->{'numeric-id'};
                $concept->broader[] = new Concept(["uri" => "http://www.wikidata.org/entity/$id"]);
            }
        }
    }


    # TODO: sitelinks

    return new Page([$concept]); # TODO: support returning a single Concept
};

$service = new Service($wrapper);

$service->supportParameter('notation');

$server = new Server($service);
$server->run();

