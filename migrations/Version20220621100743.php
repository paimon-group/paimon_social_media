<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220621100743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD avatar VARCHAR(255) DEFAULT NULL, ADD login_status VARCHAR(10) DEFAULT NULL, ADD email VARCHAR(255) DEFAULT NULL, ADD birthdate DATE DEFAULT NULL, ADD phone VARCHAR(11) DEFAULT NULL, ADD address VARCHAR(255) DEFAULT NULL, ADD token VARCHAR(32) DEFAULT NULL, ADD connection_id INT DEFAULT NULL, ADD new_password VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP avatar, DROP login_status, DROP email, DROP birthdate, DROP phone, DROP address, DROP token, DROP connection_id, DROP new_password');
    }
}
