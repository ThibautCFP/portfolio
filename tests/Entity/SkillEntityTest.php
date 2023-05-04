<?php

namespace App\Tests\Entity;

use App\Tests\Traits\AssertTestTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;

class SkillEntityTest extends KernelTestCase
{
    protected $databaseTool;

    use AssertTestTrait;

    protected function setUp(): void
    {
        parent::setup();

        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();
    }
}
