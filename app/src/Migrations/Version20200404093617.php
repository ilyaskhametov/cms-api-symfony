<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200404093617 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            "Migration can only be executed safely on 'postgresql'."
        );

        $this->addSql('CREATE SEQUENCE media_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('
            CREATE TABLE media (
                id INT NOT NULL,
                uri VARCHAR(255) NOT NULL UNIQUE,
                name VARCHAR(255) NOT NULL,
                type VARCHAR(20) NOT NULL,
                mime_type VARCHAR(255) NOT NULL,
                created_at TIMESTAMP NOT NULL DEFAULT NOW(),
                updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
                PRIMARY KEY(id)
            )
        ');
        $this->addSql('CREATE INDEX ON media (name)');
        $this->addSql('CREATE INDEX ON media (type)');
        $this->addSql('CREATE INDEX ON media (mime_type)');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            "Migration can only be executed safely on 'postgresql'."
        );

        $this->addSql('DROP SEQUENCE media_id_seq CASCADE');
        $this->addSql('DROP TABLE media');
    }
}
