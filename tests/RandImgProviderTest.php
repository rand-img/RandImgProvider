<?php

namespace Siro\Tests;

use Faker\Factory;
use Faker\Generator;
use Siro\RandImg\RandImgProvider;
use InvalidArgumentException;
use Exception;
use PHPUnit\Framework\TestCase;

class RandImgProviderTest extends TestCase
{
    private $faker;

    public function setUp()
    {
        $faker = Factory::create();
        $faker->addProvider(new RandImgProvider($faker));
        $this->faker = $faker;
    }

    /**
     * Test that true does in fact equal true
     */
    public function testGenerateDefaultImageUrl()
    {
        $this->assertRegExp('#https?\:\/\/?www\.rand\-img\.com\/720\/480#', $this->faker->imageUrl());
    }

    public function testGenerateImageUrlWithCustomWidth()
    {
        $this->assertRegExp('#(https?\:\/\/)?www\.rand\-img\.com\/200\/480#', $this->faker->imageUrl(200));
        $this->assertRegExp('#(https?\:\/\/)?www\.rand\-img\.com\/980\/480#', $this->faker->imageUrl(980));
    }

    public function testGenerateImageUrlWithCustomWidthAndHeight()
    {
        $this->assertRegExp('#(https?\:\/\/)?www\.rand\-img\.com\/200\/500#', $this->faker->imageUrl(200, 500));
        $this->assertRegExp('#(https?\:\/\/)?www\.rand\-img\.com\/320\/280#', $this->faker->imageUrl(320, 280));
        $this->assertRegExp('#(https?\:\/\/)?www\.rand\-img\.com\/1920\/1080#', $this->faker->imageUrl(1920, 1080));
    }

    public function testGenerateImageUrlWithCategory()
    {
        $this->assertRegExp(
            '#(https?\:\/\/)?www\.rand\-img\.com\/200\/500\/food#',
            $this->faker->imageUrl(200, 500, 'food')
        );
        $this->assertRegExp(
            '#(https?\:\/\/)?www\.rand\-img\.com\/500\/653\/sky#',
            $this->faker->imageUrl(500, 653, 'sky')
        );
    }

    public function testGenerateRandImageUrl()
    {
        $this->assertRegExp(
            '#(https?\:\/\/)?www\.rand\-img\.com\/320\/320\?rand=\d+#',
            $this->faker->squaredImageUrl(320, '', ['rand' => true])
        );
    }

    public function testGenerateDefaultSquaredImageUrl()
    {
        $this->assertRegExp(
            '#(https?\:\/\/)?www\.rand\-img\.com\/200\/200#',
            $this->faker->squaredImageUrl(200)
        );
    }

    public function testGenerateSquaredImageUrlWithCategory()
    {
        $this->assertRegExp(
            '#(https?\:\/\/)?www\.rand\-img\.com\/200\/200\/food#',
            $this->faker->squaredImageUrl(200, 'food')
        );
        $this->assertRegExp(
            '#(https?\:\/\/)?www\.rand\-img\.com\/1024\/1024\/sky#',
            $this->faker->squaredImageUrl(1024, 'sky')
        );
    }

    public function testImageUrlWithParameters()
    {
        $this->assertRegExp(
            '#http:\/\/www\.rand\-img\.com\/720\/480/food\?rand\=\d+&blur\=4&gray\=1#',
            $this->faker->imageUrl(720, 480, 'food', ['rand' => true, 'blur' => 4, 'gray' => 1])
        );
    }

    public function testGetGif()
    {
        $this->assertRegExp(
            '#https?\:\/\/www\.rand\-img\.com\/gif#',
            $this->faker->gifUrl()
        );
    }

    public function testGetGifWithRand()
    {
        $this->assertRegExp(
            '#https?\:\/\/www\.rand\-img\.com\/gif\?rand=\d+#',
            $this->faker->gifUrl(true)
        );
    }

    public function testDownloadGif()
    {
        $fullPath = $this->faker->gif();
        $this->assertTrue(file_exists($fullPath));
    }

    public function testDownloadGifWithInvalidArgumentException()
    {
        $this->expectException(Exception::class);
        $this->faker->gif(__DIR__ .'/non/existing/path');
    }

    public function testDownloadImage()
    {
        $fullPath = $this->faker->image();
        $this->assertTrue(file_exists($fullPath));
    }

    public function testDownloadImageWithException()
    {
        $this->expectException(Exception::class);
        $this->faker->image(null, -720);
    }

    public function testDownloadImageWithInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->faker->image(__DIR__ . '/non/existing/path');
    }
}
