<?php

namespace Zenomania\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171110135552 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE order_cart (id SERIAL NOT NULL, product_id INT NOT NULL, order_id INT NOT NULL, quantity INT NOT NULL, price NUMERIC(10, 2) NOT NULL, total_price NUMERIC(10, 2) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4652B2A04584665A ON order_cart (product_id)');
        $this->addSql('CREATE INDEX IDX_4652B2A08D9F6D38 ON order_cart (order_id)');
        $this->addSql('CREATE TABLE order_delivery (id SERIAL NOT NULL, order_id INT NOT NULL, delivery_type_id INT NOT NULL, client_name VARCHAR(512) NOT NULL, address VARCHAR(512) DEFAULT NULL, phone VARCHAR(20) DEFAULT NULL, note TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D6790EA18D9F6D38 ON order_delivery (order_id)');
        $this->addSql('CREATE INDEX IDX_D6790EA1CF52334D ON order_delivery (delivery_type_id)');
        $this->addSql('CREATE TABLE order_status_history (id SERIAL NOT NULL, from_order_status_id INT NOT NULL, to_order_status_id INT NOT NULL, created_by INT NOT NULL, order_id INT NOT NULL, note VARCHAR(512) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_471AD77E9E771E5A ON order_status_history (from_order_status_id)');
        $this->addSql('CREATE INDEX IDX_471AD77E56AC3F24 ON order_status_history (to_order_status_id)');
        $this->addSql('CREATE INDEX IDX_471AD77EDE12AB56 ON order_status_history (created_by)');
        $this->addSql('CREATE INDEX IDX_471AD77E8D9F6D38 ON order_status_history (order_id)');
        $this->addSql('CREATE TABLE order_status (id SERIAL NOT NULL, title VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE orders (id SERIAL NOT NULL, status_id INT NOT NULL, user_id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, price NUMERIC(10, 2) NOT NULL, note TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E52FFDEE6BF700BD ON orders (status_id)');
        $this->addSql('CREATE INDEX IDX_E52FFDEEA76ED395 ON orders (user_id)');
        $this->addSql('CREATE INDEX order__date ON orders (date)');
        $this->addSql('CREATE TABLE delivery_type (id SERIAL NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE order_cart ADD CONSTRAINT FK_4652B2A04584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_cart ADD CONSTRAINT FK_4652B2A08D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_delivery ADD CONSTRAINT FK_D6790EA18D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_delivery ADD CONSTRAINT FK_D6790EA1CF52334D FOREIGN KEY (delivery_type_id) REFERENCES delivery_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_status_history ADD CONSTRAINT FK_471AD77E9E771E5A FOREIGN KEY (from_order_status_id) REFERENCES order_status (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_status_history ADD CONSTRAINT FK_471AD77E56AC3F24 FOREIGN KEY (to_order_status_id) REFERENCES order_status (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_status_history ADD CONSTRAINT FK_471AD77EDE12AB56 FOREIGN KEY (created_by) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_status_history ADD CONSTRAINT FK_471AD77E8D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE6BF700BD FOREIGN KEY (status_id) REFERENCES order_status (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE order_status_history DROP CONSTRAINT FK_471AD77E9E771E5A');
        $this->addSql('ALTER TABLE order_status_history DROP CONSTRAINT FK_471AD77E56AC3F24');
        $this->addSql('ALTER TABLE orders DROP CONSTRAINT FK_E52FFDEE6BF700BD');
        $this->addSql('ALTER TABLE order_cart DROP CONSTRAINT FK_4652B2A08D9F6D38');
        $this->addSql('ALTER TABLE order_delivery DROP CONSTRAINT FK_D6790EA18D9F6D38');
        $this->addSql('ALTER TABLE order_status_history DROP CONSTRAINT FK_471AD77E8D9F6D38');
        $this->addSql('ALTER TABLE order_delivery DROP CONSTRAINT FK_D6790EA1CF52334D');
        $this->addSql('DROP TABLE order_cart');
        $this->addSql('DROP TABLE order_delivery');
        $this->addSql('DROP TABLE order_status_history');
        $this->addSql('DROP TABLE order_status');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE delivery_type');
    }
}
