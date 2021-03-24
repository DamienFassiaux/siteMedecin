<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210324155914 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis ADD auteur VARCHAR(255) NOT NULL, ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE medecins ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', CHANGE specialite_id specialite_id INT DEFAULT NULL, CHANGE departement_id departement_id INT DEFAULT NULL, CHANGE centre_medical centre_medical VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateurs ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP auteur, DROP created_at');
        $this->addSql('ALTER TABLE medecins DROP roles, CHANGE specialite_id specialite_id INT NOT NULL, CHANGE departement_id departement_id INT NOT NULL, CHANGE centre_medical centre_medical VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE utilisateurs DROP roles');
    }
}
