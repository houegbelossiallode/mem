<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240405162248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vente_drink (id INT AUTO_INCREMENT NOT NULL, boisson_id INT DEFAULT NULL, prix_vente VARCHAR(50) NOT NULL, quantite_boisson_vendue VARCHAR(50) NOT NULL, montant VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_19AF4D98734B8089 (boisson_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vente_drink ADD CONSTRAINT FK_19AF4D98734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id)');
        $this->addSql('ALTER TABLE depense_appro CHANGE total_depense total_depense VARCHAR(60) NOT NULL, CHANGE date date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vente_drink DROP FOREIGN KEY FK_19AF4D98734B8089');
        $this->addSql('DROP TABLE vente_drink');
        $this->addSql('ALTER TABLE depense_appro CHANGE total_depense total_depense VARCHAR(60) DEFAULT NULL, CHANGE date date DATETIME NOT NULL');
    }
}
