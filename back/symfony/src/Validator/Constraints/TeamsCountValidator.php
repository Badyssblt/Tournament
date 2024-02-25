<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Doctrine\Common\Collections\Collection;

class TeamsCountValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof TeamsCount) {
            throw new UnexpectedTypeException($constraint, TeamsCount::class);
        }

        if (!$value instanceof Collection) {
            return;
        }
        $tournament = $this->context->getObject();
        $maxTeams = $tournament->getMaxTeams();

        if (null === $maxTeams) {
            return;
        }

        if (count($value) > $maxTeams) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ limit }}', $maxTeams)
                ->addViolation();
        }
    }
}
