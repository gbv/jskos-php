<?php declare(strict_types=1);

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
        $msg = "JSKOS\SampleType constructor expects array, object, or JSON string";
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
            [ 'language', 'en-US' ],
            [ 'range', 'en-' ],
            [ 'string', '' ]
        ];
    }

    public function invalidProvider()
    {
        return [
            [ 'uri', 'foo', 'isURI' ],
            [ 'url', 'x:y', 'isURL' ],
            [ 'date', 'doz', 'isDate' ],
            [ 'language', '123', 'isLanguage' ],
            [ 'range', 'en', 'isLanguageRange' ],
            [ 'string', [], 'isString' ],
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
        'language' => 'Language',
        'range' => 'LanguageRange',
        'string' => 'String',
    ];

    protected $uri;
    protected $url;
    protected $date;
    protected $string;
}
