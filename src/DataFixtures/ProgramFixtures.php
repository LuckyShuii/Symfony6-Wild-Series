<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
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

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $programs = [
            'walking_dead' => 'The Walking Dead',
            'breaking_bad' => 'Breaking Bad',
            'the_100' => 'The 100',
            'the_witcher' => 'The Witcher',
            'the_crown' => 'The Crown',
            'the_queens_gambit' => 'The Queen\'s Gambit',
            'the_mandalorian' => 'The Mandalorian',
            'the_haunting_of_hill_house' => 'The Haunting of Hill House',
            'the_big_bang_theory' => 'The Big Bang Theory',
            'the_office' => 'The Office',
            'arcane' => 'Arcane',
        ];

        foreach ($programs as $currentProgram => $programTitle) {
            $program = new Program();
            $program->setTitle($programTitle);
            $program->setSynopsis($faker->paragraph(3, true));
            $program->setPoster('https://picsum.photos/300/400');
            $program->setCategory($this->getReference('category_' . self::CATEGORIES[rand(0, 9)]));
            $this->setReference('program_' . $currentProgram, $program);
            $manager->persist($program);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // Retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            CategoryFixtures::class,
        ];
    }
}
