<?php
/**
 * @file
 */

namespace JSKOS;

use JSKOS\Item;

/**
 * A JSKOS %Concordance.
 *
 * @see https://gbv.github.io/jskos/jskos.html#concordances
 */
class Concordance extends Item {
    public $mappings;
    public $schemes;

    public $fromScheme;
    public $toScheme;
}

?>
