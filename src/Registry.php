<?php declare(strict_types = 1);

namespace JSKOS;

use JSKOS\Item;

/**
 * A JSKOS Registry.
 *
 * @see https://gbv.github.io/jskos/jskos.html#registries
 */
class Registry extends Item
{
    const TYPES = [
        'http://purl.org/cld/cdtype/CatalogueOrIndex'
    ];

    const FIELDS = [
        'concepts'     => ['Set', 'AccessPoint'],
        'schemes'      => ['Set', 'AccessPoint'],
        'types'        => ['Set', 'AccessPoint'],
        'mappings'     => ['Set', 'AccessPoint'],
        'registries'   => ['Set', 'AccessPoint'],
        'concordances' => ['Set', 'AccessPoint'],
        'occurrences'  => ['Set', 'AccessPoint'],
        'extent'       => 'string',
        'languages'    => ['Listing'],
        'license'      => ['Set', 'Concept'],
    ];

    /**
     * AccessPoints to concepts schemes in this registry.
     */
    protected $concepts;

    /**
     * AccessPoints to concept schemes in this registry.
     */
    protected $schemes;

    /**
     * AccessPoints to types in this registry.
     */
    protected $types;

    /**
     * AccessPoints to concordances in this registry.
     */
    protected $concordances;

    protected $occurrences;

    /**
     * AccessPoints to mappings in this registry.
     */
    protected $mappings;

    /**
     * AccessPoints to registries in this registry.
     */
    protected $registries;

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
