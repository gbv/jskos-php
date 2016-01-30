<?php

namespace JSKOS;

/**
 * @covers \JSKOS\ServiceDescription
 */
class ServiceDescriptionTest extends \PHPUnit_Framework_TestCase {

    public function testEmptyService() {
        $service = new ServiceDescription();
        $default = [
            // @todo: context not mentioned in current spec
            '@context'=>'https://gbv.github.io/jskos/context.json',
            'jskosapi'=>'0.0.1'
        ];
        $this->assertEquals(json_encode($default),json_encode($service));
    }
}

?>
