<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240201145127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matche DROP FOREIGN KEY FK_9FCAD5105DFCD4B8');
        $this->addSql('DROP INDEX IDX_9FCAD5105DFCD4B8 ON matche');
        $this->addSql('ALTER TABLE matche DROP winner_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matche ADD winner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE matche ADD CONSTRAINT FK_9FCAD5105DFCD4B8 FOREIGN KEY (winner_id) REFERENCES team (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_9FCAD5105DFCD4B8 ON matche (winner_id)');
    }
}
