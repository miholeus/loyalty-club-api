<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171016141521 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE social_repost DROP CONSTRAINT fk_c37f24194b89032c');
        $this->addSql('DROP INDEX post_id_user_outerid');
        $this->addSql('DROP INDEX IDX_C37F24194B89032C');
        $this->addSql('ALTER TABLE social_repost RENAME COLUMN post_id TO news_id');
        $this->addSql('CREATE UNIQUE INDEX post_id_user_outerid ON social_repost (news_id, user_outerid)');
        $this->addSql('CREATE INDEX IDX_C37F24194B89032C ON social_repost (news_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP INDEX idx_c37f24194b89032c');
        $this->addSql('DROP INDEX post_id_user_outerid');
        $this->addSql('ALTER TABLE social_repost RENAME COLUMN news_id TO post_id');
        $this->addSql('ALTER TABLE social_repost ADD CONSTRAINT fk_c37f24194b89032c FOREIGN KEY (post_id) REFERENCES social_post (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_c37f24194b89032c ON social_repost (post_id)');
        $this->addSql('CREATE UNIQUE INDEX post_id_user_outerid ON social_repost (post_id, user_outerid)');
    }
}
