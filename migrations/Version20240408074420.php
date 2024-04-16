<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240408074420 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quantite_ajoute (id INT AUTO_INCREMENT NOT NULL, magasin_id INT DEFAULT NULL, quantite_ajoutee VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_C0B01F0D20096AE3 (magasin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quantite_ajoute ADD CONSTRAINT FK_C0B01F0D20096AE3 FOREIGN KEY (magasin_id) REFERENCES magasin (id)');
        $this->addSql('ALTER TABLE depense_appro CHANGE total_depense total_depense VARCHAR(60) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quantite_ajoute DROP FOREIGN KEY FK_C0B01F0D20096AE3');
        $this->addSql('DROP TABLE quantite_ajoute');
        $this->addSql('ALTER TABLE depense_appro CHANGE total_depense total_depense VARCHAR(60) DEFAULT NULL');
    }
}
