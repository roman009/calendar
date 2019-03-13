<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190313162056 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_6A8CC36EB5B48B91 ON google_calendar');
        $this->addSql('ALTER TABLE google_calendar CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT NULL, CHANGE timezone timezone VARCHAR(255) DEFAULT NULL, CHANGE public_id object_id VARCHAR(32) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6A8CC36E232D562B ON google_calendar (object_id)');
        $this->addSql('DROP INDEX UNIQ_7D3656A4B5B48B91 ON account');
        $this->addSql('ALTER TABLE account CHANGE public_id object_id VARCHAR(32) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7D3656A4232D562B ON account (object_id)');
        $this->addSql('DROP INDEX UNIQ_6DF45AB5B5B48B91 ON google_auth_token');
        $this->addSql('ALTER TABLE google_auth_token CHANGE public_id object_id VARCHAR(32) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6DF45AB5232D562B ON google_auth_token (object_id)');
        $this->addSql('DROP INDEX UNIQ_57B24CD6B5B48B91 ON office365_auth_token');
        $this->addSql('ALTER TABLE office365_auth_token CHANGE public_id object_id VARCHAR(32) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_57B24CD6232D562B ON office365_auth_token (object_id)');
        $this->addSql('DROP INDEX UNIQ_1CCAD967B5B48B91 ON outlook_event');
        $this->addSql('ALTER TABLE outlook_event CHANGE public_id object_id VARCHAR(32) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1CCAD967232D562B ON outlook_event (object_id)');
        $this->addSql('DROP INDEX UNIQ_A24303A8B5B48B91 ON google_event');
        $this->addSql('ALTER TABLE google_event CHANGE public_id object_id VARCHAR(32) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A24303A8232D562B ON google_event (object_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649B5B48B91 ON user');
        $this->addSql('ALTER TABLE user CHANGE public_id object_id VARCHAR(32) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649232D562B ON user (object_id)');
        $this->addSql('DROP INDEX UNIQ_28C0F7CDB5B48B91 ON apple_auth_token');
        $this->addSql('ALTER TABLE apple_auth_token CHANGE public_id object_id VARCHAR(32) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_28C0F7CD232D562B ON apple_auth_token (object_id)');
        $this->addSql('DROP INDEX UNIQ_10051E3B5B48B91 ON account_user');
        $this->addSql('ALTER TABLE account_user CHANGE public_id object_id VARCHAR(32) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_10051E3232D562B ON account_user (object_id)');
        $this->addSql('DROP INDEX UNIQ_C79E24DAB5B48B91 ON google_free_busy');
        $this->addSql('ALTER TABLE google_free_busy CHANGE public_id object_id VARCHAR(32) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C79E24DA232D562B ON google_free_busy (object_id)');
        $this->addSql('DROP INDEX UNIQ_AF36D7E5B5B48B91 ON outlook_free_busy');
        $this->addSql('ALTER TABLE outlook_free_busy CHANGE public_id object_id VARCHAR(32) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AF36D7E5232D562B ON outlook_free_busy (object_id)');
        $this->addSql('DROP INDEX UNIQ_DBFADF7BB5B48B91 ON outlook_auth_token');
        $this->addSql('ALTER TABLE outlook_auth_token CHANGE public_id object_id VARCHAR(32) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DBFADF7B232D562B ON outlook_auth_token (object_id)');
        $this->addSql('DROP INDEX UNIQ_1FCC04BCB5B48B91 ON outlook_calendar');
        $this->addSql('ALTER TABLE outlook_calendar CHANGE owner_email_address owner_email_address VARCHAR(255) DEFAULT NULL, CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT NULL, CHANGE timezone timezone VARCHAR(255) DEFAULT NULL, CHANGE public_id object_id VARCHAR(32) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1FCC04BC232D562B ON outlook_calendar (object_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_7D3656A4232D562B ON account');
        $this->addSql('ALTER TABLE account CHANGE object_id public_id VARCHAR(32) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7D3656A4B5B48B91 ON account (public_id)');
        $this->addSql('DROP INDEX UNIQ_10051E3232D562B ON account_user');
        $this->addSql('ALTER TABLE account_user CHANGE object_id public_id VARCHAR(32) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_10051E3B5B48B91 ON account_user (public_id)');
        $this->addSql('DROP INDEX UNIQ_28C0F7CD232D562B ON apple_auth_token');
        $this->addSql('ALTER TABLE apple_auth_token CHANGE object_id public_id VARCHAR(32) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_28C0F7CDB5B48B91 ON apple_auth_token (public_id)');
        $this->addSql('DROP INDEX UNIQ_6DF45AB5232D562B ON google_auth_token');
        $this->addSql('ALTER TABLE google_auth_token CHANGE object_id public_id VARCHAR(32) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6DF45AB5B5B48B91 ON google_auth_token (public_id)');
        $this->addSql('DROP INDEX UNIQ_6A8CC36E232D562B ON google_calendar');
        $this->addSql('ALTER TABLE google_calendar CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE timezone timezone VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE object_id public_id VARCHAR(32) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6A8CC36EB5B48B91 ON google_calendar (public_id)');
        $this->addSql('DROP INDEX UNIQ_A24303A8232D562B ON google_event');
        $this->addSql('ALTER TABLE google_event CHANGE object_id public_id VARCHAR(32) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A24303A8B5B48B91 ON google_event (public_id)');
        $this->addSql('DROP INDEX UNIQ_C79E24DA232D562B ON google_free_busy');
        $this->addSql('ALTER TABLE google_free_busy CHANGE object_id public_id VARCHAR(32) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C79E24DAB5B48B91 ON google_free_busy (public_id)');
        $this->addSql('DROP INDEX UNIQ_57B24CD6232D562B ON office365_auth_token');
        $this->addSql('ALTER TABLE office365_auth_token CHANGE object_id public_id VARCHAR(32) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_57B24CD6B5B48B91 ON office365_auth_token (public_id)');
        $this->addSql('DROP INDEX UNIQ_DBFADF7B232D562B ON outlook_auth_token');
        $this->addSql('ALTER TABLE outlook_auth_token CHANGE object_id public_id VARCHAR(32) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DBFADF7BB5B48B91 ON outlook_auth_token (public_id)');
        $this->addSql('DROP INDEX UNIQ_1FCC04BC232D562B ON outlook_calendar');
        $this->addSql('ALTER TABLE outlook_calendar CHANGE owner_email_address owner_email_address VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE timezone timezone VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE object_id public_id VARCHAR(32) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1FCC04BCB5B48B91 ON outlook_calendar (public_id)');
        $this->addSql('DROP INDEX UNIQ_1CCAD967232D562B ON outlook_event');
        $this->addSql('ALTER TABLE outlook_event CHANGE object_id public_id VARCHAR(32) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1CCAD967B5B48B91 ON outlook_event (public_id)');
        $this->addSql('DROP INDEX UNIQ_AF36D7E5232D562B ON outlook_free_busy');
        $this->addSql('ALTER TABLE outlook_free_busy CHANGE object_id public_id VARCHAR(32) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AF36D7E5B5B48B91 ON outlook_free_busy (public_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649232D562B ON user');
        $this->addSql('ALTER TABLE user CHANGE object_id public_id VARCHAR(32) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649B5B48B91 ON user (public_id)');
    }
}
