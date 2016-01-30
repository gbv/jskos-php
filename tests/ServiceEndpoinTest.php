<?php

namespace JSKOS;

class ServiceEndpointTest extends \PHPUnit_Framework_TestCase {

    public function testQueryMethod() {
        $page = new Page();
        $method = function ($q) use ($page) {
            return $page;
        };
        $service = new ServiceEndpoint($method);
        $this->assertSame($page, $service->query([]));
    }

    public function testInvalidQueryMethod() {
        $this->setExpectedException('InvalidArgumentException');
        $service = new ServiceEndpoint(42);
    }

    public function testDefaultQueryMethod() {
        $service = new ServiceEndpoint();
        $this->assertInstanceOf('\JSKOS\Page', $service->query([]));
    }

    // TODO: test supportedParameter(s)
}

?>
