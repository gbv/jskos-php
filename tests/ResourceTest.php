<?php declare(strict_types = 1);

namespace JSKOS;

/**
 * @covers \JSKOS\Resource
 */
class ResourceTest extends \PHPUnit\Framework\TestCase
{
    public function testJsonEncode()
    {
        $concept = new Concept();
        $expect = [
            '@context' => 'https://gbv.github.io/jskos/context.json',
            'type'     => ['http://www.w3.org/2004/02/skos/core#Concept']
        ];
        $this->assertEquals(json_encode($expect), json_encode($concept));

        $this->assertEquals(
            json_encode($expect, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            $concept->json()
        );

        $concept->uri = $expect['uri'] = 'http://example.org/';
        $this->assertEquals(json_encode($expect), json_encode($concept));

        $concept->created = $expect['created'] = '2016-01-01';
        ksort($expect);
        $this->assertEquals(json_encode($expect), json_encode($concept));

        $concept->modified = $expect['modified'] = '2017-01-01';
        ksort($expect);
        $this->assertEquals(json_encode($expect), json_encode($concept));
        $this->assertEquals(json_encode($expect, JSON_UNESCAPED_SLASHES), "$concept");
    }

    public function testTypeField() {
        foreach (['Concept', 'ConceptScheme', 'Mapping', 'Concordance'] as $class) {
            $class = "JSKOS\\$class";
            $a = new $class();
            $b = new $class(['type'=>[$class::TYPES[0]]]);
            $this->assertEquals($a, $b);
        }
    }

    /**
     * @dataProvider provideTypesToGuess
     */
    public function testGuessClass($types, $class) {
 	    $this->assertEquals($class, Resource::guessClassFromTypes($types));
    }

    public function provideTypesToGuess() {
        return [
            [[], null],
            [['http://www.w3.org/2004/02/skos/core#Concept'], Concept::class],
            [['http://www.w3.org/2004/02/skos/core#ConceptScheme'], ConceptScheme::class],
            [['http://www.w3.org/2004/02/skos/core#closeMatch'], Mapping::class],
            [['http://rdfs.org/ns/void#Linkset'], Concordance::class],
        ];
    }
}
