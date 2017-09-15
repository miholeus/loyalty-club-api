<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170915130417 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE device_token (id SERIAL NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(256) DEFAULT NULL, created_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, device_type VARCHAR(256) DEFAULT NULL, device_name VARCHAR(256) DEFAULT NULL, status INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX device_token__user_id ON device_token (user_id)');
        $this->addSql('ALTER TABLE device_token ADD CONSTRAINT FK_99B2415CA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE device_token');
    }
}
