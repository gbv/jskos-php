<?php declare(strict_types = 1);

namespace JSKOS;

use JSKOS\Resource;

/**
 * A JSKOS Occurrence.
 *
 * @see https://gbv.github.io/jskos/jskos.html#occurrences
 */
class Occurrence extends Resource
{
    use ConceptBundleTrait;

    const FIELDS = [
        'count'         => 'NonNegativeInteger',
        'database'      => 'Item',
        'frequency'     => 'Percentage',
        'relation'      => 'URL',
        'memberSet'     => ['Set', 'Concept'],
        'memberList'    => ['Set', 'Concept'], // FIXME
        'memberChoice'  => ['Set', 'Concept'],
    ];

    /**
     * number of times the concepts are used
     */
    protected $count;

    /**
     * database in which the concepts are used
     */
    protected $database;

    /**
     * count divided by total number of possible uses
     */
    protected $frequency;

    /**
     * type of relation between concepts and entities
     */
    protected $relation;

    /**
     * URL of a page with information about the occurrence
     */
    protected $url;
}
