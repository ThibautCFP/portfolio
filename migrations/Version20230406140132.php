<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230406140132 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, enabled TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_project (skill_id INT NOT NULL, project_id INT NOT NULL, INDEX IDX_35464EC75585C142 (skill_id), INDEX IDX_35464EC7166D1F9C (project_id), PRIMARY KEY(skill_id, project_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE skill_project ADD CONSTRAINT FK_35464EC75585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_project ADD CONSTRAINT FK_35464EC7166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skill_project DROP FOREIGN KEY FK_35464EC75585C142');
        $this->addSql('ALTER TABLE skill_project DROP FOREIGN KEY FK_35464EC7166D1F9C');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE skill_project');
    }
}
