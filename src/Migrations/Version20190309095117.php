<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190309095117 extends AbstractMigration
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
        $this->addSql('ALTER TABLE google_auth_token CHANGE scope scope LONGTEXT DEFAULT NULL, CHANGE json json LONGTEXT DEFAULT NULL, CHANGE expires_in expires INT NOT NULL');
        $this->addSql('ALTER TABLE office365_auth_token CHANGE expires_in expires INT NOT NULL');
        $this->addSql('ALTER TABLE apple_auth_token CHANGE expires_in expires INT NOT NULL');
        $this->addSql('ALTER TABLE outlook_auth_token CHANGE expires_in expires INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE apple_auth_token CHANGE expires expires_in INT NOT NULL');
        $this->addSql('ALTER TABLE google_auth_token CHANGE scope scope LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE json json LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE expires expires_in INT NOT NULL');
        $this->addSql('ALTER TABLE google_calendar CHANGE calendar_id calendar_id VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE timezone timezone VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE office365_auth_token CHANGE expires expires_in INT NOT NULL');
        $this->addSql('ALTER TABLE outlook_auth_token CHANGE expires expires_in INT NOT NULL');
    }
}
