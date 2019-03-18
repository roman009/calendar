<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190318201949 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_7D3656A4232D562B (object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE incoming_email_attachment (id INT AUTO_INCREMENT NOT NULL, incoming_email_id INT NOT NULL, name VARCHAR(255) NOT NULL, body LONGTEXT NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_6E612D83232D562B (object_id), INDEX IDX_6E612D83E633938E (incoming_email_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE incoming_email (id INT AUTO_INCREMENT NOT NULL, subject VARCHAR(255) NOT NULL, email_from VARCHAR(255) NOT NULL, email_to VARCHAR(255) NOT NULL, email_date DATETIME NOT NULL, message_id VARCHAR(255) NOT NULL, body_html LONGTEXT DEFAULT NULL, body_text LONGTEXT DEFAULT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_18044AD0232D562B (object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE office365_event (id INT AUTO_INCREMENT NOT NULL, account_user_id INT NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_FE7E4691232D562B (object_id), INDEX IDX_FE7E46916E45C7DD (account_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE office365_free_busy (id INT AUTO_INCREMENT NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_34D989BB232D562B (object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE office365_auth_token (id INT AUTO_INCREMENT NOT NULL, account_user_id INT NOT NULL, access_token LONGTEXT NOT NULL, refresh_token LONGTEXT NOT NULL, expires INT NOT NULL, json LONGTEXT DEFAULT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_57B24CD6232D562B (object_id), INDEX IDX_57B24CD66E45C7DD (account_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE office365_calendar (id INT AUTO_INCREMENT NOT NULL, account_user_id INT NOT NULL, owner_email_address VARCHAR(255) DEFAULT NULL, `primary` TINYINT(1) DEFAULT \'0\' NOT NULL, calendar_id VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, summary LONGTEXT DEFAULT NULL, timezone VARCHAR(255) DEFAULT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_9450EA7C232D562B (object_id), INDEX IDX_9450EA7C6E45C7DD (account_user_id), INDEX IDX_9450EA7C6E45C7DDA40A2C8 (account_user_id, calendar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE outlook_event (id INT AUTO_INCREMENT NOT NULL, account_user_id INT NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_1CCAD967232D562B (object_id), INDEX IDX_1CCAD9676E45C7DD (account_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE outlook_free_busy (id INT AUTO_INCREMENT NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_AF36D7E5232D562B (object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE outlook_auth_token (id INT AUTO_INCREMENT NOT NULL, account_user_id INT NOT NULL, access_token LONGTEXT NOT NULL, refresh_token LONGTEXT NOT NULL, expires INT NOT NULL, json LONGTEXT DEFAULT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_DBFADF7B232D562B (object_id), INDEX IDX_DBFADF7B6E45C7DD (account_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE outlook_calendar (id INT AUTO_INCREMENT NOT NULL, account_user_id INT NOT NULL, owner_email_address VARCHAR(255) DEFAULT NULL, `primary` TINYINT(1) DEFAULT \'0\' NOT NULL, calendar_id VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, summary LONGTEXT DEFAULT NULL, timezone VARCHAR(255) DEFAULT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_1FCC04BC232D562B (object_id), INDEX IDX_1FCC04BC6E45C7DD (account_user_id), INDEX IDX_1FCC04BC6E45C7DDA40A2C8 (account_user_id, calendar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE apple_auth_token (id INT AUTO_INCREMENT NOT NULL, account_user_id INT NOT NULL, access_token LONGTEXT NOT NULL, refresh_token LONGTEXT NOT NULL, expires INT NOT NULL, json LONGTEXT DEFAULT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_28C0F7CD232D562B (object_id), INDEX IDX_28C0F7CD6E45C7DD (account_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exchange_calendar (id INT AUTO_INCREMENT NOT NULL, account_user_id INT NOT NULL, change_key VARCHAR(255) DEFAULT NULL, `primary` TINYINT(1) DEFAULT \'0\' NOT NULL, calendar_id VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, summary LONGTEXT DEFAULT NULL, timezone VARCHAR(255) DEFAULT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_F451D826232D562B (object_id), INDEX IDX_F451D8266E45C7DD (account_user_id), INDEX IDX_F451D8266E45C7DDA40A2C8 (account_user_id, calendar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exchange_free_busy (id INT AUTO_INCREMENT NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_BF073063232D562B (object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exchange_event (id INT AUTO_INCREMENT NOT NULL, account_user_id INT NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_259946EF232D562B (object_id), INDEX IDX_259946EF6E45C7DD (account_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exchange_auth_token (id INT AUTO_INCREMENT NOT NULL, account_user_id INT NOT NULL, access_token LONGTEXT DEFAULT NULL, refresh_token LONGTEXT DEFAULT NULL, expires INT DEFAULT NULL, json LONGTEXT DEFAULT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, server VARCHAR(255) NOT NULL, version VARCHAR(255) NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_DF31C889232D562B (object_id), INDEX IDX_DF31C8896E45C7DD (account_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE google_calendar (id INT AUTO_INCREMENT NOT NULL, account_user_id INT NOT NULL, `primary` TINYINT(1) DEFAULT \'0\' NOT NULL, calendar_id VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, summary LONGTEXT DEFAULT NULL, timezone VARCHAR(255) DEFAULT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_6A8CC36E232D562B (object_id), INDEX IDX_6A8CC36E6E45C7DD (account_user_id), INDEX IDX_6A8CC36E6E45C7DDA40A2C8 (account_user_id, calendar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE google_auth_token (id INT AUTO_INCREMENT NOT NULL, account_user_id INT NOT NULL, scope LONGTEXT DEFAULT NULL, access_token LONGTEXT NOT NULL, refresh_token LONGTEXT NOT NULL, expires INT NOT NULL, json LONGTEXT DEFAULT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_6DF45AB5232D562B (object_id), INDEX IDX_6DF45AB56E45C7DD (account_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE google_event (id INT AUTO_INCREMENT NOT NULL, account_user_id INT NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_A24303A8232D562B (object_id), INDEX IDX_A24303A86E45C7DD (account_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE google_free_busy (id INT AUTO_INCREMENT NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_C79E24DA232D562B (object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE smart_invite_reply (id INT AUTO_INCREMENT NOT NULL, smart_invite_id INT NOT NULL, account_user_id INT NOT NULL, email VARCHAR(255) NOT NULL, comment VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_4A6C853A232D562B (object_id), INDEX IDX_4A6C853AEA6DCFAD (smart_invite_id), INDEX IDX_4A6C853A6E45C7DD (account_user_id), INDEX IDX_4A6C853A6E45C7DD232D562B (account_user_id, object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE smart_invite_event (id INT AUTO_INCREMENT NOT NULL, smart_invite_id INT NOT NULL, account_user_id INT NOT NULL, summary VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, timezone VARCHAR(255) NOT NULL, location VARCHAR(255) DEFAULT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_8C6A497D232D562B (object_id), UNIQUE INDEX UNIQ_8C6A497DEA6DCFAD (smart_invite_id), INDEX IDX_8C6A497D6E45C7DD (account_user_id), INDEX IDX_8C6A497D6E45C7DD232D562B (account_user_id, object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE smart_invite (id INT AUTO_INCREMENT NOT NULL, account_user_id INT NOT NULL, object_id VARCHAR(32) NOT NULL, smart_invite_id VARCHAR(255) NOT NULL, callback_url VARCHAR(255) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_D8967D09232D562B (object_id), INDEX IDX_D8967D096E45C7DD (account_user_id), INDEX IDX_D8967D096E45C7DD232D562B (account_user_id, object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE smart_invite_recipient (id INT AUTO_INCREMENT NOT NULL, smart_invite_id INT NOT NULL, account_user_id INT NOT NULL, email VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_A9A2A548232D562B (object_id), UNIQUE INDEX UNIQ_A9A2A548EA6DCFAD (smart_invite_id), INDEX IDX_A9A2A5486E45C7DD (account_user_id), INDEX IDX_A9A2A5486E45C7DD232D562B (account_user_id, object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE smart_invite_attachment (id INT AUTO_INCREMENT NOT NULL, smart_invite_id INT NOT NULL, account_user_id INT NOT NULL, icalendar LONGTEXT NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_E994F73232D562B (object_id), INDEX IDX_E994F73EA6DCFAD (smart_invite_id), INDEX IDX_E994F736E45C7DD (account_user_id), INDEX IDX_E994F736E45C7DD232D562B (account_user_id, object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE smart_invite_organizer (id INT AUTO_INCREMENT NOT NULL, smart_invite_id INT NOT NULL, account_user_id INT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_58722F72232D562B (object_id), UNIQUE INDEX UNIQ_58722F72EA6DCFAD (smart_invite_id), INDEX IDX_58722F726E45C7DD (account_user_id), INDEX IDX_58722F726E45C7DD232D562B (account_user_id, object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649232D562B (object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE account_user (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, account_id INT NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_10051E3232D562B (object_id), INDEX IDX_10051E3A76ED395 (user_id), INDEX IDX_10051E39B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE channel (id INT AUTO_INCREMENT NOT NULL, account_user_id INT NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_A2F98E47232D562B (object_id), INDEX IDX_A2F98E476E45C7DD (account_user_id), INDEX IDX_A2F98E476E45C7DD232D562B (account_user_id, object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE api_access_token (id INT AUTO_INCREMENT NOT NULL, account_user_id INT NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_BCC804C5232D562B (object_id), UNIQUE INDEX UNIQ_BCC804C56E45C7DD (account_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE account_admin (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_BE81D407E7927C74 (email), UNIQUE INDEX UNIQ_BE81D407232D562B (object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE account_admin_account (account_admin_id INT NOT NULL, account_id INT NOT NULL, INDEX IDX_262CE89E1CE560A6 (account_admin_id), INDEX IDX_262CE89E9B6B5FBA (account_id), PRIMARY KEY(account_admin_id, account_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE incoming_email_attachment ADD CONSTRAINT FK_6E612D83E633938E FOREIGN KEY (incoming_email_id) REFERENCES incoming_email (id)');
        $this->addSql('ALTER TABLE office365_event ADD CONSTRAINT FK_FE7E46916E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE office365_auth_token ADD CONSTRAINT FK_57B24CD66E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE office365_calendar ADD CONSTRAINT FK_9450EA7C6E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE outlook_event ADD CONSTRAINT FK_1CCAD9676E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE outlook_auth_token ADD CONSTRAINT FK_DBFADF7B6E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE outlook_calendar ADD CONSTRAINT FK_1FCC04BC6E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE apple_auth_token ADD CONSTRAINT FK_28C0F7CD6E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE exchange_calendar ADD CONSTRAINT FK_F451D8266E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE exchange_event ADD CONSTRAINT FK_259946EF6E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE exchange_auth_token ADD CONSTRAINT FK_DF31C8896E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE google_calendar ADD CONSTRAINT FK_6A8CC36E6E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE google_auth_token ADD CONSTRAINT FK_6DF45AB56E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE google_event ADD CONSTRAINT FK_A24303A86E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE smart_invite_reply ADD CONSTRAINT FK_4A6C853AEA6DCFAD FOREIGN KEY (smart_invite_id) REFERENCES smart_invite (id)');
        $this->addSql('ALTER TABLE smart_invite_reply ADD CONSTRAINT FK_4A6C853A6E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE smart_invite_event ADD CONSTRAINT FK_8C6A497DEA6DCFAD FOREIGN KEY (smart_invite_id) REFERENCES smart_invite (id)');
        $this->addSql('ALTER TABLE smart_invite_event ADD CONSTRAINT FK_8C6A497D6E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE smart_invite ADD CONSTRAINT FK_D8967D096E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE smart_invite_recipient ADD CONSTRAINT FK_A9A2A548EA6DCFAD FOREIGN KEY (smart_invite_id) REFERENCES smart_invite (id)');
        $this->addSql('ALTER TABLE smart_invite_recipient ADD CONSTRAINT FK_A9A2A5486E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE smart_invite_attachment ADD CONSTRAINT FK_E994F73EA6DCFAD FOREIGN KEY (smart_invite_id) REFERENCES smart_invite (id)');
        $this->addSql('ALTER TABLE smart_invite_attachment ADD CONSTRAINT FK_E994F736E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE smart_invite_organizer ADD CONSTRAINT FK_58722F72EA6DCFAD FOREIGN KEY (smart_invite_id) REFERENCES smart_invite (id)');
        $this->addSql('ALTER TABLE smart_invite_organizer ADD CONSTRAINT FK_58722F726E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE account_user ADD CONSTRAINT FK_10051E3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE account_user ADD CONSTRAINT FK_10051E39B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE channel ADD CONSTRAINT FK_A2F98E476E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE api_access_token ADD CONSTRAINT FK_BCC804C56E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE account_admin_account ADD CONSTRAINT FK_262CE89E1CE560A6 FOREIGN KEY (account_admin_id) REFERENCES account_admin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE account_admin_account ADD CONSTRAINT FK_262CE89E9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE account_user DROP FOREIGN KEY FK_10051E39B6B5FBA');
        $this->addSql('ALTER TABLE account_admin_account DROP FOREIGN KEY FK_262CE89E9B6B5FBA');
        $this->addSql('ALTER TABLE incoming_email_attachment DROP FOREIGN KEY FK_6E612D83E633938E');
        $this->addSql('ALTER TABLE smart_invite_reply DROP FOREIGN KEY FK_4A6C853AEA6DCFAD');
        $this->addSql('ALTER TABLE smart_invite_event DROP FOREIGN KEY FK_8C6A497DEA6DCFAD');
        $this->addSql('ALTER TABLE smart_invite_recipient DROP FOREIGN KEY FK_A9A2A548EA6DCFAD');
        $this->addSql('ALTER TABLE smart_invite_attachment DROP FOREIGN KEY FK_E994F73EA6DCFAD');
        $this->addSql('ALTER TABLE smart_invite_organizer DROP FOREIGN KEY FK_58722F72EA6DCFAD');
        $this->addSql('ALTER TABLE account_user DROP FOREIGN KEY FK_10051E3A76ED395');
        $this->addSql('ALTER TABLE office365_event DROP FOREIGN KEY FK_FE7E46916E45C7DD');
        $this->addSql('ALTER TABLE office365_auth_token DROP FOREIGN KEY FK_57B24CD66E45C7DD');
        $this->addSql('ALTER TABLE office365_calendar DROP FOREIGN KEY FK_9450EA7C6E45C7DD');
        $this->addSql('ALTER TABLE outlook_event DROP FOREIGN KEY FK_1CCAD9676E45C7DD');
        $this->addSql('ALTER TABLE outlook_auth_token DROP FOREIGN KEY FK_DBFADF7B6E45C7DD');
        $this->addSql('ALTER TABLE outlook_calendar DROP FOREIGN KEY FK_1FCC04BC6E45C7DD');
        $this->addSql('ALTER TABLE apple_auth_token DROP FOREIGN KEY FK_28C0F7CD6E45C7DD');
        $this->addSql('ALTER TABLE exchange_calendar DROP FOREIGN KEY FK_F451D8266E45C7DD');
        $this->addSql('ALTER TABLE exchange_event DROP FOREIGN KEY FK_259946EF6E45C7DD');
        $this->addSql('ALTER TABLE exchange_auth_token DROP FOREIGN KEY FK_DF31C8896E45C7DD');
        $this->addSql('ALTER TABLE google_calendar DROP FOREIGN KEY FK_6A8CC36E6E45C7DD');
        $this->addSql('ALTER TABLE google_auth_token DROP FOREIGN KEY FK_6DF45AB56E45C7DD');
        $this->addSql('ALTER TABLE google_event DROP FOREIGN KEY FK_A24303A86E45C7DD');
        $this->addSql('ALTER TABLE smart_invite_reply DROP FOREIGN KEY FK_4A6C853A6E45C7DD');
        $this->addSql('ALTER TABLE smart_invite_event DROP FOREIGN KEY FK_8C6A497D6E45C7DD');
        $this->addSql('ALTER TABLE smart_invite DROP FOREIGN KEY FK_D8967D096E45C7DD');
        $this->addSql('ALTER TABLE smart_invite_recipient DROP FOREIGN KEY FK_A9A2A5486E45C7DD');
        $this->addSql('ALTER TABLE smart_invite_attachment DROP FOREIGN KEY FK_E994F736E45C7DD');
        $this->addSql('ALTER TABLE smart_invite_organizer DROP FOREIGN KEY FK_58722F726E45C7DD');
        $this->addSql('ALTER TABLE channel DROP FOREIGN KEY FK_A2F98E476E45C7DD');
        $this->addSql('ALTER TABLE api_access_token DROP FOREIGN KEY FK_BCC804C56E45C7DD');
        $this->addSql('ALTER TABLE account_admin_account DROP FOREIGN KEY FK_262CE89E1CE560A6');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE incoming_email_attachment');
        $this->addSql('DROP TABLE incoming_email');
        $this->addSql('DROP TABLE office365_event');
        $this->addSql('DROP TABLE office365_free_busy');
        $this->addSql('DROP TABLE office365_auth_token');
        $this->addSql('DROP TABLE office365_calendar');
        $this->addSql('DROP TABLE outlook_event');
        $this->addSql('DROP TABLE outlook_free_busy');
        $this->addSql('DROP TABLE outlook_auth_token');
        $this->addSql('DROP TABLE outlook_calendar');
        $this->addSql('DROP TABLE apple_auth_token');
        $this->addSql('DROP TABLE exchange_calendar');
        $this->addSql('DROP TABLE exchange_free_busy');
        $this->addSql('DROP TABLE exchange_event');
        $this->addSql('DROP TABLE exchange_auth_token');
        $this->addSql('DROP TABLE google_calendar');
        $this->addSql('DROP TABLE google_auth_token');
        $this->addSql('DROP TABLE google_event');
        $this->addSql('DROP TABLE google_free_busy');
        $this->addSql('DROP TABLE smart_invite_reply');
        $this->addSql('DROP TABLE smart_invite_event');
        $this->addSql('DROP TABLE smart_invite');
        $this->addSql('DROP TABLE smart_invite_recipient');
        $this->addSql('DROP TABLE smart_invite_attachment');
        $this->addSql('DROP TABLE smart_invite_organizer');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE account_user');
        $this->addSql('DROP TABLE channel');
        $this->addSql('DROP TABLE api_access_token');
        $this->addSql('DROP TABLE account_admin');
        $this->addSql('DROP TABLE account_admin_account');
    }
}
