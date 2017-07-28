<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170728151559 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP INDEX person_id_progress_item_id');
        $this->addSql('ALTER TABLE person_progress DROP CONSTRAINT person_progress_pkey');
        $this->addSql('ALTER TABLE person_progress ALTER progress_id SET NOT NULL');
        $this->addSql('CREATE INDEX FK_person_progress__person_id ON person_progress (person_id)');
        $this->addSql('ALTER TABLE person_progress ADD PRIMARY KEY (person_id, progress_id)');
        $this->addSql('ALTER INDEX fk_person_progress_progress_items RENAME TO FK_person_progress__progress_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP INDEX FK_person_progress__person_id');
        $this->addSql('ALTER TABLE person_progress DROP CONSTRAINT person_progress_pkey');
        $this->addSql('ALTER TABLE person_progress ALTER progress_id DROP NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX person_id_progress_item_id ON person_progress (person_id, progress_id)');
        $this->addSql('ALTER TABLE person_progress ADD PRIMARY KEY (person_id)');
        $this->addSql('ALTER INDEX fk_person_progress__progress_id RENAME TO fk_person_progress_progress_items');
    }
}
