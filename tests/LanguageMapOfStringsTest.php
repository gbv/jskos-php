<?php declare(strict_types = 1);

namespace JSKOS;

/**
 * @coversDefaultClass LanguageMapOfStrings
 */
class LanguageMapOfStringsTest extends \PHPUnit\Framework\TestCase
{
    public function testConstruct()
    {
        $map = new LanguageMapOfStrings();
        $this->assertEquals(0, count($map));
        $this->assertEquals('{}', "$map");

        $map['en'] = 'hi';
        $this->assertEquals($map, new LanguageMapOfStrings(['en'=>'hi']));
        $this->assertEquals($map, new LanguageMapOfStrings($map));

        $nonstrict = new LanguageMapOfStrings([0=>[], 'en'=>'hi']);
        $this->assertEquals($map, $nonstrict);
    }

    public function testJson()
    {
        $map = new LanguageMapOfStrings();
        foreach (['fr','es','de'] as $lang) {
            $map[$lang] = '*';
        }
        $this->assertEquals('{"de":"*","es":"*","fr":"*"}', "$map");
    }

    public function testValid()
    {
        $valid = [
            ['-','?'],
            ['en',''],
            ['en-','foo'],
        ];

        $map = new LanguageMapOfStrings();
        foreach ($valid as $test) {
            list ($key, $value) = $test;
            $map[$key] = $value;
            $this->assertEquals($value, $map[$key]);

            $this->assertEquals("{\"$key\":\"$value\"}", "$map");
            unset($map[$key]);
            $this->assertFalse(isset($map[$key]));
        }
    }

    public function testIterator()
    {
        $map = new LanguageMapOfStrings(['-'=>'?','en'=>'', 'en-'=>'foo']);
        $this->assertEquals("?foo", implode('',iterator_to_array($map)));
    }

    /**
     * @dataProvider exceptionProvider
     */
    public function testExceptions($call)
    {
        $this->expectException('InvalidArgumentException');
        $call(new LanguageMapOfStrings());
    }

    public function exceptionProvider()
    {
        return [
            [function ($map) { $map[] = 'foo'; }],
            [function ($map) { $map[1] = 'foo'; }],
            [function ($map) { $map['en'] = []; }],
        ];
    }
}
