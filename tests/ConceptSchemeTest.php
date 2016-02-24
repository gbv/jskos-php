<?php

namespace JSKOS;

/**
 * @covers \JSKOS\ConceptScheme
 */
class ConceptSchemeTest extends \PHPUnit_Framework_TestCase
{

    public function testEmptyScheme()
    {
        $scheme = new ConceptScheme();
        $scheme->types = 'http://example.org/types';
        $expect = [
            '@context' => 'https://gbv.github.io/jskos/context.json',
            'type'     => ['http://www.w3.org/2004/02/skos/core#ConceptScheme'],
            'types'    => 'http://example.org/types',
        ];
        $this->assertEquals(json_encode($expect, JSON_UNESCAPED_SLASHES), "$scheme");
    }
}
