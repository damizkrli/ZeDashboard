<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221013075817 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apply_for ADD company_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE apply_for ADD CONSTRAINT FK_E5874273979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('CREATE INDEX IDX_E5874273979B1AD6 ON apply_for (company_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apply_for DROP FOREIGN KEY FK_E5874273979B1AD6');
        $this->addSql('DROP INDEX IDX_E5874273979B1AD6 ON apply_for');
        $this->addSql('ALTER TABLE apply_for DROP company_id');
    }
}
