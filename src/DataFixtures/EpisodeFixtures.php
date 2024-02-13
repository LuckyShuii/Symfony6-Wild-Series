<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $programs = ['walking_dead', 'breaking_bad', 'the_100', 'the_witcher', 'the_crown', 'the_queens_gambit', 'the_mandalorian', 'the_haunting_of_hill_house', 'the_big_bang_theory', 'the_office', 'arcane'];
        foreach ($programs as $program) {
            for ($i = 1; $i < 6; $i++) {
                for ($j = 1; $j < 4; $j++) {
                    $episode = new Episode();
                    $episode->setTitle('Episode ' . $j);
                    $episode->setNumber($j);
                    $episode->setSynopsis($faker->paragraph(1, true));
                    $episode->setSeason($this->getReference('season' . $i . '_' . $program));
                    $manager->persist($episode);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SeasonFixtures::class,
        ];
    }
}
