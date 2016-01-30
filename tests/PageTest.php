<?php

namespace JSKOS;

/**
 * @covers \JSKOS\Page
 */
class PageTest extends \PHPUnit_Framework_TestCase {
    public function testConstructor() {
        $page = new Page();
        $this->assertEquals(0,$page->totalCount);
        $this->assertEquals(1,$page->pageNum);
    }
}

?>
