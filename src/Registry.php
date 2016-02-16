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
class Registry extends Item {
    public $concepts;
    public $schemes;
    public $types;
    public $mappings; 
    public $registries; 
    public $concordances;

    /**
     * Supported languages, given as array of language codes.
     * @var array $languages
     */
    public $languages;

}

?>
