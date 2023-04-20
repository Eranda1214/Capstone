<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <title>Initialize DB</title>
    </head>
    <body>
        
        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                
                define("INITIALIZING_DATABASE", 1);
                require_once("db_conn.php");

                // creating and using the databse
                mysqli_query($dbc, "DROP DATABASE IF EXISTS TechStore");
                mysqli_query($dbc, "CREATE DATABASE TechStore");
                mysqli_query($dbc, "USE TechStore");

                // creating the brand table
                mysqli_query($dbc, "DROP TABLE IF EXISTS brands");
                mysqli_query($dbc,
                    "CREATE TABLE IF NOT EXISTS brands (
                        idBrand INT NOT NULL AUTO_INCREMENT,
                        brandName VARCHAR(64) NOT NULL,
                        PRIMARY KEY (idBrand)
                    ) ENGINE = InnoDB");
                
                // creating the category table
                mysqli_query($dbc, "DROP TABLE IF EXISTS categories");
                mysqli_query($dbc,
                "CREATE TABLE IF NOT EXISTS categories (
                    idCategories INT NOT NULL AUTO_INCREMENT,
                    categoryName VARCHAR(64) NOT NULL,
                    PRIMARY KEY (idCategories))
                ENGINE = InnoDB");

                // creating the product table
                mysqli_query($dbc, "DROP TABLE IF EXISTS products");
                mysqli_query($dbc,
                "CREATE TABLE IF NOT EXISTS products (
                    idProducts INT NOT NULL AUTO_INCREMENT,
                    productName VARCHAR(128) NOT NULL,
                    productPrice DECIMAL(10,2) NOT NULL,
                    productStock INT NOT NULL,
                    productImage VARCHAR(256) NULL,
                    productBrand INT NOT NULL,
                    productDesc VARCHAR(512) NOT NULL,
                    productCategory INT NOT NULL,
                    PRIMARY KEY (idProducts),
                    CONSTRAINT fk_products_brand
                        FOREIGN KEY (productBrand)
                        REFERENCES brands (idBrand)
                        ON DELETE NO ACTION
                        ON UPDATE NO ACTION,
                    CONSTRAINT fk_products_categories
                        FOREIGN KEY (productCategory)
                        REFERENCES categories (idCategories)
                        ON DELETE NO ACTION
                        ON UPDATE NO ACTION)
                ENGINE = InnoDB");

                // creating the user table
                mysqli_query($dbc, "DROP TABLE IF EXISTS users");
                mysqli_query($dbc,
                "CREATE TABLE IF NOT EXISTS users (
                    idUsers INT NOT NULL AUTO_INCREMENT,
                    firstName VARCHAR(32) NOT NULL,
                    lastName VARCHAR(45) NOT NULL,
                    userEmail VARCHAR(256) NOT NULL,
                    password VARCHAR(45) NOT NULL,
                    PRIMARY KEY (idUsers))
                ENGINE = InnoDB");

                // creating the order table
                mysqli_query($dbc, "DROP TABLE IF EXISTS orders");
                mysqli_query($dbc,
                "CREATE TABLE IF NOT EXISTS orders (
                    idOrders INT NOT NULL AUTO_INCREMENT,
                    orderAddress VARCHAR(100) NOT NULL,
                    orderCity VARCHAR(45) NOT NULL,
                    orderProvince VARCHAR(64) NOT NULL,
                    orderCountry VARCHAR(45) NOT NULL,
                    orderPostalCode VARCHAR(6) NOT NULL,
                    orderPhone VARCHAR(12) NOT NULL,
                    users_idUsers INT NOT NULL,
                    PRIMARY KEY (idOrders, users_idUsers),
                    CONSTRAINT fk_orders_users
                        FOREIGN KEY (users_idUsers)
                        REFERENCES users (idUsers)
                        ON DELETE NO ACTION
                        ON UPDATE NO ACTION)
                ENGINE = InnoDB");

                // creating the order_item table
                mysqli_query($dbc, "DROP TABLE IF EXISTS order_item");
                mysqli_query($dbc,
                "CREATE TABLE IF NOT EXISTS order_item (
                    orders_idOrders INT NOT NULL,
                    orders_users_idUsers INT NOT NULL,
                    products_idProducts INT NOT NULL,
                    product_quantity INT(2) NOT NULL,
                    PRIMARY KEY (orders_idOrders, orders_users_idUsers, products_idProducts),
                    CONSTRAINT fk_orders_has_products_orders
                        FOREIGN KEY (orders_idOrders , orders_users_idUsers)
                        REFERENCES orders (idOrders , users_idUsers)
                        ON DELETE NO ACTION
                        ON UPDATE NO ACTION,
                    CONSTRAINT fk_orders_has_products_products
                        FOREIGN KEY (products_idProducts)
                        REFERENCES products (idProducts)
                        ON DELETE NO ACTION
                        ON UPDATE NO ACTION)
                ENGINE = InnoDB");


                // inserting data into the brand table
                mysqli_query($dbc, "INSERT INTO brands (brandName)
                    VALUES
                    ('Apple'),
                    ('Google'),
                    ('Samsung'),
                    ('LG'),
                    ('Logitech'),
                    ('HyperX'),
                    ('Asus')");

                // inserting data into the category table
                mysqli_query($dbc, "INSERT INTO categories (categoryName)
                    VALUES
                    ('Cellphones'),
                    ('Laptops'),
                    ('Mice'),
                    ('Keyboards'),
                    ('Headsets & Microphones')");

                // inserting data into the product table
                mysqli_query($dbc, "INSERT INTO products (productName, productPrice, productStock, productBrand, productDesc, productCategory, productImage)
                    VALUES
                    ('iPhone 14 Pro', 1399.99, 24, 1, 'The newest and fastest iPhone Apple has ever created with the all new Dynamic Island', 1, 'products/iphone.jpeg'),
                    ('Pixel 7 Pro', 1099.98, 21, 2, 'The fastest and smartest phone Google has ever made. Powered by the all-new Tensor G2 chip.', 1, 'products/pixel.jpeg'),
                    ('Asus ROG Zephyrus G15', 1999.99, 8, 7, 'The Zephyrus G15 comes with the newest AMD, and Nvidia has to offer', 2, 'products/asus.jpeg'),
                    ('Apple MacBook Pro 16 (2021)', 3149.99, 5, 1, 'The all new MacBook Pro with groundbreaking performance and amazing battery life.', 2, 'products/pro.jpeg'),
                    ('Samsung Galaxy S22 5G', 1099.98, 14, 3, 'Redefine the way you experience a phone. With a beautiful smooth 120Hz display and 50mp photos.', 1, 'products/galaxy.jpeg'),
                    ('Apple MacBook Air 13.6', 1499.99, 20, 1, 'Apples thinnest and lightest laptop now with an all-new design and the brand new M2 chip.', 2, 'products/air.jpeg'),
                    ('LG Gram 16', 1699.98, 4, 4, 'The all-new LG Gram is slimmer, lighter and more powerful than ever before.', 2, 'products/gram.jpeg'),
                    ('Logitech G502 X PLUS', 249.99, 32, 5, 'The all new G502 featuring hybrid optical-mechanical Lightforce switches for superior speed and laser quick response.', 3, 'products/hero.jpeg'),
                    ('Logitech G915 TKL Lightspeed Wireless', 249.99, 12, 5, 'Take your gaming to the next level with this slim, durable, ten-keyless keyboard.', 4, 'products/lightspeed.jpeg'),
                    ('HyperX Cloud Orbit S 3D', 469.99, 7, 6, 'Gain your edge in competitive gaming with crystal clear 100mm planar magnetic gaming headphones.', 5, 'products/orbit.jpeg')");
                
                    // success message
                echo "<h3 class='text-success text-center'>Database Initialized Successfully</h3>";
                
            }
        ?>
        <!-- the html for user interaction -->
        <div style="width: 100vw; height: 100vh; display: flex; align-items: center; justify-content: center; flex-direction: column;">
            <h1 class="mb-5 text-center">Click a buttons below to create the database or go to the home page.</h1>
            <form method = "POST">
                <input class="btn btn-primary"type = "submit" value = "Initialize Database">
            </form>
            <a href="../index.php" class="btn btn-outline-dark mt-4">Back to Home</a>
        </div>

    </body>
</html>