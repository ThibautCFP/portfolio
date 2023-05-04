<?php

namespace App\Fixtures\Providers;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserProvider
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
    ) {
    }

    public function hashPassword(string $plainPassword)
    {
        return $this->hasher->hashPassword(new User, $plainPassword);
    }

    public function lastNames(): string
    {
        $names = [
            'Bové',
            'Henry',
            'Mick',
            'Thibault',
            'Gillet',
            'Roy',
            'Gauthier',
            'Marechal',
            'Brunet',
            'Morel',
            'Rousseau',
            'Boulanger',
            'Mollet',
        ];

        return $names[array_rand($names)];
    }

    public function firstNames(): string
    {
        $names = [
            'Olivier',
            'Alice',
            'Rocko',
            'Bob',
            'Fraudon',
            'Bryan',
            'Julie',
            'Morgane',
            'Kim',
            'Emma',
            'Jibril',
            'Caled',
            'Justin',
            'Pierre',
        ];

        return $names[array_rand($names)];
    }
}
