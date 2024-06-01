<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/recipe')]
class RecipeController extends AbstractController
{
  #[Route('/', name: 'app_recipe_index', methods: ['GET'])]
  public function index(RecipeRepository $recipeRepository): Response
  {
    return $this->render('recipe/index.html.twig', [
      'recipes' => $recipeRepository->findAll(),
    ]);
  }

  #[Route('/new', name: 'app_recipe_new', methods: ['GET', 'POST'])]
  public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
  {
    $recipe = new Recipe();
    $form = $this->createForm(RecipeType::class, $recipe);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $recipe->setSlug($slugger->slug($recipe->getTitle())->lower());
      $entityManager->persist($recipe);
      $entityManager->flush();

      return $this->redirectToRoute('app_recipe_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('recipe/new.html.twig', [
      'recipe' => $recipe,
      'form' => $form,
    ]);
  }

  #[Route('/{slug}', name: 'app_recipe_show', methods: ['GET'])]
  public function show(RecipeRepository $recipeRepository, string $slug): Response
  {
    $recipe = $recipeRepository->findOneBy(['slug' => $slug]);

    if (!$recipe) {
      throw $this->createNotFoundException('The recipe does not exist');
    }

    return $this->render('recipe/show.html.twig', [
      'recipe' => $recipe,
    ]);
  }

  #[Route('/{slug}/edit', name: 'app_recipe_edit', methods: ['GET', 'POST'])]
  public function edit(Request $request, RecipeRepository $recipeRepository, string $slug, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
  {
    $recipe = $recipeRepository->findOneBy(['slug' => $slug]);

    if (!$recipe) {
      throw $this->createNotFoundException('The recipe does not exist');
    }

    $form = $this->createForm(RecipeType::class, $recipe);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $recipe->setSlug($slugger->slug($recipe->getTitle())->lower());
      $entityManager->flush();

      return $this->redirectToRoute('app_recipe_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('recipe/edit.html.twig', [
      'recipe' => $recipe,
      'form' => $form,
    ]);
  }

  #[Route('/{slug}', name: 'app_recipe_delete', methods: ['POST'])]
  public function delete(Request $request, RecipeRepository $recipeRepository, string $slug, EntityManagerInterface $entityManager): Response
  {
    $recipe = $recipeRepository->findOneBy(['slug' => $slug]);

    if (!$recipe) {
      throw $this->createNotFoundException('The recipe does not exist');
    }

    if ($this->isCsrfTokenValid('delete' . $recipe->getId(), $request->get('_token'))) {
      $entityManager->remove($recipe);
      $entityManager->flush();
    }

    return $this->redirectToRoute('app_recipe_index', [], Response::HTTP_SEE_OTHER);
  }
}
