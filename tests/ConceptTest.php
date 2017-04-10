<?php declare(strict_types=1);

namespace JSKOS;

/**
 * @coversDefaultClass Concept
 */
class ConceptTest extends \PHPUnit\Framework\TestCase
{
    const TYPE_URI = 'http://www.w3.org/2004/02/skos/core#Concept';

    public function testTypes() 
    {
        $this->assertEquals( Concept::primaryTypes(), [ self::TYPE_URI ] );
        $this->assertEquals( Concept::defaultType(), self::TYPE_URI );
    }

    public function testCreate()
    {
        $concept = new Concept();

        $this->assertEquals($concept, new Concept($concept));
        $this->assertEquals($concept, new Concept("{}"));

        $concept->type = ['http://www.w3.org/2004/02/skos/core#Concept']; # TODO: remove
        $this->assertEquals($concept, new Concept("$concept"));
    }

    public function testJson()
    {
        $concept = new Concept(['uri'=>'x:1']);
        $concept->prefLabel['en'] = 'test';
        $concept->narrower[] = new Concept(['uri'=>'x:2']);

        $expect = [
            '@context'  => 'https://gbv.github.io/jskos/context.json',
            'type'      => ['http://www.w3.org/2004/02/skos/core#Concept'],
            'uri'       => 'x:1',
            'prefLabel' => [ 'en' => 'test' ],
            'narrower'  => [ [ 'uri' => 'x:2' ] ],
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
}
