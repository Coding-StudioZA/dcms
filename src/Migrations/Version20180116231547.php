<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180116231547 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE kontakty CHANGE imie imie VARCHAR(255) DEFAULT NULL, CHANGE nazwisko nazwisko VARCHAR(255) DEFAULT NULL, CHANGE telefon telefon VARCHAR(255) DEFAULT NULL, CHANGE komorka komorka VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE kontakty CHANGE imie imie VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE nazwisko nazwisko VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE telefon telefon VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE komorka komorka VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE email email VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
