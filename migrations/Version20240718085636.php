<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240718085636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE crenaux (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, task_id_id INT DEFAULT NULL, started_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', finished_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_AE70886B9D86650F (user_id_id), INDEX IDX_AE70886BB8E08577 (task_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statut (id INT AUTO_INCREMENT NOT NULL, project_id_id INT NOT NULL, label VARCHAR(255) NOT NULL, INDEX IDX_E564F0BF6C1197C9 (project_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tags (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, project_id_id INT DEFAULT NULL, statut_id_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, deadline DATE NOT NULL, INDEX IDX_527EDB259D86650F (user_id_id), INDEX IDX_527EDB256C1197C9 (project_id_id), INDEX IDX_527EDB254DB9F129 (statut_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE crenaux ADD CONSTRAINT FK_AE70886B9D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE crenaux ADD CONSTRAINT FK_AE70886BB8E08577 FOREIGN KEY (task_id_id) REFERENCES task (id)');
        $this->addSql('ALTER TABLE statut ADD CONSTRAINT FK_E564F0BF6C1197C9 FOREIGN KEY (project_id_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB259D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB256C1197C9 FOREIGN KEY (project_id_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB254DB9F129 FOREIGN KEY (statut_id_id) REFERENCES statut (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE crenaux DROP FOREIGN KEY FK_AE70886B9D86650F');
        $this->addSql('ALTER TABLE crenaux DROP FOREIGN KEY FK_AE70886BB8E08577');
        $this->addSql('ALTER TABLE statut DROP FOREIGN KEY FK_E564F0BF6C1197C9');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB259D86650F');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB256C1197C9');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB254DB9F129');
        $this->addSql('DROP TABLE crenaux');
        $this->addSql('DROP TABLE statut');
        $this->addSql('DROP TABLE tags');
        $this->addSql('DROP TABLE task');
    }
}
