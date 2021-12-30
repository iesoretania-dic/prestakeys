<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211230152339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Esquema inicial';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE departamento (id INT AUTO_INCREMENT NOT NULL, jefatura_id INT DEFAULT NULL, descripcion VARCHAR(255) NOT NULL, INDEX IDX_40E497EB74ABFCE (jefatura_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE empleado (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, apellidos VARCHAR(255) NOT NULL, ordenanza TINYINT(1) NOT NULL, secretario TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historial (id INT AUTO_INCREMENT NOT NULL, llave_id INT NOT NULL, prestada_a_id INT NOT NULL, prestada_por_id INT NOT NULL, fecha_hora_prestamo DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', fecha_hora_devolucion DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_269506528EB29E8F (llave_id), INDEX IDX_26950652EC8A7327 (prestada_a_id), INDEX IDX_269506526A7DAA6E (prestada_por_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE llave (id INT AUTO_INCREMENT NOT NULL, prestada_a_id INT DEFAULT NULL, prestada_por_id INT DEFAULT NULL, departamento_id INT DEFAULT NULL, codigo VARCHAR(20) NOT NULL, descripcion VARCHAR(60) NOT NULL, disponible TINYINT(1) NOT NULL, INDEX IDX_E6B8CF5AEC8A7327 (prestada_a_id), INDEX IDX_E6B8CF5A6A7DAA6E (prestada_por_id), INDEX IDX_E6B8CF5A5A91C08D (departamento_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE departamento ADD CONSTRAINT FK_40E497EB74ABFCE FOREIGN KEY (jefatura_id) REFERENCES empleado (id)');
        $this->addSql('ALTER TABLE historial ADD CONSTRAINT FK_269506528EB29E8F FOREIGN KEY (llave_id) REFERENCES llave (id)');
        $this->addSql('ALTER TABLE historial ADD CONSTRAINT FK_26950652EC8A7327 FOREIGN KEY (prestada_a_id) REFERENCES empleado (id)');
        $this->addSql('ALTER TABLE historial ADD CONSTRAINT FK_269506526A7DAA6E FOREIGN KEY (prestada_por_id) REFERENCES empleado (id)');
        $this->addSql('ALTER TABLE llave ADD CONSTRAINT FK_E6B8CF5AEC8A7327 FOREIGN KEY (prestada_a_id) REFERENCES empleado (id)');
        $this->addSql('ALTER TABLE llave ADD CONSTRAINT FK_E6B8CF5A6A7DAA6E FOREIGN KEY (prestada_por_id) REFERENCES empleado (id)');
        $this->addSql('ALTER TABLE llave ADD CONSTRAINT FK_E6B8CF5A5A91C08D FOREIGN KEY (departamento_id) REFERENCES departamento (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE llave DROP FOREIGN KEY FK_E6B8CF5A5A91C08D');
        $this->addSql('ALTER TABLE departamento DROP FOREIGN KEY FK_40E497EB74ABFCE');
        $this->addSql('ALTER TABLE historial DROP FOREIGN KEY FK_26950652EC8A7327');
        $this->addSql('ALTER TABLE historial DROP FOREIGN KEY FK_269506526A7DAA6E');
        $this->addSql('ALTER TABLE llave DROP FOREIGN KEY FK_E6B8CF5AEC8A7327');
        $this->addSql('ALTER TABLE llave DROP FOREIGN KEY FK_E6B8CF5A6A7DAA6E');
        $this->addSql('ALTER TABLE historial DROP FOREIGN KEY FK_269506528EB29E8F');
        $this->addSql('DROP TABLE departamento');
        $this->addSql('DROP TABLE empleado');
        $this->addSql('DROP TABLE historial');
        $this->addSql('DROP TABLE llave');
    }
}
