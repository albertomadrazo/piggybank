CREATE TABLE ahorro(
    id SERIAL NOT NULL PRIMARY KEY,
    -- id INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,

    meta_de_ahorro VARCHAR(50) NOT NULL,
    slug VARCHAR(50) NOT NULL,
    user_id INT NOT NULL,
    total INT NOT NULL,
    cantidad_a_abonar INT NOT NULL,
    periodo INT NOT NULL,
    intervalo INT NOT NULL,
    ahorro_parcial INT NOT NULL,
    fecha_inicial DATE NULL,
    fecha_final DATE NULL,
    tipo_de_ahorro VARCHAR(20) NULL,
    FOREIGN KEY (user_id) REFERENCES users (id)
)