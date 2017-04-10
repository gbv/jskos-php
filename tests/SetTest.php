<?php declare(strict_types=1);

namespace JSKOS;

use PHPUnit\Framework\Error\Notice;
use InvalidArgumentException;

/**
 * @covers Set
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

    public function testFindURI()    
    {
        $set = new Set();
        $this->assertEquals(null, $set->findURI('x:y'));

        $set[] = new Concept(['identifiers'=>['x:y']]);
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
        $uris = array_map(function($m) { return $m->uri; }, iterator_to_array($set));
        $this->assertEquals(['a:b',null,'x:y'], $uris);
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
            new Concept(['identifiers'=>['c:d']]),
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
                'JSKOS\Set may only contain JSKOS Objects'
            ],
        ];
    }
} 
