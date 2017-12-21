<?php declare(strict_types = 1);

namespace JSKOS;

/**
 * @covers \JSKOS\Mapping
 */
class MappingTest extends \PHPUnit\Framework\TestCase
{

    public function testJsonEncode()
    {
        $mapping = new Mapping();
        $expect = [
            '@context' => 'https://gbv.github.io/jskos/context.json',
            'from' => [ 'memberSet' => [], ],
            'to' => [ 'memberSet' => [], ],
            'type' => ['http://www.w3.org/2004/02/skos/core#mappingRelation'],
        ];
        $this->assertEquals(json_encode($expect), json_encode($mapping));

        $mapping->to->memberSet[] = new Concept(['uri'=>'x:1']);
        $expect['to']['memberSet'][] = ['uri'=>'x:1'];
        $this->assertEquals(json_encode($expect), json_encode($mapping));
        
        $validTypes = [
            'mappingRelation','closeMatch','exactMatch','broadMatch','narrowMatch','relatedMatch'
        ];
        foreach ($validTypes as $type) {
            $type = "http://www.w3.org/2004/02/skos/core#$type";
            $mapping->type  = [$type];
            $expect['type'] = [$type];
            $this->assertEquals(json_encode($expect), json_encode($mapping));
        }
    }
}
