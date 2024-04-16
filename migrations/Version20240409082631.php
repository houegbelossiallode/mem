<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240409082631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recette (vente_boisson_id INT NOT NULL, vente_repas_id INT NOT NULL, montant_recette VARCHAR(255) NOT NULL, INDEX IDX_49BB6390E7887C7E (vente_boisson_id), INDEX IDX_49BB6390BD76824E (vente_repas_id), PRIMARY KEY(vente_boisson_id, vente_repas_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB6390E7887C7E FOREIGN KEY (vente_boisson_id) REFERENCES vente_drink (id)');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB6390BD76824E FOREIGN KEY (vente_repas_id) REFERENCES vente_repas (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB6390E7887C7E');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB6390BD76824E');
        $this->addSql('DROP TABLE recette');
    }
}
