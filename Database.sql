USE zend;

CREATE TABLE IF NOT EXISTS users(
  id int(11) NOT NULL AUTO_INCREMENT,
  user_name varchar(100) NOT NULL,
  user_password varchar(300) NOT NULL,
  user_email varchar(60) NOT NULL,
  PRIMARY KEY(id)
) ENGINE = INNODB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8;