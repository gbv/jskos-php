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

/**
 * Query modifiers as defined by JSKOS API.
 */
const QueryModifiers = [
    "properties",
    "expand",
    "page","limit","unique",
    "callback",
];

/**
 * Receives requests and returns Records.
 *
 * Either create a subclass or provide a query function on instanciation.
 *
 */
class Service {
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
