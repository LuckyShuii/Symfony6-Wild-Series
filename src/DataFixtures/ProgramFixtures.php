<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // private const CATEGORIES = [
        //     'aventure',
        //     'policier',
        //     'fantastique',
        //     'horreur',
        //     'romance',
        //     'thriller',
        //     'comédie',
        //     'drame',
        //     'animation',
        //     'documentaire',
        // ];

        // Nous utilisons l'Entity Manager pour créer des nouvelles instances de la classe Program
        $program = new Program();
        // colonnes : title, synopsis, poster, category_id
        $program->setTitle('Walking Dead');
        $program->setSynopsis('Des zombies envahissent la terre');
        $program->setPoster('https://picsum.photos/id/1/300/400');
        $program->setCategory($this->getReference('category_horreur'));
        $manager->persist($program);

        $program = new Program();
        $program->setTitle('Breaking Bad');
        $program->setSynopsis('Un professeur de chimie devient un gros caïd');
        $program->setPoster('https://picsum.photos/id/2/300/400');
        $program->setCategory($this->getReference('category_thriller'));
        $manager->persist($program);

        // écrit en pour toutes les catégories

        $program = new Program();
        $program->setTitle('The 100');
        $program->setSynopsis('Des jeunes retournent sur terre');
        $program->setPoster('https://picsum.photos/id/3/300/400');
        $program->setCategory($this->getReference('category_aventure'));
        $manager->persist($program);

        $program = new Program();
        $program->setTitle('The Witcher');
        $program->setSynopsis('Un chasseur de monstres');
        $program->setPoster('https://picsum.photos/id/4/300/400');
        $program->setCategory($this->getReference('category_fantastique'));
        $manager->persist($program);

        $program = new Program();
        $program->setTitle('The Crown');
        $program->setSynopsis('La vie de la reine Elizabeth II');
        $program->setPoster('https://picsum.photos/id/6/300/400');
        $program->setCategory($this->getReference('category_drame'));
        $manager->persist($program);

        $program = new Program();
        $program->setTitle('The Queen\'s Gambit');
        $program->setSynopsis('Une jeune orpheline devient une championne d\'échecs');
        $program->setPoster('https://picsum.photos/id/7/300/400');
        $program->setCategory($this->getReference('category_drame'));
        $manager->persist($program);

        $program = new Program();
        $program->setTitle('The Haunting of Hill House');
        $program->setSynopsis('Une famille hantée par des fantômes');
        $program->setPoster('https://picsum.photos/id/8/300/400');
        $program->setCategory($this->getReference('category_horreur'));
        $manager->persist($program);

        $program = new Program();
        $program->setTitle('The Big Bang Theory');
        $program->setSynopsis('Des scientifiques passionnés de jeux vidéos');
        $program->setPoster('https://picsum.photos/id/9/300/400');
        $program->setCategory($this->getReference('category_comédie'));
        $manager->persist($program);

        $program = new Program();
        $program->setTitle('The Office');
        $program->setSynopsis('La vie de bureau');
        $program->setPoster('https://picsum.photos/id/10/300/400');
        $program->setCategory($this->getReference('category_comédie'));
        $manager->persist($program);

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
