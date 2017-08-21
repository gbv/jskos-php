<?php declare(strict_types = 1);

namespace JSKOS;

use InvalidArgumentException;

/**
 * @coversDefaultClass Concept
 */
class ConceptTest extends \PHPUnit\Framework\TestCase
{
    const TYPE = 'http://www.w3.org/2004/02/skos/core#Concept';

    public function testCreate()
    {
        $this->assertEquals(new Concept(), new Concept(['foo'=>'bar']));

        $concept = new Concept(); 
        $this->assertEquals($concept, new Concept($concept));
        $this->assertEquals($concept, new Concept([]));

        $concept->type = [self::TYPE];
        $this->assertEquals($concept, new Concept(json_decode("$concept")));
    }

    public function testClosed()
    {
        $concept = new Concept(); 
        $concept->narrower = [];
        $this->assertEquals(true, $concept->narrower->isClosed());

        $concept->narrower = [null];
        $this->assertEquals(false, $concept->narrower->isClosed());
    }

    public function testJson()
    {
        $concept = new Concept(['uri'=>'x:1']);
        $concept->prefLabel = ['en' => 'test'];

        $concept->narrower = [];
        $concept->narrower[] = new Concept(['uri'=>'x:2']);
        $concept->broader = [null];
        $concept->identifier = [null, 'y:1'];

        $expect = [
            '@context'  => 'https://gbv.github.io/jskos/context.json',
            'type'      => [self::TYPE],
            'uri'       => 'x:1',
            'prefLabel' => [ 'en' => 'test' ],
            'narrower'  => [ [ 'uri' => 'x:2' ] ],
            'broader'   => [ null ],
            'identifier' => [ 'y:1', null ]
        ];
        ksort($expect);
        $this->assertEquals(json_encode($expect), json_encode($concept));
    }

    public function testNested()
    {
        $concept = new Concept([ 'narrower' => [ ['uri' =>'a:b' ] ] ]);
        $expect = new Concept([
            'narrower' => new Set([ 
                new Concept(['uri' =>'a:b' ])
            ])
        ]);

        $this->assertEquals($expect, $concept);
    }

    public function testFields()
    {
        $concept = new Concept();

        foreach(['startDate','endDate','relatedDate'] as $f) {
            $concept->$f = '1984';
            $this->assertEquals($concept->$f, '1984');
        }
    }

    /**
     * @dataProvider provideExceptionTests
     */
    public function testExceptions($data)
    {
        $this->expectException(InvalidArgumentException::class);
        $concept = new Concept($data, true);
    }

    public function provideExceptionTests()
    {
        return [
            ['foo'=>'bar'],
            ['narrower'=>'yes'],
        ];
    }
}
