<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171026122510 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE news (id SERIAL NOT NULL, text TEXT DEFAULT NULL, vk_id INT DEFAULT NULL, dt TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, photo VARCHAR(255) DEFAULT NULL, video VARCHAR(255) DEFAULT NULL, tags JSONB DEFAULT NULL, published BOOLEAN DEFAULT \'true\' NOT NULL, created_on TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, status VARCHAR(255) DEFAULT \'new\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN news.tags IS \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE social_repost ADD CONSTRAINT FK_C37F2419B5A459A0 FOREIGN KEY (news_id) REFERENCES news (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('ALTER TABLE social_repost DROP CONSTRAINT FK_C37F2419B5A459A0');
        $this->addSql('DROP TABLE news');
    }
}
