<?php declare(strict_types = 1);

namespace JSKOS;

/**
 * @covers JSKOS\Occurrence
 */
class OccurenceTest extends \PHPUnit\Framework\TestCase
{

    public function testOccurrence()
    {
        $occ = new Occurrence(['database'=>['uri'=>'x:y']]);

        $occ->count = 1;
        $this->assertEquals(1, $occ->count);

        $occ->frequency = 0.3;
        $this->assertEquals(0.3, $occ->frequency);

        $occ->frequency = 1;
        $this->assertEquals(1.0, $occ->frequency);

        $this->assertInstanceOf('JSKOS\Item', $occ->database);

        $occ->memberSet = new Set([new Concept(['uri'=>'x:y'])]);
    }

}
