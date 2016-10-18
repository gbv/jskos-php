<?php
/**
 * @file
 */

namespace Psr\Log;

/**
 * Implement a minimal PRS-3 subset if Psr\Log not available.
 */
if (!interface_exists('Psr\Log\LoggerInterface')) {
    interface LoggerInterface
    {
        public function emergency($message, array $context = []);
        public function alert($message, array $context = []);
        public function critical($message, array $context = []);
        public function error($message, array $context = []);
        public function warning($message, array $context = []);
        public function notice($message, array $context = []);
        public function info($message, array $context = []);
        public function debug($message, array $context = []);
        public function log($level, $message, array $context = []);
    }

    interface LoggerAwareInterface
    {
        public function setLogger(LoggerInterface $logger);
    }

    abstract class AbstractLogger implements LoggerInterface
    {
        public function emergency($message, array $context = [])
        {
            $this->log(__FUNCTION__, $message, $context);
        }
        public function alert($message, array $context = [])
        {
            $this->log(__FUNCTION__, $message, $context);
        }
        public function critical($message, array $context = [])
        {
            $this->log(__FUNCTION__, $message, $context);
        }
        public function error($message, array $context = [])
        {
            $this->log(__FUNCTION__, $message, $context);
        }
        public function warning($message, array $context = [])
        {
            $this->log(__FUNCTION__, $message, $context);
        }
        public function notice($message, array $context = [])
        {
            $this->log(__FUNCTION__, $message, $context);
        }
        public function info($message, array $context = [])
        {
            $this->log(__FUNCTION__, $message, $context);
        }
        public function debug($message, array $context = [])
        {
            $this->log(__FUNCTION__, $message, $context);
        }
    }
}


namespace JSKOS;

use JSKOS\Service;

/**
 * Logs errors or worse events via trigger_error.
 */
class DefaultErrorLogger extends \Psr\Log\AbstractLogger
{
    public function log($level, $message, array $context = [])
    {
        if ($level=='error' or $level=='critical' or $level=='alert' or $level=='emergency') {
            if (isset($context['exception'])) {
                $message .= "\n".$context['exception'];
            }
            trigger_error($message, E_USER_ERROR);
        }
    }
}

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
class Server implements \Psr\Log\LoggerAwareInterface
{
    /**
     * @var string $API_VERSION JSKOS-API Version of this implementation
     */
    public static $API_VERSION = '0.0.0';

    /**
     * @var Service $service
     */
    protected $service;

    /**
     * PRS-3 compliant LoggerInterface for logging.
     * @var LoggerInterface $logger
     */
    protected $logger;

    /**
     * Create a new Server.
     * @param Service $service
     */
    public function __construct(Service $service = null)
    {
        $this->service = is_null($service) ? new Service() : $service;
        $this->logger = new DefaultErrorLogger();
    }

    /**
     * Sets the current Service to service.
     * @param Service $service
     */
    public function setService(Service $service)
    {
        $this->service = $service;
    }

    /**
     * Gets the current Service.
     * @return Service
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Sets a logger for the server.
     *
     * The default logger logs errors via trigger_error.
     *
     * @param LoggerInterface $logger
     * @return null
     */
    public function setLogger(\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Returns the current logger.
     *
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * Receive request and send Response.
     */
    public function run()
    {
        $this->response()->send();
    }

    /**
     * Directly run a new server with a given Service.
     *
     * @code
     * Server::runService($service);
     * @endcode
     *
     * is equivalent to
     *
     * @code
     * $server = new Server($service);
     * $server->run();
     * @endcode
     */
    public static function runService(Service $service)
    {
        $server = new Server($service);
        $server->run();
    }

    /**
     * Extract requested languages(s) from request.
     */
    public function extractRequestLanguage($params)
    {
        $language = null;

        # get query modifier: language
        if (isset($params['language'])) {
            $language = $params['language'];
            unset($params['language']);
            # TODO: parse language
        } elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            # parse accept-language-header
            preg_match_all(
                '/([a-z]+(?:-[a-z]+)?)\s*(?:;\s*q\s*=\s*(1|0?\.[0-9]+))?/i',
                $_SERVER['HTTP_ACCEPT_LANGUAGE'],
                $match);
            if (count($match[1])) {
                foreach ($match[1] as $i => $l) {
                    if (isset($match[2][$i]) && $match[2][$i] != '') {
                        $langs[strtolower($l)] = (float) $match[2][$i];
                    } else {
                        $langs[strtolower($l)] = 1;
                    }
                }
                arsort($langs, SORT_NUMERIC);
                reset($langs);
                $language = key($langs); # most wanted language
            }
        }
        
        return $language;
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
    public function response()
    {
        $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        $params = $_GET;

        if ($method == 'OPTIONS') {
            $this->logger->info("Received OPTIONS request");
            return $this->optionsResponse();
        }

        # get query modifier: callback
        if (isset($params['callback'])) {
            $callback = $params['callback'];
            if (!preg_match('/^[$A-Z_][0-9A-Z_$.]*$/i', $callback)) {
                unset($callback);
            }
            unset($params['callback']);
        }

        $language = $this->extractRequestLanguage($params);

        # TODO: extract more query modifiers

        # TODO: header: Allow/Authentication

        $error = null;

        # conflicting parameters
        if (isset($params['uri']) and isset($params['search'])) {
            $error = new Error('422', 'request_error', 'Conflicting request parameters uri & search');
        }

        if (!$error and ($method == 'GET' or $method == 'HEAD')) {
            $this->logger->info("Received $method request", $params);

            $answer = $this->queryService($params);

            if ($answer instanceof Page) {

                // TODO: if unique

                $response = $this->basicResponse(200, $answer);
                
                // TODO: Add Link header with next/last/first

                $response->headers['X-Total-Count'] = $answer->totalCount;

                if ($method == 'HEAD') {
                    $response->emptyBody = true;
                }
            } elseif ($answer instanceof Error) {
                $error = $answer;
            }
        } elseif (!$error) {
            $error = new Error(405, '???', 'Method not allowed');
        }

        if (isset($error)) {
            $this->logger->warning($error->message, ['error' => $error]);
            $response = $this->basicResponse($error->code, $error);
        }

        if (isset($callback)) {
            $response->callback = $callback;
        }

        return $response;
    }

    /**
     * Delegate request to service.
     *
     * Makes sure that exceptions are catched.
     *
     * @return Page|Error
     */
    protected function queryService($params)
    {
        $supportedTypes      = $this->service->getSupportedTypes();
        $supportedParameters = $this->service->getSupportedParameters();
        $possibleParameters  = array_merge($supportedParameters, \JSKOS\QueryModifiers);

        # filter out queries for unsupported types
        if (count($supportedTypes) and isset($params['type'])) {
            if (!in_array($params['type'], $supportedTypes)) {
                return new Page([]);
            }
        }

        # remove unknown parameters
        foreach (array_keys($params) as $name) {
            if (!in_array($name, $possibleParameters)) {
                $this->logger->notice('Unsupported query parameter {name}', [
                    'name' => $name, 'value' => $params[$name] ]);
                unset($params[$name]);
            }
        }

        # make sure all supported query parameters exist
        foreach ($supportedParameters as $name) {
            if (!isset($params[$name])) {
                $params[$name] = null;
            }
        }

        try {
            $response = $this->service->query($params);
        } catch (\Exception $e) {
            $this->logger->error('Service Exception', ['exception' => $e]);
            return new Error(500, '???', 'Internal server error');
        }

        if (is_null($response)) {
            return new Page([]);
        } elseif ($response instanceof Item) {
            return new Page([$response]);
        } elseif ($response instanceof Page or $response instanceof Error) {
            return $response;
        } else {
            $this->logger->error('Service response has wrong type', ['response' => $response]);
            return new Error(500, '???', 'Internal server error');
        }

        return $response;
    }

    /**
     * Create a Response object with standard JSKOS-API headers.
     * @param integer $code HTTP Status code
     * @return Response
     */
    protected function basicResponse($code=200, $content=null)
    {
        return new Response(
            $code,
            [
                'Access-Control-Allow-Origin' => '*',
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
    protected function optionsResponse()
    {
        $response = $this->basicResponse();

        $response->headers['Access-Control-Allow-Methods'] = 'GET, HEAD, OPTIONS';
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']) &&
            $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'GET') {
            $response->headers['Access-Control-Allow-Origin'] = '*';
            $response->headers['Acess-Control-Expose-Headers'] = 'Link, X-Total-Count';
        }

        return $response;
    }
}
