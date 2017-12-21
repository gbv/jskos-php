<?php declare(strict_types = 1);

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
            'memberSet' => [], 
        ];

        $this->assertEquals(json_encode($expect), json_encode($bundle));

        $bundle->memberSet = new Set([new Concept(['uri'=>'x:y'])]);
        $expect['memberSet'][] = ['uri'=>'x:y'];
        $this->assertEquals(json_encode($expect), json_encode($bundle));
    }    
}
