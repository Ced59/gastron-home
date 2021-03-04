<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210304085855 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livreur ADD description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE plats ADD description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE restaurant ADD description VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livreur DROP description');
        $this->addSql('ALTER TABLE plats DROP description');
        $this->addSql('ALTER TABLE restaurant DROP description');
    }
}
