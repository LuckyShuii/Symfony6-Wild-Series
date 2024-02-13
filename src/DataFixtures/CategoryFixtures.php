<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    private const CATEGORIES = [
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
        foreach (self::CATEGORIES as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
            // Nous enregistrons la catégorie créée dans une référence que nous pourrons récupérer
            $this->addReference('category_' . $categoryName, $category);
        }
        $manager->flush();
    }
}
