<?php

namespace App\Form;

use App\Entity\Recipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('title', null, [
        'required' => true,
        'attr' => [
          'minlength' => 3,
          'maxlength' => 255
        ]
      ])
      ->add('content', null, [
        'required' => true,
        'attr' => [
          'minlength' => 10,
          'maxlength' => 500
        ]
      ])
      ->add('duration', null, [
        'required' => true,
        'attr' => [
          'type' => 'number',
        ]
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Recipe::class,
    ]);
  }
}
