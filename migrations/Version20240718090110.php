<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240718090110 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tags ADD project_id_id INT NOT NULL, ADD label VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE tags ADD CONSTRAINT FK_6FBC94266C1197C9 FOREIGN KEY (project_id_id) REFERENCES project (id)');
        $this->addSql('CREATE INDEX IDX_6FBC94266C1197C9 ON tags (project_id_id)');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB259D86650F');
        $this->addSql('DROP INDEX IDX_527EDB259D86650F ON task');
        $this->addSql('ALTER TABLE task DROP user_id_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tags DROP FOREIGN KEY FK_6FBC94266C1197C9');
        $this->addSql('DROP INDEX IDX_6FBC94266C1197C9 ON tags');
        $this->addSql('ALTER TABLE tags DROP project_id_id, DROP label');
        $this->addSql('ALTER TABLE task ADD user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB259D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_527EDB259D86650F ON task (user_id_id)');
    }
}
