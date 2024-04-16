<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240405162544 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vente_boisson_boisson DROP FOREIGN KEY FK_C480CACD734B8089');
        $this->addSql('ALTER TABLE vente_boisson_boisson DROP FOREIGN KEY FK_C480CACDE7887C7E');
        $this->addSql('DROP TABLE vente_boisson');
        $this->addSql('DROP TABLE vente_boisson_boisson');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vente_boisson (id INT AUTO_INCREMENT NOT NULL, prix_vente_boisson VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, quantite_vendue VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, total_vente VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE vente_boisson_boisson (vente_boisson_id INT NOT NULL, boisson_id INT NOT NULL, INDEX IDX_C480CACD734B8089 (boisson_id), INDEX IDX_C480CACDE7887C7E (vente_boisson_id), PRIMARY KEY(vente_boisson_id, boisson_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE vente_boisson_boisson ADD CONSTRAINT FK_C480CACD734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vente_boisson_boisson ADD CONSTRAINT FK_C480CACDE7887C7E FOREIGN KEY (vente_boisson_id) REFERENCES vente_boisson (id) ON DELETE CASCADE');
    }
}
