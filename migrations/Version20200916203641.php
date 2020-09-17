<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200916203641 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `character` ADD friend_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `character` ADD CONSTRAINT FK_937AB0346A5458E8 FOREIGN KEY (friend_id) REFERENCES `character` (id)');
        $this->addSql('CREATE INDEX IDX_937AB0346A5458E8 ON `character` (friend_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `character` DROP FOREIGN KEY FK_937AB0346A5458E8');
        $this->addSql('DROP INDEX IDX_937AB0346A5458E8 ON `character`');
        $this->addSql('ALTER TABLE `character` DROP friend_id');
    }
}
