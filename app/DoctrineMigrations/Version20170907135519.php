<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170907135519 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE user_referral_activation DROP CONSTRAINT fk_270b079ee3ceadc7');
        $this->addSql('DROP SEQUENCE user_referral_code_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_referral_activation_id_seq CASCADE');
        $this->addSql('DROP TABLE user_referral_code');
        $this->addSql('DROP TABLE user_referral_activation');
        $this->addSql('ALTER TABLE player ADD firstname VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE player ADD lastname VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE player ADD middlename VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE player ADD foto VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE player ADD is_active BOOLEAN DEFAULT NULL');
        $this->addSql('ALTER TABLE player ADD created_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE player ADD updated_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE player DROP name');
        $this->addSql('ALTER TABLE player DROP active');
        $this->addSql('CREATE INDEX player_name__idx ON player (lastname, firstname, middlename)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE user_referral_code_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_referral_activation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE user_referral_code (id SERIAL NOT NULL, user_id INT DEFAULT NULL, ref_code VARCHAR(50) NOT NULL, activated BOOLEAN DEFAULT \'false\' NOT NULL, activations INT DEFAULT NULL, date_created TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, date_updated TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX user_referral_code__user_id ON user_referral_code (user_id)');
        $this->addSql('CREATE INDEX user_referral_code__ref_code ON user_referral_code (ref_code)');
        $this->addSql('COMMENT ON COLUMN user_referral_code.date_created IS \'Дата создания\'');
        $this->addSql('COMMENT ON COLUMN user_referral_code.date_updated IS \'Дата обновления\'');
        $this->addSql('CREATE TABLE user_referral_activation (id SERIAL NOT NULL, ref_code_id INT DEFAULT NULL, created_by_user INT DEFAULT NULL, used_by_user INT DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX user_referral_activation__ref_code_id ON user_referral_activation (ref_code_id)');
        $this->addSql('CREATE INDEX idx_270b079e3c2baa05 ON user_referral_activation (used_by_user)');
        $this->addSql('CREATE INDEX idx_270b079efd969db2 ON user_referral_activation (created_by_user)');
        $this->addSql('CREATE UNIQUE INDEX user_referral_activation__ref_code_id_user ON user_referral_activation (ref_code_id, created_by_user, used_by_user)');
        $this->addSql('COMMENT ON COLUMN user_referral_activation.date IS \'Дата активации кода\'');
        $this->addSql('ALTER TABLE user_referral_code ADD CONSTRAINT fk_8ac9e81aa76ed395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_referral_activation ADD CONSTRAINT fk_270b079ee3ceadc7 FOREIGN KEY (ref_code_id) REFERENCES user_referral_code (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_referral_activation ADD CONSTRAINT fk_270b079efd969db2 FOREIGN KEY (created_by_user) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_referral_activation ADD CONSTRAINT fk_270b079e3c2baa05 FOREIGN KEY (used_by_user) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP INDEX player_name__idx');
        $this->addSql('ALTER TABLE player ADD name VARCHAR(200) DEFAULT \'нет\' NOT NULL');
        $this->addSql('ALTER TABLE player ADD active BOOLEAN DEFAULT \'false\' NOT NULL');
        $this->addSql('ALTER TABLE player DROP firstname');
        $this->addSql('ALTER TABLE player DROP lastname');
        $this->addSql('ALTER TABLE player DROP middlename');
        $this->addSql('ALTER TABLE player DROP foto');
        $this->addSql('ALTER TABLE player DROP is_active');
        $this->addSql('ALTER TABLE player DROP created_on');
        $this->addSql('ALTER TABLE player DROP updated_on');
    }
}
