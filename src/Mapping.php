<?php
/**
 * @file
 */

namespace JSKOS;

use JSKOS\Item;

/**
 * A JSKOS %Mapping.
 *
 * @see https://gbv.github.io/jskos/jskos.html#concept-mappings
 */
class Mapping extends Object {
    public $from;
    public $to;
    public $sourceScheme;
    public $targetScheme;
    public $mappingRelevance; // experimental
}

?>
