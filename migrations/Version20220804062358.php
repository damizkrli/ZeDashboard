<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220804062358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apply_for ADD plateform_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE apply_for ADD CONSTRAINT FK_E5874273CCAA542F FOREIGN KEY (plateform_id) REFERENCES platform (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E5874273CCAA542F ON apply_for (plateform_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apply_for DROP FOREIGN KEY FK_E5874273CCAA542F');
        $this->addSql('DROP INDEX UNIQ_E5874273CCAA542F ON apply_for');
        $this->addSql('ALTER TABLE apply_for DROP plateform_id');
    }
}
