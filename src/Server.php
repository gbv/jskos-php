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
    public static $API_VERSION = '0.0.0';

    protected $service; /**< Service */

    /**
     * Create a new Server.
     * @param Service $service
     */
    function __construct(Service $service) {
        $this->service = $service;
    }

    /**
     * Receive request and send response.
     *
     * This is the core method implementing basic parts of JSKOS API.
     * The method handles HTTP request method, request headers and 
     * [query modifiers](https://gbv.github.io/jskos-api/#query-modifiers),
     * passes valid GET requests to Server::request and sends the result
     * in JSON with appropriate HTTP response headers.
     */
    public function run() {
        $method = $_SERVER['REQUEST_METHOD'];
        $params = $_GET;

        if ($method == 'OPTIONS') {
            $this->sendOptionsResponse();
            return;
        }

        # get query modifiers
        
        if (isset($params['callback'])) {
            $callback = $params['callback']; 
            delete($params['callback']);
        }

        if (isset($params['language'])) {
            $language = $params['language'];
            delete($params['language']);
        } else {
            # TODO: parse and map q's to preference list
            $language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        }

        // TODO: header: Allow/Authentication

        if ($method == 'GET') {

            # TODO: route?
            $page = $this->request($params);

            // TODO: if unique

            header("X-Total-Count: ".$page->totalCount);

            // TODO: unique
            // TODO: Link header with next/last/first
            // TODO: Link header with URI template of suppo       
            $response = $page;

        } else {
            # TODO: HEAD request
            $response = new Error(405,'Method not allowed');
        }

        $this->sendResponse($response, $callback);
    }

    /**
     * Send standard JSKOS-API headers.
     * @param integer $code HTTP Status code
     */
    protected function sendStandardHeaders($code) {
        http_response_code($code);
        header("X-JSKOS-API-Version: $this->API_VERSION");
    }

    /**
     * Send response to a HTTP OPTIONS request.
     */
    protected function sendOptionsResponse() {
        $this->sendStandardHeaders(200);
        header("Access-Control-Allow-Methods: GET, HEAD, OPTIONS");
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']) && 
            $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'GET') {
            header("Access-Control-Allow-Origin: *");
            header("Acess-Control-Expose-Headers: Link X-Total-Count");
        }
        return;
    }

    /**
     * Send the actual HTTP response in JSON format.
     * @param Response $response
     * @param string $callback
     */
    protected function sendJSONResponse($response, $callback) {
        $code = isa_a('\JSKOS\Error',$response) ? $response->code : 200;
        $this->sendStandardHeaders($code);

        if ($callback) {
            header('Content-Type: application/javascript; charset=utf-8');
            echo "/**/$callback(".$response->json.");";
        } else {
            header('Content-Type: application/json');
            echo $response->json;
        }
    }
}

?>
