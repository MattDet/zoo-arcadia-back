<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240919033620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal CHANGE name name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE habitat CHANGE name name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE role CHANGE role_name role_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(255) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE first_name first_name VARCHAR(255) NOT NULL, CHANGE last_name last_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE veterinary_report CHANGE report_date report_date DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE habitat CHANGE name name VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(50) NOT NULL, CHANGE password password VARCHAR(50) NOT NULL, CHANGE first_name first_name VARCHAR(50) NOT NULL, CHANGE last_name last_name VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE animal CHANGE name name VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE role CHANGE role_name role_name VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE veterinary_report CHANGE report_date report_date DATE NOT NULL');
    }
}
