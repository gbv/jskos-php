<?php

namespace JSKOS;

class SampleService extends ConfiguredService 
{
    public static $CONFIG_DIR = __DIR__;
    public function getConfig() 
    {
        return $this->config;
    }
}

class ConfiguredServiceTest extends \PHPUnit_Framework_TestCase
{

    public function testService()        
    {
        $service = new SampleService();

		$this->assertSame( $service->getConfig()["foo"], ['bar' => 'doz']);

		$concept = $service->queryURISpace(['notation' => '123']);
		$this->assertEquals( $concept, new Concept([ 
			'uri' => 'http://example.org/concept/123',
			'notation' => ['123']
		]));
    }
}
 
