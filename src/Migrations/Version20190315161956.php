<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190315161956 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE smart_invite_reply (id INT AUTO_INCREMENT NOT NULL, smart_invite_id INT NOT NULL, account_user_id INT NOT NULL, email VARCHAR(255) NOT NULL, comment VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, object_id VARCHAR(32) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_4A6C853A232D562B (object_id), UNIQUE INDEX UNIQ_4A6C853AEA6DCFAD (smart_invite_id), INDEX IDX_4A6C853A6E45C7DD (account_user_id), INDEX IDX_4A6C853A6E45C7DD232D562B (account_user_id, object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE smart_invite_reply ADD CONSTRAINT FK_4A6C853AEA6DCFAD FOREIGN KEY (smart_invite_id) REFERENCES smart_invite (id)');
        $this->addSql('ALTER TABLE smart_invite_reply ADD CONSTRAINT FK_4A6C853A6E45C7DD FOREIGN KEY (account_user_id) REFERENCES account_user (id)');
        $this->addSql('ALTER TABLE google_calendar CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT NULL, CHANGE timezone timezone VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE exchange_calendar CHANGE change_key change_key VARCHAR(255) DEFAULT NULL, CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT NULL, CHANGE timezone timezone VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE exchange_auth_token CHANGE expires expires INT DEFAULT NULL');
        $this->addSql('ALTER TABLE smart_invite_event CHANGE location location VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE smart_invite CHANGE callback_url callback_url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE outlook_calendar CHANGE owner_email_address owner_email_address VARCHAR(255) DEFAULT NULL, CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT NULL, CHANGE timezone timezone VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE smart_invite_reply');
        $this->addSql('ALTER TABLE exchange_auth_token CHANGE expires expires INT DEFAULT NULL');
        $this->addSql('ALTER TABLE exchange_calendar CHANGE change_key change_key VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE timezone timezone VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE google_calendar CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE timezone timezone VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE outlook_calendar CHANGE owner_email_address owner_email_address VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE timezone timezone VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE smart_invite CHANGE callback_url callback_url VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE smart_invite_event CHANGE location location VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
