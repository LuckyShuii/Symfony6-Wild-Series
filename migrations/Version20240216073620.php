<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240216073620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE watch_list_program (watch_list_id INT NOT NULL, program_id INT NOT NULL, INDEX IDX_47030295C4508918 (watch_list_id), INDEX IDX_470302953EB8070A (program_id), PRIMARY KEY(watch_list_id, program_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE watch_list_program ADD CONSTRAINT FK_47030295C4508918 FOREIGN KEY (watch_list_id) REFERENCES watch_list (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE watch_list_program ADD CONSTRAINT FK_470302953EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE watch_list DROP FOREIGN KEY FK_152B584B3EB8070A');
        $this->addSql('DROP INDEX IDX_152B584B3EB8070A ON watch_list');
        $this->addSql('ALTER TABLE watch_list DROP program_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE watch_list_program DROP FOREIGN KEY FK_47030295C4508918');
        $this->addSql('ALTER TABLE watch_list_program DROP FOREIGN KEY FK_470302953EB8070A');
        $this->addSql('DROP TABLE watch_list_program');
        $this->addSql('ALTER TABLE watch_list ADD program_id INT NOT NULL');
        $this->addSql('ALTER TABLE watch_list ADD CONSTRAINT FK_152B584B3EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_152B584B3EB8070A ON watch_list (program_id)');
    }
}
