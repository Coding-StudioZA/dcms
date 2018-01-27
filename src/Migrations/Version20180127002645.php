<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180127002645 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE invoices ADD contractor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE invoices ADD CONSTRAINT FK_6A2F2F95B0265DC7 FOREIGN KEY (contractor_id) REFERENCES companies (id)');
        $this->addSql('CREATE INDEX IDX_6A2F2F95B0265DC7 ON invoices (contractor_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE invoices DROP FOREIGN KEY FK_6A2F2F95B0265DC7');
        $this->addSql('DROP INDEX IDX_6A2F2F95B0265DC7 ON invoices');
        $this->addSql('ALTER TABLE invoices DROP contractor_id');
    }
}
