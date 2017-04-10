<?php declare(strict_types=1);

namespace JSKOS;

use JSKOS\Item;

/**
 * A JSKOS %Concordance.
 *
 * @see https://gbv.github.io/jskos/jskos.html#concordances
 */
class Concordance extends Item
{

    /**
     * Set of mappings in this concordance or JSKOS API endpoint.
     *
     * @var URL|Set $mappings
     */
    public $mappings;

    /**
     * Source %Concept Scheme.
     *
     * @var ConceptScheme $fromScheme
     */
    public $fromScheme;

    /**
     * Target %Concept Scheme.
     *
     * @var ConceptScheme $toScheme
     */
    public $toScheme;

    /**
     * Size of the concordance.
     * @var string $extent
     */
    public $extent;

    /**
     * License which the concordance is published under.
     *
     * @var Set $license
     */
    public $license;
}
