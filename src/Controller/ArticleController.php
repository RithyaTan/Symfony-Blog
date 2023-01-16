<?php

namespace App\Controller;

use DateTime;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="app_articles")
     */
    public function showAll(ManagerRegistry $doctrine): Response
    // public function showAll(ArticleRepository $repo): Response // Methode bis
        // (ArticleRepository $repo) injection de dépendance $repo = new ArticleRepository
    {
        // On récupère les articles en passant par un objet de l'ArticleRepository et en utilisant la méthode findAll()
        $articles = $doctrine->getRepository(Article::class)->findAll();
        // $articles = $repo->findAll(); // Methode bis

        // dd($articles); // dd = Dump&Die pour tester la variable article. Il s'agit d'une fonction de débogage (equivalent d'un var_dump() et die() en meme temps)
        
        return $this->render('article/allArticles.html.twig', [
            'articles' => $articles
        ]);
    }

    // <\d+> est une regex qui permet de dire que l'information qu'on met dans l'id doit être un entier de 1 à l'infini. Sans quoi cette route pourrait être confondue avec d'autres. ex: la route suivante /article_add, le add aurait été pris pour un id et donc intercepté avat d'y arriver
    /**
     * @Route("/article_{id<\d+>}", name="app_article")
     */

    public function show($id, ArticleRepository $repo){
        $article = $repo->find($id);

        // dd($article); // Pour vérifier les informations que l'on récupère

        return $this->render('article/oneArticle.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @Route("/article_add", name="app_article_add")
     */
    public function add(Request $request, ArticleRepository $repo)
    {
        // on crée un objet de la class Article
        $article = new Article();

        // On crée le formulaire en liant les ArticleType à l'Objet $article
        $form = $this->createForm(ArticleType::class, $article);

        // On donne accès aux données post du formulaire
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $article->setDateDeCreation(new DateTime("now"));

            // La methode add() (ou save()) me permet de faire un persist puis un flush en ajoutant le 2ème paramètre 1 ou true. Cette méthode se trouve dans le repository ArticleRepository
            $repo->add($article, 1);

            // Après avoir ajouté l'article en bdd, on redirige vers la page de tous les articles
            return $this->redirectToRoute("app_articles");
        }

        return $this->render('article/formArticle.html.twig', [
            // on crée la vue du formulaire pour l'afficher dans le template
            'formArticle' => $form->createView()
        ]);
    }

    /**
     * @Route("/article_update_{id<\d+>}", name="app_article_update")
     */
    public function update($id, Request $request, ArticleRepository $repo)
    {
        // on récupère l'article dont l'id est celui passé en paramètre de la route qui est automatiquement récupéré dans le $id de la fonction, pour pouvoir le modifier
        $article = $repo->find($id);

        // On crée le formulaire en liant les ArticleType à l'Objet $article
        $form = $this->createForm(ArticleType::class, $article);

        // On donne accès aux données post du formulaire
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $article->setDateDeModification(new DateTime("now"));

            // La methode add() (ou save()) me permet de faire un persist puis un flush en ajoutant le 2ème paramètre 1 ou true. Cette méthode se trouve dans le repository ArticleRepository
            $repo->add($article, 1);

            // Après avoir ajouté l'article en bdd, on redirige vers la page de tous les articles
            return $this->redirectToRoute("app_articles");
        }

        return $this->render('article/formArticle.html.twig', [
            // on crée la vue du formulaire pour l'afficher dans le template
            'formArticle' => $form->createView()
        ]);
    }

    /**
     * @Route("/article_delete_{id<\d+>}", name="app_article_delete")
     */

    public function delete($id, ArticleRepository $repo)
    {
        $article = $repo->find($id);

        // La methode remove() me permet de faire un remove puis un flush en ajoutant le 2ème paramètre 1 ou true. Cette méthode se trouve dans le repository ArticleRepository
        $repo->remove($article, 1);

        return $this->redirectToRoute("app_articles");
    }
}