CREATE TABLE users(
    id SERIAL NOT NULL,
	-- id int(11) NOT NULL auto_increment,
	username VARCHAR(50) NOT NULL UNIQUE,
	password VARCHAR(40) NOT NULL,
    full_name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
	PRIMARY KEY (id)
);