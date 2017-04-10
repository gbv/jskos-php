<?php declare(strict_types=1);

namespace JSKOS;

/**
 * @covers JSKOS\ConceptBundle
 */
class ConceptBundleTest extends \PHPUnit\Framework\TestCase
{

    public function testJsonEncode()
    {
        $bundle = new ConceptBundle();
        $expect = [
            '@context' => 'https://gbv.github.io/jskos/context.json',
            'members'  => [], 
        ];
        $this->assertEquals(json_encode($expect), json_encode($bundle));

        $bundle->ordered = true;
        $expect['ordered'] = true;
        ksort($expect);
        $this->assertEquals(json_encode($expect), json_encode($bundle));

        $bundle->disjunction = true;
        $expect['disjunction'] = true;
        $this->assertEquals(json_encode($expect), json_encode($bundle));
    }
}
