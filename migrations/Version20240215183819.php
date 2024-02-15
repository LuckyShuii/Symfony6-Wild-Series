<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240215183819 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE watch_list DROP FOREIGN KEY FK_152B584B362B62A0');
        $this->addSql('DROP INDEX UNIQ_152B584B362B62A0 ON watch_list');
        $this->addSql('ALTER TABLE watch_list CHANGE episode_id program_id INT NOT NULL');
        $this->addSql('ALTER TABLE watch_list ADD CONSTRAINT FK_152B584B3EB8070A FOREIGN KEY (program_id) REFERENCES program (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_152B584B3EB8070A ON watch_list (program_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE watch_list DROP FOREIGN KEY FK_152B584B3EB8070A');
        $this->addSql('DROP INDEX UNIQ_152B584B3EB8070A ON watch_list');
        $this->addSql('ALTER TABLE watch_list CHANGE program_id episode_id INT NOT NULL');
        $this->addSql('ALTER TABLE watch_list ADD CONSTRAINT FK_152B584B362B62A0 FOREIGN KEY (episode_id) REFERENCES episode (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_152B584B362B62A0 ON watch_list (episode_id)');
    }
}
