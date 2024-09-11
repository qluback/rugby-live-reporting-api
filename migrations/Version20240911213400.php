<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240911213400 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, team_home_id INTEGER NOT NULL, team_visitor_id INTEGER NOT NULL, score_home INTEGER NOT NULL, score_visitor INTEGER NOT NULL, CONSTRAINT FK_232B318CD7B4B9AB FOREIGN KEY (team_home_id) REFERENCES team_competing (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_232B318C39D29CA8 FOREIGN KEY (team_visitor_id) REFERENCES team_competing (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_232B318CD7B4B9AB ON game (team_home_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_232B318C39D29CA8 ON game (team_visitor_id)');
        $this->addSql('CREATE TABLE highlight (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, team_competing_id INTEGER NOT NULL, type VARCHAR(255) NOT NULL, minute INTEGER NOT NULL, CONSTRAINT FK_C998D8348D2D457F FOREIGN KEY (team_competing_id) REFERENCES team_competing (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_C998D8348D2D457F ON highlight (team_competing_id)');
        $this->addSql('CREATE TABLE team (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE team_competing (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, team_id INTEGER NOT NULL, CONSTRAINT FK_64BA850296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_64BA850296CD8AE ON team_competing (team_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE highlight');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE team_competing');
    }
}
