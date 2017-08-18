<?php declare(strict_types=1);

namespace JSKOS;

use JSKOS\PrettyJsonSerializable;

/**
 * A JSKOS API Error response.
 *
 * @see https://gbv.github.io/jskos-api/jskos-api.html#error-responses
 */
class Error extends PrettyJsonSerializable
{
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
     *
     * @todo check member constraints: code and error must be set properly
     */
    public function __construct($code, $error, $message, $description=null, $uri=null)
    {
        $this->code        = $code;
        $this->error       = $error;
        $this->message     = $message;
        $this->description = $description;
        $this->uri         = $uri;
    }
}
