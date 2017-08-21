<?php declare(strict_types = 1);

namespace JSKOS;

/**
 * @covers \JSKOS\Container
 */
class ContainerTest extends \PHPUnit\Framework\TestCase
{
    public function testContainer() 
    {
        foreach (['Set', 'Listing', 'LanguageMapOfStrings', 'LanguageMapOfLists'] as $class) {
            $class = "JSKOS\\$class";
            $container = new $class();
            $this->assertTrue($container->isEmpty());
            $this->assertTrue($container->isClosed());
            $this->assertEquals(0, count($container));
            $this->assertEquals(0, $container->count());
        } 
    }
}
