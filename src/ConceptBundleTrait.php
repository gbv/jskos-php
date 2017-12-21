<?php declare(strict_types = 1);

namespace JSKOS;

trait ConceptBundleTrait
{

    /**
     * Set of combined concepts in this bundle (unordered).
     */
    public $memberSet;

    /**
     * List of combined concepts in this bundle (ordered).
     */
    public $memberChoice;

    /**
     * Set of concepts in this bundle to choose from.
     */
    public $memberList;
}
