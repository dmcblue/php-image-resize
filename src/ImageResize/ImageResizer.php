<?php

namespace Dmcblue\ImageResize;

class ImageResizer {
	
	/**
	 * Takes an image, resize type and target dimensions and returns a Point 
	 * object with the new dimensions
	 * @param \Dmcblue\ImageResize\Image $image
	 * @param string $type see Type
	 * @param int $targetWidth
	 * @param int $targetHeight
	 * @return \Dmcblue\ImageResize\Point
	 */
	public function getDimensions(Image $image, $type, $targetWidth, $targetHeight) {
		$originalDimensions = $image->getDimensions();
		$dimensions = new Point();
		switch($type) {
			case Type::CONTAIN:
				$dimensions = $this->getDimensionsContain(
					$originalDimensions->x,
					$originalDimensions->y,
					$targetWidth,
					$targetHeight
				);
				break;
			case Type::COVER:
				$dimensions = $this->getDimensionsContain(
					$originalDimensions->x,
					$originalDimensions->y,
					$targetWidth,
					$targetHeight
				);
				break;
		}
		
		return $dimensions;
	}
	
	/**
	 * Gets the new dimensions for an image such that it covers the space defined
	 * by $targetWidth and $targetHeight
	 * @param \Dmcblue\ImageResize\Image $image
	 * @param int $targetWidth
	 * @param int $targetHeight
	 * @return \Dmcblue\ImageResize\Point
	 */
	public function getDimensionsContain($imageWidth, $imageHeight, $targetWidth, $targetHeight) {
		$finalWidth = 0;
		$finalHeight = 0;
		
		//if finalHeight === $targetHeight
		$predictedWidth = ($imageWidth * $targetHeight) /  $imageHeight;
		//then predictedWidth must be >= $targetWidth
		if ($predictedWidth <= $targetWidth) {
			$finalWidth = $predictedWidth;
			$finalHeight = $targetHeight;
		} else {
			$finalWidth = $targetWidth;
			$finalHeight = ($targetWidth * $imageHeight) / $imageWidth;
		}
		
		
		return new Point(
			ceil($finalWidth), 
			ceil($finalHeight)
		);
	}
	
	/**
	 * Gets the new dimensions for an image such that it covers the space defined
	 * by $targetWidth and $targetHeight
	 * @param \Dmcblue\ImageResize\Image $image
	 * @param int $targetWidth
	 * @param int $targetHeight
	 * @return \Dmcblue\ImageResize\Point
	 */
	public function getDimensionsCover($imageWidth, $imageHeight, $targetWidth, $targetHeight) {
		$finalWidth = 0;
		$finalHeight = 0;
		
		//if finalHeight === $targetHeight
		$predictedWidth = ($imageWidth * $targetHeight) /  $imageHeight;
		//then predictedWidth must be >= $targetWidth
		if ($predictedWidth >= $targetWidth) {
			$finalWidth = $predictedWidth;
			$finalHeight = $targetHeight;
		} else {
			$finalWidth = $targetWidth;
			$finalHeight = ($targetWidth * $imageHeight) / $imageWidth;
		}
		
		
		return new Point(
			ceil($finalWidth), 
			ceil($finalHeight)
		);
	}
	
	/**
	 * Gets the correct filepath to the resized image
	 * @param string $imagePath
	 * @param string $outputPath
	 * @param string $postfix
	 * @return string
	 */
	public function getResizedName($imagePath, $outputPath, $postfix = "") {
		$pathinfo = pathinfo($imagePath);
		return $targetPath = 
			$outputPath
				.$pathinfo['filename']
				.$postfix
				.".".$pathinfo['extension'];
	}
	
	/**
	 * Checks if a resized copy already exists
	 * @param string $imagePath
	 * @param string $outputPath
	 * @param string $type
	 * @param int $targetWidth
	 * @param int $targetHeight
	 * @param string $postfix
	 * @return boolean
	 */
	public function isResized($imagePath, $outputPath, $type, $targetWidth, $targetHeight, $postfix = "") {
		$targetPath = $this->getResizedName($imagePath, $outputPath, $postfix);

		if (file_exists($targetPath)){
			$targetImage = new Image($targetPath);
			$targetDimensions = $targetImage->getDimensions();
			
			$newDimensions = 
				$this->getDimensions(
					new Image($imagePath), 
					$type, 
					$targetWidth, 
					$targetHeight
				);
			
			$targetImage = null;
			
			if (
				$targetDimensions->x == $newDimensions->x 
				&& $targetDimensions->y == $newDimensions->y
			) {
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 * Resizes an image given its file path
	 * It will overwrite any file that does not have the correct dimensions.
	 * @param type $imagePath
	 * @param \Dmcblue\ImageResize\Config $config
	 * @param type $force Whether to overwrite existing file
	 */
	public function resize($imagePath, Config $config, $force = false) {
		$image = new Image($imagePath);
		
		foreach ($config->sizeConfigs as $sizeConfig) {
			$exists = 
				$this->isResized(
					$imagePath, 
					$sizeConfig->outputPath, 
					$sizeConfig->type, 
					$sizeConfig->width, 
					$sizeConfig->height, 
					$sizeConfig->postfix
				);
			$isTooSmall = !$config->doesEnlarge;
			if ($isTooSmall) {
				$dimensions = $image->getDimensions();
				$isTooSmall = $dimensions->x <= $sizeConfig->width
					&& $dimensions->y <= $sizeConfig->height;
			}
			
			if (($force || !$exists) && !$isTooSmall) {
				$resizedImage = 
					$this->resizeImage(
						$image, 
						$sizeConfig->type, 
						$sizeConfig->width, 
						$sizeConfig->height
					);
				$targetPath = 
					$this->getResizedName(
						$imagePath, 
						$sizeConfig->outputPath, 
						$sizeConfig->postfix
					);
				$resizedImage->save($targetPath);
				$resizedImage = null;
			}
		}
		
		$image = null;
	}
	
	/**
	 * Resizes all images in a folder
	 * @param \Dmcblue\ImageResize\Config $config
	 * @param type $force
	 */
	public function resizeAll(Config $config, $force = false) {
		$files = array_diff(scandir($config->originalPath), ['.', '..']);
		foreach($files as $file) {
			if(Image::isSupported($config->originalPath.DIRECTORY_SEPARATOR.$file)) {
				$this->resize(
					$config->originalPath.DIRECTORY_SEPARATOR.$file,
					$config,
					$force
				);
			}
		}
	}
	
	/**
	 * Creates a new Image which is a resized copy of the given
	 * @param \Dmcblue\ImageResize\Image $image
	 * @param string $type see Type
	 * @param int $targetWidth
	 * @param int $targetHeight
	 * @return \Dmcblue\ImageResize\Image
	 */
	public function resizeImage(Image $image, $type, $targetWidth, $targetHeight) {
		$newDimensions = 
			$this->getDimensions(
				$image, 
				$type, 
				$targetWidth, 
				$targetHeight
			);
		
		
		return new Image(
			imagescale(
				$image->resource,
				$newDimensions->x, 
				$newDimensions->y,
				IMG_BICUBIC
			)
		);
	}
}