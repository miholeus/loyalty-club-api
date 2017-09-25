<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170925122304 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE event_forecast ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event_forecast ADD score_in_round VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE event_forecast ADD CONSTRAINT FK_6C709194A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6C709194A76ED395 ON event_forecast (user_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE event_forecast DROP CONSTRAINT FK_6C709194A76ED395');
        $this->addSql('DROP INDEX IDX_6C709194A76ED395');
        $this->addSql('ALTER TABLE event_forecast DROP user_id');
        $this->addSql('ALTER TABLE event_forecast DROP score_in_round');
    }
}
