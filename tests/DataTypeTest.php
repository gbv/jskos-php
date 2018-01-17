<?php declare(strict_types = 1);

namespace JSKOS;

/**
 * @covers \JSKOS\DataType
 */
class DataTypeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider validProvider
     */
    public function testConstructValid($field, $value)
    {
        $entity = new SampleType([ $field => $value ]);
        $this->assertEquals($value, $entity->$field);
    }

    /**
     * @dataProvider validProvider
     */
    public function testSetValid($field, $value)
    {
        $entity = new SampleType();
        $entity->$field = $value;
        $this->assertEquals($value, $entity->$field);
        $entity->$field = null;
        $this->assertEquals(null, $entity->$field);
    }
    
    public function validProvider()
    {
        return [
            [ 'uri', 'x:y' ],
            [ 'url', 'http://example.org/' ],
            [ 'date', '2017' ],
            [ 'string', '' ],
            [ 'language', 'en-US' ],
            [ 'range', 'en-' ],
            [ 'range', '-' ],
            [ 'languageorrange', '-' ],
            [ 'languageorrange', 'de' ],
        ];
    }

    public function testConstructInvalid()
    {
        $this->expectException('InvalidArgumentException');
        $msg = "JSKOS\SampleType constructor expects array, object, or null";
        $this->expectExceptionMessage($msg);
        $entity = new SampleType(42);
    }

    public function testSetUnknownField()
    {
        $this->expectException('InvalidArgumentException');
        $msg = "JSKOS\SampleType->foo does not exist";
        $this->expectExceptionMessage($msg);
        $entity = new SampleType(['foo'=>1], true);
    }

    /**
     * @dataProvider invalidTypeProvider
     */
    public function testConstructInvalidType($field, $value, $test)
    {
        $this->expectInvalidType($field, $test);
        $entity = new SampleType([$field=>$value], true);
    }

    /**
     * @dataProvider invalidTypeProvider
     */
    public function testConstructInvalidTypeIgnore($field, $value, $test)
    {
        $entity = new SampleType([$field=>$value]);
        $this->assertTrue(true);
    }

    /**
     * @dataProvider invalidTypeProvider
     */
    public function testSetInvalidType($field, $value, $test)
    {
       $this->expectInvalidType($field, $test);
       $entity = new SampleType();
       $entity->$field = $value;
    }

    public function expectInvalidType($field, $test)
    {
        $this->expectException('InvalidArgumentException');
        $msg = "JSKOS\SampleType->$field must "
             . (substr($test, 0, 2)=='is' ? "match JSKOS\DataType::$test" : "be a $test");
        $this->expectExceptionMessage($msg);
    }

    public function invalidTypeProvider()
    {
        return [
            [ 'uri', 'foo', 'isURI' ],
            [ 'url', 'x:y', 'isURL' ],
            [ 'date', 'doz', 'isDate' ],
            [ 'string', [], 'isString' ],
            [ 'language', '123', 'isLanguage' ],
            [ 'language', 'en-', 'isLanguage' ],
            [ 'range', 'en', 'isLanguageRange' ],
            [ 'range', '', 'isLanguageRange' ],
            [ 'languageorrange', '', 'isLanguageOrRange' ],
            [ 'urilist', 123, 'Listing' ],
            [ 'conceptset', 123, 'Set' ],
        ];
    }

    public function testConstructIgnoreUnknown()
    {
        $entity = new SampleType(['uri'=>'a:b','foo'=>'bar']);
        $this->assertEquals('a:b', $entity->uri);
        $this->assertTrue(isset($entity->uri));
        $this->assertFalse(isset($entity->foo));
    }

    public function testGetUnknown()
    {
        $this->expectException('PHPUnit\Framework\Error\Notice');
        $this->expectExceptionMessage('Undefined property: JSKOS\SampleType::$foo');
        $entity = new SampleType(['uri'=>'a:b','foo'=>'bar']);
        $foo = $entity->foo;
    }
}

class SampleType extends DataType
{
    const FIELDS = [
        'uri' => 'URI',
        'url' => 'URL',
        'date' => 'Date',
        'string' => 'String',
        'language' => 'Language',
        'range' => 'LanguageRange',
        'languageorrange' => 'LanguageOrRange',
        'urilist' => ['Listing', 'URI'],
        'conceptset' => ['Set', 'Concept'],
    ];

    protected $uri;
    protected $url;
    protected $date;
    protected $string;
    protected $language;
    protected $range;
    protected $languageorrange;
    protected $urilist;
    protected $conceptset;
}
