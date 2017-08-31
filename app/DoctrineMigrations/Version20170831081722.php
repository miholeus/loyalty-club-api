<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170831081722 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE user_referral_code (id SERIAL NOT NULL, user_id INT DEFAULT NULL, ref_code VARCHAR(50) NOT NULL, activated BOOLEAN DEFAULT \'false\' NOT NULL, activations INT DEFAULT NULL, date_created TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, date_updated TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX user_referral_code__ref_code ON user_referral_code (ref_code)');
        $this->addSql('CREATE UNIQUE INDEX user_referral_code__user_id ON user_referral_code (user_id)');
        $this->addSql('COMMENT ON COLUMN user_referral_code.date_created IS \'Дата создания\'');
        $this->addSql('COMMENT ON COLUMN user_referral_code.date_updated IS \'Дата обновления\'');
        $this->addSql('ALTER TABLE user_referral_code ADD CONSTRAINT FK_8AC9E81AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE user_referral_code');
    }
}
