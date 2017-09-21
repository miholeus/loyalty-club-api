<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170920134905 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA74EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person_points ADD CONSTRAINT FK_BB1FBE9F4EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE promo_code ADD CONSTRAINT FK_3D8C939E4EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX promo_code__season ON promo_code (season_id)');
        $this->addSql('ALTER TABLE promo_code_distribution ADD CONSTRAINT FK_EB2F24694EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX promo_code_distribution__season_id ON promo_code_distribution (season_id)');
        $this->addSql('ALTER TABLE season DROP CONSTRAINT fk_f0e45ba96f0eccce');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D34EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX FK_subscription_season ON subscription (season_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE person_points DROP CONSTRAINT FK_BB1FBE9F4EC001D1');
        $this->addSql('ALTER TABLE promo_code_distribution DROP CONSTRAINT FK_EB2F24694EC001D1');
        $this->addSql('DROP INDEX promo_code_distribution__season_id');
        $this->addSql('ALTER TABLE subscription DROP CONSTRAINT FK_A3C664D34EC001D1');
        $this->addSql('DROP INDEX FK_subscription_season');
        $this->addSql('ALTER TABLE promo_code DROP CONSTRAINT FK_3D8C939E4EC001D1');
        $this->addSql('DROP INDEX promo_code__season');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA74EC001D1');
    }
}
