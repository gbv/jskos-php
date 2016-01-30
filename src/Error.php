<?php
namespace JSKOS;

require_once 'Data.php';

/**
 * A JSKOS API Error response.
 */
class Error extends Data {
    public $code;
    public $error;
    public $message;
    public $description;
    public $uri;

    /**
     * Create a JSKOS API error.
     *
     * @param integer $code HTTP status code
     * @param string  $error
     * @param string  $message
     * @param string  $description
     * @param string  $uri
     */
     public function __construct($code, $error, $message, $description, $uri) {
        // TODO: make sure code and error are set
        $this->code        = $code;
        $this->error       = $error;
        $this->message     = $message;
        $this->description = $description;
        $this->uri         = $uri;
    }
}

?>
