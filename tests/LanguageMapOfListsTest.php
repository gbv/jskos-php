<?php declare(strict_types = 1);

namespace JSKOS;

/**
 * @coversDefaultClass LanguageMapOfLists
 */
class LanguageMapOfListsTest extends \PHPUnit\Framework\TestCase
{
    public function testConstruct()
    {
        $map = new LanguageMapOfLists();
        $this->assertEquals(0, count($map));
        $this->assertEquals('{}', "$map");
    }

    public function testValid()
    {
        $valid = [
            ['-',['?']],
            ['en',[null]],
            ['en-',['foo','bar']],
        ];

        $map = new LanguageMapOfLists();
        foreach ($valid as $test) {
            list ($key, $value) = $test;
            $list = new Listing($value);
            $map[$key] = $value;
            $this->assertEquals($list, $map[$key]);
            $this->assertEquals("{\"$key\":$list}", "$map");

            unset($map[$key]);
            $this->assertFalse(isset($map[$key]));
        }
    }

    public function testExceptions()
    {
        $this->expectException('InvalidArgumentException');
        $map = new LanguageMapOfLists();
        $map['en'] = 123;
    }
}
