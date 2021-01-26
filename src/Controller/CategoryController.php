<?php

namespace App\Controller;

use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(CategoryRepository $repository)
    {
        $this->categoryRepository = $repository;
    }

    /**
     * @Route("/admin/categories", name="category_list")
     */
    public function index(): Response
    {
        $categories = $this->categoryRepository->findAll();

        return $this->render('admin/categories/main.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/admin/categories/new", name="new_category")
     * @Route("/admin/categories/edit/{slug}", name="edit_category")
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
        $category = $this->categoryRepository->findOrNew($slug);

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

            $this->categoryRepository->save($category);

            return $this->redirectToRoute('category_list');
        }

        return $this->render('admin/categories/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     *
     * @param string $slug
     *
     * @return Response
     *
     * @Route("/admin/categories/delete/{slug}", name="category_delete")
     */
    public function delete(string $slug): Response
    {
        $this->categoryRepository->delete($slug);

        return $this->redirectToRoute('category_list');
    }
}
