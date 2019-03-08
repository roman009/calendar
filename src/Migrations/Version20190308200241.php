<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190308200241 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE google_calendar (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, `primary` TINYINT(1) DEFAULT \'0\' NOT NULL, calendar_id VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, summary LONGTEXT DEFAULT NULL, timezone VARCHAR(255) DEFAULT NULL, INDEX IDX_6A8CC36EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE google_token (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, access_token VARCHAR(255) NOT NULL, refresh_token VARCHAR(255) NOT NULL, scope LONGTEXT NOT NULL, expires_in INT NOT NULL, json LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_C6DAA834A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE google_calendar ADD CONSTRAINT FK_6A8CC36EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE google_token ADD CONSTRAINT FK_C6DAA834A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE google_calendar DROP FOREIGN KEY FK_6A8CC36EA76ED395');
        $this->addSql('ALTER TABLE google_token DROP FOREIGN KEY FK_C6DAA834A76ED395');
        $this->addSql('DROP TABLE google_calendar');
        $this->addSql('DROP TABLE google_token');
        $this->addSql('DROP TABLE user');
    }
}
