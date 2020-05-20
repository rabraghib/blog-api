<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200519234433 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blogs ADD poster_id INT NOT NULL, DROP poster_username');
        $this->addSql('ALTER TABLE blogs ADD CONSTRAINT FK_F41BCA705BB66C05 FOREIGN KEY (poster_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F41BCA702B36786B ON blogs (title)');
        $this->addSql('CREATE INDEX IDX_F41BCA705BB66C05 ON blogs (poster_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE blogs DROP FOREIGN KEY FK_F41BCA705BB66C05');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX UNIQ_F41BCA702B36786B ON blogs');
        $this->addSql('DROP INDEX IDX_F41BCA705BB66C05 ON blogs');
        $this->addSql('ALTER TABLE blogs ADD poster_username VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, DROP poster_id');
    }
}
