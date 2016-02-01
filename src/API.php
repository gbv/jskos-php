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

/**
 * Receives requests and returns Records.
 *
 * Either create a subclass or provide a query function on instanciation.
 *
 */
class ServiceEndpoint implements Service {
    private $queryMethod; /**< callable */

    /**
     * List of supported query parameters.
     * @var array
     */
    protected $supportedParameters = [];

    function __construct($queryMethod=NULL) {
        if (!isset($queryMethod)) {
            $queryMethod = function() {
                return new Page();
            };
        } elseif (!is_callable($queryMethod)) {
            throw new \InvalidArgumentException('queryMethod must be callable');
        }
        $this->queryMethod = $queryMethod;

        $this->supportParameter("uri");
        $this->supportParameter("type");
    }

    /**
     * Perform a query.
     * @return Page|Record|Error
     */
    public function query($request) {
        $method = $this->queryMethod;
        return $method($request);
/*
        try {
            $response = $method($request);
        } catch ( \Exception $e ) {
            // TODO: return Error( ... )
        }
        if (!is_a('Response', $response)) {
            // TODO: return Error( ... )
        }
        return $response;
*/
    }

    /**
     * Enable support of a query parameter.
     * @param string $name
     */
    public function supportParameter($name) {
        if (in_array($name, QueryModifiers)) {
            throw new \DomainException("parameter $name not allowed");
        }
        $this->supportedParameters[$name] = $name;
    }
}

?>
