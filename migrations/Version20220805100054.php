<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220805100054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3314296D31F');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3311BC7E6B6');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3314296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3311BC7E6B6 FOREIGN KEY (writer_id) REFERENCES writer (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3314296D31F');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3311BC7E6B6');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3314296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3311BC7E6B6 FOREIGN KEY (writer_id) REFERENCES writer (id)');
    }
}
