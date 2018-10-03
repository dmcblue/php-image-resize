<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Dmcblue\ImageResize\Config;
use Dmcblue\ImageResize\Type;

final class ConfigTest extends TestCase
{
    static protected $legitArray = [
		'originalPath' => __DIR__,
		'sizeConfigs' => [[
			'outputPath' => __DIR__,
			'postfix' => '_small',
			'type' => Type::COVER,
			'width' => 100,
			'height' => 100,
		]]
	];
	static protected $badArray = [
		'originalPath' => "",
		'sizeConfigs' => [[
			'outputPath' => "",
			'postfix' => '_post',
			'type' => Type::COVER,
			'width' => 200,
			'height' => 50,
		]]
	];

	public function testValidatesLegitArray()
    {
		$this->assertTrue(Config::validateArray(self::$legitArray));
    }
	
	public function testNotValidatesBadArray()
    {
		$this->assertInstanceOf(
            "\\Exception",
            Config::validateArray(self::$badArray)
        );
    }
}