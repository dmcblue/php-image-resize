<?php

namespace Dmcblue\ImageResize;

class Type {
	/**
	 * Makes sure the image at least covers the area while maintaining proportions
	 */
	const COVER = "cover";
	/**
	 * Makes sure the image is in the limits of the area while maintaining proportions
	 */
	const CONTAIN = "contain";
	/**
	 * Error for invalid type strings
	 */
	const ERROR_INVALID_TYPE = "Invalid Resize Type";
	
	static public $TYPES = [self::COVER, self::CONTAIN];
	
	static public function isValid($type) {
		return in_array($type, self::$TYPES);
	}
}