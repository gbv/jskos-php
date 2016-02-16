<?php

namespace JSKOS;

/**
 * @covers \JSKOS\Object
 */
class ObjectTest extends \PHPUnit_Framework_TestCase {

    public function testJsonEncode() {
        $concept = new Concept();
        $expect = ['@context'=>'https://gbv.github.io/jskos/context.json'];
        $this->assertEquals(json_encode($expect),json_encode($concept));

        $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES;
        $this->assertEquals(json_encode($expect, $options),$concept->pretty());

        $concept->uri = $expect['uri'] = 'http://example.org/';
        $this->assertEquals(json_encode($expect),json_encode($concept));

        $concept->created = $expect['created'] = '2016-01-01';
        ksort($expect);
        $this->assertEquals(json_encode($expect),json_encode($concept));

        $concept->modified = $expect['modified'] = '2017-01-01';
        ksort($expect);
        $this->assertEquals(json_encode($expect),json_encode($concept));
        $this->assertEquals(json_encode($expect),json_encode($concept));
        $this->assertEquals(json_encode($expect),"$concept");
    }

    public function testCreate() {
        $concept = new Concept();

        $this->assertEquals($concept, new Concept($concept));
        $this->assertEquals($concept, new Concept("$concept"));
        $this->assertEquals($concept, new Concept("{}"));
    }
}

?>
