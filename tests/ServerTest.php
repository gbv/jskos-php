<?php

namespace JSKOS;

class MockLogger extends \Psr\Log\AbstractLogger {
    public $log = [];
    public function log($level, $message, array $context = []) 
    {
        $this->log[]=[$level, $message, $context];
    }
}

class MyConceptService extends \JSKOS\Service 
{
    protected $supportedTypes = ['http://www.w3.org/2004/02/skos/core#Concept'];
    public function query($request) 
    {
        if ($request['uri']) {
            return new Concept($request['uri']);
        } else {
            return;
        }
    }
}

/**
 * @covers \JSKOS\Server
 */
class ServerTest extends \PHPUnit_Framework_TestCase
{
    private $server;
    private $response;
    private $logger;

    private function newServer($service=null)
    {
        $this->server = new Server($service);
    }

    private function newLogger()
    {
        $this->logger = new MockLogger();
        $this->server->setLogger($this->logger);
    }

    private function condenseLog()
    {
        return array_map(function ($m) { 
            return "$m[0]: $m[1]"; 
        }, $this->logger->log);
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

    /**
     * @expectedException PHPUnit_Framework_Exception
     */
    public function testDefaultLogger()
    {
        $service = new Service(function($query) { throw new \Exception("!"); });
        $this->newServer($service);
        $this->getRequest();
    }

    public function testService()
    {
        $this->newServer();
        $this->assertInstanceOf('\JSKOS\Service', $this->server->getService());

        $service = new Service();
        $this->server->setService($service);
        $this->assertSame( $service, $this->server->getService() );
    }

    public function testServiceException()
    {
        $service = new Service(function($query) { throw new \Exception("!"); });
        $this->newServer($service);
        $this->newLogger();

        $this->getRequest();
        $this->assertEquals([
                "info: Received GET request",
                "error: Service Exception",
                "warning: Internal server error"
            ], $this->condenseLog()
        );
    }

    public function testServiceWrongResponse()
    {
        $service = new Service(function($query) { return 42; });
        $this->newServer($service);
        $this->newLogger();
        $this->getRequest();
        $this->assertEquals([
            "info: Received GET request",
            "error: Service response has wrong type",
            "warning: Internal server error"
            ], $this->condenseLog()
        );
        $this->assertSame(42, $this->logger->log[1][2]['response']);
    }

    public function testConceptService() 
    {
        $service = new MyConceptService();
        $this->newServer($service);

        $this->getRequest();
        $this->assertEquals(0, $this->response->headers['X-Total-Count']);

        $this->newLogger();
        $this->getRequest([],['foo' => 'bar', 'uri' => 'http://example.org/', 'page' => 1]);
        $this->assertEquals([
            "info: Received GET request",
            "notice: Unsupported query parameter {name}"
            ], $this->condenseLog()
        );
        $this->assertEquals(1, $this->response->headers['X-Total-Count']);

        $this->getRequest([],['uri' => 'http://example.org/', 'type' => 'x:unknown']);
        $this->assertEquals(0, $this->response->headers['X-Total-Count']);

        $this->getRequest([],['uri' => 'http://example.org/', 
                              'type' => 'http://www.w3.org/2004/02/skos/core#Concept']);
        $this->assertEquals(1, $this->response->headers['X-Total-Count']);
    }
}
