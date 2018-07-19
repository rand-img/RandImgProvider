<?php

namespace Siro\Tests;

use Faker\Factory;
use Faker\Generator;
use Siro\RandImg\RandImgProvider;
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
        $this->assertRegExp('#(https?\:\/\/)?www\.rand\-img\.com\/(.+)#', $this->faker->imageUrl());
    }

    public function testGenerateImageUrlWithCustomWidth()
    {
        $this->assertRegExp('#(https?\:\/\/)?www\.rand\-img\.com\/200\/480#', $this->faker->imageUrl(200));
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
            '#(https?\:\/\/)?www\.rand\-img\.com\/200\/200\/food#',
            $this->faker->squaredImageUrl(200, 'food')
        );
    }

    public function testGenerateSquaredImageUrlWithCategory()
    {
        $this->assertRegExp(
            '#(https?\:\/\/)?www\.rand\-img\.com\/200\/200\/food#',
            $this->faker->squaredImageUrl(200, 'food')
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
}
