<?php


namespace App\Controller\App;


use App\Entity\Post;
use App\Entity\Comment;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * Renders the detail of the post
     *
     * @param Post $post
     * @param Request $request
     * @param EntityManagerInterface $manager
     *
     * @return Response
     *
     * @Route(path="/post/{slug}", name="app.post.detail")
     */
    public function detailAction(Request $request, Post $post, EntityManagerInterface $manager): Response
    {

        $comment = new Comment();
        $comment->setPost($post);

        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {

            $manager->persist($comment);
            $manager->flush();

            // If the request is AJAX, return a JSON response
            if ($request->isXmlHttpRequest()) {
                return $this->json(['name' => $comment->getName(), 'email' => $comment->getEmail(), 'comment' => $comment->getComment()]);
            }

            // Redirect to avoid resubmission on refresh
            return $this->redirectToRoute('app.post.detail', ['slug' => $post->getSlug()]);
        }

        $comments = $manager->getRepository(Comment::class)->findBy(
            ['post' => $post],
            ['createdAt' => 'DESC']
        );


        return $this->render('app/detail/detail.html.twig', [
            'post' => $post,
            'commentForm' => $commentForm->createView(),
            'comments' => $comments
        ]);
    }
}