<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220801105124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apply_for ADD company_id INT DEFAULT NULL, DROP company');
        $this->addSql('ALTER TABLE apply_for ADD CONSTRAINT FK_E5874273979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E5874273979B1AD6 ON apply_for (company_id)');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F816528D8');
        $this->addSql('DROP INDEX UNIQ_4FBF094F816528D8 ON company');
        $this->addSql('ALTER TABLE company DROP apply_for_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apply_for DROP FOREIGN KEY FK_E5874273979B1AD6');
        $this->addSql('DROP INDEX UNIQ_E5874273979B1AD6 ON apply_for');
        $this->addSql('ALTER TABLE apply_for ADD company VARCHAR(100) NOT NULL, DROP company_id');
        $this->addSql('ALTER TABLE company ADD apply_for_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F816528D8 FOREIGN KEY (apply_for_id) REFERENCES apply_for (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FBF094F816528D8 ON company (apply_for_id)');
    }
}
