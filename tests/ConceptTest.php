<?php

namespace JSKOS;

/**
 * @covers \JSKOS\Concept
 */
class ConceptTest extends \PHPUnit_Framework_TestCase {

    public function testCreate() {
        $concept = new Concept();

        $this->assertEquals($concept, new Concept($concept));
        $this->assertEquals($concept, new Concept("{}"));

        $concept->type = ['http://www.w3.org/2004/02/skos/core#Concept']; # TODO: remove
        $this->assertEquals($concept, new Concept("$concept"));
    }

    public function testJson() {
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
}

?>
