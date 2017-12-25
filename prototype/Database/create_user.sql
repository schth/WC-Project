SET GLOBAL validate_password_length=4;
SET GLOBAL validate_password_policy=LOW;

CREATE USER 'wc-admin'@'localhost' IDENTIFIED BY 'wc-admin';
CREATE USER 'wcusr'@'localhost' IDENTIFIED BY 'wcusr';
CREATE USER 'wcses'@'localhost' IDENTIFIED BY 'wcses';

GRANT ALL ON `wc`.events TO 'wc-admin'@'localhost';
GRANT ALL ON `wc`.sensor_comp TO 'wc-admin'@'localhost';

GRANT SELECT,UPDATE,INSERT,DELETE ON `wc`.events TO 'wcusr'@'localhost';
GRANT SELECT,UPDATE,INSERT,DELETE ON `wc`.sensor_comp TO 'wcusr'@'localhost';

GRANT SELECT ON `wc`.events TO 'wcses'@'localhost';
GRANT SELECT ON `wc`.sensor_comp TO 'wcses'@'localhost';
