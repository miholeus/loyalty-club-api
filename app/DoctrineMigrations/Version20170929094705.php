<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170929094705 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE subscription DROP CONSTRAINT fk_a3c664d322c47cdb');
        $this->addSql('ALTER TABLE fan_card_person DROP CONSTRAINT fk_315bdcd466aa7e71');
        $this->addSql('DROP SEQUENCE fan_card_id_seq CASCADE');
        $this->addSql('DROP TABLE fan_card');
        $this->addSql('DROP TABLE fan_card_person');
        $this->addSql('ALTER TABLE event_attendance DROP fan_card');
        $this->addSql('ALTER TABLE event_attendance_import DROP fan_card_number');
        $this->addSql('DROP INDEX fk_subscription_fan_card');
        $this->addSql('DROP INDEX subscription__person_id_fan_card_id');
        $this->addSql('ALTER TABLE subscription DROP fan_card_id');
        $this->addSql('DROP INDEX ticket__fan_card');
        $this->addSql('ALTER TABLE ticket DROP fan_card_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE fan_card_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE fan_card (id SERIAL NOT NULL, number VARCHAR(50) DEFAULT \'0\' NOT NULL, inner_number VARCHAR(50) DEFAULT \'0\' NOT NULL, state VARCHAR(255) DEFAULT \'Active\' NOT NULL, best_before_date DATE NOT NULL, spent_sum NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL, points NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL, given_date DATE NOT NULL, blocked_reason VARCHAR(255) DEFAULT NULL, blocked_reason_comment VARCHAR(512) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN fan_card.spent_sum IS \'Потрачено денег по этой карте\'');
        $this->addSql('COMMENT ON COLUMN fan_card.points IS \'Начисленные баллы по этой карте\'');
        $this->addSql('CREATE TABLE fan_card_person (fancard_id INT NOT NULL, person_id INT NOT NULL, PRIMARY KEY(fancard_id, person_id))');
        $this->addSql('CREATE INDEX idx_315bdcd466aa7e71 ON fan_card_person (fancard_id)');
        $this->addSql('CREATE INDEX idx_315bdcd4217bbb47 ON fan_card_person (person_id)');
        $this->addSql('ALTER TABLE fan_card_person ADD CONSTRAINT fk_315bdcd4217bbb47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fan_card_person ADD CONSTRAINT fk_315bdcd466aa7e71 FOREIGN KEY (fancard_id) REFERENCES fan_card (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_attendance ADD fan_card INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event_attendance_import ADD fan_card_number VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE subscription ADD fan_card_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT fk_a3c664d322c47cdb FOREIGN KEY (fan_card_id) REFERENCES fan_card (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX fk_subscription_fan_card ON subscription (fan_card_id)');
        $this->addSql('CREATE UNIQUE INDEX subscription__person_id_fan_card_id ON subscription (person_id, fan_card_id)');
        $this->addSql('ALTER TABLE ticket ADD fan_card_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX ticket__fan_card ON ticket (fan_card_id)');
    }
}
