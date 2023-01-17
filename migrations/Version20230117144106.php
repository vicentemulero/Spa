<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230117144106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE service (id VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, name VARCHAR(255) NOT NULL UNIQUE, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE service_schedule (id SERIAL NOT NULL, service_id VARCHAR(255) NOT NULL, reservation_id VARCHAR(255) DEFAULT NULL, reservation_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, day_available VARCHAR(255) NOT NULL, available_from VARCHAR(255) NOT NULL, available_to VARCHAR(255) NOT NULL,time_available VARCHAR(255) NOT NULL, is_available BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A34E4AC6ED5CA9E6 ON service_schedule (service_id)');
        $this->addSql('ALTER TABLE service_schedule ADD CONSTRAINT FK_A34E4AC6ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE service_schedule DROP CONSTRAINT FK_A34E4AC6ED5CA9E6');
        $this->addSql('DROP TABLE services');
        $this->addSql('DROP TABLE service_schedule');
    }
}
