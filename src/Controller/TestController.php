<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="app_test")
     */
    public function index(): Response
    {
        $prenom = "Rithya"; // Création de la variable prenom
        $nom = "Tan";

        $tab = [
                'personne1' => [
                    'nom' => 'Bon', 
                    'prenom' => 'Jean'
                ],
                'personne2' => [
                    'nom' => "Croche",
                    'prenom' => "Sarah"
                ]
            ];        

        return $this->render("test.html.twig", [
            // 'cle(ou index)' =>$valeur
            'prenom' => $prenom,
            'nom' => $nom,
            'personnes' => $tab
        ]);
    }
    
    /**
     * @Route("/test-home", name="app_test-home")
     */
    public function testHome(): Response
    {
        $article = [
                'titre' => "Entrainement Symfony",
                'dateDeCreation' => '10-01-2023',
                'auteur' => "Rithya",
                'contenu' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eget efficitur tortor. Etiam volutpat vestibulum tellus, sed tempus nisi ullamcorper ut. Donec est tellus, efficitur vitae massa et, laoreet lobortis felis."
        ];

        return $this->render("home/index.html.twig", [
            'article' => $article,
        ]);
    }

}
