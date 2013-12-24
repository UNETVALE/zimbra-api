<?php

namespace Zimbra\Tests\Soap;

use Zimbra\Tests\ZimbraTestCase;
use Zimbra\Utils\Text;

/**
 * Testcase class for simple xml.
 */
class TextTest extends ZimbraTestCase
{
    public function testIsValidTagName()
    {
        $this->assertTrue(Text::isValidTagName('name'));
        $this->assertTrue(Text::isValidTagName('_name'));
        $this->assertTrue(Text::isValidTagName('ns:name'));
        $this->assertTrue(Text::isValidTagName('year2000'));
        $this->assertTrue(Text::isValidTagName('year_2000'));
        $this->assertTrue(Text::isValidTagName('year-2000'));
        $this->assertTrue(Text::isValidTagName('year.2000'));
        $this->assertTrue(Text::isValidTagName('year 2000'));

        $this->assertFalse(Text::isValidTagName(':name'));
        $this->assertFalse(Text::isValidTagName('.name'));
        $this->assertFalse(Text::isValidTagName(' name'));
        $this->assertFalse(Text::isValidTagName('-name'));
        $this->assertFalse(Text::isValidTagName('2000'));
    }

    public function tesTextractHeaders()
    {
        $headersString = 'HTTP/1.1 200 OK' . "\r\n"
                       . 'Date: Sun, 25 Jun 2006 19:55:19 GMT' . "\r\n"
                       . 'Server: Apache' . "\r\n"
                       . 'X-powered-by: PHP/5.2.4' . "\r\n"
                       . 'Connection: close' . "\r\n"
                       . 'Transfer-encoding: chunked' . "\r\n"
                       . 'Content-type: text/html' . "\r\n";
        $headers = array(
            'Date' => 'Sun, 25 Jun 2006 19:55:19 GMT',
            'Server' => 'Apache',
            'X-powered-by' => 'PHP/5.2.4',
            'Connection' => 'close',
            'Transfer-encoding' => 'chunked',
            'Content-type' => 'text/html',
        );
           $extractHeaders = Text::extractHeaders($headersString);
           $this->assertCount(count($headers), $extractHeaders);
           foreach ($headers as $key => $value)
           {
               $this->assertArrayHasKey($key, $extractHeaders);
               $this->assertSame($value, $extractHeaders[$key]);
           }
    }

    public function testBoolToString()
    {
        $this->assertSame('true', Text::boolToString(true));
        $this->assertSame('false', Text::boolToString(false));
        $this->assertSame(100, Text::boolToString(100));
        $this->assertSame('foo-bar', Text::boolToString('foo-bar'));
    }
}