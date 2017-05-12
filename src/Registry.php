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
        'concepts'     => ['Set','Access'],
        'schemes'      => ['Set','Access'],
        'types'        => ['Set','Access'],
        'mappings'     => ['Set','Access'],
        'registries'   => ['Set','Access'],
        'concordances' => ['Set','Access'],
        'extent'       => 'string',
        'languages'    => ['Listing'],
        'license'      => ['Set','Concept'],
    ];

    /**
     * Accesses to concepts schemes in this registry.
     */
    protected $concepts;

    /**
     * Accesses to concept schemes in this registry.
     */
    protected $schemes;

    /**
     * Accesses to types in this registry.
     */
    protected $types;

    /**
     * Accesses to concordances in this registry.
     */
    protected $concordances;

    /**
     * Accesses to mappings in this registry.
     */
    protected $mappings;

    /**
     * Accesses to registries in this registry.
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
