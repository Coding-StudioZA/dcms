<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180118175729 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE kontakty');
        $this->addSql('DROP INDEX UNIQ_3881AD35C3520957 ON firmy');
        $this->addSql('ALTER TABLE firmy ADD imie VARCHAR(255) DEFAULT NULL, ADD nazwisko VARCHAR(255) DEFAULT NULL, ADD telefon VARCHAR(255) DEFAULT NULL, ADD komorka VARCHAR(255) DEFAULT NULL, ADD email VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE kontakty (id INT AUTO_INCREMENT NOT NULL, imie VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, nazwisko VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, telefon VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, komorka VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, email VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, nr_kontrahenta INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE firmy DROP imie, DROP nazwisko, DROP telefon, DROP komorka, DROP email');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3881AD35C3520957 ON firmy (nr_kontrahenta)');
    }
}
