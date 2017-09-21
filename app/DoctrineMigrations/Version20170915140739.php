<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170915140739 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE role_actor DROP CONSTRAINT fk_b3a9bed6d60322ac');
        $this->addSql('ALTER TABLE video_view DROP CONSTRAINT fk_f96af65229c1004e');
        $this->addSql('DROP SEQUENCE document_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE push_device_id_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE role_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE video_id_seq CASCADE');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE person_subs');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE video');
        $this->addSql('DROP TABLE role_actor');
        $this->addSql('DROP TABLE push_device_id');
        $this->addSql('DROP TABLE video_view');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE document_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE push_device_id_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE role_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE video_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE document (id SERIAL NOT NULL, person_id INT DEFAULT 0 NOT NULL, type VARCHAR(255) NOT NULL, serial VARCHAR(50) DEFAULT \'0\' NOT NULL, number VARCHAR(50) DEFAULT \'0\' NOT NULL, date DATE NOT NULL, sub_code VARCHAR(128) DEFAULT \'0\' NOT NULL, given VARCHAR(128) DEFAULT \'0\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX document__person_id_type ON document (person_id, type)');
        $this->addSql('COMMENT ON COLUMN document.type IS \'тип документа\'');
        $this->addSql('COMMENT ON COLUMN document.serial IS \'серия документа\'');
        $this->addSql('COMMENT ON COLUMN document.number IS \'номер документа\'');
        $this->addSql('COMMENT ON COLUMN document.date IS \'дата выдачи\'');
        $this->addSql('COMMENT ON COLUMN document.sub_code IS \'код подразделения\'');
        $this->addSql('COMMENT ON COLUMN document.given IS \'кем выдан\'');
        $this->addSql('CREATE TABLE person_subs (person_id INT NOT NULL, list_id INT NOT NULL, enabled BOOLEAN NOT NULL, PRIMARY KEY(person_id, list_id))');
        $this->addSql('CREATE TABLE role (id SERIAL NOT NULL, role VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE video (id SERIAL NOT NULL, name VARCHAR(50) NOT NULL, depiction VARCHAR(250) NOT NULL, file VARCHAR(250) NOT NULL, img VARCHAR(250) DEFAULT \'/static/img/video.jpg\' NOT NULL, view_cond VARCHAR(255) NOT NULL, dt TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actor_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX name ON video (name)');
        $this->addSql('CREATE TABLE role_actor (role_id INT NOT NULL, actor_id INT NOT NULL, PRIMARY KEY(role_id, actor_id))');
        $this->addSql('CREATE INDEX idx_b3a9bed6d60322ac ON role_actor (role_id)');
        $this->addSql('CREATE INDEX idx_b3a9bed610daf24a ON role_actor (actor_id)');
        $this->addSql('CREATE TABLE push_device_id (id SERIAL NOT NULL, person_id INT DEFAULT NULL, os VARCHAR(10) NOT NULL, device_id TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX fk_push_device_id_person ON push_device_id (person_id)');
        $this->addSql('CREATE TABLE video_view (person_id INT NOT NULL, video_id INT NOT NULL, PRIMARY KEY(person_id, video_id))');
        $this->addSql('CREATE INDEX idx_f96af65229c1004e ON video_view (video_id)');
        $this->addSql('CREATE INDEX idx_f96af652217bbb47 ON video_view (person_id)');
        $this->addSql('ALTER TABLE role_actor ADD CONSTRAINT fk_b3a9bed610daf24a FOREIGN KEY (actor_id) REFERENCES actor (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE role_actor ADD CONSTRAINT fk_b3a9bed6d60322ac FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE push_device_id ADD CONSTRAINT fk_1f7e2fd3217bbb47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE video_view ADD CONSTRAINT fk_f96af652217bbb47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE video_view ADD CONSTRAINT fk_f96af65229c1004e FOREIGN KEY (video_id) REFERENCES video (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
