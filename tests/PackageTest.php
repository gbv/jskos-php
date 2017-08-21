<?php declare(strict_types = 1);

namespace JSKOS;


class PackageTest extends \PHPUnit\Framework\TestCase
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
        exec("vendor/bin/php-cs-fixer fix --dry-run src/", $output, $return_var);

        if ($output) {
            array_pop($output);
            $output = array_map("trim", $output);
        }

        $this->assertEquals(0, $return_var, "PSR-2 violated in: " . join("; ", $output));
    }
}
