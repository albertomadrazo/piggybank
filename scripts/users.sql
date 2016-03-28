CREATE TABLE users(
	id int(11) NOT NULL auto_increment,
	username varchar(50) NOT NULL UNIQUE,
	password varchar(40) NOT NULL,
    full_name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
	PRIMARY KEY (id)
);