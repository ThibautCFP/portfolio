<?php

namespace App\Tests\Traits;

trait AssertTestTrait
{
    public function assertHasErrors(mixed $entity, int $number = 0)
    {
        self::bootKernel();

        $errors = self::getContainer()->get('validator')->validate($entity);

        $messages = [];

        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' -> ' . $error->getMessage();
        }

        $this->assertCount($number, $errors, implode(', ', $messages));
    }
}
