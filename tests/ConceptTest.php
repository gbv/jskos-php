<?php

namespace JSKOS;

/**
 * @covers \JSKOS\Concept
 */
class ConceptTest extends \PHPUnit_Framework_TestCase {

    public function testCreate() {
        $concept = new Concept();

        $this->assertEquals($concept, new Concept($concept));
        $this->assertEquals($concept, new Concept("$concept"));
        $this->assertEquals($concept, new Concept("{}"));
    }

    public function testJson() {
        $concept = new Concept(['uri'=>'x:1']);
        $concept->prefLabel['en'] = 'test';
        $concept->narrower[] = new Concept(['uri'=>'x:2']);

        $expect = [
            '@context' => 'https://gbv.github.io/jskos/context.json',
            'uri' => 'x:1',
            'prefLabel' => [ 'en' => 'test' ],
            'narrower' => [ [ 'uri' => 'x:2' ] ],
        ];
        ksort($expect);
        $this->assertEquals(json_encode($expect), json_encode($concept));
    }
}

?>
