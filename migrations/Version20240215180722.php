<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240215180722 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE watch_list (id INT AUTO_INCREMENT NOT NULL, seen TINYINT(1) NOT NULL, liked TINYINT(1) NOT NULL, user_id INT NOT NULL, episode_id INT NOT NULL, UNIQUE INDEX UNIQ_152B584BA76ED395 (user_id), UNIQUE INDEX UNIQ_152B584B362B62A0 (episode_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE watch_list ADD CONSTRAINT FK_152B584BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE watch_list ADD CONSTRAINT FK_152B584B362B62A0 FOREIGN KEY (episode_id) REFERENCES episode (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE watch_list DROP FOREIGN KEY FK_152B584BA76ED395');
        $this->addSql('ALTER TABLE watch_list DROP FOREIGN KEY FK_152B584B362B62A0');
        $this->addSql('DROP TABLE watch_list');
    }
}
