<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240408100336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE magasin ADD quantite_ajout_magasin VARCHAR(50) NOT NULL, CHANGE quantite_stock quantite_stock VARCHAR(50) NOT NULL, CHANGE quantite_sortir_resto quantite_sortir_resto VARCHAR(50) NOT NULL, CHANGE stock_final stock_final VARCHAR(80) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE magasin DROP quantite_ajout_magasin, CHANGE quantite_stock quantite_stock VARCHAR(50) DEFAULT NULL, CHANGE quantite_sortir_resto quantite_sortir_resto VARCHAR(50) DEFAULT NULL, CHANGE stock_final stock_final VARCHAR(80) DEFAULT NULL');
    }
}
