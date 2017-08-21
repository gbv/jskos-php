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
    }

    /**
     * @dataProvider validProvider
     */
    public function testSetNull($field, $value)
    {
        $entity = new SampleType();
        $entity->$field = null;
        $this->assertEquals(null, $entity->$field);
    }

    /**
     * @dataProvider invalidProvider
     */
    public function testConstructInvalidArgument($field, $value, $test)
    {
        $this->expectException('InvalidArgumentException');
        $msg = "JSKOS\SampleType->$field must match JSKOS\DataType::$test";
        $this->expectExceptionMessage($msg);
        $entity = new SampleType([$field=>$value], false);
    }

    public function testConstructInvalid()
    {
        $this->expectException('InvalidArgumentException');
        $msg = "JSKOS\SampleType constructor expects array, object, or null";
        $this->expectExceptionMessage($msg);
        $entity = new SampleType(42);
    }

    /**
     * @dataProvider invalidProvider
     */
    public function testSetInvalidArgument($field, $value, $test)
    {
        $this->expectException('InvalidArgumentException');
        $msg = "JSKOS\SampleType->$field must match JSKOS\DataType::$test";
        $this->expectExceptionMessage($msg);
        $entity = new SampleType();
        $entity->$field = $value;
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

    public function invalidProvider()
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
    ];

    protected $uri;
    protected $url;
    protected $date;
    protected $string;
    protected $language;
    protected $range;
    protected $languageorrange;
}
