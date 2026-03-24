<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260324080630 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidacy (id INT AUTO_INCREMENT NOT NULL, message LONGTEXT NOT NULL, attached_file VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE candidacy_offer (candidacy_id INT NOT NULL, offer_id INT NOT NULL, INDEX IDX_C736A24A59B22434 (candidacy_id), INDEX IDX_C736A24A53C674EE (offer_id), PRIMARY KEY (candidacy_id, offer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE candidacy_offer ADD CONSTRAINT FK_C736A24A59B22434 FOREIGN KEY (candidacy_id) REFERENCES candidacy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidacy_offer ADD CONSTRAINT FK_C736A24A53C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidacy_offer DROP FOREIGN KEY FK_C736A24A59B22434');
        $this->addSql('ALTER TABLE candidacy_offer DROP FOREIGN KEY FK_C736A24A53C674EE');
        $this->addSql('DROP TABLE candidacy');
        $this->addSql('DROP TABLE candidacy_offer');
    }
}
