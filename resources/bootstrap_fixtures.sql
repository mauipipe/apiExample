CREATE DATABASE `address`;

CREATE USER 'user'@'localhost'
  IDENTIFIED BY '123456';

CREATE TABLE `address` (
  `id`     INT(11)      NOT NULL AUTO_INCREMENT,
  `name`   VARCHAR(255) NOT NULL,
  `phone`  VARCHAR(100) NOT NULL,
  `street` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

GRANT ALL PRIVILEGES ON `address` TO 'user'@'localhost'
IDENTIFIED BY '123456';

