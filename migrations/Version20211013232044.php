<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211013232044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande_stage (id INT AUTO_INCREMENT NOT NULL, stage_id INT DEFAULT NULL, offrestage_id INT NOT NULL, niveau_id INT NOT NULL, specialite_id INT NOT NULL, prenom VARCHAR(50) NOT NULL, nom VARCHAR(50) NOT NULL, date_naissance DATE NOT NULL, adresse VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, telephone INT NOT NULL, email VARCHAR(255) NOT NULL, etablissement VARCHAR(255) NOT NULL, nom_piece_jointe VARCHAR(255) NOT NULL, date_demande DATE NOT NULL, cin INT NOT NULL, INDEX IDX_34A210402298D193 (stage_id), INDEX IDX_34A21040FA0B43CE (offrestage_id), INDEX IDX_34A21040B3E9C81 (niveau_id), INDEX IDX_34A210402195E0F0 (specialite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre_stage (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, specialite_id INT NOT NULL, intitule VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, mission LONGTEXT NOT NULL, duree INT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, pre_requis LONGTEXT NOT NULL, date_creation DATE NOT NULL, INDEX IDX_955674F2C54C8C93 (type_id), INDEX IDX_955674F22195E0F0 (specialite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre_stage_niveau (offre_stage_id INT NOT NULL, niveau_id INT NOT NULL, INDEX IDX_EC735B32195A2A28 (offre_stage_id), INDEX IDX_EC735B32B3E9C81 (niveau_id), PRIMARY KEY(offre_stage_id, niveau_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specialite (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stage (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, utilisateur_id INT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, date_affectation DATE DEFAULT NULL, validation TINYINT(1) DEFAULT NULL, INDEX IDX_C27C9369BCF5E72D (categorie_id), INDEX IDX_C27C9369FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, login VARCHAR(100) NOT NULL, telephone INT NOT NULL, dat_creation DATETIME NOT NULL, cin INT DEFAULT NULL, UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demande_stage ADD CONSTRAINT FK_34A210402298D193 FOREIGN KEY (stage_id) REFERENCES stage (id)');
        $this->addSql('ALTER TABLE demande_stage ADD CONSTRAINT FK_34A21040FA0B43CE FOREIGN KEY (offrestage_id) REFERENCES offre_stage (id)');
        $this->addSql('ALTER TABLE demande_stage ADD CONSTRAINT FK_34A21040B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE demande_stage ADD CONSTRAINT FK_34A210402195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id)');
        $this->addSql('ALTER TABLE offre_stage ADD CONSTRAINT FK_955674F2C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE offre_stage ADD CONSTRAINT FK_955674F22195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id)');
        $this->addSql('ALTER TABLE offre_stage_niveau ADD CONSTRAINT FK_EC735B32195A2A28 FOREIGN KEY (offre_stage_id) REFERENCES offre_stage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre_stage_niveau ADD CONSTRAINT FK_EC735B32B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369BCF5E72D');
        $this->addSql('ALTER TABLE demande_stage DROP FOREIGN KEY FK_34A21040B3E9C81');
        $this->addSql('ALTER TABLE offre_stage_niveau DROP FOREIGN KEY FK_EC735B32B3E9C81');
        $this->addSql('ALTER TABLE demande_stage DROP FOREIGN KEY FK_34A21040FA0B43CE');
        $this->addSql('ALTER TABLE offre_stage_niveau DROP FOREIGN KEY FK_EC735B32195A2A28');
        $this->addSql('ALTER TABLE demande_stage DROP FOREIGN KEY FK_34A210402195E0F0');
        $this->addSql('ALTER TABLE offre_stage DROP FOREIGN KEY FK_955674F22195E0F0');
        $this->addSql('ALTER TABLE demande_stage DROP FOREIGN KEY FK_34A210402298D193');
        $this->addSql('ALTER TABLE offre_stage DROP FOREIGN KEY FK_955674F2C54C8C93');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369FB88E14F');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE demande_stage');
        $this->addSql('DROP TABLE niveau');
        $this->addSql('DROP TABLE offre_stage');
        $this->addSql('DROP TABLE offre_stage_niveau');
        $this->addSql('DROP TABLE specialite');
        $this->addSql('DROP TABLE stage');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE utilisateur');
    }
}
