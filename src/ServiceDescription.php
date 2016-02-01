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
use JSKOS\Service;

/**
 * Description of a JSKOS API Service.
 *
 * This includes pointers to Service Endpoints or embedded Records.
 */
class ServiceDescription extends Data implements Service {
    public $jskosapi = '0.0.1';
    public $title;

    public $concepts;
    public $types;
    public $schemes;
    public $mappings;

    /**
     * @return ServiceDescription|Error
     */
    public function query($response) {
        return $this;
    }
}

?>
