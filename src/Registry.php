<?php declare(strict_types=1);

namespace JSKOS;

use JSKOS\Item;

/**
 * A JSKOS %Registry.
 *
 * @see https://gbv.github.io/jskos/jskos.html#registries
 */
class Registry extends Item
{
    const FIELDS = [
        # TODO: concepts, schemes, types, mappings, registries, concordances
        'extent'    => 'string',
        'languages' => ['Listing'],
        'license'   => ['Concept','Concept'],
    ];

    /**
     * Set of concepts in this registry or JSKOS API endpoint.
     */
    public $concepts;

    /**
     * Set of concept schemes in this registry or JSKOS API endpoint.
     */
    public $schemes;

    /**
     * Set of concordances in this registry or JSKOS API endpoint.
     */
    public $types;

    /**
     * Set of concordances in this registry or JSKOS API endpoint.
     */
    public $concordances;

    /**
     * Set of mappings in this registry or JSKOS API endpoint.
     */
    public $mappings;

    /**
     * Set of registries in this registry or JSKOS API endpoint.
     */
    public $registries;

    /**
     * Supported languages, given as array of language codes.
     */
    protected $languages;

    /**
     * Size of the registry
     */
    protected $extent;

    /**
     * License which the registry is published under.
     */
    protected $license;
}
