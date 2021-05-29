<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Product;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $names = ['Flip Flops M', 'Flip Flops L', 'Cotton Shorts M', 'Cotton Shorts L', 'Hat Red', 'Hat Pink', 'Hat White', 'Umbrella Blue', 'Umbrella White', 'Umbrella Red', 'Premium quality umbrella made by Uncle Rob'];
        $conditions = [1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2];

        $faker = Factory::create();

        for ($i = 0; $i < 11; $i++) {
            $product = new Product();
            $product->setSku($faker->regexify('[A-Z0-9]{8}'));
            $product->setName($names[$i]);
            $product->setPrice($faker->randomFloat(2, 1, 100));
            $product->setWeather($conditions[$i]);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
