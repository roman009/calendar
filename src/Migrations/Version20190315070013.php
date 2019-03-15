<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190315070013 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE google_calendar CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT NULL, CHANGE timezone timezone VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE exchange_calendar CHANGE change_key change_key VARCHAR(255) DEFAULT NULL, CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT NULL, CHANGE timezone timezone VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE exchange_auth_token CHANGE expires expires INT DEFAULT NULL');
        $this->addSql('ALTER TABLE organizer ADD email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE recipient ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE smart_invite CHANGE callback_url callback_url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE event CHANGE location location VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE outlook_calendar CHANGE owner_email_address owner_email_address VARCHAR(255) DEFAULT NULL, CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT NULL, CHANGE timezone timezone VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event CHANGE location location VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE exchange_auth_token CHANGE expires expires INT DEFAULT NULL');
        $this->addSql('ALTER TABLE exchange_calendar CHANGE change_key change_key VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE timezone timezone VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE google_calendar CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE timezone timezone VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE organizer DROP email');
        $this->addSql('ALTER TABLE outlook_calendar CHANGE owner_email_address owner_email_address VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE timezone timezone VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE recipient DROP name');
        $this->addSql('ALTER TABLE smart_invite CHANGE callback_url callback_url VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
