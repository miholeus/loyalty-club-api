<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170927113457 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE badge_type (id SERIAL NOT NULL, title VARCHAR(255) NOT NULL, sort INT DEFAULT 0 NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE badge (id SERIAL NOT NULL, type_id INT NOT NULL, title VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, photo VARCHAR(255) DEFAULT NULL, sort INT DEFAULT 0 NOT NULL, points INT DEFAULT 1 NOT NULL, max_points INT DEFAULT 1 NOT NULL, active BOOLEAN DEFAULT \'true\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE badge ADD CONSTRAINT FK_FEF0481DC54C8C93 FOREIGN KEY (type_id) REFERENCES badge_type (id) ON DELETE RESTRICT NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FEF0481D77153098 ON badge (code)');
        $this->addSql('CREATE INDEX IDX_FEF0481DC54C8C93 ON badge (type_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE badge DROP CONSTRAINT FK_FEF0481DC54C8C93');
        $this->addSql('DROP TABLE badge');
        $this->addSql('DROP TABLE badge_type');
    }
}
