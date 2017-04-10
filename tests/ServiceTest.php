<?php declare(strict_types=1);

namespace JSKOS;

class MyService extends \JSKOS\Service 
{
    protected $supportedParameters = ['notation'];
    public function query($request) 
    {
        return new Concept(["notation"=>$request["notation"]]);
    }  
}

class MyOtherService extends \JSKOS\Service 
{
    protected $supportedParameters = [];
    protected $supportedTypes = ['http://www.w3.org/2004/02/skos/core#Concept'];
}

/**
 * @covers \JSKOS\Service
 */
class ServiceTest extends \PHPUnit\Framework\TestCase
{
    public function testQueryFunction()
    {
        $page = new Page();
        $method = function ($q) use ($page) {
            return $page;
        };
        $service = new Service($method);
        $this->assertSame($page, $service->query([]));
    }

    public function testDefaultQueryFunction()
    {
        $service = new Service();
        $this->assertInstanceOf('\JSKOS\Page', $service->query([]));
    }

    public function testInvalidQueryFunction()
    {
        $this->expectException('InvalidArgumentException');
        $service = new Service(42);
    }

    public function testSupportParameter()
    {
        $service = new Service();
        $this->assertEquals('{?uri}', $service->uriTemplate());

        $service->supportParameter('notation');
        $this->assertEquals('{?notation}{?uri}', $service->uriTemplate());

        $this->assertEquals(['notation'=>'notation','uri'=>'uri'], $service->getSupportedParameters());
    }

    public function testInvalidSupportParameter()
    {
        $this->expectException('DomainException');
        $service = new Service();
        $service->supportParameter('callback');
    }

    public function testSupportType() 
    {
        $service = new MyOtherService();
        $this->assertEquals('{?type}{?uri}', $service->uriTemplate());
    }

    public function testInheritance() 
    {
        $service = new MyService();
        $this->assertEquals('{?notation}{?uri}', $service->uriTemplate());
        $result = $service->query(['notation'=>'abc']);
        $this->assertEquals(new Concept(['notation'=>'abc']), $result);
    }
}
