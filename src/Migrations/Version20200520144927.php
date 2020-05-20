<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200520144927 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE blog_category (id INT AUTO_INCREMENT NOT NULL, blog_id_id INT NOT NULL, category_id_id INT NOT NULL, INDEX IDX_72113DE68FABDD9F (blog_id_id), INDEX IDX_72113DE69777D11E (category_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_tag (id INT AUTO_INCREMENT NOT NULL, blog_id_id INT NOT NULL, tag_id_id INT NOT NULL, INDEX IDX_6EC39898FABDD9F (blog_id_id), INDEX IDX_6EC39895DA88751 (tag_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, parent_id_id INT DEFAULT NULL, title VARCHAR(50) NOT NULL, metatitle VARCHAR(100) NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_64C19C1B3750AF4 (parent_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, blog_id_id INT NOT NULL, parent_id_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, deleted TINYINT(1) NOT NULL, last_update_at DATETIME NOT NULL, INDEX IDX_9474526C8FABDD9F (blog_id_id), INDEX IDX_9474526CB3750AF4 (parent_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_meta (id INT AUTO_INCREMENT NOT NULL, blog_id_id INT NOT NULL, mkey VARCHAR(50) NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_1EA7733E8FABDD9F (blog_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, meta_title VARCHAR(100) NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog_category ADD CONSTRAINT FK_72113DE68FABDD9F FOREIGN KEY (blog_id_id) REFERENCES blogs (id)');
        $this->addSql('ALTER TABLE blog_category ADD CONSTRAINT FK_72113DE69777D11E FOREIGN KEY (category_id_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE blog_tag ADD CONSTRAINT FK_6EC39898FABDD9F FOREIGN KEY (blog_id_id) REFERENCES blogs (id)');
        $this->addSql('ALTER TABLE blog_tag ADD CONSTRAINT FK_6EC39895DA88751 FOREIGN KEY (tag_id_id) REFERENCES tag (id)');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1B3750AF4 FOREIGN KEY (parent_id_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C8FABDD9F FOREIGN KEY (blog_id_id) REFERENCES blogs (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CB3750AF4 FOREIGN KEY (parent_id_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE post_meta ADD CONSTRAINT FK_1EA7733E8FABDD9F FOREIGN KEY (blog_id_id) REFERENCES blogs (id)');
        $this->addSql('ALTER TABLE user ADD first_name VARCHAR(50) NOT NULL, ADD last_name VARCHAR(50) NOT NULL, ADD email VARCHAR(180) NOT NULL, ADD mobile VARCHAR(15) DEFAULT NULL, ADD intro VARCHAR(500) NOT NULL, ADD registered_at DATETIME NOT NULL, ADD last_login DATETIME NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE blog_category DROP FOREIGN KEY FK_72113DE69777D11E');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1B3750AF4');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CB3750AF4');
        $this->addSql('ALTER TABLE blog_tag DROP FOREIGN KEY FK_6EC39895DA88751');
        $this->addSql('DROP TABLE blog_category');
        $this->addSql('DROP TABLE blog_tag');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE post_meta');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user DROP first_name, DROP last_name, DROP email, DROP mobile, DROP intro, DROP registered_at, DROP last_login');
    }
}
