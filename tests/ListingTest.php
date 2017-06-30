<?php declare(strict_types=1);

namespace JSKOS;

use PHPUnit\Framework\Error\Notice;
use InvalidArgumentException;

/**
 * @covers JSKOS\Listing
 */
class ListingTest extends \PHPUnit\Framework\TestCase
{
    public function testList()
    {
        $listing = new Listing();
        $this->assertEquals("[]", "$listing");
        $this->assertTrue($listing->isEmpty());
        $this->assertTrue($listing->isClosed());
        $this->assertEquals(0, count($listing));
        $this->assertFalse(isset($listing[0]));

        $listing[] = null;
        $this->assertEquals("[null]", "$listing");
        $this->assertFalse($listing->isClosed());
        $this->assertFalse($listing->isEmpty());
    }

    public function testDuplicates()
    {
        $listing = new Listing(['foo','bar','foo','doz']);
        $listing[] = 'bar';

        $this->assertEquals('foo bar doz', $listing->implode(' '));
    }

    public function testImplode()
    {
        $listing = new Listing();
        $this->assertEquals('', $listing->implode(', '));

        $listing[] = 'x';
        $listing[] = 'y';
        $this->assertEquals('x, y', $listing->implode(', '));
    }

    public function testExceptions()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('JSKOS\Listing may only contain strings');
        $listing = new Listing();
        $listing[] = new Listing();
    }
}
