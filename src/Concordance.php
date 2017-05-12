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
    const TYPES = [
        'http://rdfs.org/ns/void#Linkset',
    ];

    const FIELDS = [
        'mappings'   => ['Set','Access'],
        'fromScheme' => 'ConceptScheme',
        'toScheme'   => 'ConceptScheme',
        'extent'     => 'string',
        'license'    => ['Set','Concept'],
    ];

    /**
     * Access to mappings in this concordance.
     */
    protected $mappings;

    /**
     * Source %Concept Scheme.
     */
    protected $fromScheme;

    /**
     * Target %Concept Scheme.
     */
    protected $toScheme;

    /**
     * Size of the concordance.
     */
    protected $extent;

    /**
     * License which the concordance is published under.
     */
    protected $license;
}
