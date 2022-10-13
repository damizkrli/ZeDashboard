<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221013080058 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apply_for ADD platform_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE apply_for ADD CONSTRAINT FK_E5874273FFE6496F FOREIGN KEY (platform_id) REFERENCES platform (id)');
        $this->addSql('CREATE INDEX IDX_E5874273FFE6496F ON apply_for (platform_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apply_for DROP FOREIGN KEY FK_E5874273FFE6496F');
        $this->addSql('DROP INDEX IDX_E5874273FFE6496F ON apply_for');
        $this->addSql('ALTER TABLE apply_for DROP platform_id');
    }
}
