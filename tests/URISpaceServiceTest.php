<?php declare(strict_types=1);

namespace JSKOS;

/**
 * @covers JSKOS\URISpaceService
 */
class URISpaceServiceTest extends \PHPUnit\Framework\TestCase
{

    public function testService()
    {
        foreach (['/.*/',FALSE] as $notationPattern) {
            $config = [ 'Concept' => [ 'uriSpace' => 'http://example.org/' ] ];
            if ($notationPattern) {
                $config['Concept']['notationPattern'] = $notationPattern;
            }
            $service = new URISpaceService($config);
           
            $this->assertNull($service->query([]));
            $this->assertNull($service->query(['uri' => '']));
            $this->assertNull($service->query(['uri' => 'http://example.com']));
            $this->assertNull($service->query(['uri' => 'http://example.org']));

            $concept = $service->query(['uri' => 'http://example.org/']);
            $this->assertInstanceOf('JSKOS\Concept', $concept);
            $this->assertSame('http://example.org/', $concept->uri);
            $this->assertNull($concept->notation);
     
            $concept = $service->query(['uri' => 'http://example.org/foo']);
            $this->assertInstanceOf('JSKOS\Concept', $concept);
            $this->assertSame('http://example.org/foo', $concept->uri);
            $this->assertEquals(new Listing(['foo']), $concept->notation);

            $this->assertNull($service->query([
                'uri'      => 'http://example.org/foo', 
                'notation' => 'bar'
            ]));
        }
    }

    public function testNotation() {
        $service = new URISpaceService([
            'Concept' => [
                'uriSpace'        => 'http://example.org/',
                'notationPattern' => '/[0-9]+/',
            ]
        ]);

        $this->assertNull($service->query(['uri' => 'http://example.org/']));
        $this->assertNull($service->query(['uri' => 'http://example.org/foo']));

        $concept = $service->query(['uri' => 'http://example.org/123']);
        $this->assertInstanceOf('JSKOS\Concept', $concept);
        $this->assertSame('http://example.org/123', $concept->uri);
        $this->assertEquals(new Listing(['123']), $concept->notation);

        // ignore empty notation
        $this->assertNotNull($service->query([
            'uri' => 'http://example.org/123', 
            'notation' => ''
        ]));

        // URI and notation don't match
        $this->assertNull($service->query([
            'uri' => 'http://example.org/123', 
            'notation' => 'foo'
        ]));

        $this->assertNull($service->query(['notation' => 'foo']));

        $concept = $service->query(['notation' => '123']);
        $this->assertInstanceOf('JSKOS\Concept', $concept);
        $this->assertSame('http://example.org/123', $concept->uri);
        $this->assertEquals(new Listing(['123']), $concept->notation);
    }

    public function testNotationNormalizer() {
        $service = new URISpaceService([
            'Concept' => [
                'uriSpace'           => 'http://example.org/',
                'notationPattern'    => '/[QP][0-9]+/i',
                'notationNormalizer' => 'strtoupper',
            ]
        ]);
        $concept = $service->query(['notation' => 'q42']);
        $this->assertSame('http://example.org/Q42', $concept->uri);
        $this->assertEquals(new Listing(['Q42']), $concept->notation);

        $concept = $service->query(['uri' => 'http://example.org/q42']);
        $this->assertSame('http://example.org/q42', $concept->uri);
        $this->assertEquals(new Listing(['Q42']), $concept->notation);
     }

    # TODO: test multiple types but Concept

}
