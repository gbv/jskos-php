<?php declare(strict_types=1);

namespace JSKOS;

/**
 * @covers \JSKOS\Page
 */
class PageTest extends \PHPUnit\Framework\TestCase
{
    public function testConstructor()
    {
        $page = new Page();
        $this->assertEquals(0, $page->totalCount);
        $this->assertEquals(1, $page->pageNum);
    }
}
