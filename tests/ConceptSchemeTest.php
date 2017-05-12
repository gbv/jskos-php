<?php declare(strict_types=1);

namespace JSKOS;

/**
 * @covers JSKOS\ConceptScheme
 */
class ConceptSchemeTest extends \PHPUnit\Framework\TestCase
{

    public function testEmptyScheme()
    {
        $scheme = new ConceptScheme();
        $scheme->types = [new Access(['download'=>'http://example.org/types'])];
        $expect = [
            '@context' => 'https://gbv.github.io/jskos/context.json',
            'type'     => ['http://www.w3.org/2004/02/skos/core#ConceptScheme'],
            'types'    => [
                ['download' => 'http://example.org/types']
            ],
        ];
        $this->assertEquals(json_encode($expect, JSON_UNESCAPED_SLASHES), "$scheme");
    }

    public function testFields()
    {
        $scheme = new ConceptScheme();
        $scheme->extent = '123';
        $this->assertEquals('123', $scheme->extent);
    }
}
