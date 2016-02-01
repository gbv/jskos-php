<?php
/**
 * PHP library to implement JSKOS API.
 *
 * See Client.php for a JSKOS API Client.
 *
 * @see https://gbv.github.io/jskos-api/
 *
 * @file
 */

namespace JSKOS;

use JSKOS\Data;
use JSKOS\Error;
use JSKOS\Page;

/**
 * Query modifiers as defined by JSKOS API.
 */
const QueryModifiers = [
    "properties",
    "page","limit","unique",
    "callback",
];

/**
 * A ServiceDescription or ServiceEndpoint.
 */
interface Service {
    /**
     * @return Response
     */
    public function query($request);
}

?>
