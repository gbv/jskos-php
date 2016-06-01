<?php

namespace JSKOS;

/**
 * This JSKOS Service can be queried by URI and (optionally) Notation. A
 * JSKOS Item of predefined type (Concept, ConceptScheme...) is returned
 * if the requested URI matches a given prefix and an optional notation 
 * suffix or if the requested notation looks valid.
 */
class URISpaceService extends Service
{
    private $config = [];

    protected $supportedParameters = ['notation'];

    /**
     * Create a new URISpaceService based on configurations. 
     *
     * Configuration for each JSKOS class consists of the mandatory
     * field "uriSpace" and the optional fields "notationPattern" and 
     * "notationNormalizer".
     */
    public function __construct(array $config)
    {
        foreach ($config as $type => $typeConfig) {
            if (!$typeConfig['uriSpace']) {
                throw new \Exception('Missing field uriSpace');
            } else {
                // TODO: syntax check (URI-look-alike)
            }
            if (!class_exists("JSKOS\\$type")) {
                throw new \Exception("Class JSKOS\\$type not found!");
            }
            if (!isset($typeConfig['notationPattern'])) {
                $typeConfig['notationPattern'] = '/.*/';
            }
            if (isset($typeConfig['notationNormalizer'])) {
                // THIS CAN BE A SECURITY ISSUE!
                $normalizer = $typeConfig['notationNormalizer'];
                if (!function_exists($normalizer)) {
                    throw new \Exception("Function $normalizer not found!");
                }
            } else {
                $typeConfig['notationNormalizer'] = null;
            }
            $this->config[$type] = [
                'uriSpace'           => $typeConfig['uriSpace'],
                'notationPattern'    => $typeConfig['notationPattern'],
                'notationNormalizer' => $typeConfig['notationNormalizer'],
            ];
        }
    }

    public function query($query)
    {
        $class  = null;

        if (isset($query['uri']) and $query['uri'] !== "") {
            foreach ($this->config as $type => $config) {
                // request URI matches uriSpace
                if (strpos($query['uri'], $config['uriSpace']) === 0) {
                    $uri      = $query['uri'];
                    $notation = substr($uri, strlen($config['uriSpace']));

                    if (!preg_match($config['notationPattern'], $notation)) {
                        return;
                    }

                    if ($config['notationNormalizer']) {
                        $notation = $config['notationNormalizer']($notation);
                    }

                    if (!$notation and $notation !== '0') {
                        unset($notation);
                    }

                    $class = "JSKOS\\$type";

                    break;
                }
            }
            if (!isset($uri)) {
                return;
            }
        }

        if (isset($query['notation']) and $query['notation'] !== "") {
            if (isset($notation)) {
                if ($query['notation'] != $notation) {
                    // requested notation and uri do not match 
                    return;
                }
            } else {
                foreach ($this->config as $type => $config) {
                    if (preg_match($config['notationPattern'], $query['notation'])) {
                        $notation = $query['notation'];
                        if ($config['notationNormalizer']) {
                            $notation = $config['notationNormalizer']($notation);
                        }

                        $class = "JSKOS\\$type";

                        if (!isset($uri)) {
                            $uri = $config['uriSpace'] . $notation;
                        }
                        break;
                    }
                }
                if (!isset($notation)) {
                    return;
                }
            }
        }
        
        if ($class and isset($uri)) {
            if (isset($notation)) {
                return new $class(['uri' => $uri, 'notation' => [$notation]]);
            } else {
                return new $class(['uri' => $uri]);
            }
        }
    }
}
