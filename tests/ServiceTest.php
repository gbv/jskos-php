<?php

namespace JSKOS;

/**
 * @covers \JSKOS\Service
 */
class ServiceTest extends \PHPUnit_Framework_TestCase {

    public function testQueryFunction() {
        $page = new Page();
        $method = function ($q) use ($page) {
            return $page;
        };
        $service = new Service($method);
        $this->assertSame($page, $service->query([]));
    }

    public function testDefaultQueryFunction() {
        $service = new Service();
        $this->assertInstanceOf('\JSKOS\Page', $service->query([]));
    }

    public function testInvalidQueryFunction() {
        $this->setExpectedException('InvalidArgumentException');
        $service = new Service(42);
    }

    public function testSupportParameter() {
        $service = new Service();
        $this->assertEquals('{?uri}', $service->uriTemplate());

        $service->supportParameter('notation');
        $this->assertEquals('{?uri}{?notation}', $service->uriTemplate());
    }

    public function testInvalidSupportParameter() {
        $this->setExpectedException('DomainException');
        $service = new Service();
        $service->supportParameter('callback');
    }
}

?>
