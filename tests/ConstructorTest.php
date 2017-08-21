<?php declare(strict_types = 1);

namespace JSKOS;

/**
 * @covers \JSKOS\Constructor
 */
class ConstructorTest extends \PHPUnit\Framework\TestCase
{
    public function testConstructor() 
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('JSKOS\Concept constructor expects array, object, or null');
        $concept = new Concept(42);
    }
}
