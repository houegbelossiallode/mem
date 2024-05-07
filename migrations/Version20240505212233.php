<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240505212233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vivre ADD proteine_id INT DEFAULT NULL, DROP qte_sortir');
        $this->addSql('ALTER TABLE vivre ADD CONSTRAINT FK_8633C0BA8956884A FOREIGN KEY (proteine_id) REFERENCES proteine (id)');
        $this->addSql('CREATE INDEX IDX_8633C0BA8956884A ON vivre (proteine_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vivre DROP FOREIGN KEY FK_8633C0BA8956884A');
        $this->addSql('DROP INDEX IDX_8633C0BA8956884A ON vivre');
        $this->addSql('ALTER TABLE vivre ADD qte_sortir VARCHAR(50) DEFAULT NULL, DROP proteine_id');
    }
}
