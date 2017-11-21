<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171116112110 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE club ADD external_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE club DROP vk_group');
        $this->addSql('ALTER TABLE club DROP fb_group');
        $this->addSql('ALTER TABLE club DROP twitter_group');
        $this->addSql('ALTER TABLE club DROP instagram_group');
        $this->addSql('ALTER TABLE club DROP youtube_group');
        $this->addSql('ALTER TABLE club DROP yt_upload_playlist');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE club ADD vk_group VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE club ADD fb_group VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE club ADD twitter_group VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE club ADD instagram_group VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE club ADD youtube_group VARCHAR(256) DEFAULT NULL');
        $this->addSql('ALTER TABLE club ADD yt_upload_playlist VARCHAR(256) DEFAULT NULL');
        $this->addSql('ALTER TABLE club DROP external_id');
    }
}
