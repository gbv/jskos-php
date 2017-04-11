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
    const FIELDS = [
        # TODO: mappings, fromScheme, toScheme
        'license' => ['Set','Concept'],
    ];

    /**
     * Set of mappings in this concordance or JSKOS API endpoint.
     */
    public $mappings;

    /**
     * Source %Concept Scheme.
     */
    public $fromScheme;

    /**
     * Target %Concept Scheme.
     */
    public $toScheme;

    /**
     * Size of the concordance.
     */
    public $extent;

    /**
     * License which the concordance is published under.
     */
    protected $license;
}
