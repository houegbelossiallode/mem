<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240611202145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE calibre_repas (id INT AUTO_INCREMENT NOT NULL, repas_id INT DEFAULT NULL, prix VARCHAR(50) NOT NULL, INDEX IDX_AEC1BB311D236AAA (repas_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE calibre_repas ADD CONSTRAINT FK_AEC1BB311D236AAA FOREIGN KEY (repas_id) REFERENCES repas (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calibre_repas DROP FOREIGN KEY FK_AEC1BB311D236AAA');
        $this->addSql('DROP TABLE calibre_repas');
    }
}
