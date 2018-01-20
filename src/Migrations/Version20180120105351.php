<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180120105351 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE invoices (id INT AUTO_INCREMENT NOT NULL, evidence_number VARCHAR(255) NOT NULL, invocie_number VARCHAR(255) NOT NULL, due_date DATE NOT NULL, amount DOUBLE PRECISION NOT NULL, state SMALLINT NOT NULL, contractor_number INT NOT NULL, notes LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE companies (id INT AUTO_INCREMENT NOT NULL, company_name VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, surname VARCHAR(255) DEFAULT NULL, telephone VARCHAR(255) DEFAULT NULL, cellphone VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, contractor_number INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE faktury');
        $this->addSql('DROP TABLE firmy');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE faktury (id INT AUTO_INCREMENT NOT NULL, nr_ewidencyjny VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, nr_dokumentu VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, termin_zaplaty DATE NOT NULL, kwota DOUBLE PRECISION NOT NULL, stan SMALLINT NOT NULL, nr_kontrahenta INT NOT NULL, notatki LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE firmy (id INT AUTO_INCREMENT NOT NULL, nazwa VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, nr_kontrahenta INT NOT NULL, imie VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, nazwisko VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, telefon VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, komorka VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, email VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE invoices');
        $this->addSql('DROP TABLE companies');
    }
}
