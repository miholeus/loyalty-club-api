<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170921125335 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE person DROP CONSTRAINT fk_34dcd17643d261d4');
        $this->addSql('ALTER TABLE person DROP CONSTRAINT fk_34dcd176db0a5ed2');
        $this->addSql('DROP INDEX fk_person_education');
        $this->addSql('DROP INDEX fk_person_line_of_work');
        $this->addSql('DROP INDEX person__club_owner_mobile');
        $this->addSql('DROP INDEX person__promo_code');
        $this->addSql('DROP INDEX person__reg_type_name');
        $this->addSql('ALTER TABLE person DROP line_of_work');
        $this->addSql('ALTER TABLE person DROP education');
        $this->addSql('ALTER TABLE person DROP work_at');
        $this->addSql('ALTER TABLE person DROP study_at');
        $this->addSql('ALTER TABLE person DROP events_info');
        $this->addSql('ALTER INDEX person__club RENAME TO IDX_34DCD1766F0ECCCE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE person ADD line_of_work INT DEFAULT NULL');
        $this->addSql('ALTER TABLE person ADD education INT DEFAULT NULL');
        $this->addSql('ALTER TABLE person ADD work_at VARCHAR(256) DEFAULT \'\' NOT NULL');
        $this->addSql('ALTER TABLE person ADD study_at VARCHAR(256) DEFAULT \'\' NOT NULL');
        $this->addSql('ALTER TABLE person ADD events_info TEXT DEFAULT \'\' NOT NULL');
        $this->addSql('COMMENT ON COLUMN person.work_at IS \'место работы\'');
        $this->addSql('COMMENT ON COLUMN person.study_at IS \'место учёбы\'');
        $this->addSql('COMMENT ON COLUMN person.events_info IS \'(DC2Type:simple_array)\'');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT fk_34dcd17643d261d4 FOREIGN KEY (line_of_work) REFERENCES line_of_work (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT fk_34dcd176db0a5ed2 FOREIGN KEY (education) REFERENCES education (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX fk_person_education ON person (education)');
        $this->addSql('CREATE INDEX fk_person_line_of_work ON person (line_of_work)');
        $this->addSql('CREATE UNIQUE INDEX person__club_owner_mobile ON person (club_owner, mobile)');
        $this->addSql('CREATE UNIQUE INDEX person__promo_code ON person (promo_code)');
        $this->addSql('CREATE INDEX person__reg_type_name ON person (reg_type_name)');
        $this->addSql('ALTER INDEX idx_34dcd1766f0eccce RENAME TO person__club');
    }
}
