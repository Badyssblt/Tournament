<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240119202404 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tournament ADD winner_tournament_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tournament ADD CONSTRAINT FK_BD5FB8D9F843B524 FOREIGN KEY (winner_tournament_id) REFERENCES team (id)');
        $this->addSql('CREATE INDEX IDX_BD5FB8D9F843B524 ON tournament (winner_tournament_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tournament DROP FOREIGN KEY FK_BD5FB8D9F843B524');
        $this->addSql('DROP INDEX IDX_BD5FB8D9F843B524 ON tournament');
        $this->addSql('ALTER TABLE tournament DROP winner_tournament_id');
    }
}
