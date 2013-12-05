-- -----------------------------------------------------
-- Require: locations
-- -----------------------------------------------------



-- -----------------------------------------------------
-- Drops
-- -----------------------------------------------------

DROP TABLE IF EXISTS profiles;
DROP TABLE IF EXISTS docid_types;
DROP TABLE IF EXISTS user_passwords;
DROP TABLE IF EXISTS alternate_logins;
DROP TABLE IF EXISTS social_networks;
DROP TABLE IF EXISTS user_logs;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS groups;


-- -----------------------------------------------------
-- Table alternate_logins
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS alternate_logins (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id INT UNSIGNED NOT NULL,
  social_network_id INT UNSIGNED NOT NULL,
  uid VARCHAR(45) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

ALTER TABLE alternate_logins ADD INDEX altlog_use_idx (user_id ASC);
ALTER TABLE alternate_logins ADD INDEX altlog_socnet_idx (social_network_id ASC);


-- -----------------------------------------------------
-- Table groups
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS groups (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(45) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;


-- -----------------------------------------------------
-- Table docid_types
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS docid_types (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(45) NOT NULL,
  alias VARCHAR(45) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;


-- -----------------------------------------------------
-- Table profiles
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS profiles (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id INT UNSIGNED NOT NULL,
  location_id INT UNSIGNED NOT NULL,
  docid_type_id INT UNSIGNED NOT NULL,
  first_name VARCHAR(45) NOT NULL,
  last_name VARCHAR(45) NOT NULL,
  docid VARCHAR(45) NOT NULL,
  gender VARCHAR(1) NOT NULL,
  birthday DATE NOT NULL,
  address VARCHAR(150) NOT NULL,
  mobile VARCHAR(20) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

ALTER TABLE profiles ADD INDEX pro_use_idx (user_id ASC);
ALTER TABLE profiles ADD INDEX pro_loc_idx (location_id ASC);
ALTER TABLE profiles ADD INDEX pro_doctyp_idx (docid_type_id ASC);


-- -----------------------------------------------------
-- Table social_networks
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS social_networks (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(45) NOT NULL,
  KEY id (id)
) ENGINE=InnoDB ;


-- -----------------------------------------------------
-- Table users
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  group_id INT UNSIGNED NOT NULL,
  username VARCHAR(45) NOT NULL,
  password VARCHAR(45) NOT NULL,
  email VARCHAR(45) NOT NULL,
  created DATETIME NOT NULL,
  activated DATETIME NOT NULL,
  modified DATETIME NOT NULL,
  banned DATETIME NOT NULL,
  deleted DATETIME NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

ALTER TABLE users ADD INDEX use_gro_idx (group_id ASC);


-- -----------------------------------------------------
-- Table user_logs
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS user_logs (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  is_correct TINYINT(1) NOT NULL,
  created DATETIME NOT NULL,
  ip VARCHAR(15) NOT NULL,
  username VARCHAR(45) NOT NULL,
  user_agent VARCHAR(250) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;


-- -----------------------------------------------------
-- Table user_passwords
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS user_passwords (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id INT UNSIGNED NOT NULL,
  password VARCHAR(45) NOT NULL,
  created DATETIME NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

ALTER TABLE user_passwords ADD INDEX usepas_use_idx (user_id ASC);


-- -----------------------------------------------------
-- Constraints
-- -----------------------------------------------------

ALTER TABLE alternate_logins ADD
CONSTRAINT altlog_socnet_fk FOREIGN KEY (social_network_id) REFERENCES social_networks (id)
ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE alternate_logins ADD
CONSTRAINT altlog_user_fk FOREIGN KEY (user_id) REFERENCES users (id)
ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE profiles ADD
CONSTRAINT pro_loc_fk FOREIGN KEY (location_id) REFERENCES locations (id)
ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE profiles ADD
CONSTRAINT pro_use_fx FOREIGN KEY (user_id) REFERENCES users (id)
ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE profiles ADD
CONSTRAINT pro_doctyp_fx FOREIGN KEY (docid_type_id) REFERENCES docid_types (id)
ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE users ADD
CONSTRAINT use_gro_fk FOREIGN KEY (group_id) REFERENCES groups (id)
ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE user_passwords ADD
CONSTRAINT usepas_use_fk FOREIGN KEY (user_id) REFERENCES users (id)
ON DELETE NO ACTION ON UPDATE NO ACTION;
