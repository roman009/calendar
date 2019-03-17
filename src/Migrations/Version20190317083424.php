<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190317083424 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE account_admin (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_BE81D407E7927C74 (email), UNIQUE INDEX UNIQ_BE81D407232D562B (object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE account_admin_account (account_admin_id INT NOT NULL, account_id INT NOT NULL, INDEX IDX_262CE89E1CE560A6 (account_admin_id), INDEX IDX_262CE89E9B6B5FBA (account_id), PRIMARY KEY(account_admin_id, account_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE account_admin_account ADD CONSTRAINT FK_262CE89E1CE560A6 FOREIGN KEY (account_admin_id) REFERENCES account_admin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE account_admin_account ADD CONSTRAINT FK_262CE89E9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE office365_calendar CHANGE owner_email_address owner_email_address VARCHAR(255) DEFAULT NULL, CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT NULL, CHANGE timezone timezone VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE outlook_calendar CHANGE owner_email_address owner_email_address VARCHAR(255) DEFAULT NULL, CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT NULL, CHANGE timezone timezone VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE exchange_calendar CHANGE change_key change_key VARCHAR(255) DEFAULT NULL, CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT NULL, CHANGE timezone timezone VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE exchange_auth_token CHANGE expires expires INT DEFAULT NULL');
        $this->addSql('ALTER TABLE google_calendar CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT NULL, CHANGE timezone timezone VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE smart_invite_reply CHANGE comment comment VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE smart_invite_event CHANGE location location VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE smart_invite CHANGE callback_url callback_url VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE account_admin_account DROP FOREIGN KEY FK_262CE89E1CE560A6');
        $this->addSql('DROP TABLE account_admin');
        $this->addSql('DROP TABLE account_admin_account');
        $this->addSql('ALTER TABLE exchange_auth_token CHANGE expires expires INT DEFAULT NULL');
        $this->addSql('ALTER TABLE exchange_calendar CHANGE change_key change_key VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE timezone timezone VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE google_calendar CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE timezone timezone VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE office365_calendar CHANGE owner_email_address owner_email_address VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE timezone timezone VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE outlook_calendar CHANGE owner_email_address owner_email_address VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE timezone timezone VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE smart_invite CHANGE callback_url callback_url VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE smart_invite_event CHANGE location location VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE smart_invite_reply CHANGE comment comment VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
