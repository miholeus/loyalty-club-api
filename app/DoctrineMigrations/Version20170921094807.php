<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170921094807 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE club ALTER name SET NOT NULL');
        $this->addSql('ALTER TABLE club ALTER vk_group DROP DEFAULT');
        $this->addSql('ALTER TABLE club ALTER vk_group DROP NOT NULL');
        $this->addSql('ALTER TABLE club ALTER fb_group DROP DEFAULT');
        $this->addSql('ALTER TABLE club ALTER fb_group DROP NOT NULL');
        $this->addSql('ALTER TABLE club ALTER twitter_group DROP DEFAULT');
        $this->addSql('ALTER TABLE club ALTER twitter_group DROP NOT NULL');
        $this->addSql('ALTER TABLE club ALTER instagram_group DROP DEFAULT');
        $this->addSql('ALTER TABLE club ALTER instagram_group DROP NOT NULL');
        $this->addSql('ALTER TABLE club ALTER youtube_group DROP DEFAULT');
        $this->addSql('ALTER TABLE club ALTER youtube_group DROP NOT NULL');
        $this->addSql('ALTER TABLE club ALTER yt_upload_playlist DROP DEFAULT');
        $this->addSql('ALTER TABLE club ALTER yt_upload_playlist DROP NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE club ALTER name DROP NOT NULL');
        $this->addSql('ALTER TABLE club ALTER vk_group SET DEFAULT \'\'');
        $this->addSql('ALTER TABLE club ALTER vk_group SET NOT NULL');
        $this->addSql('ALTER TABLE club ALTER fb_group SET DEFAULT \'\'');
        $this->addSql('ALTER TABLE club ALTER fb_group SET NOT NULL');
        $this->addSql('ALTER TABLE club ALTER twitter_group SET DEFAULT \'\'');
        $this->addSql('ALTER TABLE club ALTER twitter_group SET NOT NULL');
        $this->addSql('ALTER TABLE club ALTER instagram_group SET DEFAULT \'\'');
        $this->addSql('ALTER TABLE club ALTER instagram_group SET NOT NULL');
        $this->addSql('ALTER TABLE club ALTER youtube_group SET DEFAULT \'\'');
        $this->addSql('ALTER TABLE club ALTER youtube_group SET NOT NULL');
        $this->addSql('ALTER TABLE club ALTER yt_upload_playlist SET DEFAULT \'\'');
        $this->addSql('ALTER TABLE club ALTER yt_upload_playlist SET NOT NULL');
    }
}
