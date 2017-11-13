<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171017122001 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE social_repost ADD person_points_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE social_repost ADD CONSTRAINT FK_C37F24196740B485 FOREIGN KEY (person_points_id) REFERENCES person_points (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C37F24196740B485 ON social_repost (person_points_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE social_repost DROP CONSTRAINT FK_C37F24196740B485');
        $this->addSql('DROP INDEX UNIQ_C37F24196740B485');
        $this->addSql('ALTER TABLE social_repost DROP person_points_id');
    }
}
