<?php

namespace JSKOS;

class JSKOSTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Make sure version numbers are valid.
     */
    public function testVersion()
    {
        $this->assertRegexp('/^\d+\.\d+\.\d+$/', JSKOS_SPECIFICATION);
    }

    /**
     * Test for PSR-2 coding standard.
     */
    public function testPSR2()
    {
        exec("vendor/bin/php-cs-fixer fix --level=psr2 --dry-run src/", $output, $return_var);

        if ($output) {
            array_pop($output);
            $output = array_map("trim", $output);
        }

        $this->assertEquals(0, $return_var, "PSR-2 violated in: " . join("; ", $output));
    }
}
