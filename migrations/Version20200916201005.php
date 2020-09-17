<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200916201005 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE character_episodes DROP INDEX UNIQ_25D4B74C362B62A0, ADD INDEX IDX_25D4B74C362B62A0 (episode_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE character_episodes DROP INDEX IDX_25D4B74C362B62A0, ADD UNIQUE INDEX UNIQ_25D4B74C362B62A0 (episode_id)');
    }
}
