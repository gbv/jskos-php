<?php declare(strict_types=1);

namespace JSKOS;

use JSKOS\Item;

/**
 * A JSKOS %Access.
 *
 * @see https://gbv.github.io/jskos/jskos.html#accesses
 */
class Access extends Item
{
    const FIELDS = [
        'set' => ['Set','Concept'],
        'download' => 'URL',
    ];

    /**
     * Set of JSKOS Concepts, Mappings, or other objects.
     */
    protected $set;

    /**
     * An URL to download JSKOS data (<http://schema.org/downloadUrl>).
     */
    protected $download;
}
