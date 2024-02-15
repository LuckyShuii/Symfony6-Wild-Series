<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240215190109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE watch_list DROP INDEX UNIQ_152B584BA76ED395, ADD INDEX IDX_152B584BA76ED395 (user_id)');
        $this->addSql('ALTER TABLE watch_list DROP INDEX UNIQ_152B584B3EB8070A, ADD INDEX IDX_152B584B3EB8070A (program_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE watch_list DROP INDEX IDX_152B584BA76ED395, ADD UNIQUE INDEX UNIQ_152B584BA76ED395 (user_id)');
        $this->addSql('ALTER TABLE watch_list DROP INDEX IDX_152B584B3EB8070A, ADD UNIQUE INDEX UNIQ_152B584B3EB8070A (program_id)');
    }
}
