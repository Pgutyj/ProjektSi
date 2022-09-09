<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220906165301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE authorInfos (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, slug VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_96C155AD989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE books (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, author_id INT DEFAULT NULL, book_author_id INT NOT NULL, publishing_house_info_id INT NOT NULL, title VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, book_creation_time DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', price INT DEFAULT NULL, INDEX IDX_4A1B2A9212469DE2 (category_id), INDEX IDX_4A1B2A92F675F31B (author_id), INDEX IDX_4A1B2A92E4DBE55D (book_author_id), INDEX IDX_4A1B2A9238D3B431 (publishing_house_info_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE books_tags (book_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_4C35340916A2B381 (book_id), INDEX IDX_4C353409BAD26311 (tag_id), PRIMARY KEY(book_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, slug VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_3AF34668989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publishingHouseInfos (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservationStatus (id INT AUTO_INCREMENT NOT NULL, status_info VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservations (id INT AUTO_INCREMENT NOT NULL, reservation_status_id INT DEFAULT NULL, book_id INT NOT NULL, requester_id INT NOT NULL, email VARCHAR(255) NOT NULL, reservation_time DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', comment LONGTEXT NOT NULL, INDEX IDX_4DA23971B06122 (reservation_status_id), INDEX IDX_4DA23916A2B381 (book_id), INDEX IDX_4DA239ED442CF4 (requester_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tags (id INT AUTO_INCREMENT NOT NULL, tag_info VARCHAR(40) NOT NULL, slug VARCHAR(40) NOT NULL, UNIQUE INDEX UNIQ_6FBC9426989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, nick VARCHAR(20) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9290B2F37 (nick), UNIQUE INDEX email_idx (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE books ADD CONSTRAINT FK_4A1B2A9212469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE books ADD CONSTRAINT FK_4A1B2A92F675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE books ADD CONSTRAINT FK_4A1B2A92E4DBE55D FOREIGN KEY (book_author_id) REFERENCES authorInfos (id)');
        $this->addSql('ALTER TABLE books ADD CONSTRAINT FK_4A1B2A9238D3B431 FOREIGN KEY (publishing_house_info_id) REFERENCES publishingHouseInfos (id)');
        $this->addSql('ALTER TABLE books_tags ADD CONSTRAINT FK_4C35340916A2B381 FOREIGN KEY (book_id) REFERENCES books (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE books_tags ADD CONSTRAINT FK_4C353409BAD26311 FOREIGN KEY (tag_id) REFERENCES tags (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA23971B06122 FOREIGN KEY (reservation_status_id) REFERENCES reservationStatus (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA23916A2B381 FOREIGN KEY (book_id) REFERENCES books (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239ED442CF4 FOREIGN KEY (requester_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE books DROP FOREIGN KEY FK_4A1B2A92E4DBE55D');
        $this->addSql('ALTER TABLE books_tags DROP FOREIGN KEY FK_4C35340916A2B381');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA23916A2B381');
        $this->addSql('ALTER TABLE books DROP FOREIGN KEY FK_4A1B2A9212469DE2');
        $this->addSql('ALTER TABLE books DROP FOREIGN KEY FK_4A1B2A9238D3B431');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA23971B06122');
        $this->addSql('ALTER TABLE books_tags DROP FOREIGN KEY FK_4C353409BAD26311');
        $this->addSql('ALTER TABLE books DROP FOREIGN KEY FK_4A1B2A92F675F31B');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239ED442CF4');
        $this->addSql('DROP TABLE authorInfos');
        $this->addSql('DROP TABLE books');
        $this->addSql('DROP TABLE books_tags');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE publishingHouseInfos');
        $this->addSql('DROP TABLE reservationStatus');
        $this->addSql('DROP TABLE reservations');
        $this->addSql('DROP TABLE tags');
        $this->addSql('DROP TABLE users');
    }
}
