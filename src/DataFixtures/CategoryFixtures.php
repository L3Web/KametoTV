<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = [
            1 => [
                'category_name' => 'Vetement',
                'category_desc' => 'Pulls, Sweat, Tshirt et Maillot'
            ],
            2 => [
                'category_name' => 'Accessoire',
                'category_desc' => 'Goodies et accessoires'
            ],
        ];

        foreach($categories as $key => $value ){
            $category = new Category();
            $category->setCategoryName($value['category_name']);
            $category->setCategoryDesc($value['category_desc']);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
