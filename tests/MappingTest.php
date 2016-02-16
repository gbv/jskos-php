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
    }
}

?>
