CREATE TABLE citas(
    id SERIAL NOT NULL PRIMARY KEY,
    -- id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL DEFAULT 1,
    texto VARCHAR (500) NOT NULL,
    autor VARCHAR(50) NOT NULL DEFAULT 'Anónimo',
    FOREIGN KEY (user_id) REFERENCES users (id)
)