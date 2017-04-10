<?php declare(strict_types=1);

namespace JSKOS;

use PHPUnit\Framework\Error\Notice;
use InvalidArgumentException;

/**
 * @covers Listing
 */
class ListingTest extends \PHPUnit\Framework\TestCase
{
    public function testList()
    {
        $list = new Listing();
        $this->assertEquals("[]", "$list");
        $this->assertTrue($list->isEmpty());
        $this->assertTrue($list->isClosed());
        $this->assertEquals(0, count($list));
        $this->assertFalse(isset($list[0]));

        $list[] = null;
        $this->assertEquals("[null]", "$list");
        $this->assertFalse($list->isClosed());
        $this->assertFalse($list->isEmpty());
    }

    public function testExceptions()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('JSKOS\Listing may only contain strings');
        $list = new Listing();
        $list[] = new Listing();
    }
} 
