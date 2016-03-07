<?php
/**
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
 * JSKOS API backend class.
 *
 * A %Service can be queried with a set of query parameters to return a Page
 * or Error. To actually implement JSKOS API, create a Server that passes HTTP
 * requests to the %Service. To implement a %Service, either provide a query 
 * function on instanciation:
 *
 * @code
 * $service = new Service(function($query) { ... });
 * $server = new Server($service);
 * $server->run();
 * @endcode
 *
 * Or create a subclass that overrides the query method and possibly the
 * supportedParameters member variable:
 *
 * @code
 * class MyService extends \JSKOS\Service {
 *     
 *     protected $supportedParameters = [...];
 *
 *     public function query($request) {
 *         ...
 *     }  
 *
 * }
 * @endcode
 *
 * Each %Service can be configured to support specific query parameters, in 
 * addition to the mandatory parameter `uri`. The list of supported parameters
 * can be returned as URI Template.
 *
 * @code
 * $service->supportParameter('notation');
 * $service->uriTemplate(); # '{?uri}{?notation}'
 * @endcode
 *
 * @see Server
 */
class Service
{
    private $queryFunction; /**< callable */

    /**
     * List of supported query parameters.
     * @var array
     */
    protected $supportedParameters = [];

    /**
     * Create a new service.
     */
    public function __construct($queryFunction=null)
    {
        if (!isset($queryFunction)) {
            $queryFunction = function () {
                return new Page();
            };
        } elseif (!is_callable($queryFunction)) {
            throw new \InvalidArgumentException('queryFunction must be callable');
        }
        $this->queryFunction = $queryFunction;
        $this->supportParameter('uri');
    }

    /**
     * Perform a query.
     *
     * @return Page|Error
     */
    public function query($request)
    {
        $method = $this->queryFunction;
        # TODO: check whether result is actually a Page or Error
        return $method($request);
    }

    /**
     * Enable support of a query parameter.
     * @param string $name
     */
    public function supportParameter($name)
    {
        if (in_array($name, QueryModifiers)) {
            throw new \DomainException("parameter $name not allowed");
        }
        $this->supportedParameters[$name] = $name;
    }

    /**
     * Get a list of query parameters as URI template.
     *
     * @return string
     */
    public function uriTemplate($template='')
    {
        asort($this->supportedParameters);
        foreach ($this->supportedParameters as $name) {
            $template .= "{?$name}";
        }
        return $template;
    }
}
