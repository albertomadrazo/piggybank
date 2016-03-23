CREATE TABLE ahorro(
    id INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    meta_de_ahorro VARCHAR(50) NOT NULL,
    slug VARCHAR(50) NOT NULL,
    user_id INT (11) NOT NULL,
    total INT (11) NOT NULL,
    cantidad_a_abonar INT(11) NOT NULL,
    periodo INT (11) NOT NULL,
    intervalo INT (11) NOT NULL,
    ahorro_parcial INT (11) NOT NULL,
    fecha_inicial DATE NULL,
    fecha_final DATE NULL,
    tipo_de_ahorro VARCHAR(20) NULL,
    FOREIGN KEY (user_id) REFERENCES users (id)
)