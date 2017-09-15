<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170911140113 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE event ADD mvp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD is_line_up BOOLEAN DEFAULT \'false\' NOT NULL');
        $this->addSql('ALTER TABLE event ADD score_in_round VARCHAR(256) DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7962E2E2D FOREIGN KEY (mvp) REFERENCES player (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX FK_event_mvp ON event (mvp)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP INDEX FK_event_mvp');
        $this->addSql('ALTER TABLE event DROP mvp');
        $this->addSql('ALTER TABLE event DROP is_line_up');
        $this->addSql('ALTER TABLE event DROP score_in_round');
    }
}
