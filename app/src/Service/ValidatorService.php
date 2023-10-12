<?php

namespace App\Service;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorService
{
    public function __construct(
        private readonly ValidatorInterface $validator
    ) { }

    public function validate(object $objectToValidate): array{
        $errors = $this->validator->validate($objectToValidate);
        $messageToReturn = [];

        if(sizeof($errors)) {
            foreach ($errors as $error) {
                $messageToReturn[$error->getPropertyPath()] = $error->getMessage();
            }
        }

        return $messageToReturn;
    }
}