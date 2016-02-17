<?php

namespace JSKOS;

/**
 * @covers \JSKOS\Mapping
 */
class MappingTest extends \PHPUnit_Framework_TestCase {

    public function testJsonEncode() {
        $mapping = new Mapping();
        $expect = [
            '@context' => 'https://gbv.github.io/jskos/context.json',
            'from' => [ 'members' => [], ],
            'to' => [ 'members' => [], ],
            'type' => ['http://www.w3.org/2004/02/skos/core#mappingRelation'],
        ];
        $this->assertEquals(json_encode($expect),json_encode($mapping));

        $mapping->to->members[] = new Concept(['uri'=>'x:1']);
        $expect['to']['members'][] = ['uri'=>'x:1'];
        $this->assertEquals(json_encode($expect),json_encode($mapping));
        #$this->assertEquals('{}',json_encode($mapping->jsonSerializeRoot()));
    }
}

?>
