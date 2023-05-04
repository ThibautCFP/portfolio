<?php

namespace App\Tests\Entity;

use App\Entity\Skill;
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

    public function GetEntity(): Skill
    {
        $skill = new Skill;
        $skill
            ->setTitle('Travail de groupe')
            ->setEnabled(true);

        return $skill;
    }

    public function testEntityValide()
    {
        $this->assertHasErrors($this->GetEntity(), 0);
    }

    public function testTitleNotBlank()
    {
        $skill = $this->GetEntity()->setTitle('');

        $this->assertHasErrors($skill, 1);
    }

    public function testMaxTitleLength()
    {
        $skill = $this->GetEntity()->setTitle('nonfiznfgnerignrgnirgnidnginezfozpofjopjfosdkfoqrhgjqgjqieghqgubqvbnidfboiqefjgqegjrqpoejqojgjzùq,fknfzrgôihgzgiozebgoierhighziogzogjhuozGHPÇzhgiohziogjzgoezi');

        $this->assertHasErrors($skill, 1);
    }
}
