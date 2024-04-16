<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240409155442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depense_appro ADD total_depense VARCHAR(60) NOT NULL, ADD nombre_trou VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE quantite_ajoute CHANGE quantite_ajoutee quantite_ajoutee VARCHAR(50) NOT NULL, CHANGE quantite_sortir quantite_sortir VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depense_appro DROP total_depense, DROP nombre_trou');
        $this->addSql('ALTER TABLE quantite_ajoute CHANGE quantite_ajoutee quantite_ajoutee VARCHAR(50) DEFAULT NULL, CHANGE quantite_sortir quantite_sortir VARCHAR(50) DEFAULT NULL');
    }
}
