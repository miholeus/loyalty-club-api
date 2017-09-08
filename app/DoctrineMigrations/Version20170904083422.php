<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170904083422 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE user_referral_activation (id SERIAL NOT NULL, ref_code_id INT DEFAULT NULL, created_by_user INT DEFAULT NULL, used_by_user INT DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_270B079EFD969DB2 ON user_referral_activation (created_by_user)');
        $this->addSql('CREATE INDEX IDX_270B079E3C2BAA05 ON user_referral_activation (used_by_user)');
        $this->addSql('CREATE INDEX user_referral_activation__ref_code_id ON user_referral_activation (ref_code_id)');
        $this->addSql('CREATE UNIQUE INDEX user_referral_activation__ref_code_id_user ON user_referral_activation (ref_code_id, created_by_user, used_by_user)');
        $this->addSql('COMMENT ON COLUMN user_referral_activation.date IS \'Дата активации кода\'');
        $this->addSql('ALTER TABLE user_referral_activation ADD CONSTRAINT FK_270B079EE3CEADC7 FOREIGN KEY (ref_code_id) REFERENCES user_referral_code (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_referral_activation ADD CONSTRAINT FK_270B079EFD969DB2 FOREIGN KEY (created_by_user) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_referral_activation ADD CONSTRAINT FK_270B079E3C2BAA05 FOREIGN KEY (used_by_user) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE user_referral_activation DROP CONSTRAINT FK_270B079EE3CEADC7');
        $this->addSql('DROP TABLE user_referral_activation');;
    }
}
