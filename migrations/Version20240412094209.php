<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240412094209 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE proteine (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE repas DROP proteines');
        $this->addSql('ALTER TABLE vente_repas ADD proteine_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vente_repas ADD CONSTRAINT FK_BCC25CFA8956884A FOREIGN KEY (proteine_id) REFERENCES proteine (id)');
        $this->addSql('CREATE INDEX IDX_BCC25CFA8956884A ON vente_repas (proteine_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vente_repas DROP FOREIGN KEY FK_BCC25CFA8956884A');
        $this->addSql('DROP TABLE proteine');
        $this->addSql('ALTER TABLE repas ADD proteines VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_BCC25CFA8956884A ON vente_repas');
        $this->addSql('ALTER TABLE vente_repas DROP proteine_id');
    }
}
