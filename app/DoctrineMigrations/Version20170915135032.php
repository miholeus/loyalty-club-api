<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170915135032 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE email_dispatch_done DROP CONSTRAINT fk_a1aab47e8d747913');
        $this->addSql('ALTER TABLE event_map DROP CONSTRAINT fk_82626f687987212d');
        $this->addSql('ALTER TABLE email_dispatch_to DROP CONSTRAINT fk_b90a1a9abab47356');
        $this->addSql('DROP SEQUENCE auth_log_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE client_application_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE email_dispatch_done_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE email_dispatch_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE email_dispatch_to_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE email_friends_reference_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE email_out_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE event_map_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE giveaway_action_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE log_callcenter_id_seq CASCADE');
        $this->addSql('DROP TABLE email_dispatch_to');
        $this->addSql('DROP TABLE email_dispatch');
        $this->addSql('DROP TABLE client_application');
        $this->addSql('DROP TABLE event_map');
        $this->addSql('DROP TABLE giveaway_action');
        $this->addSql('DROP TABLE log_callcenter');
        $this->addSql('DROP TABLE auth_log');
        $this->addSql('DROP TABLE email_out');
        $this->addSql('DROP TABLE email_friends_reference');
        $this->addSql('DROP TABLE email_dispatch_done');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE auth_log_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE client_application_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE email_dispatch_done_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE email_dispatch_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE email_dispatch_to_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE email_friends_reference_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE email_out_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE event_map_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE giveaway_action_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE log_callcenter_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE email_dispatch_to (id SERIAL NOT NULL, ed_id INT DEFAULT NULL, person_id INT NOT NULL, person_email VARCHAR(200) NOT NULL, body TEXT NOT NULL, sent BOOLEAN DEFAULT \'false\' NOT NULL, unsubscribe_token CHAR(20) DEFAULT \'\' NOT NULL, state VARCHAR(255) DEFAULT \'queued\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX fk_email_dispatch_to_person ON email_dispatch_to (person_id)');
        $this->addSql('CREATE INDEX idx_b90a1a9abab47356 ON email_dispatch_to (ed_id)');
        $this->addSql('CREATE UNIQUE INDEX ed_id_person_email ON email_dispatch_to (ed_id, person_email)');
        $this->addSql('CREATE TABLE email_dispatch (id SERIAL NOT NULL, subject VARCHAR(256) DEFAULT \'\' NOT NULL, body TEXT NOT NULL, source VARCHAR(255) DEFAULT \'html\' NOT NULL, category VARCHAR(255) DEFAULT \'info\' NOT NULL, name VARCHAR(50) DEFAULT \'Рас-рас-рассылка\' NOT NULL, active VARCHAR(255) DEFAULT \'N\' NOT NULL, created_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_actor INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN email_dispatch.created_date IS \'Дата создания\'');
        $this->addSql('CREATE TABLE client_application (id SERIAL NOT NULL, club_owner INT DEFAULT NULL, outer_service VARCHAR(25) NOT NULL, name VARCHAR(50) DEFAULT NULL, password VARCHAR(50) DEFAULT NULL, auth_key VARCHAR(50) DEFAULT NULL, url VARCHAR(256) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX fk_client_application_club ON client_application (club_owner)');
        $this->addSql('CREATE TABLE event_map (id SERIAL NOT NULL, event_id INT DEFAULT NULL, app_id INT DEFAULT NULL, outer_id INT NOT NULL, use4promo BOOLEAN DEFAULT \'false\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX app_id_event_id_outer_id ON event_map (app_id, event_id, outer_id)');
        $this->addSql('CREATE INDEX idx_82626f687987212d ON event_map (app_id)');
        $this->addSql('CREATE INDEX event_map_event ON event_map (event_id)');
        $this->addSql('CREATE TABLE giveaway_action (id SERIAL NOT NULL, actor_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT \'Free zens to everyone\' NOT NULL, occasion VARCHAR(1024) DEFAULT \'\' NOT NULL, dt TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, points SMALLINT NOT NULL, progress BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX giveaway_action__name ON giveaway_action (name)');
        $this->addSql('CREATE INDEX fk_giveaway_action_actor ON giveaway_action (actor_id)');
        $this->addSql('CREATE TABLE log_callcenter (id SERIAL NOT NULL, actor_id INT DEFAULT 0 NOT NULL, person_id INT DEFAULT 0 NOT NULL, dt TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, old TEXT NOT NULL, new TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE auth_log (id SERIAL NOT NULL, person_id INT DEFAULT NULL, login VARCHAR(50) NOT NULL, status TEXT NOT NULL, dt TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX auth_log__dt ON auth_log (dt)');
        $this->addSql('CREATE INDEX auth_log__person_id ON auth_log (person_id)');
        $this->addSql('COMMENT ON COLUMN auth_log.status IS \'(DC2Type:simple_array)\'');
        $this->addSql('CREATE TABLE email_out (id SERIAL NOT NULL, to_person INT DEFAULT NULL, from_person INT DEFAULT NULL, dt TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, from_email VARCHAR(100) NOT NULL, to_email VARCHAR(100) NOT NULL, subject VARCHAR(100) NOT NULL, body TEXT NOT NULL, type VARCHAR(25) NOT NULL, sended BOOLEAN DEFAULT \'false\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX fk_email_out_to_person ON email_out (to_person)');
        $this->addSql('CREATE INDEX fk_email_out_from_person ON email_out (from_person)');
        $this->addSql('CREATE TABLE email_friends_reference (id SERIAL NOT NULL, person_id INT DEFAULT NULL, email VARCHAR(100) DEFAULT \'0\' NOT NULL, subject VARCHAR(256) DEFAULT \'\' NOT NULL, body TEXT NOT NULL, dt TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX email_friends_reference__person_id ON email_friends_reference (person_id)');
        $this->addSql('CREATE INDEX email_friends_reference__email ON email_friends_reference (email)');
        $this->addSql('CREATE TABLE email_dispatch_done (id SERIAL NOT NULL, actor INT DEFAULT NULL, email_dispatch INT DEFAULT NULL, recipient_code VARCHAR(20000) NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, state VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX fk_email_dispatch_done_email_dispatch ON email_dispatch_done (email_dispatch)');
        $this->addSql('CREATE INDEX fk_email_dispatch_done_actor ON email_dispatch_done (actor)');
        $this->addSql('ALTER TABLE email_dispatch_to ADD CONSTRAINT fk_b90a1a9abab47356 FOREIGN KEY (ed_id) REFERENCES email_dispatch_done (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE client_application ADD CONSTRAINT fk_a510f8fa6f0eccce FOREIGN KEY (club_owner) REFERENCES club (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_map ADD CONSTRAINT fk_82626f6871f7e88b FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_map ADD CONSTRAINT fk_82626f687987212d FOREIGN KEY (app_id) REFERENCES client_application (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE giveaway_action ADD CONSTRAINT fk_d8dcfd1c10daf24a FOREIGN KEY (actor_id) REFERENCES actor (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE auth_log ADD CONSTRAINT fk_1dd25db8217bbb47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE email_out ADD CONSTRAINT fk_302e4ddf120eddeb FOREIGN KEY (to_person) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE email_out ADD CONSTRAINT fk_302e4ddfb9edaaa6 FOREIGN KEY (from_person) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE email_friends_reference ADD CONSTRAINT fk_94f51edd217bbb47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE email_dispatch_done ADD CONSTRAINT fk_a1aab47e447556f9 FOREIGN KEY (actor) REFERENCES actor (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE email_dispatch_done ADD CONSTRAINT fk_a1aab47e8d747913 FOREIGN KEY (email_dispatch) REFERENCES email_dispatch (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
