<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170929091215 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE promo_coupon_action DROP CONSTRAINT fk_79d4b3d16f0eccce');
        $this->addSql('DROP INDEX fk_promo_coupon_action_club');
        $this->addSql('ALTER TABLE promo_coupon_action ADD created_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE promo_coupon_action ADD updated_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE promo_coupon_action DROP club_owner');
        $this->addSql('ALTER TABLE promo_coupon_action DROP pca_type');
        $this->addSql('ALTER TABLE promo_coupon_action RENAME COLUMN caption TO name');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE promo_coupon_action ADD club_owner INT DEFAULT NULL');
        $this->addSql('ALTER TABLE promo_coupon_action ADD pca_type VARCHAR(255) DEFAULT \'normal\' NOT NULL');
        $this->addSql('ALTER TABLE promo_coupon_action DROP created_on');
        $this->addSql('ALTER TABLE promo_coupon_action DROP updated_on');
        $this->addSql('ALTER TABLE promo_coupon_action RENAME COLUMN name TO caption');
        $this->addSql('ALTER TABLE promo_coupon_action ADD CONSTRAINT fk_79d4b3d16f0eccce FOREIGN KEY (club_owner) REFERENCES club (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX fk_promo_coupon_action_club ON promo_coupon_action (club_owner)');
    }
}
