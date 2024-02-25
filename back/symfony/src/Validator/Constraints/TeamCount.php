<?php


namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class TeamsCount extends Constraint
{
    public string $message = 'Vous ne pouvez pas ajouter plus de {{ limit }} équipes.';
}
