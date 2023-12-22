<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231222092715 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, numero INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE wine ADD region_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE wine ADD CONSTRAINT FK_560C646898260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('CREATE INDEX IDX_560C646898260155 ON wine (region_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wine DROP FOREIGN KEY FK_560C646898260155');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP INDEX IDX_560C646898260155 ON wine');
        $this->addSql('ALTER TABLE wine DROP region_id');
    }
}
