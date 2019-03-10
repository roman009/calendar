<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190310085017 extends AbstractMigration
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
        $this->addSql('ALTER TABLE account ADD public_id VARCHAR(32) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7D3656A4B5B48B91 ON account (public_id)');
        $this->addSql('ALTER TABLE google_auth_token ADD public_id VARCHAR(32) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6DF45AB5B5B48B91 ON google_auth_token (public_id)');
        $this->addSql('ALTER TABLE office365_auth_token ADD public_id VARCHAR(32) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_57B24CD6B5B48B91 ON office365_auth_token (public_id)');
        $this->addSql('ALTER TABLE user ADD public_id VARCHAR(32) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649B5B48B91 ON user (public_id)');
        $this->addSql('ALTER TABLE apple_auth_token ADD public_id VARCHAR(32) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_28C0F7CDB5B48B91 ON apple_auth_token (public_id)');
        $this->addSql('ALTER TABLE account_user ADD public_id VARCHAR(32) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_10051E3B5B48B91 ON account_user (public_id)');
        $this->addSql('ALTER TABLE google_free_busy ADD public_id VARCHAR(32) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C79E24DAB5B48B91 ON google_free_busy (public_id)');
        $this->addSql('ALTER TABLE outlook_free_busy ADD public_id VARCHAR(32) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AF36D7E5B5B48B91 ON outlook_free_busy (public_id)');
        $this->addSql('ALTER TABLE outlook_auth_token ADD public_id VARCHAR(32) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DBFADF7BB5B48B91 ON outlook_auth_token (public_id)');
        $this->addSql('ALTER TABLE outlook_calendar CHANGE owner_email_address owner_email_address VARCHAR(255) DEFAULT NULL, CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT NULL, CHANGE timezone timezone VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_7D3656A4B5B48B91 ON account');
        $this->addSql('ALTER TABLE account DROP public_id');
        $this->addSql('DROP INDEX UNIQ_10051E3B5B48B91 ON account_user');
        $this->addSql('ALTER TABLE account_user DROP public_id');
        $this->addSql('DROP INDEX UNIQ_28C0F7CDB5B48B91 ON apple_auth_token');
        $this->addSql('ALTER TABLE apple_auth_token DROP public_id');
        $this->addSql('DROP INDEX UNIQ_6DF45AB5B5B48B91 ON google_auth_token');
        $this->addSql('ALTER TABLE google_auth_token DROP public_id');
        $this->addSql('ALTER TABLE google_calendar CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE timezone timezone VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('DROP INDEX UNIQ_C79E24DAB5B48B91 ON google_free_busy');
        $this->addSql('ALTER TABLE google_free_busy DROP public_id');
        $this->addSql('DROP INDEX UNIQ_57B24CD6B5B48B91 ON office365_auth_token');
        $this->addSql('ALTER TABLE office365_auth_token DROP public_id');
        $this->addSql('DROP INDEX UNIQ_DBFADF7BB5B48B91 ON outlook_auth_token');
        $this->addSql('ALTER TABLE outlook_auth_token DROP public_id');
        $this->addSql('ALTER TABLE outlook_calendar CHANGE owner_email_address owner_email_address VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE timezone timezone VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('DROP INDEX UNIQ_AF36D7E5B5B48B91 ON outlook_free_busy');
        $this->addSql('ALTER TABLE outlook_free_busy DROP public_id');
        $this->addSql('DROP INDEX UNIQ_8D93D649B5B48B91 ON user');
        $this->addSql('ALTER TABLE user DROP public_id');
    }
}
