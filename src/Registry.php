<?php
/**
 * @file
 */

namespace JSKOS;

use JSKOS\Item;

/**
 * A JSKOS %Registry.
 *
 * @see https://gbv.github.io/jskos/jskos.html#registries
 */
class Registry extends Item
{

    /**
     * Set of concepts in this registry or JSKOS API endpoint.
     *
     * @var URL|Set $concepts
     */
    public $concepts;

    /**
     * Set of concept schemes in this registry or JSKOS API endpoint.
     *
     * @var URL|Set $schemes
     */
    public $schemes;

    /**
     * Set of concordances in this registry or JSKOS API endpoint.
     *
     * @var URL|Set $types
     */
    public $types;

    /**
     * Set of concordances in this registry or JSKOS API endpoint.
     *
     * @var URL|Set $concordances
     */
    public $concordances;

    /**
     * Set of mappings in this registry or JSKOS API endpoint.
     *
     * @var URL|Set $mappings
     */
    public $mappings;

    /**
     * Set of registries in this registry or JSKOS API endpoint.
     *
     * @var URL|Set $registries
     */
    public $registries;

    /**
     * Supported languages, given as array of language codes.
     *
     * @var List $languages
     */
    public $languages;

    /**
     * License which the registry is published under.
     *
     * @var URI $license
     */
    public $license;
}
