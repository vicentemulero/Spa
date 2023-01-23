<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230123044834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation (id SERIAL NOT NULL, service_id VARCHAR(255) DEFAULT NULL, reserved_day VARCHAR(255) NOT NULL, reserved_time VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, client_name VARCHAR(255) NOT NULL, client_email VARCHAR(255) NOT NULL, service_name VARCHAR(255) NOT NULL, service_price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_42C84955ED5CA9E6 ON reservation (service_id)');
        $this->addSql('CREATE TABLE service (id VARCHAR(255) NOT NULL, service_name VARCHAR(255) NOT NULL, service_price DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE service_schedule (id SERIAL NOT NULL, service_id VARCHAR(255) NOT NULL, reservation_id INT DEFAULT NULL, day_available VARCHAR(255) NOT NULL, available_from VARCHAR(255) NOT NULL, available_to VARCHAR(255) NOT NULL, available_time VARCHAR(255) NOT NULL, is_available BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A34E4AC6B83297E7 ON service_schedule (reservation_id)');
        $this->addSql('CREATE INDEX IDX_A34E4AC6ED5CA9E6 ON service_schedule (service_id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE service_schedule ADD CONSTRAINT FK_A34E4AC6B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE service_schedule ADD CONSTRAINT FK_A34E4AC6ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE reservation DROP CONSTRAINT FK_42C84955ED5CA9E6');
        $this->addSql('ALTER TABLE service_schedule DROP CONSTRAINT FK_A34E4AC6B83297E7');
        $this->addSql('ALTER TABLE service_schedule DROP CONSTRAINT FK_A34E4AC6ED5CA9E6');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE service_schedule');
    }
}
