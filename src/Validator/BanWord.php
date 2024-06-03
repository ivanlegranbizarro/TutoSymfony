<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class BanWord extends Constraint
{

  public function __construct(public string $message = 'You can not use the word "{{ banWord }}"', public array $banWords = ['coño', 'polla', 'puta', 'sexo', 'follar'], $groups = null, $payload = null)
  {
    parent::__construct(null, $groups, $payload);
  }
}
