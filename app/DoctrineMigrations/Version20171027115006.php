<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171027115006 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE social_post_attachments DROP CONSTRAINT fk_df2a8f344b89032c');
        $this->addSql('DROP SEQUENCE social_post_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE social_post_attachments_id_seq CASCADE');
        $this->addSql('DROP TABLE social_post_attachments');
        $this->addSql('DROP TABLE social_post');
        $this->addSql('ALTER TABLE social_repost DROP CONSTRAINT fk_c37f2419217bbb47');
        $this->addSql('ALTER TABLE social_repost DROP CONSTRAINT fk_c37f24196740b485');
        $this->addSql('DROP INDEX uniq_c37f24196740b485');
        $this->addSql('DROP INDEX post_id_user_outerid');
        $this->addSql('DROP INDEX FK_social_repost_person');
        $this->addSql('ALTER TABLE social_repost ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE social_repost ADD vk_id VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE social_repost ADD created_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE social_repost DROP person_id');
        $this->addSql('ALTER TABLE social_repost DROP person_points_id');
        $this->addSql('ALTER TABLE social_repost DROP network');
        $this->addSql('ALTER TABLE social_repost DROP user_outerid');
        $this->addSql('ALTER TABLE social_repost DROP repost_outerid');
        $this->addSql('ALTER TABLE social_repost RENAME COLUMN repost_dt TO dt');
        $this->addSql('ALTER TABLE social_repost ADD CONSTRAINT FK_C37F2419A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX news_id_vk_id ON social_repost (news_id, vk_id)');
        $this->addSql('CREATE INDEX FK_social_repost_person ON social_repost (user_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE social_post_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE social_post_attachments_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE social_post_attachments (id SERIAL NOT NULL, post_id INT DEFAULT NULL, type VARCHAR(255) DEFAULT \'video\' NOT NULL, outer_id VARCHAR(50) DEFAULT NULL, inner_link VARCHAR(256) DEFAULT NULL, outer_link VARCHAR(256) DEFAULT NULL, pic_small VARCHAR(100) DEFAULT NULL, pic_big VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX fk_social_post_attachments_social_post ON social_post_attachments (post_id)');
        $this->addSql('CREATE UNIQUE INDEX post_id_outer_id ON social_post_attachments (post_id, outer_id)');
        $this->addSql('CREATE TABLE social_post (id SERIAL NOT NULL, club_id INT DEFAULT 0 NOT NULL, network VARCHAR(255) NOT NULL, group_id VARCHAR(50) DEFAULT \'\' NOT NULL, outerid VARCHAR(50) DEFAULT \'\' NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, text TEXT DEFAULT NULL, textbig TEXT DEFAULT NULL, link TEXT DEFAULT NULL, pic TEXT DEFAULT NULL, picbig TEXT DEFAULT NULL, reposts INT DEFAULT 0 NOT NULL, likes INT DEFAULT 0 NOT NULL, comments INT DEFAULT 0 NOT NULL, views INT DEFAULT 0 NOT NULL, moder BOOLEAN DEFAULT \'false\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX social_post__views ON social_post (views)');
        $this->addSql('CREATE INDEX social_post__group_id ON social_post (group_id)');
        $this->addSql('CREATE UNIQUE INDEX network_group_id_outerid ON social_post (network, group_id, outerid)');
        $this->addSql('CREATE INDEX social_post__moder ON social_post (moder)');
        $this->addSql('CREATE INDEX social_post__likes ON social_post (likes)');
        $this->addSql('CREATE INDEX social_post__network ON social_post (network)');
        $this->addSql('CREATE INDEX social_post__date ON social_post (date)');
        $this->addSql('CREATE INDEX social_post__club_id ON social_post (club_id)');
        $this->addSql('COMMENT ON COLUMN social_post.moder IS \'статус модерации\'');
        $this->addSql('ALTER TABLE social_post_attachments ADD CONSTRAINT fk_df2a8f344b89032c FOREIGN KEY (post_id) REFERENCES social_post (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE social_repost DROP CONSTRAINT FK_C37F2419A76ED395');
        $this->addSql('DROP INDEX news_id_vk_id');
        $this->addSql('DROP INDEX fk_social_repost_person');
        $this->addSql('ALTER TABLE social_repost ADD person_points_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE social_repost ADD network VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE social_repost ADD repost_outerid VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE social_repost DROP created_on');
        $this->addSql('ALTER TABLE social_repost RENAME COLUMN user_id TO person_id');
        $this->addSql('ALTER TABLE social_repost RENAME COLUMN vk_id TO user_outerid');
        $this->addSql('ALTER TABLE social_repost RENAME COLUMN dt TO repost_dt');
        $this->addSql('ALTER TABLE social_repost ADD CONSTRAINT fk_c37f2419217bbb47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE social_repost ADD CONSTRAINT fk_c37f24196740b485 FOREIGN KEY (person_points_id) REFERENCES person_points (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_c37f24196740b485 ON social_repost (person_points_id)');
        $this->addSql('CREATE UNIQUE INDEX post_id_user_outerid ON social_repost (news_id, user_outerid)');
        $this->addSql('CREATE INDEX fk_social_repost_person ON social_repost (person_id)');
    }
}
