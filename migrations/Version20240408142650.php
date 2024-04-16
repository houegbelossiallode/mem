<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240408142650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE congelateur (id INT AUTO_INCREMENT NOT NULL, boisson_id INT DEFAULT NULL, qte_stock VARCHAR(50) NOT NULL, INDEX IDX_883ABC81734B8089 (boisson_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE congelateur ADD CONSTRAINT FK_883ABC81734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id)');
        $this->addSql('ALTER TABLE magasin CHANGE quantite_stock quantite_stock VARCHAR(50) NOT NULL, CHANGE quantite_sortir_resto quantite_sortir_resto VARCHAR(50) NOT NULL, CHANGE stock_final stock_final VARCHAR(80) NOT NULL');
        $this->addSql('ALTER TABLE quantite_ajoute CHANGE quantite_ajoutee quantite_ajoutee VARCHAR(50) NOT NULL, CHANGE quantite_sortir quantite_sortir VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE congelateur DROP FOREIGN KEY FK_883ABC81734B8089');
        $this->addSql('DROP TABLE congelateur');
        $this->addSql('ALTER TABLE magasin CHANGE quantite_stock quantite_stock VARCHAR(50) DEFAULT NULL, CHANGE quantite_sortir_resto quantite_sortir_resto VARCHAR(50) DEFAULT NULL, CHANGE stock_final stock_final VARCHAR(80) DEFAULT NULL');
        $this->addSql('ALTER TABLE quantite_ajoute CHANGE quantite_ajoutee quantite_ajoutee VARCHAR(50) DEFAULT NULL, CHANGE quantite_sortir quantite_sortir VARCHAR(50) DEFAULT NULL');
    }
}
