<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220125204029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dealers (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, city VARCHAR(255) DEFAULT NULL, street VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genere (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, dealer_id INT NOT NULL, INDEX IDX_E52FFDEE249E6EA1 (dealer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE249E6EA1 FOREIGN KEY (dealer_id) REFERENCES dealers (id)');
        $this->addSql('ALTER TABLE book ADD orders_id INT DEFAULT NULL, ADD genere_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331D35A57F1 FOREIGN KEY (genere_id) REFERENCES genere (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A331CFFE9AD6 ON book (orders_id)');
        $this->addSql('CREATE INDEX IDX_CBE5A331D35A57F1 ON book (genere_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE249E6EA1');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331D35A57F1');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331CFFE9AD6');
        $this->addSql('DROP TABLE dealers');
        $this->addSql('DROP TABLE genere');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP INDEX IDX_CBE5A331CFFE9AD6 ON book');
        $this->addSql('DROP INDEX IDX_CBE5A331D35A57F1 ON book');
        $this->addSql('ALTER TABLE book DROP orders_id, DROP genere_id');
    }
}
