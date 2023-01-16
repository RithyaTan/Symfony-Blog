<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i <= 10; $i++) 
        {           
            $article = new Article(); // L'objet (par exemple un formulaire)
            $article->setTitre("Le titre de l'article $i"); // Ce que l'on doit ecrire dans le formulaire
            $article->setContenu("$i Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur suscipit erat at placerat ornare. Ut imperdiet leo eu nibh gravida, eu hendrerit metus luctus. Integer id varius eros. Proin bibendum tincidunt nisl a porttitor."); // Ce que l'on doit ecrire dans le formulaire
            $article->setDateDeCreation(new DateTime("now")); // Ce que l'on doit ecrire dans le formulaire
            $manager->persist($article); // stockage des objets avant envoie à la base
        }

        $manager->flush(); // pour envoyer les objets dans la base de données
    }
}
