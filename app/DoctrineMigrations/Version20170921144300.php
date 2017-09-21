<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170921144300 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP INDEX network_group_id_club_id_outer_id');
        $this->addSql('DROP INDEX network_club_person_outerid');
        $this->addSql('CREATE INDEX social_account__network_idx ON social_account (network, outer_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP INDEX social_account__network_idx');
        $this->addSql('CREATE UNIQUE INDEX network_group_id_club_id_outer_id ON social_account (network, group_id, club_id, outer_id)');
        $this->addSql('CREATE UNIQUE INDEX network_club_person_outerid ON social_account (network, club_id, person_id, outer_id)');
    }
}
