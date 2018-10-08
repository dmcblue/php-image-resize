<?php

namespace Dmcblue\ImageResize;

class Image {
	const ERROR_INVALID_FILE = "Invalid image file at '%s', may be corrupted.";
	static protected $FORMATS = [
		'bmp',
		'gif',
		'jpeg',
		'jpg',
		'png',
	];
	static protected $MIME_TYPES = [
		'image/bmp',
		'image/x-windows-bmp',
		'image/gif',
		'image/jpeg',
		'image/pjpeg',
		'image/png',
	];
	
	public $resource;
	
	/**
	 * Wrapper object from a file path or an image resource
	 * param string|resource $path
	 */
	public function __construct($path) {
		if(is_resource($path)) {
			$this->resource = $path;
		} else {
			$this->resource = Image::getResourceFromString($path);
		}
	}
	
	/**
	 * Makes sure image resources are destroyed properly
	 */
	public function __destruct() { 
		if(is_resource($this->resource)) { 
			\imagedestroy($this->resource); 
		} 
	}
	
	public function getDimensions() {
		$imageWidth = imagesx($this->resource);
		$imageHeight = imagesy($this->resource);
		
		return new Point($imageWidth, $imageHeight);
	}
	
	/**
	 * Saves this image
	 * param string $path
	 */
	public function save($path) {
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		$success = false;
		
		switch($ext) {
			case 'bmp':
				$success = \imagebmp($this->resource, $path);
				break;
			case 'gif':
				$success = \imagegif($this->resource, $path);
				break;
			case 'jpg':
			case 'jpeg':
				$success = \imagejpeg($this->resource, $path);
				break;
			case 'png':
				$success = \imagepng($this->resource, $path);
				break;
		}
		
		return $success;
	}
	
	/**
	 * Creates an image resource from a file path string
	 * param string $path
	 * return resource
	 */
	static public function getResourceFromString($path) {
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		
		$resource = null;

		switch($ext) {
			case 'bmp':
				$resource = \imagecreatefrombmp($path);
				break;
			case 'gif':
				$resource = \imagecreatefromgif($path);
				break;
			case 'jpg':
			case 'jpeg':
				$resource = \imagecreatefromjpeg($path);
				break;
			case 'png':
				$resource = \imagecreatefrompng($path);
				break;
		}

		return $resource;
	}
	
	/**
	 * Whether a file is in a supported image format
	 * param string $path Path to the image file
	 * return boolean
	 */
	static public function isSupported($path) {
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		return in_array($ext, self::$FORMATS);
	}
}