<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240405132527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE depense_appro (id INT AUTO_INCREMENT NOT NULL, boisson_id INT DEFAULT NULL, quantite_achete VARCHAR(50) NOT NULL, prix_unitaire VARCHAR(50) NOT NULL, montant VARCHAR(50) NOT NULL, total_depense VARCHAR(60) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7193943C734B8089 (boisson_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE magasin (id INT AUTO_INCREMENT NOT NULL, boisson_id INT DEFAULT NULL, quantite_stock VARCHAR(50) NOT NULL, quantite_sortir_resto VARCHAR(50) NOT NULL, quantite_ajout_magasin VARCHAR(50) NOT NULL, prix_achat VARCHAR(50) NOT NULL, stock_final VARCHAR(80) NOT NULL, INDEX IDX_54AF5F27734B8089 (boisson_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vente_boisson (id INT AUTO_INCREMENT NOT NULL, prix_vente_boisson VARCHAR(50) NOT NULL, quantite_vendue VARCHAR(50) NOT NULL, total_vente VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vente_boisson_boisson (vente_boisson_id INT NOT NULL, boisson_id INT NOT NULL, INDEX IDX_C480CACDE7887C7E (vente_boisson_id), INDEX IDX_C480CACD734B8089 (boisson_id), PRIMARY KEY(vente_boisson_id, boisson_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE depense_appro ADD CONSTRAINT FK_7193943C734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id)');
        $this->addSql('ALTER TABLE magasin ADD CONSTRAINT FK_54AF5F27734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id)');
        $this->addSql('ALTER TABLE vente_boisson_boisson ADD CONSTRAINT FK_C480CACDE7887C7E FOREIGN KEY (vente_boisson_id) REFERENCES vente_boisson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vente_boisson_boisson ADD CONSTRAINT FK_C480CACD734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8B97C84D8947610D ON boisson (designation)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depense_appro DROP FOREIGN KEY FK_7193943C734B8089');
        $this->addSql('ALTER TABLE magasin DROP FOREIGN KEY FK_54AF5F27734B8089');
        $this->addSql('ALTER TABLE vente_boisson_boisson DROP FOREIGN KEY FK_C480CACDE7887C7E');
        $this->addSql('ALTER TABLE vente_boisson_boisson DROP FOREIGN KEY FK_C480CACD734B8089');
        $this->addSql('DROP TABLE depense_appro');
        $this->addSql('DROP TABLE magasin');
        $this->addSql('DROP TABLE vente_boisson');
        $this->addSql('DROP TABLE vente_boisson_boisson');
        $this->addSql('DROP INDEX UNIQ_8B97C84D8947610D ON boisson');
    }
}
