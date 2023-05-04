<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Tests\Traits\AssertTestTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserEntityTest extends KernelTestCase
{
    protected $databaseTool;

    private $hasher;

    use AssertTestTrait;

    protected function setup(): void
    {
        parent::setup();

        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->hasher = self::getContainer()->get(UserPasswordHasherInterface::class);
    }

    public function testRepositoryCount()
    {
        $users = $this->databaseTool->loadAliceFixture([
            \dirname(__DIR__) . '/Fixtures/UserFixtures.yaml',
        ]);

        $users = self::getContainer()->get(UserRepository::class)->count([]);

        $this->assertSame(11, $users);
    }

    public function getEntity(): User
    {
        $user = new User();
        $user
            ->setLastName('Test')
            ->setFirstName('Unitaire')
            ->setEmail('unitaire@test.com');
        $user
            ->setPassword($this->hasher->hashPassword($user, 'Test1234#'))
            ->setRoles(['ROLE_USER']);
        return $user;
    }

    public function testEntityValide()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidFormatEmailUser()
    {
        $user = $this->getEntity()->setEmail('ineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuv');

        $this->assertHasErrors($user, 1);
    }

    public function testInvalidMinEmailUser()
    {
        $user = $this->getEntity()->setEmail('ineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuv@ineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuv.fr');

        $this->assertHasErrors($user, 2);
    }

    public function testLastNameLength()
    {
        $user = $this->getEntity()->setLastName('ineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuv');

        $this->assertHasErrors($user, 1);
    }

    public function testLastNameNotBlank()
    {
        $user = $this->getEntity()->setLastName('');

        $this->assertHasErrors($user, 1);
    }

    public function testFirstNameLength()
    {
        $user = $this->getEntity()->setFirstName('ineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuv');

        $this->assertHasErrors($user, 1);
    }

    public function testFirstNameNotBlank()
    {
        $user = $this->getEntity()->setFirstName('');

        $this->assertHasErrors($user, 1);
    }

    // public function testUserPasswordLength()
    // {
    //     $user = $this->getEntity();
    //     $user->setPassword($this->hasher->hashPassword($user, 'ineivbdeiovboihkuuerzbfiuineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvrehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiuineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvrehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvineivbdeiovboihkuuerzbfiurehfguobgfueiuoirdbuengjervguiberziuvzbfiurehfguobgfueiuoirdbuengjervguiberziuv'));

    //     $this->assertHasErrors($user, 1);
    // }

}
