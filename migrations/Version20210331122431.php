<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210331122431 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis ADD auteur VARCHAR(255) NOT NULL, ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE medecins ADD image VARCHAR(255) NOT NULL, CHANGE specialite_id specialite_id INT DEFAULT NULL, CHANGE departement_id departement_id INT DEFAULT NULL, CHANGE telephone telephone VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE specialite DROP relation');
        $this->addSql('ALTER TABLE utilisateurs DROP FOREIGN KEY FK_497B315EFB88E14F');
        $this->addSql('DROP INDEX IDX_497B315EFB88E14F ON utilisateurs');
        $this->addSql('ALTER TABLE utilisateurs ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', DROP utilisateur_id, CHANGE telephone telephone VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP auteur, DROP created_at');
        $this->addSql('ALTER TABLE medecins DROP image, CHANGE specialite_id specialite_id INT NOT NULL, CHANGE departement_id departement_id INT NOT NULL, CHANGE telephone telephone INT NOT NULL');
        $this->addSql('ALTER TABLE specialite ADD relation VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE utilisateurs ADD utilisateur_id INT DEFAULT NULL, DROP roles, CHANGE telephone telephone INT NOT NULL');
        $this->addSql('ALTER TABLE utilisateurs ADD CONSTRAINT FK_497B315EFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES specialite (id)');
        $this->addSql('CREATE INDEX IDX_497B315EFB88E14F ON utilisateurs (utilisateur_id)');
    }
}
