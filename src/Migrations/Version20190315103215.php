<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190315103215 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE exchange_event (id INT AUTO_INCREMENT NOT NULL, account_user_id INT NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_259946EF232D562B (object_id), INDEX IDX_259946EF6E45C7DD (account_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE incoming_email_attachment (id INT AUTO_INCREMENT NOT NULL, incoming_email_id INT NOT NULL, name VARCHAR(255) NOT NULL, body LONGTEXT NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_6E612D83232D562B (object_id), INDEX IDX_6E612D83E633938E (incoming_email_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE incoming_email (id INT AUTO_INCREMENT NOT NULL, subject VARCHAR(255) NOT NULL, `from` VARCHAR(255) NOT NULL, `to` VARCHAR(255) NOT NULL, date DATETIME NOT NULL, message_id VARCHAR(255) NOT NULL, body_html LONGTEXT NOT NULL, body_text LONGTEXT NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_18044AD0232D562B (object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE smart_invite_event (id INT AUTO_INCREMENT NOT NULL, smart_invite_id INT NOT NULL, account_user_id INT NOT NULL, summary VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, timezone VARCHAR(255) NOT NULL, location VARCHAR(255) DEFAULT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_8C6A497D232D562B (object_id), UNIQUE INDEX UNIQ_8C6A497DEA6DCFAD (smart_invite_id), INDEX IDX_8C6A497D6E45C7DD (account_user_id), INDEX IDX_8C6A497D6E45C7DD232D562B (account_user_id, object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE smart_invite (id INT AUTO_INCREMENT NOT NULL, account_user_id INT NOT NULL, smart_invite_id VARCHAR(255) NOT NULL, callback_url VARCHAR(255) DEFAULT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_D8967D09232D562B (object_id), INDEX IDX_D8967D096E45C7DD (account_user_id), INDEX IDX_D8967D096E45C7DD232D562B (account_user_id, object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE smart_invite_recipient (id INT AUTO_INCREMENT NOT NULL, smart_invite_id INT NOT NULL, account_user_id INT NOT NULL, email VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_A9A2A548232D562B (object_id), UNIQUE INDEX UNIQ_A9A2A548EA6DCFAD (smart_invite_id), INDEX IDX_A9A2A5486E45C7DD (account_user_id), INDEX IDX_A9A2A5486E45C7DD232D562B (account_user_id, object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE smart_invite_attachment (id INT AUTO_INCREMENT NOT NULL, smart_invite_id INT NOT NULL, account_user_id INT NOT NULL, icalendar LONGTEXT NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_E994F73232D562B (object_id), INDEX IDX_E994F73EA6DCFAD (smart_invite_id), INDEX IDX_E994F736E45C7DD (account_user_id), INDEX IDX_E994F736E45C7DD232D562B (account_user_id, object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE smart_invite_organizer (id INT AUTO_INCREMENT NOT NULL, smart_invite_id INT NOT NULL, account_user_id INT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_58722F72232D562B (object_id), UNIQUE INDEX UNIQ_58722F72EA6DCFAD (smart_invite_id), INDEX IDX_58722F726E45C7DD (account_user_id), INDEX IDX_58722F726E45C7DD232D562B (account_user_id, object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exchange_event ADD CONSTRAINT FK_259946EF6E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE incoming_email_attachment ADD CONSTRAINT FK_6E612D83E633938E FOREIGN KEY (incoming_email_id) REFERENCES incoming_email (id)');
        $this->addSql('ALTER TABLE smart_invite_event ADD CONSTRAINT FK_8C6A497DEA6DCFAD FOREIGN KEY (smart_invite_id) REFERENCES smart_invite (id)');
        $this->addSql('ALTER TABLE smart_invite_event ADD CONSTRAINT FK_8C6A497D6E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE smart_invite ADD CONSTRAINT FK_D8967D096E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE smart_invite_recipient ADD CONSTRAINT FK_A9A2A548EA6DCFAD FOREIGN KEY (smart_invite_id) REFERENCES smart_invite (id)');
        $this->addSql('ALTER TABLE smart_invite_recipient ADD CONSTRAINT FK_A9A2A5486E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE smart_invite_attachment ADD CONSTRAINT FK_E994F73EA6DCFAD FOREIGN KEY (smart_invite_id) REFERENCES smart_invite (id)');
        $this->addSql('ALTER TABLE smart_invite_attachment ADD CONSTRAINT FK_E994F736E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE smart_invite_organizer ADD CONSTRAINT FK_58722F72EA6DCFAD FOREIGN KEY (smart_invite_id) REFERENCES smart_invite (id)');
        $this->addSql('ALTER TABLE smart_invite_organizer ADD CONSTRAINT FK_58722F726E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE google_calendar CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT NULL, CHANGE timezone timezone VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE exchange_calendar CHANGE change_key change_key VARCHAR(255) DEFAULT NULL, CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT NULL, CHANGE timezone timezone VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE exchange_auth_token CHANGE expires expires INT DEFAULT NULL');
        $this->addSql('ALTER TABLE outlook_calendar CHANGE owner_email_address owner_email_address VARCHAR(255) DEFAULT NULL, CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT NULL, CHANGE timezone timezone VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incoming_email_attachment DROP FOREIGN KEY FK_6E612D83E633938E');
        $this->addSql('ALTER TABLE smart_invite_event DROP FOREIGN KEY FK_8C6A497DEA6DCFAD');
        $this->addSql('ALTER TABLE smart_invite_recipient DROP FOREIGN KEY FK_A9A2A548EA6DCFAD');
        $this->addSql('ALTER TABLE smart_invite_attachment DROP FOREIGN KEY FK_E994F73EA6DCFAD');
        $this->addSql('ALTER TABLE smart_invite_organizer DROP FOREIGN KEY FK_58722F72EA6DCFAD');
        $this->addSql('DROP TABLE exchange_event');
        $this->addSql('DROP TABLE incoming_email_attachment');
        $this->addSql('DROP TABLE incoming_email');
        $this->addSql('DROP TABLE smart_invite_event');
        $this->addSql('DROP TABLE smart_invite');
        $this->addSql('DROP TABLE smart_invite_recipient');
        $this->addSql('DROP TABLE smart_invite_attachment');
        $this->addSql('DROP TABLE smart_invite_organizer');
        $this->addSql('ALTER TABLE exchange_auth_token CHANGE expires expires INT DEFAULT NULL');
        $this->addSql('ALTER TABLE exchange_calendar CHANGE change_key change_key VARCHAR(255) DEFAULT \'\'NULL\'\' COLLATE utf8mb4_unicode_ci, CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT \'\'NULL\'\' COLLATE utf8mb4_unicode_ci, CHANGE timezone timezone VARCHAR(255) DEFAULT \'\'NULL\'\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE google_calendar CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT \'\'NULL\'\' COLLATE utf8mb4_unicode_ci, CHANGE timezone timezone VARCHAR(255) DEFAULT \'\'NULL\'\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE outlook_calendar CHANGE owner_email_address owner_email_address VARCHAR(255) DEFAULT \'\'NULL\'\' COLLATE utf8mb4_unicode_ci, CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT \'\'NULL\'\' COLLATE utf8mb4_unicode_ci, CHANGE timezone timezone VARCHAR(255) DEFAULT \'\'NULL\'\' COLLATE utf8mb4_unicode_ci');
    }
}
