<?php

namespace Tzsk\Collage\Tests\Contracts;

use Intervention\Image\Image;
use Tzsk\Collage\Helpers\File;
use Tzsk\Collage\Helpers\Config;
use Tzsk\Collage\Tests\PhpTestCase;
use Intervention\Image\ImageManagerStatic;
use Tzsk\Collage\Contracts\CollageGenerator;
use Tzsk\Collage\Exceptions\ImageCountException;

class CollageGeneratorTest extends PhpTestCase
{
    protected $generator;

    public function setUp()
    {
        $this->generator = $generator = new FakeCollageGenerator(new File, new Config);
    }

    public function test_it_can_create_image()
    {
        $this->assertInstanceOf(Image::class, $this->generator->create());
    }

    public function test_it_has_image_collection()
    {
        $this->assertCount(0, $this->generator->getImages());
    }

    public function test_it_can_check_for_errors()
    {
        $this->expectException(ImageCountException::class);
        $this->generator->fakeCheck(1);
    }
}

class FakeCollageGenerator extends CollageGenerator
{
    public function create($closure = null)
    {
        return ImageManagerStatic::make('tests/images/image.jpg');
    }

    public function getImages()
    {
        return $this->images;
    }

    public function fakeCheck($count)
    {
        $this->check($count);
    }
}
