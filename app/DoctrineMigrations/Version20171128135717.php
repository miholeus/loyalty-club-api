<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171128135717 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE ticket_for_zen (id SERIAL NOT NULL, event_id INT DEFAULT NULL, name VARCHAR(256) NOT NULL, barcode VARCHAR(256) NOT NULL, price INT NOT NULL, status VARCHAR(128) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX FK_ticket_for_zen_event ON ticket_for_zen (event_id)');
        $this->addSql('ALTER TABLE ticket_for_zen ADD CONSTRAINT FK_7BFED01C71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE ticket_for_zen');
    }
}
