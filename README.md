# php-image-resize

A convenience tool to resize a batch of images into different sizes for website asset responsiveness.

## Requirements

+ PHP 7+
+ PHP [GD image module](http://php.net/manual/en/image.setup.php)

## Features

+ Resizes images or a folder of images into predefined size sets.
+ Two types of resize: `contain` and `cover`, think [CSS background-size](https://developer.mozilla.org/en-US/docs/Web/CSS/background-size).
+ Can be configured to prevent enlarging of images, with down sampling only (the default).
+ Handles any number of size groups all at once.
+ Adds postfixes to the filename.
+ Currently handles BMP, (static) GIF, JPG and PNG.

### Notes

The code is limited by the allowed memory size designated in php.ini by `memory_limit`. If php tries to allocate more memory than it is allowed, it will shutdown in the middle of creating a file.

When running the script again, it will run into this truncated file *in the output folder* and throw the following error:
```
"PHP Warning:  imagecreatefrompng(): gd-png:  fatal libpng error: Read Error: truncated data in..."
```

You just need to delete the file (or better all the output files to be sure) and then run the script again.

I have not found a satisfactory way to detect either of these problems before a shutdown error.

## Usage

```php
// Load composer libs
require("some/file/path/vendor/autoload.php");

$imageResizer = new \Dmcblue\ImageResize\ImageResizer();
$configArray = 
	[
		'originalPath' => '/path/to/original/images',
		'sizeConfigs' => [[
			'outputPath' => '/path/to/resized/images/thumbnails',
			'postfix' => '_thumbnail',
			'type' => \Dmcblue\ImageResize\Type::COVER,
			'width' => 50,
			'height' => 50,
		],[
			'outputPath' => '/path/to/resized/images/large',
			'postfix' => '_lrg',
			'type' => \Dmcblue\ImageResize\Type::CONTAIN,
			'width' => 2000,
			'height' => 2000,
		]]
	];
$config = new \Dmcblue\ImageResize\Config($configArray);
$imageResizer->resizeAll($config);
// Or resize a single image
$imageResizer->resize('/path/to/original/image.jpg', $config);
// Creates
//    /path/to/resized/images/thumbnails/image_thumbnail.jpg
//    /path/to/resized/images/large/image_lrg.jpg
```


## Tests

```
"./vendor/bin/phpunit" --bootstrap "vendor/autoload.php" tests
```
