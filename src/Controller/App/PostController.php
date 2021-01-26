<?php


namespace App\Controller\App;


use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{


    /**
     * Renders the detail of the post
     *
     * @param Post $post
     *
     * @return Response
     *
     * @Route(path="/post/{slug}", name="app.post.detail")
     */
    public function detailAction(Post $post) {


        return $this->render('app/detail/detail.html.twig', [
            'post' => $post
        ]);
    }

}