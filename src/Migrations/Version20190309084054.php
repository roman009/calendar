<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190309084054 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE google_calendar (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, `primary` TINYINT(1) DEFAULT \'0\' NOT NULL, calendar_id VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, summary LONGTEXT DEFAULT NULL, timezone VARCHAR(255) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_6A8CC36EA76ED395 (user_id), INDEX IDX_6A8CC36EA76ED395A40A2C8 (user_id, calendar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE google_auth_token (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, scope LONGTEXT NOT NULL, json LONGTEXT NOT NULL, access_token VARCHAR(255) NOT NULL, refresh_token VARCHAR(255) NOT NULL, expires_in INT NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_6DF45AB5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE office365_auth_token (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, access_token VARCHAR(255) NOT NULL, refresh_token VARCHAR(255) NOT NULL, expires_in INT NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_57B24CD6A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE apple_auth_token (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, access_token VARCHAR(255) NOT NULL, refresh_token VARCHAR(255) NOT NULL, expires_in INT NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_28C0F7CDA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE outlook_auth_token (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, access_token VARCHAR(255) NOT NULL, refresh_token VARCHAR(255) NOT NULL, expires_in INT NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_DBFADF7BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE google_calendar ADD CONSTRAINT FK_6A8CC36EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE google_auth_token ADD CONSTRAINT FK_6DF45AB5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE office365_auth_token ADD CONSTRAINT FK_57B24CD6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE apple_auth_token ADD CONSTRAINT FK_28C0F7CDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE outlook_auth_token ADD CONSTRAINT FK_DBFADF7BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE google_calendar DROP FOREIGN KEY FK_6A8CC36EA76ED395');
        $this->addSql('ALTER TABLE google_auth_token DROP FOREIGN KEY FK_6DF45AB5A76ED395');
        $this->addSql('ALTER TABLE office365_auth_token DROP FOREIGN KEY FK_57B24CD6A76ED395');
        $this->addSql('ALTER TABLE apple_auth_token DROP FOREIGN KEY FK_28C0F7CDA76ED395');
        $this->addSql('ALTER TABLE outlook_auth_token DROP FOREIGN KEY FK_DBFADF7BA76ED395');
        $this->addSql('DROP TABLE google_calendar');
        $this->addSql('DROP TABLE google_auth_token');
        $this->addSql('DROP TABLE office365_auth_token');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE apple_auth_token');
        $this->addSql('DROP TABLE outlook_auth_token');
    }
}
