<?php

namespace JSKOS;

// make sure include file works
include './src/JSKOS.php';

class JSKOSTest extends \PHPUnit_Framework_TestCase {

    // make sure version numbers are valid
    public function testVersion() {
        $this->assertRegexp('/^\d+\.\d+\.\d+$/',JSKOS_SPEC_VERSION);
    }
}

?>
