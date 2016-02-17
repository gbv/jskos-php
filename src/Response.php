<?php
/**
 * @file
 */

namespace JSKOS;

use JSKOS\PrettyJsonSerializable;

/**
 * A HTTP Response with JSON/JSONP data.
 */
class Response {

   /**
    * @var integer
    */
    public $status;

   /**
    * @var array
    */
    public $headers;

   /**
    * @var string
    */
    public $content;

   /**
    * @var boolean
    */
    public $emptyBody;

   /**
    * @var string
    */
    public $callback;

    /**
     * Create a new response.
     */
    public function __construct($status=200, $headers=[], PrettyJsonSerializable $content=NULL, $callback=NULL) {
        $this->status = $status;
        $this->headers = $headers;
        $this->content = $content;
        $this->emptyBody = FALSE;
        $this->callback = $callback;
    }

    /**
     * Send HTTP headers and content as string.
     */
    public function send() {

        if ($this->callback) {
            $this->headers['Content-Type'] = 'application/javascript; charset=utf-8';
        } else {
            $this->headers['Content-Type'] = 'application/json';
        }

        if (!is_null($this->content)) {
     
            # TODO: catch exception
            $body = $this->getBody(); 
            
            $this->headers['Content-Length'] = strlen($body);

            if ($this->emptyBody) {
                unset($body);
            }
        }
        
        $this->sendHeaders();

        if (isset($body)) {
            echo $body;
        }
    }

    /**
     * Get the response body as string.
     *
     * @return string
     */
    public function getBody() {
        if ($this->callback) {
            return "/**/".$this->callback."(".$this->content.");";
        } else {
            return (string)$this->content->json();
        }
    }

    /**
     * Sent HTTP headers and HTTP response code.
     */
    protected function sendHeaders() {
        http_response_code($this->status);
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }
    }
}

?>
