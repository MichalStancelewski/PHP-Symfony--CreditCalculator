<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230403215912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE credit_data ADD calculation_results_id INT NOT NULL, ADD clients_id INT NOT NULL');
        $this->addSql('ALTER TABLE credit_data ADD CONSTRAINT FK_AA314C5E1F97560 FOREIGN KEY (calculation_results_id) REFERENCES calculation_results (id)');
        $this->addSql('ALTER TABLE credit_data ADD CONSTRAINT FK_AA314C5EAB014612 FOREIGN KEY (clients_id) REFERENCES clients (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AA314C5E1F97560 ON credit_data (calculation_results_id)');
        $this->addSql('CREATE INDEX IDX_AA314C5EAB014612 ON credit_data (clients_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE credit_data DROP FOREIGN KEY FK_AA314C5E1F97560');
        $this->addSql('ALTER TABLE credit_data DROP FOREIGN KEY FK_AA314C5EAB014612');
        $this->addSql('DROP INDEX UNIQ_AA314C5E1F97560 ON credit_data');
        $this->addSql('DROP INDEX IDX_AA314C5EAB014612 ON credit_data');
        $this->addSql('ALTER TABLE credit_data DROP calculation_results_id, DROP clients_id');
    }
}
