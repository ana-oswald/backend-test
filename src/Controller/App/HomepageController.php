<?php


namespace App\Controller\App;


use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{

    /**
     * Returns the list of all posts
     *
     * @param PostRepository $postRepository
     *
     * @return Response
     *
     * @Route(path="/", name="app.index")
     */
    public function indexAction(PostRepository $postRepository) {

        $posts = $postRepository->findAll();

        return $this->render('app/homepage/index.html.twig', [
            'posts' => $posts
        ]);
    }
}