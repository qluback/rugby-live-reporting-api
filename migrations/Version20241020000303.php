<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241020000303 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE team_competing ADD COLUMN side INTEGER NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__team_competing AS SELECT id, team_id FROM team_competing');
        $this->addSql('DROP TABLE team_competing');
        $this->addSql('CREATE TABLE team_competing (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, team_id INTEGER NOT NULL, CONSTRAINT FK_64BA850296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO team_competing (id, team_id) SELECT id, team_id FROM __temp__team_competing');
        $this->addSql('DROP TABLE __temp__team_competing');
        $this->addSql('CREATE INDEX IDX_64BA850296CD8AE ON team_competing (team_id)');
    }
}
