<?php

use PHPUnit\Framework\TestCase;
use SimpleSoftwareIO\Packagist\Formats;

class FormatTest extends TestCase
{
    public function setUp()
    {
        $this->manager = $this->getMockBuilder(stdClass::class)
            ->setMethods(['getConfig'])
            ->getMock();

        $this->format = $this->getMockForTrait(Formats::class);
        $this->format->manager = $this->manager;
    }

    public function test_it_does_not_format_when_formatting_is_disabled()
    {
        $this->manager->expects($this->any())
            ->method('getConfig')
            ->with($this->equalTo('formatting.enable'))
            ->will($this->returnValue(false));

        $this->assertEquals('foo', $this->format->format('foo'));
        $this->assertEquals(1, $this->format->format(1));
        $this->assertEquals(1000, $this->format->format(1000));
    }

    public function test_it_formats_a_number()
    {
        $this->manager->expects($this->any())
            ->method('getConfig')
            ->will($this->returnCallback([$this, 'getConfig']));

        $this->assertSame('1', $this->format->format(1));
        $this->assertSame('1,000', $this->format->format(1000));
    }

    public function test_it_formats_numbers_within_an_array()
    {
        $this->manager->expects($this->any())
            ->method('getConfig')
            ->will($this->returnCallback([$this, 'getConfig']));

        $response = [
            'favers' => 1000,
            'downloads' => [
                'total' => 1000,
                'monthly' => 10,
                'daily' => 1,
            ]
        ];

        $formattedResponse = [
            'favers' => '1,000',
            'downloads' => [
                'total' => '1,000',
                'monthly' => '10',
                'daily' => '1',
            ]
        ];

        $this->assertSame($formattedResponse, $this->format->format($response));
    }

    public function getConfig()
    {
        $args = func_get_args();

        switch ($args[0]) {
            case 'formatting.enable':
                return true;

            case 'formatting.decimals':
                return 0;

            case 'formatting.dec_point':
                return '.';

            case 'formatting.thousands_sep':
                return ',';
        }
    }
}
