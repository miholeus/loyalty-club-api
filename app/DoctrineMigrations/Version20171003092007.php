<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171003092007 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP INDEX person_event');
        $this->addSql('CREATE UNIQUE INDEX event_forecast_by_user ON event_forecast (user_id, event_id)');
        $this->addSql('ALTER INDEX idx_89ada1aa217bbb47 RENAME TO IDX_6C709194217BBB47');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP INDEX event_forecast_by_user');
        $this->addSql('CREATE UNIQUE INDEX person_event ON event_forecast (person_id, event_id)');
        $this->addSql('ALTER INDEX idx_6c709194217bbb47 RENAME TO idx_89ada1aa217bbb47');
    }
}
