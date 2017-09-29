<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170929094922 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE sportomat_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE subs_list_id_seq CASCADE');
        $this->addSql('DROP TABLE sportomat');
        $this->addSql('DROP TABLE subs_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE sportomat_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE subs_list_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE sportomat (id SERIAL NOT NULL, email VARCHAR(50) DEFAULT NULL, fname VARCHAR(50) DEFAULT NULL, lname VARCHAR(50) DEFAULT NULL, testresult TEXT DEFAULT NULL, favsport VARCHAR(256) DEFAULT NULL, dt TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE subs_list (id SERIAL NOT NULL, name VARCHAR(256) DEFAULT \'\' NOT NULL, outer_id VARCHAR(256) DEFAULT \'\' NOT NULL, PRIMARY KEY(id))');
    }
}
