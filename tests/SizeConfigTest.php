<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Dmcblue\ImageResize\SizeConfig;
use Dmcblue\ImageResize\Type;

final class SizeConfigTest extends TestCase
{
    static protected $legitArray = [
		'outputPath' => __DIR__,
		'postfix' => '_small',
		'type' => Type::COVER,
		'width' => 100,
		'height' => 100,
	];
	static protected $legitArray2 = [
		'outputPath' => __DIR__.DIRECTORY_SEPARATOR.'..',
		'postfix' => '_post',
		'type' => Type::COVER,
		'width' => 200,
		'height' => 50,
	];
	static protected $badArray = [
		'outputPath' => "",
		'postfix' => '_post',
		'type' => Type::COVER,
		'width' => 200,
		'height' => 50,
	];

	public function testValidatesLegitArray()
    {
		$this->assertTrue(SizeConfig::validateArray(self::$legitArray2));
    }
	
	public function testNotValidatesBadArray()
    {
		$this->assertInstanceOf(
            "\\Exception",
            SizeConfig::validateArray(self::$badArray)
        );
    }
}