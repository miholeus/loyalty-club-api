<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170929093635 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE person_activity DROP CONSTRAINT fk_3832ac6d81c06096');
        $this->addSql('DROP SEQUENCE activity_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE actor_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE news_id_seq CASCADE');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE person_activity');
        $this->addSql('DROP TABLE actor');
        $this->addSql('ALTER TABLE person DROP reg_actor');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE activity_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE actor_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE news_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE activity (id SERIAL NOT NULL, name VARCHAR(256) NOT NULL, description VARCHAR(1024) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE news (id SERIAL NOT NULL, text TEXT NOT NULL, hide BOOLEAN NOT NULL, dt TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, dt_start TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, dt_end TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actor_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX news__date__indx ON news (dt_start, dt_end)');
        $this->addSql('CREATE TABLE person_activity (person_id INT NOT NULL, activity_id INT NOT NULL, PRIMARY KEY(person_id, activity_id))');
        $this->addSql('CREATE INDEX idx_3832ac6d217bbb47 ON person_activity (person_id)');
        $this->addSql('CREATE INDEX idx_3832ac6d81c06096 ON person_activity (activity_id)');
        $this->addSql('CREATE TABLE actor (id SERIAL NOT NULL, person INT DEFAULT NULL, club_owner INT DEFAULT NULL, username VARCHAR(50) NOT NULL, password VARCHAR(512) NOT NULL, token VARCHAR(20) DEFAULT NULL, refrr INT DEFAULT NULL, should_change_pwd BOOLEAN DEFAULT \'false\' NOT NULL, auth_token VARCHAR(256) DEFAULT NULL, vk_id VARCHAR(128) DEFAULT NULL, fb_id VARCHAR(128) DEFAULT NULL, reset_token CHAR(6) DEFAULT NULL, reg_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, reg_source VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX actor__person ON actor (person)');
        $this->addSql('CREATE UNIQUE INDEX actor__club_owner_vk_id ON actor (club_owner, vk_id)');
        $this->addSql('CREATE UNIQUE INDEX actor__club_owner_username ON actor (club_owner, username)');
        $this->addSql('CREATE UNIQUE INDEX actor__club_owner_fb_id ON actor (club_owner, fb_id)');
        $this->addSql('CREATE INDEX idx_447556f96f0eccce ON actor (club_owner)');
        $this->addSql('COMMENT ON COLUMN actor.reg_date IS \'Дата регистрации\'');
        $this->addSql('ALTER TABLE person_activity ADD CONSTRAINT fk_3832ac6d217bbb47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person_activity ADD CONSTRAINT fk_3832ac6d81c06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE actor ADD CONSTRAINT fk_447556f934dcd176 FOREIGN KEY (person) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE actor ADD CONSTRAINT fk_447556f96f0eccce FOREIGN KEY (club_owner) REFERENCES club (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person ADD reg_actor INT DEFAULT NULL');
    }
}
