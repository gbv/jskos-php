<?php declare(strict_types = 1);

namespace JSKOS;

/**
 * @covers \JSKOS\Concordance
 */
class ConcordanceTest extends \PHPUnit\Framework\TestCase
{
    public function testConcordance()
    {
        $conc = new Concordance([
            'fromScheme' => ['uri' => 'a:scheme'],
            'mappings' => [
                ['set' => []]
            ]
        ]);
        $this->assertInstanceOf('JSKOS\ConceptScheme', $conc->fromScheme);

        $conc->toScheme = ['uri' => 'b:scheme'];
        $this->assertInstanceOf('JSKOS\ConceptScheme', $conc->toScheme);
        
        $conc->extent = '42 mappings';
        $conc->mappings[1] = new AccessPoint(['download'=>'http://example.org']);

        $expect = [            
            '@context' => 'https://gbv.github.io/jskos/context.json',
            'type' => ['http://rdfs.org/ns/void#Linkset'],
            'fromScheme' => ['uri'=>'a:scheme'],
            'toScheme' => ['uri'=>'b:scheme'],
            'extent' => '42 mappings',
            'mappings' => [
                ['set'=>[]],
                ['download'=>'http://example.org']
            ]
        ];
        ksort($expect);

        $this->assertEquals(json_encode($expect), json_encode($conc));
    }
}
