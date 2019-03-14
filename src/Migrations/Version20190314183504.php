<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190314183504 extends AbstractMigration
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
        $this->addSql('CREATE TABLE organizer (id INT AUTO_INCREMENT NOT NULL, smart_invite_id INT NOT NULL, account_user_id INT NOT NULL, name VARCHAR(255) NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_99D47173232D562B (object_id), UNIQUE INDEX UNIQ_99D47173EA6DCFAD (smart_invite_id), INDEX IDX_99D471736E45C7DD (account_user_id), INDEX IDX_99D471736E45C7DD232D562B (account_user_id, object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attachment (id INT AUTO_INCREMENT NOT NULL, smart_invite_id INT NOT NULL, account_user_id INT NOT NULL, icalendar LONGTEXT NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_795FD9BB232D562B (object_id), INDEX IDX_795FD9BBEA6DCFAD (smart_invite_id), INDEX IDX_795FD9BB6E45C7DD (account_user_id), INDEX IDX_795FD9BB6E45C7DD232D562B (account_user_id, object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipient (id INT AUTO_INCREMENT NOT NULL, smart_invite_id INT NOT NULL, account_user_id INT NOT NULL, email VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_6804FB49232D562B (object_id), UNIQUE INDEX UNIQ_6804FB49EA6DCFAD (smart_invite_id), INDEX IDX_6804FB496E45C7DD (account_user_id), INDEX IDX_6804FB496E45C7DD232D562B (account_user_id, object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE smart_invite (id INT AUTO_INCREMENT NOT NULL, account_user_id INT NOT NULL, smart_invite_id VARCHAR(255) NOT NULL, callback_url VARCHAR(255) DEFAULT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_D8967D09232D562B (object_id), INDEX IDX_D8967D096E45C7DD (account_user_id), INDEX IDX_D8967D096E45C7DD232D562B (account_user_id, object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, smart_invite_id INT NOT NULL, account_user_id INT NOT NULL, summary VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, timezone VARCHAR(255) NOT NULL, location VARCHAR(255) DEFAULT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_3BAE0AA7232D562B (object_id), UNIQUE INDEX UNIQ_3BAE0AA7EA6DCFAD (smart_invite_id), INDEX IDX_3BAE0AA76E45C7DD (account_user_id), INDEX IDX_3BAE0AA76E45C7DD232D562B (account_user_id, object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exchange_event ADD CONSTRAINT FK_259946EF6E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE organizer ADD CONSTRAINT FK_99D47173EA6DCFAD FOREIGN KEY (smart_invite_id) REFERENCES smart_invite (id)');
        $this->addSql('ALTER TABLE organizer ADD CONSTRAINT FK_99D471736E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE attachment ADD CONSTRAINT FK_795FD9BBEA6DCFAD FOREIGN KEY (smart_invite_id) REFERENCES smart_invite (id)');
        $this->addSql('ALTER TABLE attachment ADD CONSTRAINT FK_795FD9BB6E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE recipient ADD CONSTRAINT FK_6804FB49EA6DCFAD FOREIGN KEY (smart_invite_id) REFERENCES smart_invite (id)');
        $this->addSql('ALTER TABLE recipient ADD CONSTRAINT FK_6804FB496E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE smart_invite ADD CONSTRAINT FK_D8967D096E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7EA6DCFAD FOREIGN KEY (smart_invite_id) REFERENCES smart_invite (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA76E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE google_calendar CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT NULL, CHANGE timezone timezone VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE exchange_calendar CHANGE change_key change_key VARCHAR(255) DEFAULT NULL, CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT NULL, CHANGE timezone timezone VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE exchange_auth_token CHANGE expires expires INT DEFAULT NULL');
        $this->addSql('ALTER TABLE outlook_calendar CHANGE owner_email_address owner_email_address VARCHAR(255) DEFAULT NULL, CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT NULL, CHANGE timezone timezone VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE organizer DROP FOREIGN KEY FK_99D47173EA6DCFAD');
        $this->addSql('ALTER TABLE attachment DROP FOREIGN KEY FK_795FD9BBEA6DCFAD');
        $this->addSql('ALTER TABLE recipient DROP FOREIGN KEY FK_6804FB49EA6DCFAD');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7EA6DCFAD');
        $this->addSql('DROP TABLE exchange_event');
        $this->addSql('DROP TABLE organizer');
        $this->addSql('DROP TABLE attachment');
        $this->addSql('DROP TABLE recipient');
        $this->addSql('DROP TABLE smart_invite');
        $this->addSql('DROP TABLE event');
        $this->addSql('ALTER TABLE exchange_auth_token CHANGE expires expires INT DEFAULT NULL');
        $this->addSql('ALTER TABLE exchange_calendar CHANGE change_key change_key VARCHAR(255) DEFAULT \'\'NULL\'\' COLLATE utf8mb4_unicode_ci, CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT \'\'NULL\'\' COLLATE utf8mb4_unicode_ci, CHANGE timezone timezone VARCHAR(255) DEFAULT \'\'NULL\'\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE google_calendar CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT \'\'NULL\'\' COLLATE utf8mb4_unicode_ci, CHANGE timezone timezone VARCHAR(255) DEFAULT \'\'NULL\'\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE outlook_calendar CHANGE owner_email_address owner_email_address VARCHAR(255) DEFAULT \'\'NULL\'\' COLLATE utf8mb4_unicode_ci, CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT \'\'NULL\'\' COLLATE utf8mb4_unicode_ci, CHANGE timezone timezone VARCHAR(255) DEFAULT \'\'NULL\'\' COLLATE utf8mb4_unicode_ci');
    }
}
