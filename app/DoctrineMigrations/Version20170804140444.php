<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170804140444 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE image (id SERIAL NOT NULL, created_by INT NOT NULL, name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, size INT DEFAULT NULL, mime VARCHAR(255) DEFAULT NULL, crop_data TEXT DEFAULT NULL, created_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, queued BOOLEAN DEFAULT \'false\' NOT NULL, published BOOLEAN DEFAULT \'false\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C53D045FDE12AB56 ON image (created_by)');
        $this->addSql('CREATE INDEX images_name__idx ON image (name)');
        $this->addSql('CREATE INDEX images_path__idx ON image (path)');
        $this->addSql('CREATE INDEX images_created_on__idx ON image (created_on)');
        $this->addSql('CREATE TABLE image_size (id SERIAL NOT NULL, image_id INT NOT NULL, name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, width INT NOT NULL, height INT NOT NULL, created_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5FACEF43DA5256D ON image_size (image_id)');
        $this->addSql('CREATE INDEX image_size_name__idx ON image_size (name)');
        $this->addSql('CREATE INDEX image_size_sizes__idx ON image_size (width, height)');
        $this->addSql('CREATE INDEX image_size_created_on__idx ON image_size (created_on)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FDE12AB56 FOREIGN KEY (created_by) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE image_size ADD CONSTRAINT FK_5FACEF43DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE image_size DROP CONSTRAINT FK_5FACEF43DA5256D');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE image_size');
    }
}
