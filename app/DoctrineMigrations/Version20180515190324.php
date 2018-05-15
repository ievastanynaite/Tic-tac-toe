<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180515190324 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE move_entity (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, moveNumber INT NOT NULL, moveValue VARCHAR(255) NOT NULL, INDEX IDX_A1EE5D3BE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_entity (id INT AUTO_INCREMENT NOT NULL, isFinished TINYINT(1) DEFAULT \'0\' NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE move_entity ADD CONSTRAINT FK_A1EE5D3BE48FD905 FOREIGN KEY (game_id) REFERENCES game_entity (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE move_entity DROP FOREIGN KEY FK_A1EE5D3BE48FD905');
        $this->addSql('DROP TABLE move_entity');
        $this->addSql('DROP TABLE game_entity');
    }
}
