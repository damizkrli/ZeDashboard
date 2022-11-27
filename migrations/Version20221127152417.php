<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221127152417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apply_for DROP FOREIGN KEY FK_E5874273979B1AD6');
        $this->addSql('ALTER TABLE apply_for DROP FOREIGN KEY FK_E5874273FFE6496F');
        $this->addSql('ALTER TABLE directory DROP FOREIGN KEY FK_467844DA979B1AD6');
        $this->addSql('ALTER TABLE apply_for_note DROP FOREIGN KEY FK_DA848A0A26ED0855');
        $this->addSql('ALTER TABLE apply_for_note DROP FOREIGN KEY FK_DA848A0A816528D8');
        $this->addSql('DROP TABLE directory');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE apply_for_note');
        $this->addSql('DROP TABLE platform');
        $this->addSql('DROP TABLE professional_link');
        $this->addSql('DROP TABLE technical_link');
        $this->addSql('DROP TABLE personal_link');
        $this->addSql('DROP INDEX IDX_E5874273FFE6496F ON apply_for');
        $this->addSql('DROP INDEX IDX_E5874273979B1AD6 ON apply_for');
        $this->addSql('ALTER TABLE apply_for DROP company_id, DROP platform_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE directory (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, phone VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_467844DA979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, name LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, note LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE apply_for_note (apply_for_id INT NOT NULL, note_id INT NOT NULL, INDEX IDX_DA848A0A26ED0855 (note_id), INDEX IDX_DA848A0A816528D8 (apply_for_id), PRIMARY KEY(apply_for_id, note_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE platform (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(70) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE professional_link (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(75) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, url VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE technical_link (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, url VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE personal_link (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, url VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE directory ADD CONSTRAINT FK_467844DA979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE apply_for_note ADD CONSTRAINT FK_DA848A0A26ED0855 FOREIGN KEY (note_id) REFERENCES note (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apply_for_note ADD CONSTRAINT FK_DA848A0A816528D8 FOREIGN KEY (apply_for_id) REFERENCES apply_for (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apply_for ADD company_id INT DEFAULT NULL, ADD platform_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE apply_for ADD CONSTRAINT FK_E5874273979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apply_for ADD CONSTRAINT FK_E5874273FFE6496F FOREIGN KEY (platform_id) REFERENCES platform (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_E5874273FFE6496F ON apply_for (platform_id)');
        $this->addSql('CREATE INDEX IDX_E5874273979B1AD6 ON apply_for (company_id)');
    }
}
