<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    private const CATEGORIES = [
        'science fiction',
        'aventure',
        'policier',
        'fantastique',
        'horreur',
        'romance',
        'thriller',
        'comédie',
        'drame',
        'animation',
        'documentaire',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORIES as $i => $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
        }
        $manager->flush();
    }
}
