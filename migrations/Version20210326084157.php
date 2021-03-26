<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210326084157 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, medecins_id INT NOT NULL, utilisateurs_id INT NOT NULL, titre VARCHAR(255) NOT NULL, contenu VARCHAR(255) NOT NULL, note_accueil INT NOT NULL, note_pro INT NOT NULL, auteur VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_8F91ABF0DA00906 (medecins_id), INDEX IDX_8F91ABF01E969C5 (utilisateurs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, numero INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medecins (id INT AUTO_INCREMENT NOT NULL, specialite_id INT DEFAULT NULL, departement_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, telephone INT NOT NULL, centre_medical VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) NOT NULL, code_postal INT NOT NULL, ville VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, horaires VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', INDEX IDX_691272DD2195E0F0 (specialite_id), INDEX IDX_691272DDCCF9E01E (departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rdv (id INT AUTO_INCREMENT NOT NULL, utilisateurs_id INT NOT NULL, medecins_id INT NOT NULL, date DATE NOT NULL, horaires TIME NOT NULL, INDEX IDX_10C31F861E969C5 (utilisateurs_id), INDEX IDX_10C31F86DA00906 (medecins_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specialite (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateurs (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, telephone INT NOT NULL, adresse VARCHAR(255) NOT NULL, code_postal INT NOT NULL, ville VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0DA00906 FOREIGN KEY (medecins_id) REFERENCES medecins (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF01E969C5 FOREIGN KEY (utilisateurs_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE medecins ADD CONSTRAINT FK_691272DD2195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id)');
        $this->addSql('ALTER TABLE medecins ADD CONSTRAINT FK_691272DDCCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F861E969C5 FOREIGN KEY (utilisateurs_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F86DA00906 FOREIGN KEY (medecins_id) REFERENCES medecins (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medecins DROP FOREIGN KEY FK_691272DDCCF9E01E');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0DA00906');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F86DA00906');
        $this->addSql('ALTER TABLE medecins DROP FOREIGN KEY FK_691272DD2195E0F0');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF01E969C5');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F861E969C5');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE medecins');
        $this->addSql('DROP TABLE rdv');
        $this->addSql('DROP TABLE specialite');
        $this->addSql('DROP TABLE utilisateurs');
    }
}
