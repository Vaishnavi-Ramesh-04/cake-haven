CREATE DATABASE IF NOT EXISTS cakehaven;
USE cakehaven;

CREATE TABLE cakes(
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100), description TEXT,
 price DECIMAL(10,2), image VARCHAR(200),
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE orders(
 id INT AUTO_INCREMENT PRIMARY KEY,
 customer_name VARCHAR(100),
 customer_email VARCHAR(100),
 customer_phone VARCHAR(30),
 delivery_address TEXT,
 delivery_date DATE, delivery_time TIME,
 total_amount DECIMAL(10,2),
 payment_status VARCHAR(20),
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE order_items(
 id INT AUTO_INCREMENT PRIMARY KEY,
 order_id INT,cake_id INT,
 cake_name VARCHAR(100),
 unit_price DECIMAL(10,2),
 quantity INT, subtotal DECIMAL(10,2)
);

INSERT INTO cakes (name, description, price, image) VALUES
('Chocolate Cake','Rich chocolate sponge with ganache',450,'images/chocolate.jpg'),
('Vanilla Cake','Soft vanilla cake with cream frosting',400,'images/vanilla.jpg'),
('Strawberry Cake','Fresh strawberry cake with whipped cream',550,'images/strawberry.jpg'),
('Red Velvet','Classic red velvet with cream cheese',500,'images/redvelvet.jpg'),
('Black Forest','Chocolate cake with cherries and cream',600,'images/blackforest.jpg'),
('Carrot Cake','Spiced carrot cake with cream cheese frosting',480,'images/carrot.jpg'),
('Mango Mousse','Light mango mousse cake',530,'images/mango.jpg'),
('Coffee Cake','Moist coffee-flavored cake',470,'images/coffee.jpg'),
('Pineapple Upside Down','Classic pineapple upside-down cake',450,'images/pineapple.jpg'),
('Cheesecake','Creamy cheesecake with a graham cracker crust',550,'images/cheesecake.jpg'),
('Tiramisu','Italian dessert with coffee and mascarpone',600,'images/tiramisu.jpg'),
('Coconut Cake','Tropical coconut cake with coconut frosting',480,'images/coconut.jpg'),
('Funfetti Cake','Vanilla cake with colorful sprinkles',420,'images/funfetti.jpg'),
('Matcha Green Tea Cake','Delicate matcha-flavored cake',530,'images/matcha.jpg'),
('Raspberry Ripple','Vanilla cake with raspberry swirls',520,'images/raspberry.jpg'),
('Opera Cake','Layered chocolate and coffee cake',650,'images/opera.jpg'),
('Blackberry Cake','Moist cake with fresh blackberries',540,'images/blackberry.jpg'),
('Nutella Cake','Chocolate hazelnut cake with Nutella frosting',580,'images/nutella.jpg'),
('Pistachio Cake','Rich pistachio cake with cream cheese frosting',600,'images/pistachio.jpg'),
('Chocolate Fudge','Decadent chocolate fudge cake',620,'images/chocolatefudge.jpg'),
('Caramel Cake','Buttery caramel cake with caramel frosting',550,'images/caramel.jpg'),
('Red Velvet Cupcakes','Mini red velvet cupcakes with cream cheese frosting',300,'images/redvelvetcupcakes.jpg'),
('Chocolate Chip Cookie Cake','Giant cookie cake with chocolate chips',400,'images/cookiecake.jpg');
('Lemon Drizzle Cake','Zesty lemon cake with lemon glaze',450,'images/lemondrizzle.jpg');




