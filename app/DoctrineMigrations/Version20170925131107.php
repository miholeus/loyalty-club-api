<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170925131107 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP INDEX person_event_forecast__dt');
        $this->addSql('ALTER TABLE event_forecast ADD updated_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE event_forecast ADD status INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event_forecast RENAME COLUMN dt TO created_on');
        $this->addSql('CREATE INDEX person_event_forecast__dt ON event_forecast (created_on)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP INDEX person_event_forecast__dt');
        $this->addSql('ALTER TABLE event_forecast DROP updated_on');
        $this->addSql('ALTER TABLE event_forecast DROP status');
        $this->addSql('ALTER TABLE event_forecast RENAME COLUMN created_on TO dt');
        $this->addSql('CREATE INDEX person_event_forecast__dt ON event_forecast (dt)');
    }
}
