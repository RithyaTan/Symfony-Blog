<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        // On récupère le dernier article depuis la bdd en utilisant le repository lié à l'entité Article puis la méthode findOneBy() qui permet de récuperer un article parmis une liste (liste qu'on met en ordre décroissant de date)
        $article = $doctrine->getRepository(Article::class)->findOneBy([], ["dateDeCreation" => "DESC"]);

        return $this->render('home/index.html.twig', [
            'article' => $article
        ]);
    }
}
