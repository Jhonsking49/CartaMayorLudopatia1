<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240115125620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE boleto (id INT AUTO_INCREMENT NOT NULL, propietario_id INT NOT NULL, sorteo_id INT NOT NULL, numero INT NOT NULL, INDEX IDX_462E6E2553C8D32C (propietario_id), INDEX IDX_462E6E25663FD436 (sorteo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sorteo (id INT AUTO_INCREMENT NOT NULL, ganador_id INT DEFAULT NULL, creador_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, fecha_ini DATETIME NOT NULL, fecha_fin DATETIME NOT NULL, precio_boleto INT NOT NULL, numeros_posibles INT NOT NULL, INDEX IDX_705F75E0A338CEA5 (ganador_id), INDEX IDX_705F75E062F40C3D (creador_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, saldo INT NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE boleto ADD CONSTRAINT FK_462E6E2553C8D32C FOREIGN KEY (propietario_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE boleto ADD CONSTRAINT FK_462E6E25663FD436 FOREIGN KEY (sorteo_id) REFERENCES sorteo (id)');
        $this->addSql('ALTER TABLE sorteo ADD CONSTRAINT FK_705F75E0A338CEA5 FOREIGN KEY (ganador_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE sorteo ADD CONSTRAINT FK_705F75E062F40C3D FOREIGN KEY (creador_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boleto DROP FOREIGN KEY FK_462E6E2553C8D32C');
        $this->addSql('ALTER TABLE boleto DROP FOREIGN KEY FK_462E6E25663FD436');
        $this->addSql('ALTER TABLE sorteo DROP FOREIGN KEY FK_705F75E0A338CEA5');
        $this->addSql('ALTER TABLE sorteo DROP FOREIGN KEY FK_705F75E062F40C3D');
        $this->addSql('DROP TABLE boleto');
        $this->addSql('DROP TABLE sorteo');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
