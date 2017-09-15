<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170907135519 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE player ADD firstname VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE player ADD lastname VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE player ADD middlename VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE player ADD photo VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE player ADD is_active BOOLEAN DEFAULT NULL');
        $this->addSql('ALTER TABLE player ADD created_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE player ADD updated_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE player DROP name');
        $this->addSql('ALTER TABLE player DROP active');
        $this->addSql('ALTER TABLE player RENAME COLUMN bdate TO birthdate');
        $this->addSql('CREATE INDEX player_name__idx ON player (lastname, firstname, middlename)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP INDEX player_name__idx');
        $this->addSql('ALTER TABLE player ADD name VARCHAR(200) DEFAULT \'нет\' NOT NULL');
        $this->addSql('ALTER TABLE player ADD active BOOLEAN DEFAULT \'false\' NOT NULL');
        $this->addSql('ALTER TABLE player DROP firstname');
        $this->addSql('ALTER TABLE player DROP lastname');
        $this->addSql('ALTER TABLE player DROP middlename');
        $this->addSql('ALTER TABLE player DROP photo');
        $this->addSql('ALTER TABLE player DROP is_active');
        $this->addSql('ALTER TABLE player DROP created_on');
        $this->addSql('ALTER TABLE player DROP updated_on');
        $this->addSql('ALTER TABLE player RENAME COLUMN birthdate TO bdate');
    }
}
