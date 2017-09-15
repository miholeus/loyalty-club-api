<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170915132035 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE event_out_spot DROP CONSTRAINT fk_26d3c980558fbeb9');
        $this->addSql('ALTER TABLE person_purchase DROP CONSTRAINT fk_f551740c126f525e');
        $this->addSql('ALTER TABLE person_purchase DROP CONSTRAINT fk_f551740ccf3d9be4');
        $this->addSql('ALTER TABLE item DROP CONSTRAINT fk_1f1b251ecf3d9be4');
        $this->addSql('DROP SEQUENCE event_out_spot_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE item_how2get_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE item_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE person_purchase_id_seq CASCADE');
        $this->addSql('DROP TABLE person_purchase');
        $this->addSql('DROP TABLE event_out_spot');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE item_how2get');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE event_out_spot_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE item_how2get_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE person_purchase_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE person_purchase (id SERIAL NOT NULL, item_id INT DEFAULT NULL, person_id INT DEFAULT NULL, how2get INT DEFAULT NULL, app_id INT NOT NULL, price_points VARCHAR(50) NOT NULL, url_called VARCHAR(255) NOT NULL, query_string VARCHAR(255) NOT NULL, checksum VARCHAR(50) NOT NULL, datetime TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status BOOLEAN NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, ship_to VARCHAR(300) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX fk_person_purchase_item_how2get ON person_purchase (how2get)');
        $this->addSql('CREATE INDEX fk_person_purchase_item ON person_purchase (item_id)');
        $this->addSql('CREATE INDEX fk_person_purchase_person ON person_purchase (person_id)');
        $this->addSql('CREATE TABLE event_out_spot (id SERIAL NOT NULL, purchase_id INT DEFAULT NULL, event_id INT DEFAULT NULL, code CHAR(10) NOT NULL, reserved BOOLEAN DEFAULT \'false\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX fk_event_out_spot_event ON event_out_spot (event_id)');
        $this->addSql('CREATE INDEX fk_event_out_spot_person_purchase ON event_out_spot (purchase_id)');
        $this->addSql('CREATE TABLE item (id SERIAL NOT NULL, event_id INT DEFAULT NULL, how2get INT DEFAULT NULL, active BOOLEAN DEFAULT \'false\' NOT NULL, parent_item INT DEFAULT NULL, rule INT DEFAULT NULL, outer_id INT NOT NULL, app_id INT NOT NULL, price_points VARCHAR(50) DEFAULT \'0\' NOT NULL, price_rub VARCHAR(50) DEFAULT \'0\' NOT NULL, name VARCHAR(256) DEFAULT \'Приз\' NOT NULL, img VARCHAR(1024) DEFAULT \'/static/img/prize1.png\' NOT NULL, sortorder BOOLEAN DEFAULT \'false\', PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX item__sortorder_ix ON item (sortorder)');
        $this->addSql('CREATE INDEX fk_item_event ON item (event_id)');
        $this->addSql('CREATE INDEX fk_item_item_how2get ON item (how2get)');
        $this->addSql('COMMENT ON COLUMN item.app_id IS \'ид внешнего приложения\'');
        $this->addSql('COMMENT ON COLUMN item.price_points IS \'цена в баллах\'');
        $this->addSql('COMMENT ON COLUMN item.price_rub IS \'цена в рублях\'');
        $this->addSql('CREATE TABLE item_how2get (id SERIAL NOT NULL, name VARCHAR(128) DEFAULT \'\' NOT NULL, display_text TEXT DEFAULT NULL, purchase_text TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE person_purchase ADD CONSTRAINT fk_f551740c126f525e FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person_purchase ADD CONSTRAINT fk_f551740c217bbb47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person_purchase ADD CONSTRAINT fk_f551740ccf3d9be4 FOREIGN KEY (how2get) REFERENCES item_how2get (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_out_spot ADD CONSTRAINT fk_26d3c980558fbeb9 FOREIGN KEY (purchase_id) REFERENCES person_purchase (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_out_spot ADD CONSTRAINT fk_26d3c98071f7e88b FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT fk_1f1b251e71f7e88b FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT fk_1f1b251ecf3d9be4 FOREIGN KEY (how2get) REFERENCES item_how2get (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
