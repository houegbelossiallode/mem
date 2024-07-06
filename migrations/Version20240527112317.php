<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240527112317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE calibre (id INT AUTO_INCREMENT NOT NULL, proteine_id INT DEFAULT NULL, masse VARCHAR(50) NOT NULL, INDEX IDX_95F4E6D18956884A (proteine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE calibre ADD CONSTRAINT FK_95F4E6D18956884A FOREIGN KEY (proteine_id) REFERENCES proteine (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calibre DROP FOREIGN KEY FK_95F4E6D18956884A');
        $this->addSql('DROP TABLE calibre');
    }
}
