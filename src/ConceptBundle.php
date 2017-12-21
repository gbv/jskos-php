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
        'memberSet' => ['Set', 'Concept'],
        'memberList' => ['Set', 'Concept'], // FIXME
        'memberChoice' => ['Set', 'Concept'],
    ];

    use ConceptBundleTrait;

    /**
     * Returns data which should be serialized to JSON.
     * @param string $context
     * @param bool $types
     */
    public function jsonLDSerialize(string $context = self::DEFAULT_CONTEXT, bool $types = null)
    {
        if (!$this->memberSet && !$this->memberList && !$this->memberChoice) {
            $this->memberSet = new Set();
        }

        return parent::jsonLDSerialize($context, $types);
    }
}
