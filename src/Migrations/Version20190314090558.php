<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190314090558 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE exchange_auth_token (id INT AUTO_INCREMENT NOT NULL, account_user_id INT NOT NULL, access_token LONGTEXT DEFAULT NULL, refresh_token LONGTEXT DEFAULT NULL, expires INT DEFAULT NULL, json LONGTEXT DEFAULT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, server VARCHAR(255) NOT NULL, version VARCHAR(255) NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_DF31C889232D562B (object_id), INDEX IDX_DF31C8896E45C7DD (account_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE api_access_token (id INT AUTO_INCREMENT NOT NULL, account_user_id INT NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_BCC804C5232D562B (object_id), UNIQUE INDEX UNIQ_BCC804C56E45C7DD (account_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exchange_auth_token ADD CONSTRAINT FK_DF31C8896E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE api_access_token ADD CONSTRAINT FK_BCC804C56E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE exchange_auth_token');
        $this->addSql('DROP TABLE api_access_token');
    }
}
