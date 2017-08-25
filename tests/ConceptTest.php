<?php declare(strict_types = 1);

namespace JSKOS;

use InvalidArgumentException;

/**
 * @coversDefaultClass Concept
 */
class ConceptTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        $this->assertEquals(new Concept(), new Concept(['foo'=>'bar']));

        $concept = new Concept(); 
        $this->assertEquals($concept, new Concept($concept));
        $this->assertEquals($concept, new Concept([]));

        $concept->type = [Concept::TYPES[0]];
        $this->assertEquals($concept, new Concept(json_decode("$concept")));
    }

    public function testClosed()
    {
        $concept = new Concept(); 
        $concept->narrower = [];
        $this->assertEquals(true, $concept->narrower->isClosed());

        $concept->narrower = [null];
        $this->assertEquals(false, $concept->narrower->isClosed());
    }

    public function testJson()
    {
        $fields = ['uri'=>'x:1'];

        $concept = new Concept($fields);
        $this->assertEquals($fields, $concept->jsonLDSerialize(''));
        $this->assertEquals($fields, $concept->jsonLDSerialize('', false));
    
        $fields['@context'] = 'e:x';
        $this->assertEquals($fields, $concept->jsonLDSerialize('e:x', false));

        $fields['type'] = [Concept::TYPES[0]];
        $this->assertEquals($fields, $concept->jsonLDSerialize('e:x'));
        $this->assertEquals($fields, $concept->jsonLDSerialize('e:x', true));

        unset($fields['@context']);
        $this->assertEquals($fields, $concept->jsonLDSerialize('', true));

        $fields['@context'] = 'https://gbv.github.io/jskos/context.json';
        $this->assertEquals($fields, $concept->jsonLDSerialize());


        $concept->prefLabel = ($fields['prefLabel'] = ['en' => 'test']);
        $concept->narrower = [];
        $concept->narrower[] = new Concept(['uri'=>'x:2']);
        $fields['narrower'] = [ [ 'uri' => 'x:2' ] ];
        $concept->broader = ($fields['broader'] = [null]);
        $concept->identifier =  [null, 'y:1', 'y:1'];
        $fields['identifier'] = ['y:1', null];
        ksort($fields);
        $this->assertEquals(json_encode($fields), json_encode($concept));
    }

    public function testNested()
    {
        $concept = new Concept([ 'narrower' => [ ['uri' =>'a:b' ] ] ]);
        $expect = new Concept([
            'narrower' => new Set([ 
                new Concept(['uri' =>'a:b' ])
            ])
        ]);

        $this->assertEquals($expect, $concept);
    }

    public function testFields()
    {
        $concept = new Concept();

        foreach(['startDate','endDate','relatedDate'] as $f) {
            $concept->$f = '1984';
            $this->assertEquals($concept->$f, '1984');
        }
    }

    /**
     * @dataProvider provideExceptionTests
     */
    public function testExceptions($data)
    {
        $this->expectException(InvalidArgumentException::class);
        $concept = new Concept($data, true);
    }

    public function provideExceptionTests()
    {
        return [
            ['foo'=>'bar'],
            ['narrower'=>'yes'],
        ];
    }
}
