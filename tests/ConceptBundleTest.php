<?php

namespace JSKOS;

/**
 * @covers \JSKOS\ConceptBundle
 */
class ConceptBundleTest extends \PHPUnit_Framework_TestCase {

    public function testJsonEncode() {
        $bundle = new ConceptBundle();
        $expect = [ 'members' => [] ];
        $this->assertEquals(json_encode($expect),json_encode($bundle));

        $bundle->ordered = true;
        $expect['ordered'] = TRUE;
        $this->assertEquals(json_encode($expect),json_encode($bundle));

        $bundle->disjunction = true;
        $expect['disjunction'] = TRUE;
        $this->assertEquals(json_encode($expect),json_encode($bundle));
    }
}

?>
