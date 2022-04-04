<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $products = [
            1 => [
                'product_name' => 'Tote bag karmine',
                'price' => '100',
                'product_qtt' => '20',
                'created_at' => new \DateTimeImmutable("now"),
                'category_id' => 1,
                'image' => 'tote-bag-karmine-6233395f91e8e-6234e5694fa13-62444cf744968-62445db53a966-6244602e2fc78-624465a6e836c-6244663ad4126.jpg',
                'product_desc' => 'Un tote bag noir',
            ],
            2 => [
                'product_name' => 'Ultra flag',
                'price' => '80',
                'product_qtt' => '15',
                'created_at' => new \DateTimeImmutable("now"),
                'category_id' => 2,
                'image' => 'ultraflag-624461afccee8.jpg',
                'product_desc' => 'Quelque chose',
            ],
            3 => [
                'product_name' => 'T-shirt bleu',
                'price' => '40',
                'product_qtt' => '30',
                'created_at' => new \DateTimeImmutable("now"),
                'category_id' => 1,
                'image' => 'teebleu-624464ebd4d45.jpg',
                'product_desc' => 'Un t-shirt bleu',
            ],
            4 => [
                'product_name' => 'Casquette Kcorp',
                'price' => '15',
                'product_qtt' => '20',
                'created_at' => new \DateTimeImmutable("now"),
                'category_id' => 2,
                'image' => 'casquetteKcorp-6244643f3f43e.jpg',
                'product_desc' => 'Une casquette des Kcorp',
            ],
            5 => [
                'product_name' => 'Gourde',
                'price' => '100',
                'product_qtt' => '20',
                'created_at' => new \DateTimeImmutable("now"),
                'category_id' => 2,
                'image' => 'gourde-624b54c8ab3bd.jpg',
                'product_desc' => 'Une gourde',
            ],
        ];

        foreach ($products as $value) {
            $products = new Product();
            $products->setProductName($value["product_name"]);
            $products->setPrice($value["price"]);
            $products->setProductQtt($value["product_qtt"]);
            $products->setCreatedAt($value["created_at"]);
            $products->setCategoryId($value["category_id"]);
            $products->setImage($value["image"]);
            $products->setProductDesc($value["product_desc"]);

            $manager->persist($products);
        }

        $manager->flush();
    }
}