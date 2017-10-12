<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171004092116 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE promo_coupon ADD activated_by INT NULL');
        $this->addSql('ALTER TABLE promo_coupon ADD CONSTRAINT FK_7D3A204F255FA5E4 FOREIGN KEY (activated_by) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_7D3A204F255FA5E4 ON promo_coupon (activated_by)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE promo_coupon DROP CONSTRAINT FK_7D3A204F255FA5E4');
        $this->addSql('DROP INDEX IDX_7D3A204F255FA5E4');
        $this->addSql('ALTER TABLE promo_coupon DROP activated_by');
    }
}
