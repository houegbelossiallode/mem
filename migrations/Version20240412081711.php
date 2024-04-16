<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240412081711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vente_repas ADD repas_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vente_repas ADD CONSTRAINT FK_BCC25CFA1D236AAA FOREIGN KEY (repas_id) REFERENCES repas (id)');
        $this->addSql('CREATE INDEX IDX_BCC25CFA1D236AAA ON vente_repas (repas_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vente_repas DROP FOREIGN KEY FK_BCC25CFA1D236AAA');
        $this->addSql('DROP INDEX IDX_BCC25CFA1D236AAA ON vente_repas');
        $this->addSql('ALTER TABLE vente_repas DROP repas_id');
    }
}
