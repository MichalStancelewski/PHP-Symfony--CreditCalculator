<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230404121112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE auth_key (id INT AUTO_INCREMENT NOT NULL, key_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calculation_results (id INT AUTO_INCREMENT NOT NULL, calculation_date VARCHAR(255) NOT NULL, repayed_so_far DOUBLE PRECISION NOT NULL, profit_after_credit_annulment DOUBLE PRECISION NOT NULL, type VARCHAR(255) NOT NULL, overpaid_installments DOUBLE PRECISION DEFAULT NULL, full_cost_if_not_changed DOUBLE PRECISION DEFAULT NULL, profit_after_wibor_annulment DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clients (id INT AUTO_INCREMENT NOT NULL, name_first VARCHAR(255) DEFAULT NULL, name_last VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, agreement_gdpr TINYINT(1) NOT NULL, agreement_marketing TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE credit_data (id INT AUTO_INCREMENT NOT NULL, calculation_results_id INT NOT NULL, clients_id INT NOT NULL, currency VARCHAR(255) NOT NULL, value DOUBLE PRECISION NOT NULL, start_year VARCHAR(4) NOT NULL, start_month VARCHAR(2) NOT NULL, period INT NOT NULL, margin DOUBLE PRECISION DEFAULT NULL, UNIQUE INDEX UNIQ_AA314C5E1F97560 (calculation_results_id), INDEX IDX_AA314C5EAB014612 (clients_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE credit_data ADD CONSTRAINT FK_AA314C5E1F97560 FOREIGN KEY (calculation_results_id) REFERENCES calculation_results (id)');
        $this->addSql('ALTER TABLE credit_data ADD CONSTRAINT FK_AA314C5EAB014612 FOREIGN KEY (clients_id) REFERENCES clients (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE credit_data DROP FOREIGN KEY FK_AA314C5E1F97560');
        $this->addSql('ALTER TABLE credit_data DROP FOREIGN KEY FK_AA314C5EAB014612');
        $this->addSql('DROP TABLE auth_key');
        $this->addSql('DROP TABLE calculation_results');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE credit_data');
    }
}
