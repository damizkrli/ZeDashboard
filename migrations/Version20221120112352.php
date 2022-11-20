<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221120112352 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apply_for ADD note_id INT DEFAULT NULL, DROP note');
        $this->addSql('ALTER TABLE apply_for ADD CONSTRAINT FK_E587427326ED0855 FOREIGN KEY (note_id) REFERENCES note (id)');
        $this->addSql('CREATE INDEX IDX_E587427326ED0855 ON apply_for (note_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apply_for DROP FOREIGN KEY FK_E587427326ED0855');
        $this->addSql('DROP INDEX IDX_E587427326ED0855 ON apply_for');
        $this->addSql('ALTER TABLE apply_for ADD note LONGTEXT DEFAULT NULL, DROP note_id');
    }
}
