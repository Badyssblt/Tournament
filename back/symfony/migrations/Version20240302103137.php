<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240302103137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tournament_game (tournament_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_14A683B233D1A3E7 (tournament_id), INDEX IDX_14A683B2E48FD905 (game_id), PRIMARY KEY(tournament_id, game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tournament_game ADD CONSTRAINT FK_14A683B233D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tournament_game ADD CONSTRAINT FK_14A683B2E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tournament DROP game');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tournament_game DROP FOREIGN KEY FK_14A683B233D1A3E7');
        $this->addSql('ALTER TABLE tournament_game DROP FOREIGN KEY FK_14A683B2E48FD905');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE tournament_game');
        $this->addSql('ALTER TABLE tournament ADD game VARCHAR(255) NOT NULL');
    }
}
