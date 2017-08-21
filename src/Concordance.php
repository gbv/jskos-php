<?php declare(strict_types = 1);

namespace JSKOS;

/**
 * A JSKOS Concordance.
 *
 * @see https://gbv.github.io/jskos/jskos.html#concordances
 */
class Concordance extends Item
{
    const TYPES = [
        'http://rdfs.org/ns/void#Linkset',
    ];

    const FIELDS = [
        'mappings'   => ['Set', 'AccessPoint'],
        'fromScheme' => 'ConceptScheme',
        'toScheme'   => 'ConceptScheme',
        'extent'     => 'string',
        'license'    => ['Set', 'Concept'],
    ];

    /**
     * AccessPoint to mappings in this concordance.
     */
    protected $mappings;

    /**
     * Source ConceptScheme.
     */
    protected $fromScheme;

    /**
     * Target ConceptScheme.
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
