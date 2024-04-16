<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240405133458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vente_boisson_boisson (vente_boisson_id INT NOT NULL, boisson_id INT NOT NULL, INDEX IDX_C480CACDE7887C7E (vente_boisson_id), INDEX IDX_C480CACD734B8089 (boisson_id), PRIMARY KEY(vente_boisson_id, boisson_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vente_boisson_boisson ADD CONSTRAINT FK_C480CACDE7887C7E FOREIGN KEY (vente_boisson_id) REFERENCES vente_boisson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vente_boisson_boisson ADD CONSTRAINT FK_C480CACD734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vente_boisson_boisson DROP FOREIGN KEY FK_C480CACDE7887C7E');
        $this->addSql('ALTER TABLE vente_boisson_boisson DROP FOREIGN KEY FK_C480CACD734B8089');
        $this->addSql('DROP TABLE vente_boisson_boisson');
    }
}
