<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170728155329 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE push_device_id DROP CONSTRAINT push_device_id_pkey');
        $this->addSql('ALTER TABLE push_device_id ADD id SERIAL NOT NULL');
        $this->addSql('ALTER TABLE push_device_id ALTER os TYPE VARCHAR(10)');
        $this->addSql('ALTER TABLE push_device_id ADD PRIMARY KEY (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE push_device_id DROP CONSTRAINT push_device_id_pkey');
        $this->addSql('ALTER TABLE push_device_id DROP id');
        $this->addSql('ALTER TABLE push_device_id ALTER os TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE push_device_id ADD PRIMARY KEY (os)');
    }
}
