<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241120160528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game ADD COLUMN time INTEGER NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__game AS SELECT id, team_competing_home_id, team_competing_visitor_id, score_home, score_visitor FROM game');
        $this->addSql('DROP TABLE game');
        $this->addSql('CREATE TABLE game (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, team_competing_home_id INTEGER NOT NULL, team_competing_visitor_id INTEGER NOT NULL, score_home INTEGER NOT NULL, score_visitor INTEGER NOT NULL, CONSTRAINT FK_232B318C97384821 FOREIGN KEY (team_competing_home_id) REFERENCES team_competing (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_232B318C3CD91D49 FOREIGN KEY (team_competing_visitor_id) REFERENCES team_competing (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO game (id, team_competing_home_id, team_competing_visitor_id, score_home, score_visitor) SELECT id, team_competing_home_id, team_competing_visitor_id, score_home, score_visitor FROM __temp__game');
        $this->addSql('DROP TABLE __temp__game');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_232B318C97384821 ON game (team_competing_home_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_232B318C3CD91D49 ON game (team_competing_visitor_id)');
    }
}
