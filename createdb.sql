CREATE DATABASE IF NOT EXISTS desafio_webjump;

CREATE TABLE IF NOT EXISTS desafio_webjump.products (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(300) NOT NULL,
    sku VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    quantity INT(5) NOT NULL,
    price FLOAT(5) NOT NULL,
    image VARCHAR(500) NOT NULL
);

CREATE TABLE IF NOT EXISTS desafio_webjump.categories (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(300) NOT NULL
);


CREATE TABLE IF NOT EXISTS desafio_webjump.product_has_categories(
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
    id_product BIGINT UNSIGNED NOT NULL,
    FOREIGN KEY (id_product) REFERENCES products(id),
    id_categories BIGINT UNSIGNED NOT NULL,
    FOREIGN KEY (id_categories) REFERENCES categories(id)
);

INSERT INTO desafio_webjump.products (name, sku, description, quantity, price, image)
VALUES ('Teclado', '790', 'Um teclado mecânico bem legal', 2, 180.90, 'public/assets/images/product/default-product.png');

INSERT INTO desafio_webjump.categories (name, code)
VALUES ('Periféricos', 'A3BC80');

INSERT INTO desafio_webjump.product_has_categories (id_product, id_categories)
VALUES (1, 1);