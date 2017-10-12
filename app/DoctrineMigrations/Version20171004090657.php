<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171004090657 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE badge DROP CONSTRAINT FK_FEF0481DC54C8C93');
        $this->addSql('ALTER TABLE badge ADD CONSTRAINT FK_FEF0481DC54C8C93 FOREIGN KEY (type_id) REFERENCES badge_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE badge DROP CONSTRAINT fk_fef0481dc54c8c93');
        $this->addSql('ALTER TABLE badge ADD CONSTRAINT fk_fef0481dc54c8c93 FOREIGN KEY (type_id) REFERENCES badge_type (id) ON DELETE RESTRICT NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
