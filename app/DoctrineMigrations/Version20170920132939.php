<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170920132939 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE person_points DROP CONSTRAINT fk_bb1fbe9f4ec001d1');
        $this->addSql('ALTER TABLE promo_code_distribution DROP CONSTRAINT fk_eb2f2469b5f8978e');
        $this->addSql('ALTER TABLE subscription DROP CONSTRAINT fk_a3c664d3f0e45ba9');
        $this->addSql('ALTER TABLE promo_code DROP CONSTRAINT fk_3d8c939e47cc8c92');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT fk_3bae0aa75e4993df');

        $this->addSql('DROP SEQUENCE promo_action_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE season_id_seq');
        $this->addSql('ALTER TABLE promo_action RENAME to season');
        $this->addSql('ALTER TABLE season ALTER COLUMN id SET DEFAULT nextval(\'season_id_seq\'::regclass)');


        $this->addSql('ALTER TABLE season ADD CONSTRAINT FK_F0E45BA96F0ECCCE FOREIGN KEY (club_owner) REFERENCES club (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql('DROP INDEX fk_event_promo_action');
        $this->addSql('ALTER TABLE event RENAME promo_action TO season_id');

        $this->addSql('CREATE INDEX FK_event_season ON event (season_id)');

        $this->addSql('DROP INDEX promo_code__promo_action');
        $this->addSql('ALTER TABLE promo_code RENAME action TO season_id');


        $this->addSql('DROP INDEX promo_code_distribution__promo_action_id');
        $this->addSql('ALTER TABLE promo_code_distribution RENAME promo_action_id TO season_id');


        $this->addSql('DROP INDEX fk_subscription_promo_action');
        $this->addSql('ALTER TABLE subscription RENAME season TO season_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE subscription RENAME season_id TO season');
        $this->addSql('CREATE INDEX fk_subscription_promo_action ON subscription (season)');

        $this->addSql('ALTER TABLE promo_code_distribution RENAME season_id TO promo_action_id');
        $this->addSql('CREATE INDEX promo_code_distribution__promo_action_id ON promo_code_distribution (promo_action_id)');

        $this->addSql('ALTER TABLE promo_code RENAME season_id TO action');
        $this->addSql('CREATE INDEX promo_code__promo_action ON promo_code (action)');

        $this->addSql('DROP INDEX FK_event_season');

        $this->addSql('ALTER TABLE event RENAME season_id TO promo_action');
        $this->addSql('CREATE INDEX fk_event_promo_action ON event (promo_action)');

        $this->addSql('ALTER TABLE season DROP CONSTRAINT FK_F0E45BA96F0ECCCE');

        $this->addSql('DROP SEQUENCE season_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE promo_action_id_seq');
        $this->addSql('ALTER TABLE season ALTER COLUMN id SET DEFAULT nextval(\'promo_action_seq\'::regclass)');
        $this->addSql('ALTER TABLE season RENAME to promo_action');


        $this->addSql('ALTER TABLE event ADD CONSTRAINT fk_3bae0aa75e4993df FOREIGN KEY (promo_action) REFERENCES promo_action (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person_points ADD CONSTRAINT fk_bb1fbe9f4ec001d1 FOREIGN KEY (season_id) REFERENCES promo_action (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE promo_code_distribution DROP CONSTRAINT fk_eb2f2469b5f8978e');
        $this->addSql('ALTER TABLE promo_code_distribution ADD CONSTRAINT fk_eb2f2469b5f8978e FOREIGN KEY (promo_action_id) REFERENCES promo_action (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE promo_code ADD CONSTRAINT fk_3d8c939e47cc8c92 FOREIGN KEY (action) REFERENCES promo_action (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
