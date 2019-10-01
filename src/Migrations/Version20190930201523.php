<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190930201523 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('ALTER SEQUENCE user_id_seq INCREMENT BY 1');
        $this->addSql('CREATE TABLE public."user" (id INT NOT NULL, email VARCHAR(64) NOT NULL, password VARCHAR(64) NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_327C5DE7E7927C74 ON public."user" (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_327C5DE735C246D5 ON public."user" (password)');
        $this->addSql('DROP TABLE "user"');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('ALTER SEQUENCE user_id_seq INCREMENT BY 1');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(64) NOT NULL, password VARCHAR(128) NOT NULL, created TIMESTAMP(0) WITH TIME ZONE NOT NULL, roles JSON DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX user_email_index ON "user" (email)');
        $this->addSql('CREATE UNIQUE INDEX user_email_unique ON "user" (email)');
        $this->addSql('DROP TABLE public."user"');
    }
}
