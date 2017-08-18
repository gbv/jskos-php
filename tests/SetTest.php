<?php declare(strict_types=1);

namespace JSKOS;

use PHPUnit\Framework\Error\Notice;
use InvalidArgumentException;

/**
 * @covers JSKOS\Set
 */
class SetTest extends \PHPUnit\Framework\TestCase
{
    public function testEmpty()
    {
        $set = new Set();
        $this->assertEquals("[]", "$set");
        $this->assertTrue($set->isEmpty());
        $this->assertTrue($set->isClosed());
        $this->assertEquals(0, count($set));
        $this->assertFalse(isset($set[0]));

        $this->assertEquals($set, new Set([]));
    }

    public function testClosed()
    {
        $set = new Set([null]);
        $this->assertEquals("[null]", "$set");
        $this->assertFalse($set->isClosed());
        $this->assertFalse($set->isEmpty());
        $this->assertEquals(0, count($set));
        $this->assertFalse(isset($set[0]));

        $set->setClosed(true);
        $this->assertEquals($set, new Set());
        $set->setClosed(false);

        $this->assertEquals($set, new Set([null, null]));
    }

    public function testDuplicates()
    {
        $set = new Set([
            new Concept(['uri'=>'x:y']),
            new Concept(['identifier'=>'foo']),
            new Concept(['uri'=>'x:y']),
            new Concept(['uri'=>'a:b'])
        ]);
        $set[] = new Concept(['identifier'=>'foo']);
        $set[] = new Concept(['uri'=>'a:b']);

        $uris = $set->map(function($m) { return $m->uri; });
        $this->assertEquals(['x:y',null,'a:b',null], $uris);

        $this->assertTrue($set->isValid());

        $set[0]->uri = 'a:b';
        $this->assertFalse($set->isValid());
    }

    public function testFindURI()
    {
        $set = new Set();
        $this->assertEquals(null, $set->findURI('x:y'));

        $set[] = new Concept(['identifier'=>['x:y']]);
        $this->assertEquals(null, $set->findURI('x:y'));

        $concept = new Concept(['uri'=>'x:y']);
        $set[] = $concept;

        $this->assertSame($concept, $set->findURI('x:y'));
    }

    /**
     * @dataProvider provideSampleSet
     */
    public function testSetIterator($set)
    {
        $callback = function($m) { return $m->uri; };
        $expect = ['a:b',null,'x:y'];

        $uris = array_map($callback, iterator_to_array($set));
        $this->assertEquals($expect, $uris);

        $uris = $set->map($callback);
        $this->assertEquals($expect, $uris);
    }

    /**
     * @dataProvider provideSampleSet
     */
    public function testArrayAccess($set)
    {
        $this->assertEquals(new Concept(['uri'=>'a:b']), $set[0]);
        $this->assertTrue(isset($set[2]));

        $concept = new Concept(['uri'=>'foo:bar']);
        $set[1] = $concept;
        $this->assertSame($concept, $set[1]);
    }

    /**
     * @dataProvider provideSampleSet
     */
    public function testJSON($set)
    {
        $this->assertFalse(strpos('context',"$set"));
    }

    public function provideSampleSet() {
        return [ [ new Set([
            new Concept(['uri'=>'a:b']),
            new Concept(['identifier'=>['c:d']]),
            new Concept(['uri'=>'x:y']),
        ]) ] ];
    }

    /**
     * @dataProvider provideExceptionTests
     */
    public function testExceptions($set, $call, $exception, $message)
    {
        $this->expectException($exception);
        $this->expectExceptionMessage($message);
        $call($set);
    }

    public function provideExceptionTests()
    {
        $set = new Set();
        return [
            [
                new Set(),
                function($s) { $s[0]; },
                Notice::class, 'Undefined offset: 0'
            ], [
                new Set(),
                function($s) {$s[0] = 42; },
                InvalidArgumentException::class,
                'JSKOS\Set may only contain JSKOS Resources'
            ],
        ];
    }
}
