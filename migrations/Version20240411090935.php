<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240411090935 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE magasin CHANGE quantite_stock quantite_stock VARCHAR(50) NOT NULL, CHANGE quantite_sortir_resto quantite_sortir_resto VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE quantite_ajoute CHANGE quantite_ajoutee quantite_ajoutee VARCHAR(50) DEFAULT NULL, CHANGE quantite_sortir quantite_sortir VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE vivre CHANGE designation designation VARCHAR(255) NOT NULL, CHANGE qte_stock qte_stock VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE magasin CHANGE quantite_stock quantite_stock VARCHAR(50) DEFAULT NULL, CHANGE quantite_sortir_resto quantite_sortir_resto VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE quantite_ajoute CHANGE quantite_ajoutee quantite_ajoutee VARCHAR(50) NOT NULL, CHANGE quantite_sortir quantite_sortir VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE vivre CHANGE designation designation VARCHAR(255) DEFAULT NULL, CHANGE qte_stock qte_stock VARCHAR(50) DEFAULT NULL');
    }
}
