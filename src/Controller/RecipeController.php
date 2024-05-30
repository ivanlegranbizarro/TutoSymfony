<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecipeController extends AbstractController
{
  #[Route('/recipe', name: 'app_recipe')]
  public function index(): Response
  {
    return $this->render('recipe/index.html.twig', [
      'controller_name' => 'RecipeController',
    ]);
  }

  #[Route('/recipe/{slug}-{id}', name: 'app_recipe_show', requirements: ['slug' => '[a-z0-9-]+', 'id' => '\d+'])]
  public function show(int $id, EntityManager $em): Response
  {
    $recipe = $em->getRepository('App\Entity\Recipe')->find($id);

    return $this->render('recipe/show.html.twig', [
      'recipe' => $recipe,
    ]);
  }
}
