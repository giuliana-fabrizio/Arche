<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250416115702 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, fk_post_type_id INT DEFAULT NULL, fk_section_id INT NOT NULL, fk_user_id INT NOT NULL, datetime DATETIME NOT NULL, description LONGTEXT DEFAULT NULL, label VARCHAR(50) NOT NULL, ranking INT DEFAULT NULL, pinned TINYINT(1) DEFAULT NULL, filename VARCHAR(50) DEFAULT NULL, filetype VARCHAR(5) DEFAULT NULL, INDEX IDX_5A8A6C8DD97939B9 (fk_post_type_id), INDEX IDX_5A8A6C8D284D29E9 (fk_section_id), INDEX IDX_5A8A6C8D5741EEB9 (fk_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE post_type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE section (id INT AUTO_INCREMENT NOT NULL, fk_ue_id INT NOT NULL, label VARCHAR(50) NOT NULL, ranking INT DEFAULT NULL, INDEX IDX_2D737AEFA305A0C4 (fk_ue_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ue (id INT AUTO_INCREMENT NOT NULL, fk_category_id INT NOT NULL, user_id INT NOT NULL, code VARCHAR(4) NOT NULL, label VARCHAR(100) NOT NULL, photo VARCHAR(50) DEFAULT NULL, INDEX IDX_2E490A9B7BB031D6 (fk_category_id), INDEX IDX_2E490A9BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role_id INT NOT NULL, address VARCHAR(50) DEFAULT NULL, avatar VARCHAR(50) DEFAULT NULL, email VARCHAR(50) NOT NULL, firstname VARCHAR(20) NOT NULL, lastname VARCHAR(20) NOT NULL, password VARCHAR(50) NOT NULL, phone VARCHAR(10) NOT NULL, INDEX IDX_8D93D649D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_ue (user_id INT NOT NULL, ue_id INT NOT NULL, INDEX IDX_361EBE5EA76ED395 (user_id), INDEX IDX_361EBE5E62E883B1 (ue_id), PRIMARY KEY(user_id, ue_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DD97939B9 FOREIGN KEY (fk_post_type_id) REFERENCES post_type (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D284D29E9 FOREIGN KEY (fk_section_id) REFERENCES section (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D5741EEB9 FOREIGN KEY (fk_user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE section ADD CONSTRAINT FK_2D737AEFA305A0C4 FOREIGN KEY (fk_ue_id) REFERENCES ue (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ue ADD CONSTRAINT FK_2E490A9B7BB031D6 FOREIGN KEY (fk_category_id) REFERENCES category (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ue ADD CONSTRAINT FK_2E490A9BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_ue ADD CONSTRAINT FK_361EBE5EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_ue ADD CONSTRAINT FK_361EBE5E62E883B1 FOREIGN KEY (ue_id) REFERENCES ue (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DD97939B9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D284D29E9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D5741EEB9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE section DROP FOREIGN KEY FK_2D737AEFA305A0C4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ue DROP FOREIGN KEY FK_2E490A9B7BB031D6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ue DROP FOREIGN KEY FK_2E490A9BA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_ue DROP FOREIGN KEY FK_361EBE5EA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_ue DROP FOREIGN KEY FK_361EBE5E62E883B1
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE category
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE post
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE post_type
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE role
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE section
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ue
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_ue
        SQL);
    }
}
