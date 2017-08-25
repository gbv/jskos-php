<?php declare(strict_types = 1);

namespace JSKOS;

use JSKOS\PrettyJsonSerializable;

/**
 * A JSKOS Concept Bundle to be used as part of Mappings.
 *
 * @see https://gbv.github.io/jskos/jskos.html#concept-bundles
 */
class ConceptBundle extends PrettyJsonSerializable
{
    const FIELDS = [
        'members' => ['Set', 'Concept']
    ];

    /**
     * Set of concepts in this bundle.
     *
     * @var Set $members
     */
    public $members = [];

    /**
     * Whether the concepts in this bundle are ordered (list) or not (set).
     * @var boolean $ordered
     */
    public $ordered = false;

    /**
     * Whether the concepts in this bundle are combined by OR instead of AND.
     * @var boolean $disjunction
     */
    public $disjunction = false;

    /**
     * Returns data which should be serialized to JSON.
     * @param string $context
     * @param bool $types
     */
    public function jsonLDSerialize(string $context = self::DEFAULT_CONTEXT, bool $types = null)
    {
        $members = [];
        foreach ($this->members as $m) {
            $members[] = $m->jsonLDSerialize('', $types);
        }
        $json = [];
        if ($context) {
            $json['@context'] = $context;
        }
        $json['members'] = $members;
        if ($this->ordered) {
            $json['ordered'] = true;
        }
        if ($this->disjunction) {
            $json['disjunction'] = true;
        }
        return $json;
    }
}
