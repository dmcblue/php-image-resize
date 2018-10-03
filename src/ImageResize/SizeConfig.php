<?php

namespace Dmcblue\ImageResize;

class SizeConfig {
	const ERROR_MISSING_PROPERTY = "Missing Property '%s'";
	const ERROR_INVALID_PATH = "INVALID PATH '%s', Please check path and path permissions";
	/** 
	 * Path to place resized files
	 * @var string 
	 */
	public $outputPath;
	/**  
	 * image height
	 * @var int 
	 */
	public $height;
	/**  
	 * String to add to filename
	 * @var string 
	 */
	public $postfix;
	/**  
	 * Resizing algorithm, const from Type
	 * @var string 
	 */
	public $type;
	/**  
	 * image width
	 * @var int 
	 */
	public $width;
	
	/**
	 * Class constructor. Accepts either a set of parameters or a single
	 * array.
	 * @param string $outputPath The path to output resized images OR the config array
	 * @param string $postfix [Optional] A postfix to add at the end of every resized images filename, before the extension.
	 * @param string $type [Optional] Type of image resize algorithm (see Type)
	 * @param int $width [Optional] Width for the resize
	 * @param int $height [Optional] Height for the resize
	 */
	public function __construct ($outputPath, $postfix = null, $type = null, $width = null, $height = null) {
		if(is_array($outputPath)) {
			$configArray = $outputPath; //change variable just for clarity
			$this->outputPath = (string)$configArray['outputPath'];
			$this->postfix = (string)$configArray['postfix'];
			$this->type = (string)$configArray['type'];
			$this->width = (int)$configArray['width'];
			$this->height = (int)$configArray['height'];
		} else {
			$this->outputPath = (string)$outputPath;
			$this->postfix = (string)$postfix;
			$this->type = (string)$type;
			$this->width = (int)$width;
			$this->height = (int)$height;
		}
	}
	
	/**
	 * Validates whether an config array has all the appropriate fields to help
	 * devs troubleshoot
	 * @param array $arrayConfig The configuration array
	 * @return boolean|\Exception
	 */
	static public function validateArray($arrayConfig) {
		if(!array_key_exists('outputPath', $arrayConfig)){
			return new \Exception(sprintf(self::ERROR_MISSING_PROPERTY, 'outputPath'));
		} else if(!strlen($arrayConfig['outputPath']) || !realpath($arrayConfig['outputPath'])) {
			return new \Exception(sprintf(self::ERROR_INVALID_PATH, $arrayConfig['outputPath']));
		} else if(!array_key_exists('postfix', $arrayConfig)){
			return new \Exception(sprintf(self::ERROR_MISSING_PROPERTY, 'postfix'));
		} else if(!array_key_exists('type', $arrayConfig)){
			return new \Exception(sprintf(self::ERROR_MISSING_PROPERTY, 'type'));
		} else if(!Type::isValid($arrayConfig['type'])){
			return new \Exception(Type::ERROR_INVALID_TYPE);
		} else if(!array_key_exists('width', $arrayConfig)){
			return new \Exception(sprintf(self::ERROR_MISSING_PROPERTY, 'width'));
		} else if(!array_key_exists('height', $arrayConfig)){
			return new \Exception(sprintf(self::ERROR_MISSING_PROPERTY, 'height'));
		}
		
		return true;
	}
}
