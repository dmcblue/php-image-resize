<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Dmcblue\ImageResize\Type;

final class TypeTest extends TestCase
{
    public function testIsValidForConstant()
    {
		$this->assertTrue(Type::isValid(Type::COVER));
    }
	
    public function testIsValidForString()
    {
		$this->assertTrue(Type::isValid("cover"));
    }
	
    public function testIsInvalid()
    {
		$this->assertFalse(Type::isValid("blerg"));
		$this->assertFalse(Type::isValid(1));
		$this->assertFalse(Type::isValid(false));
    }
	/*
    public function testCannotBeCreatedFromInvalidEmailAddress(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Email::fromString('invalid');
    }

    public function testCanBeUsedAsString(): void
    {
        $this->assertEquals(
            'user@example.com',
            Email::fromString('user@example.com')
        );
    }
	 */
}