<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240409114857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quantite_ajoute ADD vivre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quantite_ajoute ADD CONSTRAINT FK_C0B01F0DDAA20828 FOREIGN KEY (vivre_id) REFERENCES vivre (id)');
        $this->addSql('CREATE INDEX IDX_C0B01F0DDAA20828 ON quantite_ajoute (vivre_id)');
        $this->addSql('ALTER TABLE vivre CHANGE qte_stock qte_stock VARCHAR(50) NOT NULL, CHANGE qte_sortir qte_sortir VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quantite_ajoute DROP FOREIGN KEY FK_C0B01F0DDAA20828');
        $this->addSql('DROP INDEX IDX_C0B01F0DDAA20828 ON quantite_ajoute');
        $this->addSql('ALTER TABLE quantite_ajoute DROP vivre_id');
        $this->addSql('ALTER TABLE vivre CHANGE qte_stock qte_stock VARCHAR(50) DEFAULT NULL, CHANGE qte_sortir qte_sortir VARCHAR(50) DEFAULT NULL');
    }
}
