<?php

namespace JSKOS;

class MockLogger extends \Psr\Log\AbstractLogger {
    public $log = [];
    public function log($level, $message, array $context = []) {
        $this->log[]=[$level, $message, $context];
    }
}

/**
 * @covers \JSKOS\Server
 */
class ServerTest extends \PHPUnit_Framework_TestCase
{
    private $server;
    private $response;

    private function newServer($service=null) {
        $this->server = new Server($service);
    }

    private function getRequest($headers=[], $params=[])
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        foreach ($headers as $name => $value) {
            $_SERVER['HTTP_'.$name] = $value;
        }
        $_GET = $params;

        $this->response = $this->server->response();
    }

    private function assertResponse($status, $headers, $body)
    {
        $this->assertEquals($status, $this->response->status);
        $this->assertEquals($headers, $this->response->headers);
        $this->assertEquals($body, $this->response->getBody());
    }


    public function testSomeRequest()
    {
        $this->newServer();
        $this->getRequest();

        $headers = [
            'X-JSKOS-API-Version' => '0.0.0',
            'X-Total-Count' => 0,
            'Link-Template' => '<{?uri}>; rel="search"',
            # TODO: Link: rel="collection" to concept scheme or registry
        ];
        $this->assertResponse(200, $headers, '[]');

        $this->getRequest([],['callback' => 'abc']);
        $this->assertResponse(200, $headers, '/**/abc([]);');
    }

    public function testLogging() 
    {
        $logger = new MockLogger();

        $this->newServer();
        $this->server->setLogger($logger);
        $this->assertSame($logger, $this->server->getLogger());

        $this->getRequest();
        $this->assertEquals([
            ["info","Received GET request",[]]
        ],$logger->log);
    }

}
