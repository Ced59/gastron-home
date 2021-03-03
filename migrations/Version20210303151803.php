<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210303151803 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie_restaurant_restaurant DROP FOREIGN KEY FK_F43B9739B1E7706E');
        $this->addSql('ALTER TABLE categorie_restaurant_restaurant DROP FOREIGN KEY FK_F43B9739B2289124');
        $this->addSql('ALTER TABLE categorie_restaurant_restaurant ADD CONSTRAINT FK_F43B9739B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE categorie_restaurant_restaurant ADD CONSTRAINT FK_F43B9739B2289124 FOREIGN KEY (categorie_restaurant_id) REFERENCES categorie_restaurant (id)');
        $this->addSql('ALTER TABLE restaurant ADD image_file_restaurant VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie_restaurant_restaurant DROP FOREIGN KEY FK_F43B9739B2289124');
        $this->addSql('ALTER TABLE categorie_restaurant_restaurant DROP FOREIGN KEY FK_F43B9739B1E7706E');
        $this->addSql('ALTER TABLE categorie_restaurant_restaurant ADD CONSTRAINT FK_F43B9739B2289124 FOREIGN KEY (categorie_restaurant_id) REFERENCES categorie_restaurant (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_restaurant_restaurant ADD CONSTRAINT FK_F43B9739B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restaurant DROP image_file_restaurant');
    }
}
