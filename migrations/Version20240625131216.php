<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240625131216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD prenom VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE vente_repas CHANGE qte_vendue qte_vendue VARCHAR(255) NOT NULL, CHANGE prix_vente_proteine prix_vente_proteine VARCHAR(50) NOT NULL, CHANGE prix_vente_accompagnement prix_vente_accompagnement VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE vivre CHANGE proteine_id proteine_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP prenom');
        $this->addSql('ALTER TABLE vente_repas CHANGE prix_vente_proteine prix_vente_proteine VARCHAR(50) DEFAULT NULL, CHANGE qte_vendue qte_vendue VARCHAR(255) DEFAULT NULL, CHANGE prix_vente_accompagnement prix_vente_accompagnement VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE vivre CHANGE proteine_id proteine_id INT NOT NULL');
    }
}
