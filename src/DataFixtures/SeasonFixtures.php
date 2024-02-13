<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

//Tout d'abord nous ajoutons la classe Factory de FakerPhp
use Faker\Factory;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        //Puis ici nous demandons à la Factory de nous fournir un Faker
        $faker = Factory::create();
        $programs = ['walking_dead', 'breaking_bad', 'the_100', 'the_witcher', 'the_crown', 'the_queens_gambit', 'the_mandalorian', 'the_haunting_of_hill_house', 'the_big_bang_theory', 'the_office', 'arcane'];
        /**
         * L'objet $faker que tu récupère est l'outil qui va te permettre 
         * de te générer toutes les données que tu souhaites
         */
        foreach ($programs as $program) {
            for ($i = 1; $i < 6; $i++) {
                $season = new Season();
                //Ce Faker va nous permettre d'alimenter l'instance de Season que l'on souhaite ajouter en base
                $season->setNumber($i);
                $season->setYear($faker->year());
                $season->setDescription($faker->paragraph(1, true));
                $season->setProgram($this->getReference('program_' . $program));

                $manager->persist($season);

                $this->addReference('season' . $i . '_' . $program, $season);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProgramFixtures::class,
        ];
    }
}
