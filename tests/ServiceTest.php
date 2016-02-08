<?php

namespace JSKOS;

/**
 * @covers \JSKOS\Service
 */
class ServiceTest extends \PHPUnit_Framework_TestCase {

    public function testQueryMethod() {
        $page = new Page();
        $method = function ($q) use ($page) {
            return $page;
        };
        $service = new Service($method);
        $this->assertSame($page, $service->query([]));
    }

    public function testInvalidQueryMethod() {
        $this->setExpectedException('InvalidArgumentException');
        $service = new Service(42);
    }

    public function testDefaultQueryMethod() {
        $service = new Service();
        $this->assertInstanceOf('\JSKOS\Page', $service->query([]));
    }

    // TODO: test supportedParameter(s)
}

?>
