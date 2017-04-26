<?php declare(strict_types=1);

namespace JSKOS;

/**
 * @coversDefaultClass Item
 */
class ItemTest extends \PHPUnit\Framework\TestCase
{
    public function testLabels()
    {
        $item = new Concept();
        $this->assertEquals(null, $item->prefLabel);

        $item->prefLabel = [];
        $expect = new LanguageMapOfStrings();
        $this->assertEquals($expect, $item->prefLabel);

        $item->prefLabel['en'] = 'foo';
        $expect = new LanguageMapOfStrings(['en'=>'foo']);
        $this->assertEquals($expect, $item->prefLabel);

        $copy = new Concept($item);
        $this->assertEquals($expect, $copy->prefLabel);

        $item->altLabel['en'] = ['foo',null]; # FIXME: expect warning
        $this->assertEquals(null, $item->altLabel);

        $item->altLabel = [];
        $item->altLabel['en'] = ['foo',null];
        $expect = new LanguageMapOfLists(['en'=>['foo',null]]);
        $this->assertEquals($expect, $item->altLabel);
    }
}
