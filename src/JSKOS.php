<?php
/**
 * PHP library to access and serve JSKOS data and services.
 *
 * @file
 */

namespace JSKOS;

/**
 * A list of records in a possibly larger result set.
 */
class Page {
    public $records;    // @var array
    public $pageNum;    // @var integer
    public $pageSize;   // @var integer
    public $totalCount; // @var integer

    function __construct($records=[], $pageSize=0, $pageNum=1, $totalCount=0) {
        $this->records  = $records;
        $this->pageNum  = $pageNum;
        $this->pageSize = $pageSize;

        $count = count($records);

        $totalCount = max($totalCount, ($pageNum-1)*$pageSize + $count);
        $this->totalCount = $totalCount;

        if ($pageSize == 0) {
            if ($pageNum == 1) {
                $pageSize = max($pageSize, $count);
            } elseif($count > $pageSize) {
                $records = array_slice($records, 0, $pageSize);
            } 
        }
    }
}

class Record {
    public $jskos;

    function __construct($jskos) {
        $this->jskos = $jskos;
    }
}

/**
 * A JSKOS Server.
 *
 * Example:
 * @code
 * my $server = new Server();
 * $server->setBackend( function(...) { ... } );
 * $server->run();
 * @endcode
 *
 */
class Server {

    /**
     * Query modifiers as defined by JSKOS API.
     */
    const QueryModifiers = [
        "properties",
        "page","limit","unique",
        "callback",
    ];

    /**
     * List of enableed query parameters.
     * @var array
     */
    protected $enabledParameters = [];

    /**
     * Backend query function to use.
     */
    protected $backend;

    /**
     * Create a new Server.
     */
    function __construct() {
        $this->enableParameter("uri");
        $this->enableParameter("type");
    }


    /**
     * Set the backend function to be used in this server.
     */
    public function setBackend($backend) {
        $this->backend = $backend;
    }

    /**
     * Enable support of a query parameter.
     */
    public function enableParameter($name) {
        if (!in_array($name, QueryModifiers)) {
            throw new Exception("parameter '$name' not allowed");
        }
        $this->enabledParameters[$name] = $name;
    }

    /**
     * Receive request and send response.
     */
    public function run() {
        $method = $_SERVER['REQUEST_METHOD'];

        // TODO: request parameters and headers
        $params = $_GET;
        $callback = ""; // TODO
        // header: Accept-Language
        // header: Allow/Authentication

        if ($method == 'GET') {
            $response = $this->request($params);
            if (isset($response["count"])) {
                header("X-Total-Count: ".$response["count"]);
            }
            // TODO: next/last/first
            $this->sendJSON(200, $response["jskos"], $callback);
        } elseif ($method == 'OPTIONS') {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']) && 
                $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'GET') {
                header("Access-Control-Allow-Origin: *");
                header("Acess-Control-Expose-Headers: Link X-Total-Count");
           }
        } else {
            $error = $this->buildError(405, "Method not allowed");
            $this->sendJSON($error["code"], $error, $callback);
        }
    }

    /**
     * Receive a GET request and build a response.
     * Response may be a JSKOS\Page, or JSKOS\Record (Mapping, Concept...)
     * May throw an exception.
     */
    public function request($params) { 
        return new Page(0,0,[]);
    }

    /**
     * Sends the actual HTTP response (JSON).
     *
     * @param integer $code
     * @param object  $data
     */
    public function sendJSON($code, $data, $callback=null) {
        http_response_code($code);

        if ($callback) {
            header('Content-Type: application/javascript; charset=utf-8');
            echo "/**/$callback(".json_encode($data).");";
        } else {
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }

    /**
     * Build an error response.
     *
     * @param integer $code HTTP status code
     * @param string  $error
     * @param string  $message
     * @param string  $description
     * @param string  $uri
     * @param object
     */
    public function buildError($code, $error, $message, $description, $uri) {
        $response = [
            "code" => $code,
            "error" => $error
        ];
        if (isset($message))     $response["message"]     = $message;
        if (isset($description)) $response["description"] = $description;
        if (isset($uri))         $response["uri"]         = $uri;
        return $response;
    }
}

// !EOF : JSKOS.php
?>
