<?php

namespace App\Controller;

use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    public function __construct(PostRepository $repository)
    {
        $this->postRepository = $repository;
    }

    /**
     * @Route("/admin/posts", name="post_list")
     */
    public function index(): Response
    {
        $posts = $this->postRepository->findAll();

        return $this->render('admin/posts/main.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/admin/posts/new", name="new_post")
     * @Route("/admin/posts/edit/{slug}", name="edit_post")
     * @param Request $request
     * @param string $slug
     *
     * @return Response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function edit(Request $request, string $slug = ''): Response
    {
        $post = $this->postRepository->findOrNew($slug);

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            $this->postRepository->save($post);

            return $this->redirectToRoute('post_list');
        }

        return $this->render('admin/posts/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/posts/detail/{slug}", name="post_detail")
     * @param string $slug
     *
     * @return Response
     */
    public function detail(string $slug): Response
    {
        $post = $this->postRepository->findOneBy(['slug' => $slug]);

        return $this->render('admin/posts/detail.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @Route("/admin/posts/delete/{slug}", name="post_delete")
     * @param string $slug
     *
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(string $slug): Response
    {
        $this->postRepository->delete($slug);

        return $this->index();
    }
}
