<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Dmcblue\ImageResize\ImageResizer;
use Dmcblue\ImageResize\Image;

final class ImageResizerTest extends TestCase
{
	public function testGetResizedName() {
		$imagePath = "image".DIRECTORY_SEPARATOR."path".DIRECTORY_SEPARATOR."img.png";
		$outputPath = "output".DIRECTORY_SEPARATOR."path".DIRECTORY_SEPARATOR;
		$postfix = "_resized";
		$expected = 
			"output".DIRECTORY_SEPARATOR
				."path".DIRECTORY_SEPARATOR
				."img_resized.png";
		$imageResizer = new ImageResizer();
		$actual = 
			$imageResizer->getResizedName(
				$imagePath, 
				$outputPath, 
				$postfix
			);
		$this->assertEquals($expected, $actual);
	}
	
	public function testGetDimensionsContainLandscapeToSquare()
    {
		$imageWidth = 30;
		$imageHeight = 20;
		
		$targetWidth = 10;
		$targetHeight = 10;
		
		$imageResizer = new ImageResizer();
		$newDimensions = 
			$imageResizer->getDimensionsContain(
				$imageWidth, 
				$imageHeight,
				$targetWidth,
				$targetHeight
			);

		$this->assertEquals(10, $newDimensions->x);
		$this->assertEquals(7, $newDimensions->y);
    }
	
	public function testGetDimensionsContainPortraitToSquare()
    {
		$imageWidth = 20;
		$imageHeight = 30;
		
		$targetWidth = 10;
		$targetHeight = 10;
		
		$imageResizer = new ImageResizer();
		$newDimensions = 
			$imageResizer->getDimensionsContain(
				$imageWidth, 
				$imageHeight,
				$targetWidth,
				$targetHeight
			);

		$this->assertEquals(7, $newDimensions->x);
		$this->assertEquals(10, $newDimensions->y);
    }
	
	public function testGetDimensionsContainSquareToSquare()
    {
		$imageWidth = 30;
		$imageHeight = 30;
		
		$targetWidth = 10;
		$targetHeight = 10;
		
		$imageResizer = new ImageResizer();
		$newDimensions = 
			$imageResizer->getDimensionsContain(
				$imageWidth, 
				$imageHeight,
				$targetWidth,
				$targetHeight
			);

		$this->assertEquals(10, $newDimensions->x);
		$this->assertEquals(10, $newDimensions->y);
    }
	
	public function testGetDimensionsContainPortraitToLandscape()
    {
		$imageWidth = 20;
		$imageHeight = 30;
		
		$targetWidth = 20;
		$targetHeight = 10;
		
		$imageResizer = new ImageResizer();
		$newDimensions = 
			$imageResizer->getDimensionsContain(
				$imageWidth, 
				$imageHeight,
				$targetWidth,
				$targetHeight
			);

		$this->assertEquals(7, $newDimensions->x);
		$this->assertEquals(10, $newDimensions->y);
    }
	
	public function testGetDimensionsContainLandscapeToLandscape()
    {
		$imageWidth = 30;
		$imageHeight = 20;
		
		$targetWidth = 20;
		$targetHeight = 10;
		
		$imageResizer = new ImageResizer();
		$newDimensions = 
			$imageResizer->getDimensionsContain(
				$imageWidth, 
				$imageHeight,
				$targetWidth,
				$targetHeight
			);

		$this->assertEquals(15, $newDimensions->x);
		$this->assertEquals(10, $newDimensions->y);
    }
	
	public function testGetDimensionsContainSquareToLandscape()
    {
		$imageWidth = 30;
		$imageHeight = 30;
		
		$targetWidth = 20;
		$targetHeight = 10;
		
		$imageResizer = new ImageResizer();
		$newDimensions = 
			$imageResizer->getDimensionsContain(
				$imageWidth, 
				$imageHeight,
				$targetWidth,
				$targetHeight
			);

		$this->assertEquals(10, $newDimensions->x);
		$this->assertEquals(10, $newDimensions->y);
    }
	
	public function testGetDimensionsContainSquareToPortrait()
    {
		$imageWidth = 30;
		$imageHeight = 30;
		
		$targetWidth = 10;
		$targetHeight = 20;
		
		$imageResizer = new ImageResizer();
		$newDimensions = 
			$imageResizer->getDimensionsContain(
				$imageWidth, 
				$imageHeight,
				$targetWidth,
				$targetHeight
			);

		$this->assertEquals(10, $newDimensions->x);
		$this->assertEquals(10, $newDimensions->y);
    }
	
	public function testGetDimensionsContainPortraitToPortrait()
    {
		$imageWidth = 200;
		$imageHeight = 300;
		
		$targetWidth = 10;
		$targetHeight = 20;
		
		$imageResizer = new ImageResizer();
		$newDimensions = 
			$imageResizer->getDimensionsContain(
				$imageWidth, 
				$imageHeight,
				$targetWidth,
				$targetHeight
			);

		$this->assertEquals(10, $newDimensions->x);
		$this->assertEquals(15, $newDimensions->y);
    }
	
	public function testGetDimensionsContainLandscapeToPortrait()
    {
		$imageWidth = 300;
		$imageHeight = 200;
		
		$targetWidth = 10;
		$targetHeight = 20;
		
		$imageResizer = new ImageResizer();
		$newDimensions = 
			$imageResizer->getDimensionsContain(
				$imageWidth, 
				$imageHeight,
				$targetWidth,
				$targetHeight
			);

		$this->assertEquals(10, $newDimensions->x);
		$this->assertEquals(7, $newDimensions->y);
    }
	
	public function testGetDimensionsCoverLandscapeToSquare()
    {
		$imageWidth = 30;
		$imageHeight = 20;
		
		$targetWidth = 10;
		$targetHeight = 10;
		
		$imageResizer = new ImageResizer();
		$newDimensions = 
			$imageResizer->getDimensionsCover(
				$imageWidth, 
				$imageHeight,
				$targetWidth,
				$targetHeight
			);

		$this->assertEquals(15, $newDimensions->x);
		$this->assertEquals(10, $newDimensions->y);
    }
	
	public function testGetDimensionsCoverPortraitToSquare()
    {
		$imageWidth = 20;
		$imageHeight = 30;
		
		$targetWidth = 10;
		$targetHeight = 10;
		
		$imageResizer = new ImageResizer();
		$newDimensions = 
			$imageResizer->getDimensionsCover(
				$imageWidth, 
				$imageHeight,
				$targetWidth,
				$targetHeight
			);

		$this->assertEquals(10, $newDimensions->x);
		$this->assertEquals(15, $newDimensions->y);
    }
	
	public function testGetDimensionsCoverSquareToSquare()
    {
		$imageWidth = 30;
		$imageHeight = 30;
		
		$targetWidth = 10;
		$targetHeight = 10;
		
		$imageResizer = new ImageResizer();
		$newDimensions = 
			$imageResizer->getDimensionsCover(
				$imageWidth, 
				$imageHeight,
				$targetWidth,
				$targetHeight
			);

		$this->assertEquals(10, $newDimensions->x);
		$this->assertEquals(10, $newDimensions->y);
    }
	
	public function testGetDimensionsCoverPortraitToLandscape()
    {
		$imageWidth = 20;
		$imageHeight = 30;
		
		$targetWidth = 20;
		$targetHeight = 10;
		
		$imageResizer = new ImageResizer();
		$newDimensions = 
			$imageResizer->getDimensionsCover(
				$imageWidth, 
				$imageHeight,
				$targetWidth,
				$targetHeight
			);

		$this->assertEquals(20, $newDimensions->x);
		$this->assertEquals(30, $newDimensions->y);
    }
	
	public function testGetDimensionsCoverLandscapeToLandscape()
    {
		$imageWidth = 30;
		$imageHeight = 20;
		
		$targetWidth = 20;
		$targetHeight = 10;
		
		$imageResizer = new ImageResizer();
		$newDimensions = 
			$imageResizer->getDimensionsCover(
				$imageWidth, 
				$imageHeight,
				$targetWidth,
				$targetHeight
			);

		$this->assertEquals(20, $newDimensions->x);
		$this->assertEquals(14, $newDimensions->y);
    }
	
	public function testGetDimensionsCoverSquareToLandscape()
    {
		$imageWidth = 30;
		$imageHeight = 30;
		
		$targetWidth = 20;
		$targetHeight = 10;
		
		$imageResizer = new ImageResizer();
		$newDimensions = 
			$imageResizer->getDimensionsCover(
				$imageWidth, 
				$imageHeight,
				$targetWidth,
				$targetHeight
			);

		$this->assertEquals(20, $newDimensions->x);
		$this->assertEquals(20, $newDimensions->y);
    }
	
	public function testGetDimensionsCoverSquareToPortrait()
    {
		$imageWidth = 30;
		$imageHeight = 30;
		
		$targetWidth = 10;
		$targetHeight = 20;
		
		$imageResizer = new ImageResizer();
		$newDimensions = 
			$imageResizer->getDimensionsCover(
				$imageWidth, 
				$imageHeight,
				$targetWidth,
				$targetHeight
			);

		$this->assertEquals(20, $newDimensions->x);
		$this->assertEquals(20, $newDimensions->y);
    }
	
	public function testGetDimensionsCoverPortraitToPortrait()
    {
		$imageWidth = 200;
		$imageHeight = 300;
		
		$targetWidth = 10;
		$targetHeight = 20;
		
		$imageResizer = new ImageResizer();
		$newDimensions = 
			$imageResizer->getDimensionsCover(
				$imageWidth, 
				$imageHeight,
				$targetWidth,
				$targetHeight
			);

		$this->assertEquals(14, $newDimensions->x);
		$this->assertEquals(20, $newDimensions->y);
    }
	
	public function testGetDimensionsCoverLandscapeToPortrait()
    {
		$imageWidth = 300;
		$imageHeight = 200;
		
		$targetWidth = 10;
		$targetHeight = 20;
		
		$imageResizer = new ImageResizer();
		$newDimensions = 
			$imageResizer->getDimensionsCover(
				$imageWidth, 
				$imageHeight,
				$targetWidth,
				$targetHeight
			);

		$this->assertEquals(30, $newDimensions->x);
		$this->assertEquals(20, $newDimensions->y);
    }
}