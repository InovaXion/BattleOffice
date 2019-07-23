<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190723072555 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY orders_ibfk_3');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY orders_ibfk_2');
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, address_line1 VARCHAR(255) NOT NULL, address_line2 VARCHAR(255) DEFAULT NULL, city VARCHAR(255) NOT NULL, zipcode VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, addresses_billing_id INT DEFAULT NULL, addresses_shipping_id INT NOT NULL, product VARCHAR(255) DEFAULT NULL, payment_method VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, addresses VARCHAR(255) NOT NULL, INDEX IDX_F529939819EB6921 (client_id), INDEX IDX_F52993982A48D76A (addresses_billing_id), INDEX IDX_F5299398962D27B6 (addresses_shipping_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939819EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993982A48D76A FOREIGN KEY (addresses_billing_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398962D27B6 FOREIGN KEY (addresses_shipping_id) REFERENCES address (id)');
        $this->addSql('DROP TABLE clientDeliveryAddress');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE product');
        $this->addSql('ALTER TABLE client DROP address, DROP addressMore, DROP city, DROP postalCode, DROP country, DROP phoneNumber, DROP createdAt, DROP apdatedAt');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993982A48D76A');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398962D27B6');
        $this->addSql('CREATE TABLE clientDeliveryAddress (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, firstName VARCHAR(255) NOT NULL COLLATE utf8_general_ci, lastName VARCHAR(255) NOT NULL COLLATE utf8_general_ci, address VARCHAR(255) NOT NULL COLLATE utf8_general_ci, addressMore VARCHAR(255) NOT NULL COLLATE utf8_general_ci, city VARCHAR(255) NOT NULL COLLATE utf8_general_ci, postalCode VARCHAR(255) NOT NULL COLLATE utf8_general_ci, country VARCHAR(255) NOT NULL COLLATE utf8_general_ci, phoneNumber VARCHAR(255) NOT NULL COLLATE utf8_general_ci, createdAt DATETIME DEFAULT \'NULL\', updatedAt DATETIME DEFAULT \'NULL\', INDEX client_id (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, product_id INT NOT NULL, createdAt DATETIME DEFAULT \'NULL\', updatedAt DATETIME DEFAULT \'NULL\', status VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_general_ci, clientDeliveryAddress INT NOT NULL, INDEX clientDeliveryAddress (clientDeliveryAddress), INDEX product_id (product_id), INDEX client_id (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_general_ci, reducPrice INT NOT NULL, realPrice INT DEFAULT NULL, stock INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE clientDeliveryAddress ADD CONSTRAINT clientDeliveryAddress_ibfk_1 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT orders_ibfk_1 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT orders_ibfk_2 FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT orders_ibfk_3 FOREIGN KEY (clientDeliveryAddress) REFERENCES clientDeliveryAddress (id)');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('ALTER TABLE client ADD address VARCHAR(255) NOT NULL COLLATE utf8_general_ci, ADD addressMore VARCHAR(255) NOT NULL COLLATE utf8_general_ci, ADD city VARCHAR(255) NOT NULL COLLATE utf8_general_ci, ADD postalCode VARCHAR(255) NOT NULL COLLATE utf8_general_ci, ADD country VARCHAR(255) NOT NULL COLLATE utf8_general_ci, ADD phoneNumber VARCHAR(255) NOT NULL COLLATE utf8_general_ci, ADD createdAt DATETIME DEFAULT \'NULL\', ADD apdatedAt DATETIME DEFAULT \'NULL\'');
    }
}
