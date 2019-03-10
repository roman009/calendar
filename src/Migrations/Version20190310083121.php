<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190310083121 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE google_calendar (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, `primary` TINYINT(1) DEFAULT \'0\' NOT NULL, calendar_id VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, summary LONGTEXT DEFAULT NULL, public_id VARCHAR(32) NOT NULL, timezone VARCHAR(255) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_6A8CC36EB5B48B91 (public_id), INDEX IDX_6A8CC36EA76ED395 (user_id), INDEX IDX_6A8CC36EA76ED395A40A2C8 (user_id, calendar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE google_auth_token (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, scope LONGTEXT DEFAULT NULL, access_token LONGTEXT NOT NULL, refresh_token LONGTEXT NOT NULL, expires INT NOT NULL, json LONGTEXT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_6DF45AB5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE office365_auth_token (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, access_token LONGTEXT NOT NULL, refresh_token LONGTEXT NOT NULL, expires INT NOT NULL, json LONGTEXT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_57B24CD6A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE apple_auth_token (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, access_token LONGTEXT NOT NULL, refresh_token LONGTEXT NOT NULL, expires INT NOT NULL, json LONGTEXT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_28C0F7CDA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE account_user (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, account_id INT NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_10051E3A76ED395 (user_id), INDEX IDX_10051E39B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE google_free_busy (id INT AUTO_INCREMENT NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE outlook_free_busy (id INT AUTO_INCREMENT NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE outlook_auth_token (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, access_token LONGTEXT NOT NULL, refresh_token LONGTEXT NOT NULL, expires INT NOT NULL, json LONGTEXT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_DBFADF7BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE outlook_calendar (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, owner_email_address VARCHAR(255) DEFAULT NULL, `primary` TINYINT(1) DEFAULT \'0\' NOT NULL, calendar_id VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, summary LONGTEXT DEFAULT NULL, public_id VARCHAR(32) NOT NULL, timezone VARCHAR(255) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_1FCC04BCB5B48B91 (public_id), INDEX IDX_1FCC04BCA76ED395 (user_id), INDEX IDX_1FCC04BCA76ED395A40A2C8 (user_id, calendar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE google_calendar ADD CONSTRAINT FK_6A8CC36EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE google_auth_token ADD CONSTRAINT FK_6DF45AB5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE office365_auth_token ADD CONSTRAINT FK_57B24CD6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE apple_auth_token ADD CONSTRAINT FK_28C0F7CDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE account_user ADD CONSTRAINT FK_10051E3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE account_user ADD CONSTRAINT FK_10051E39B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE outlook_auth_token ADD CONSTRAINT FK_DBFADF7BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE outlook_calendar ADD CONSTRAINT FK_1FCC04BCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE account_user DROP FOREIGN KEY FK_10051E39B6B5FBA');
        $this->addSql('ALTER TABLE google_calendar DROP FOREIGN KEY FK_6A8CC36EA76ED395');
        $this->addSql('ALTER TABLE google_auth_token DROP FOREIGN KEY FK_6DF45AB5A76ED395');
        $this->addSql('ALTER TABLE office365_auth_token DROP FOREIGN KEY FK_57B24CD6A76ED395');
        $this->addSql('ALTER TABLE apple_auth_token DROP FOREIGN KEY FK_28C0F7CDA76ED395');
        $this->addSql('ALTER TABLE account_user DROP FOREIGN KEY FK_10051E3A76ED395');
        $this->addSql('ALTER TABLE outlook_auth_token DROP FOREIGN KEY FK_DBFADF7BA76ED395');
        $this->addSql('ALTER TABLE outlook_calendar DROP FOREIGN KEY FK_1FCC04BCA76ED395');
        $this->addSql('DROP TABLE google_calendar');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE google_auth_token');
        $this->addSql('DROP TABLE office365_auth_token');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE apple_auth_token');
        $this->addSql('DROP TABLE account_user');
        $this->addSql('DROP TABLE google_free_busy');
        $this->addSql('DROP TABLE outlook_free_busy');
        $this->addSql('DROP TABLE outlook_auth_token');
        $this->addSql('DROP TABLE outlook_calendar');
    }
}
