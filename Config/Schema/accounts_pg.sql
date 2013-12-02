
-- -----------------------------------------------------
-- Table locations
-- -----------------------------------------------------
DROP TABLE IF EXISTS locations ;
DROP SEQUENCE IF EXISTS loc_sq;

CREATE SEQUENCE loc_sq START 1;
CREATE TABLE IF NOT EXISTS locations (
 id INTEGER DEFAULT NEXTVAL('loc_sq') NOT NULL,
 parent_id INTEGER NULL,
 lft INTEGER NULL,
 rght INTEGER NULL,
 name CHARACTER VARYING(45) NOT NULL,
 latitude NUMERIC(12,9) NOT NULL,
 longitude NUMERIC(12,9) NOT NULL,
 is_capital BOOLEAN NOT NULL,
 is_node BOOLEAN NOT NULL,
 CONSTRAINT loc_pk PRIMARY KEY (id),
 CONSTRAINT loc_loc_fk
 FOREIGN KEY (parent_id)
 REFERENCES locations (id)
 ON DELETE NO ACTION
 ON UPDATE NO ACTION
 );
CREATE UNIQUE INDEX loc_idx ON locations (id);
CREATE INDEX loc_fkidx ON locations (parent_id);


CREATE OR REPLACE VIEW countries AS
SELECT id, name, latitude, longitude FROM locations WHERE parent_id IS NULL;


-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------


-- -----------------------------------------------------
-- Table groups
-- -----------------------------------------------------
DROP TABLE IF EXISTS groups ;
DROP SEQUENCE IF EXISTS gro_sq;

CREATE SEQUENCE gro_sq START 1;
CREATE TABLE IF NOT EXISTS groups (
 id INTEGER DEFAULT NEXTVAL('gro_sq') NOT NULL,
 name CHARACTER VARYING(45) NOT NULL,
 CONSTRAINT gro_pk PRIMARY KEY (id)
);
CREATE UNIQUE INDEX gro_idx ON groups (id);



-- -----------------------------------------------------
-- Table users
-- -----------------------------------------------------
DROP TABLE IF EXISTS users ;
DROP SEQUENCE IF EXISTS use_sq;

CREATE SEQUENCE use_sq START 1;
CREATE TABLE IF NOT EXISTS users (
 id INTEGER DEFAULT NEXTVAL('use_sq') NOT NULL,
 group_id INTEGER NOT NULL,
 username CHARACTER VARYING(45) NOT NULL,
 password CHARACTER VARYING(45) NOT NULL,
 email CHARACTER VARYING(45) NOT NULL,
 created TIMESTAMP NOT NULL,
 activated TIMESTAMP NOT NULL,
 modified TIMESTAMP NOT NULL,
 banned TIMESTAMP NOT NULL,
 deleted TIMESTAMP NOT NULL,
 CONSTRAINT use_pk PRIMARY KEY (id),
 CONSTRAINT use_gro_fk
 FOREIGN KEY (group_id)
 REFERENCES groups (id)
 ON DELETE NO ACTION
 ON UPDATE NO ACTION)
;
CREATE UNIQUE INDEX use_idx ON users (id);
CREATE INDEX use_fkidx ON users (group_id);


-- -----------------------------------------------------
-- Table profiles
-- -----------------------------------------------------
DROP TABLE IF EXISTS profiles ;
DROP SEQUENCE IF EXISTS pro_sq;

CREATE SEQUENCE pro_sq START 1;
CREATE TABLE IF NOT EXISTS profiles (
 id INTEGER DEFAULT NEXTVAL('pro_sq') NOT NULL,
 user_id INTEGER NOT NULL,
 location_id INTEGER NOT NULL,
 first_name CHARACTER VARYING(45) NOT NULL,
 last_name CHARACTER VARYING(45) NOT NULL,
 docid CHARACTER VARYING(45) NOT NULL,
 gender CHARACTER VARYING(1) NOT NULL,
 birthday DATE NOT NULL,
 address CHARACTER VARYING(150) NOT NULL,
 mobile CHARACTER VARYING(20) NOT NULL,
 phone CHARACTER VARYING(20) NOT NULL,
 CONSTRAINT pro_pk PRIMARY KEY (id),
 CONSTRAINT prof_use_fk
 FOREIGN KEY (user_id)
 REFERENCES users (id)
 ON DELETE NO ACTION
 ON UPDATE NO ACTION,
 CONSTRAINT use_loc_fk
 FOREIGN KEY (location_id)
 REFERENCES locations (id)
 ON DELETE NO ACTION
 ON UPDATE NO ACTION
);
CREATE UNIQUE INDEX pro_idx ON profiles (id);
CREATE INDEX pro_fkidx ON profiles (user_id);
CREATE INDEX pro_loc_fkidx ON profiles (location_id);


-- -----------------------------------------------------
-- Table user_passwords
-- -----------------------------------------------------
DROP TABLE IF EXISTS user_passwords ;
DROP SEQUENCE IF EXISTS use_pas_sq;

CREATE SEQUENCE use_pas_sq START 1;
CREATE TABLE IF NOT EXISTS user_passwords (
 id INTEGER DEFAULT NEXTVAL('use_pas_sq') NOT NULL,
 user_id INTEGER NULL,
 password CHARACTER VARYING(45) NOT NULL,
 created TIMESTAMP NOT NULL,
 CONSTRAINT use_pas_pk PRIMARY KEY (id),
 CONSTRAINT use_pas_use_fk
 FOREIGN KEY (user_id)
 REFERENCES users (id)
 ON DELETE NO ACTION
 ON UPDATE NO ACTION)
;
CREATE UNIQUE INDEX use_pas_idx ON user_passwords (id);
CREATE INDEX use_pas_fkidx ON user_passwords (user_id);


-- -----------------------------------------------------
-- Table user_logs
-- -----------------------------------------------------
DROP TABLE IF EXISTS user_logs ;
DROP SEQUENCE IF EXISTS use_log_sq;

CREATE SEQUENCE use_log_sq START 1;
CREATE TABLE IF NOT EXISTS user_logs (
 id INTEGER DEFAULT NEXTVAL('use_log_sq') NOT NULL,
 username CHARACTER VARYING(45) NOT NULL,
 user_agent CHARACTER VARYING(45) NOT NULL,
 ip CHARACTER VARYING(15) NOT NULL,
 created TIMESTAMP NOT NULL,
 CONSTRAINT use_log_pk PRIMARY KEY (id) )
;
CREATE UNIQUE INDEX use_log_idx ON user_logs (id);


-- -----------------------------------------------------
-- Table social_networks
-- -----------------------------------------------------
DROP TABLE IF EXISTS social_networks ;
DROP SEQUENCE IF EXISTS soc_net_sq;

CREATE SEQUENCE soc_net_sq START 1;
CREATE TABLE IF NOT EXISTS social_networks (
 id INTEGER DEFAULT NEXTVAL('soc_net_sq') NOT NULL,
 name CHARACTER VARYING(45) NOT NULL,
 CONSTRAINT soc_net_pk PRIMARY KEY (id)
 );
CREATE UNIQUE INDEX soc_net_idx ON social_networks (id);


-- -----------------------------------------------------
-- Table alternate_logins
-- -----------------------------------------------------
DROP TABLE IF EXISTS alternate_logins ;
DROP SEQUENCE IF EXISTS alt_log_sq;

CREATE SEQUENCE alt_log_sq START 1;
CREATE TABLE IF NOT EXISTS alternate_logins (
 id INTEGER DEFAULT NEXTVAL('alt_log_sq') NOT NULL,
 user_id INTEGER NOT NULL,
 social_network_id INTEGER NOT NULL,
 uid CHARACTER VARYING(45) NOT NULL,
 CONSTRAINT alt_log_pk PRIMARY KEY (id),
 CONSTRAINT alt_log_use_fk
 FOREIGN KEY (user_id)
 REFERENCES users (id)
 ON DELETE NO ACTION
 ON UPDATE NO ACTION,
 CONSTRAINT alt_log_soc_net_fk
 FOREIGN KEY (social_network_id)
 REFERENCES social_networks (id)
 ON DELETE NO ACTION
 ON UPDATE NO ACTION
;
CREATE UNIQUE INDEX alt_log_idx ON alternate_logins (id);
CREATE INDEX alt_log_use_fkidx ON alternate_logins (user_id);
CREATE INDEX alt_log_soc_net_fkidx ON alternate_logins (social_network_id);

