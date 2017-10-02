<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170929100533 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE person DROP CONSTRAINT fk_34dcd1766f0eccce');
        $this->addSql('DROP INDEX idx_34dcd1766f0eccce');
        $this->addSql('ALTER TABLE person DROP club_owner');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE person ADD club_owner INT DEFAULT NULL');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT fk_34dcd1766f0eccce FOREIGN KEY (club_owner) REFERENCES club (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_34dcd1766f0eccce ON person (club_owner)');
    }
}
