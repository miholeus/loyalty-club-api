<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170928144231 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE promo_coupon DROP CONSTRAINT fk_7d3a204f852235b0');
        $this->addSql('DROP INDEX FK_promo_coupon_promo_coupon_action');
        $this->addSql('ALTER TABLE promo_coupon ADD action_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE promo_coupon ADD created_by INT DEFAULT NULL');
        $this->addSql('ALTER TABLE promo_coupon ADD created_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE promo_coupon ADD updated_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE promo_coupon DROP pcaction');
        $this->addSql('ALTER TABLE promo_coupon ADD CONSTRAINT FK_7D3A204F9D32F035 FOREIGN KEY (action_id) REFERENCES promo_coupon_action (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE promo_coupon ADD CONSTRAINT FK_7D3A204FDE12AB56 FOREIGN KEY (created_by) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_7D3A204FDE12AB56 ON promo_coupon (created_by)');
        $this->addSql('CREATE INDEX FK_promo_coupon_promo_coupon_action ON promo_coupon (action_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE promo_coupon DROP CONSTRAINT FK_7D3A204F9D32F035');
        $this->addSql('ALTER TABLE promo_coupon DROP CONSTRAINT FK_7D3A204FDE12AB56');
        $this->addSql('DROP INDEX IDX_7D3A204FDE12AB56');
        $this->addSql('DROP INDEX fk_promo_coupon_promo_coupon_action');
        $this->addSql('ALTER TABLE promo_coupon ADD pcaction INT DEFAULT NULL');
        $this->addSql('ALTER TABLE promo_coupon DROP action_id');
        $this->addSql('ALTER TABLE promo_coupon DROP created_by');
        $this->addSql('ALTER TABLE promo_coupon DROP created_on');
        $this->addSql('ALTER TABLE promo_coupon DROP updated_on');
        $this->addSql('ALTER TABLE promo_coupon ADD CONSTRAINT fk_7d3a204f852235b0 FOREIGN KEY (pcaction) REFERENCES promo_coupon_action (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX fk_promo_coupon_promo_coupon_action ON promo_coupon (pcaction)');
    }
}
