SET GLOBAL validate_password_length=4;
SET GLOBAL validate_password_policy=LOW;

CREATE USER 'wc-admin'@'localhost' IDENTIFIED BY 'wc-admin';
CREATE USER 'wcusr'@'localhost' IDENTIFIED BY 'wcusr';
CREATE USER 'wcses'@'localhost' IDENTIFIED BY 'wcses';

GRANT ALL ON `wc`.compartment TO 'wc-admin'@'localhost';
GRANT SELECT,UPDATE,INSERT,DELETE ON `wc`.compartment TO 'wcusr'@'localhost';
GRANT SELECT ON `wc`.compartment TO 'wcses'@'localhost';
