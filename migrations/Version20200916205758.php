<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200916205758 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE character_friends (character_id INT NOT NULL, friend_id INT NOT NULL, INDEX IDX_484BF0541136BE75 (character_id), INDEX IDX_484BF0546A5458E8 (friend_id), PRIMARY KEY(character_id, friend_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE character_friends ADD CONSTRAINT FK_484BF0541136BE75 FOREIGN KEY (character_id) REFERENCES `character` (id)');
        $this->addSql('ALTER TABLE character_friends ADD CONSTRAINT FK_484BF0546A5458E8 FOREIGN KEY (friend_id) REFERENCES `character` (id)');
        $this->addSql('ALTER TABLE `character` DROP FOREIGN KEY FK_937AB0346A5458E8');
        $this->addSql('DROP INDEX IDX_937AB0346A5458E8 ON `character`');
        $this->addSql('ALTER TABLE `character` DROP friend_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE character_friends');
        $this->addSql('ALTER TABLE `character` ADD friend_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `character` ADD CONSTRAINT FK_937AB0346A5458E8 FOREIGN KEY (friend_id) REFERENCES `character` (id)');
        $this->addSql('CREATE INDEX IDX_937AB0346A5458E8 ON `character` (friend_id)');
    }
}
