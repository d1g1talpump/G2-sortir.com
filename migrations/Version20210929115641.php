<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210929115641 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE campus (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, postal_code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, status_id INT NOT NULL, campus_id INT NOT NULL, place_id INT NOT NULL, organiser_id INT NOT NULL, name VARCHAR(150) NOT NULL, start_date DATETIME NOT NULL, limit_sub_date DATETIME NOT NULL, infos LONGTEXT NOT NULL, max_sub INT NOT NULL, duration INT NOT NULL, INDEX IDX_3BAE0AA76BF700BD (status_id), INDEX IDX_3BAE0AA7AF5D55E1 (campus_id), INDEX IDX_3BAE0AA7DA6A219 (place_id), INDEX IDX_3BAE0AA7A0631C12 (organiser_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE place (id INT AUTO_INCREMENT NOT NULL, city_id INT NOT NULL, name VARCHAR(150) NOT NULL, street VARCHAR(150) NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, INDEX IDX_741D53CD8BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, campus_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, telephone VARCHAR(20) DEFAULT NULL, admin TINYINT(1) NOT NULL, active TINYINT(1) NOT NULL, pseudo VARCHAR(50) NOT NULL, picture VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649AF5D55E1 (campus_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_event (user_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_D96CF1FFA76ED395 (user_id), INDEX IDX_D96CF1FF71F7E88B (event_id), PRIMARY KEY(user_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA76BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7AF5D55E1 FOREIGN KEY (campus_id) REFERENCES campus (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7DA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7A0631C12 FOREIGN KEY (organiser_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CD8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649AF5D55E1 FOREIGN KEY (campus_id) REFERENCES campus (id)');
        $this->addSql('ALTER TABLE user_event ADD CONSTRAINT FK_D96CF1FFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_event ADD CONSTRAINT FK_D96CF1FF71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('create definer = root@localhost procedure AutoUpdateEventEnded() no sql UPDATE event SET status_id = 5 WHERE status_id = 4 AND DATE_ADD(start_date, INTERVAL duration MINUTE) < CURRENT_TIMESTAMP()');
        $this->addSql('create definer = root@localhost procedure AutoUpdateEventHideMe() no sql UPDATE event SET status_id = 7 WHERE status_id IN (1, 6) AND DATE_ADD(DATE_ADD(start_date, INTERVAL duration MINUTE), INTERVAL 28 DAY) < CURRENT_TIMESTAMP()');
        $this->addSql('create definer = root@localhost procedure AutoUpdateEventInProgress() no sql UPDATE event SET status_id = 4 WHERE status_id in (2, 3) AND start_date < CURRENT_TIMESTAMP() AND DATE_ADD(start_date, INTERVAL duration MINUTE) > CURRENT_TIMESTAMP()');
        $this->addSql('create definer = root@localhost procedure AutoUpdateEventSubsEnded() no sql UPDATE event SET status_id = 3 WHERE status_id = 2 AND limit_sub_date < CURRENT_TIMESTAMP()');
        $this->addSql('create definer = root@localhost procedure SetUserActive() no sql UPDATE user SET roles = \'["ROLE_USER"]\' WHERE active = true AND admin = false');
        $this->addSql('create definer = root@localhost procedure SetUserAdmin() no sql UPDATE user SET roles = \'["ROLE_ADMIN"]\' WHERE admin = true AND active = true');
        $this->addSql('create definer = root@localhost procedure SetUserInactive() no sql UPDATE user SET roles = \'["ROLE_NO_ACCESS"]\' WHERE active = false');
        $this->addSql('create definer = root@localhost event CallAutoUpdateEventEnded on schedule every \'30\' SECOND starts \'2021-09-29 12:47:45\' enable do call AutoUpdateEventEnded()');
        $this->addSql('create definer = root@localhost event CallAutoUpdateEventHideMe on schedule every \'30\' SECOND starts \'2021-09-29 12:48:36\' enable do call AutoUpdateEventHideMe()');
        $this->addSql('create definer = root@localhost event CallAutoUpdateEventInProgress on schedule every \'30\' SECOND starts \'2021-09-29 12:43:18\' enable do call AutoUpdateEventInProgress()');
        $this->addSql('create definer = root@localhost event CallAutoUpdateEventSubsEnded on schedule every \'30\' SECOND starts \'2021-09-29 12:48:01\' enable do call AutoUpdateEventSubsEnded()');
        $this->addSql('create definer = root@localhost event CallSetUserActive on schedule every \'2\' MINUTE starts \'2021-09-29 12:47:51\' enable do call SetUserActive()');
        $this->addSql('create definer = root@localhost event CallSetUserAdmin on schedule every \'30\' SECOND starts \'2021-09-29 12:48:26\' enable do call SetUserAdmin()');
        $this->addSql('create definer = root@localhost event CallSetUserInactive on schedule every \'30\' SECOND starts \'2021-09-29 12:47:56\' enable do call SetUserInactive()');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7AF5D55E1');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649AF5D55E1');
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY FK_741D53CD8BAC62AF');
        $this->addSql('ALTER TABLE user_event DROP FOREIGN KEY FK_D96CF1FF71F7E88B');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7DA6A219');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA76BF700BD');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7A0631C12');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE user_event DROP FOREIGN KEY FK_D96CF1FFA76ED395');
        $this->addSql('DROP TABLE campus');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE place');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_event');
    }
}
