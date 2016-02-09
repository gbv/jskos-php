<?php
/**
 * @file
 */

namespace JSKOS;

use JSKOS\Service;

/**
 * A JSKOS Server.
 *
 * Serves a Service via HTTP.
 *
 * Example:
 * @code
 * $service = new Service();
 * $server = new Server($service);
 * $server->run();
 * @endcode
 */
class Server {

    /**
     * @var string $API_VERSION JSKOS-API Version of this implementation
     */
    public static $API_VERSION = '0.0.0';

    /**
     * @var Service $service
     */
    protected $service;

    /**
     * Create a new Server.
     * @param Service $service
     */
    function __construct(Service $service = NULL) {
        $this->service = is_null($service) ? new Service() : $service;
    }

    /**
     * Receive request and send Response.
     */
    public function run() {
       $this->response()->send();
    }

    /**
     * Receive request and create a Response.
     *
     * This is the core method implementing basic parts of JSKOS API.
     * The method handles HTTP request method, request headers and 
     * [query modifiers](https://gbv.github.io/jskos-api/#query-modifiers),
     * passes valid GET and HEAD requests to the served Service and wraps
     * the result as Response.
     *
     * @return Response
     */
    public function response() {
        $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        $params = $_GET;

        if ($method == 'OPTIONS') {
            return $this->optionsResponse();
        }

        # get query modifiers
        if (isset($params['callback'])) {
            $callback = $params['callback'];
            if (!preg_match('/^[$A-Z_][0-9A-Z_$.]*$/i', $callback)) {
                unset($callback);
            }
            unset($params['callback']);
        }

        if (isset($params['language'])) {
            $language = $params['language'];
            unset($params['language']);
        } elseif(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
            # TODO: parse and map q's to preference list
        }

        // TODO: header: Allow/Authentication

        if ($method == 'GET' or $method == 'HEAD') {

            # TODO: route?
            $page = $this->service->query($params);

            // TODO: if unique

            // TODO: unique
            // TODO: Link header with next/last/first
            // TODO: Link header with URI template of suppo       

            $response = $this->basicResponse(200, $page);
            $response->headers['X-Total-Count'] = $page->totalCount;

            if ($method == 'HEAD') {
                $response->emptyBody = TRUE;
            }
        } else {
            error_log("Method not allowed: $method");
            # TODO: HEAD request
            # TODO: clean error object
            $response = $this->basicResponse(
                405,
                [],
                new Error(405,'','Method not allowed')
            );
        }

        if (isset($callback)) {
            $response->callback = $callback;
        }
        return $response;
    }

    /**
     * Create a Response object with standard JSKOS-API headers.
     * @param integer $code HTTP Status code
     * @return Response
     */
    protected function basicResponse($code=200, $content=NULL) {
        return new Response(
            $code,
            [
                'X-JSKOS-API-Version' => self::$API_VERSION,
                'Link-Template' => '<'.$this->service->uriTemplate().'>; rel="search"',
            ],
            $content
        );
    }

    /**
     * Respond to a HTTP OPTIONS request.
     * @return Response
     */
    protected function optionsResponse() {
        $response = $this->basicResponse();

        $response->headers['Access-Control-Allow-Methods'] = 'GET, HEAD, OPTIONS';
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']) && 
            $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'GET') {
            $response->headers['Access-Control-Allow-Origin'] = '*';
            $response->headers['Acess-Control-Expose-Headers'] = 'Link X-Total-Count';
        }

        return $response;
    }
}

?>
