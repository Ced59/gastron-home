<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210304083516 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie_plats (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_restaurant (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_restaurant_restaurant (categorie_restaurant_id INT NOT NULL, restaurant_id INT NOT NULL, INDEX IDX_F43B9739B2289124 (categorie_restaurant_id), INDEX IDX_F43B9739B1E7706E (restaurant_id), PRIMARY KEY(categorie_restaurant_id, restaurant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, restaurant_id INT NOT NULL, utilisateur_id INT NOT NULL, heure_commande DATETIME NOT NULL, status VARCHAR(30) NOT NULL, total_price DOUBLE PRECISION NOT NULL, INDEX IDX_6EEAA67DB1E7706E (restaurant_id), INDEX IDX_6EEAA67DFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_plat (id INT AUTO_INCREMENT NOT NULL, commande_id INT DEFAULT NULL, plats_id INT DEFAULT NULL, quantite INT NOT NULL, INDEX IDX_4B54A3E482EA2E54 (commande_id), INDEX IDX_4B54A3E4AA14E1C8 (plats_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livraison (id INT AUTO_INCREMENT NOT NULL, livreur_id INT NOT NULL, commande_id INT NOT NULL, date_livraison DATETIME DEFAULT NULL, adresse_livraison VARCHAR(255) NOT NULL, status VARCHAR(50) NOT NULL, INDEX IDX_A60C9F1FF8646701 (livreur_id), UNIQUE INDEX UNIQ_A60C9F1F82EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livreur (id INT AUTO_INCREMENT NOT NULL, type_vehicule VARCHAR(15) DEFAULT NULL, is_disponible TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plats (id INT AUTO_INCREMENT NOT NULL, categorie_plats_id INT NOT NULL, restaurant_id INT DEFAULT NULL, name VARCHAR(30) NOT NULL, price DOUBLE PRECISION NOT NULL, qte INT NOT NULL, image_file_plat VARCHAR(255) DEFAULT NULL, INDEX IDX_854A620A9293A0A2 (categorie_plats_id), INDEX IDX_854A620AB1E7706E (restaurant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurant (id INT AUTO_INCREMENT NOT NULL, company_name VARCHAR(255) DEFAULT NULL, image_file_restaurant VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE secteur (id INT AUTO_INCREMENT NOT NULL, nom_secteur VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, ville_id INT NOT NULL, restaurant_id INT DEFAULT NULL, livreur_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, adress VARCHAR(255) NOT NULL, user_type VARCHAR(20) NOT NULL, image_file_name VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649A73F0036 (ville_id), UNIQUE INDEX UNIQ_8D93D649B1E7706E (restaurant_id), UNIQUE INDEX UNIQ_8D93D649F8646701 (livreur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, secteur_id INT NOT NULL, nom_ville VARCHAR(70) NOT NULL, code_postal VARCHAR(10) DEFAULT NULL, INDEX IDX_43C3D9C39F7E4405 (secteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie_restaurant_restaurant ADD CONSTRAINT FK_F43B9739B2289124 FOREIGN KEY (categorie_restaurant_id) REFERENCES categorie_restaurant (id)');
        $this->addSql('ALTER TABLE categorie_restaurant_restaurant ADD CONSTRAINT FK_F43B9739B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE commande_plat ADD CONSTRAINT FK_4B54A3E482EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE commande_plat ADD CONSTRAINT FK_4B54A3E4AA14E1C8 FOREIGN KEY (plats_id) REFERENCES plats (id)');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1FF8646701 FOREIGN KEY (livreur_id) REFERENCES livreur (id)');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1F82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE plats ADD CONSTRAINT FK_854A620A9293A0A2 FOREIGN KEY (categorie_plats_id) REFERENCES categorie_plats (id)');
        $this->addSql('ALTER TABLE plats ADD CONSTRAINT FK_854A620AB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649A73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649F8646701 FOREIGN KEY (livreur_id) REFERENCES livreur (id)');
        $this->addSql('ALTER TABLE ville ADD CONSTRAINT FK_43C3D9C39F7E4405 FOREIGN KEY (secteur_id) REFERENCES secteur (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plats DROP FOREIGN KEY FK_854A620A9293A0A2');
        $this->addSql('ALTER TABLE categorie_restaurant_restaurant DROP FOREIGN KEY FK_F43B9739B2289124');
        $this->addSql('ALTER TABLE commande_plat DROP FOREIGN KEY FK_4B54A3E482EA2E54');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1F82EA2E54');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1FF8646701');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649F8646701');
        $this->addSql('ALTER TABLE commande_plat DROP FOREIGN KEY FK_4B54A3E4AA14E1C8');
        $this->addSql('ALTER TABLE categorie_restaurant_restaurant DROP FOREIGN KEY FK_F43B9739B1E7706E');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DB1E7706E');
        $this->addSql('ALTER TABLE plats DROP FOREIGN KEY FK_854A620AB1E7706E');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649B1E7706E');
        $this->addSql('ALTER TABLE ville DROP FOREIGN KEY FK_43C3D9C39F7E4405');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DFB88E14F');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649A73F0036');
        $this->addSql('DROP TABLE categorie_plats');
        $this->addSql('DROP TABLE categorie_restaurant');
        $this->addSql('DROP TABLE categorie_restaurant_restaurant');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE commande_plat');
        $this->addSql('DROP TABLE livraison');
        $this->addSql('DROP TABLE livreur');
        $this->addSql('DROP TABLE plats');
        $this->addSql('DROP TABLE restaurant');
        $this->addSql('DROP TABLE secteur');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE ville');
    }
}
