<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240219194318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE code_weave (id INT AUTO_INCREMENT NOT NULL, type INT NOT NULL, code LONGTEXT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE code_weaver_files (id INT AUTO_INCREMENT NOT NULL, css_file VARCHAR(255) DEFAULT NULL, js_file VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, post_id INT DEFAULT NULL, pseudo VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_5F9E962A4B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE social_manager (id INT AUTO_INCREMENT NOT NULL, facebook VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, youtube VARCHAR(255) DEFAULT NULL, pinterest VARCHAR(255) DEFAULT NULL, slideshare VARCHAR(255) DEFAULT NULL, xing VARCHAR(255) DEFAULT NULL, angel_list VARCHAR(255) DEFAULT NULL, glassdoor VARCHAR(255) DEFAULT NULL, behance VARCHAR(255) DEFAULT NULL, meetup VARCHAR(255) DEFAULT NULL, reddit VARCHAR(255) DEFAULT NULL, quora VARCHAR(255) DEFAULT NULL, whatsapp VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A4B89032C FOREIGN KEY (post_id) REFERENCES posts_list (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A4B89032C');
        $this->addSql('DROP TABLE code_weave');
        $this->addSql('DROP TABLE code_weaver_files');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE social_manager');
    }
}
