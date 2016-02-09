<?php

namespace JSKOS;

/**
 * @covers \JSKOS\Server
 */
class ServerTest extends \PHPUnit_Framework_TestCase {

    protected function assertResponse($response, $status, $headers, $body) {
        $this->assertEquals($status, $response->status); 
        $this->assertEquals($headers, $response->headers);
        $this->assertEquals($body, $response->getBody());
    }

    public function testSomeRequest() {
        $server = new Server();

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = '';
        $_GET = [];
        $response = $server->response(); 

        $this->assertResponse($response, 200, 
            ['X-JSKOS-API-Version' => '0.0.0'],
            '[]'
        );

        $_GET = ['callback' => 'abc'];
        $response = $server->response(); 
        $this->assertResponse($response, 200, 
            ['X-JSKOS-API-Version' => '0.0.0'],
            '/**/abc([]);'
        );
    }
}

?>
