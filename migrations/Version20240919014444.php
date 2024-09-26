<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240919014444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, service_id INT DEFAULT NULL, animal_id INT DEFAULT NULL, habitat_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, alt_text VARCHAR(255) NOT NULL, INDEX IDX_C53D045FED5CA9E6 (service_id), INDEX IDX_C53D045F8E962C16 (animal_id), INDEX IDX_C53D045FAFFE2D26 (habitat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FAFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitat (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FED5CA9E6');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F8E962C16');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FAFFE2D26');
        $this->addSql('DROP TABLE image');
    }
}
