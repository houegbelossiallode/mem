<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240418150453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depense_appro ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE depense_appro ADD CONSTRAINT FK_7193943CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7193943CA76ED395 ON depense_appro (user_id)');
        $this->addSql('ALTER TABLE vente_drink ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vente_drink ADD CONSTRAINT FK_19AF4D98A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_19AF4D98A76ED395 ON vente_drink (user_id)');
        $this->addSql('ALTER TABLE vente_repas ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vente_repas ADD CONSTRAINT FK_BCC25CFAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_BCC25CFAA76ED395 ON vente_repas (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depense_appro DROP FOREIGN KEY FK_7193943CA76ED395');
        $this->addSql('DROP INDEX IDX_7193943CA76ED395 ON depense_appro');
        $this->addSql('ALTER TABLE depense_appro DROP user_id');
        $this->addSql('ALTER TABLE vente_drink DROP FOREIGN KEY FK_19AF4D98A76ED395');
        $this->addSql('DROP INDEX IDX_19AF4D98A76ED395 ON vente_drink');
        $this->addSql('ALTER TABLE vente_drink DROP user_id');
        $this->addSql('ALTER TABLE vente_repas DROP FOREIGN KEY FK_BCC25CFAA76ED395');
        $this->addSql('DROP INDEX IDX_BCC25CFAA76ED395 ON vente_repas');
        $this->addSql('ALTER TABLE vente_repas DROP user_id');
    }
}
