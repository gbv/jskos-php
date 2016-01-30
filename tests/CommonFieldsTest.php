<?php

namespace JSKOS;

class CommonFieldsTest extends \PHPUnit_Framework_TestCase {

    public function testJsonEncode() {
        $concept = new Concept();
        $default = ['@context'=>'https://gbv.github.io/jskos/context.json'];
        $this->assertEquals(json_encode($default),json_encode($concept));

        $concept->uri = $default['uri'] = 'http://example.org/';
        $this->assertEquals(json_encode($default),json_encode($concept));

        $concept->created = $default['created'] = '2016-01-01';
        $this->assertEquals(json_encode($default),json_encode($concept));

        $concept->modified = $default['modified'] = '2017-01-01';
        $this->assertEquals(json_encode($default),json_encode($concept));
    }
}

?>
