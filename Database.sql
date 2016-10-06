-- USE zend;

/*
CREATE TABLE IF NOT EXISTS users(
  id int(11) NOT NULL AUTO_INCREMENT,
  user_name varchar(100) NOT NULL,
  user_password varchar(300) NOT NULL,
  user_email varchar(60) NOT NULL,
  PRIMARY KEY(id)
) ENGINE = INNODB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8;
*/

INSERT INTO users (user_name, user_password, user_email, user_full_name, user_role) VALUES ('admin', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9', 'admin@admin.com', 'Admin User', 'admin');