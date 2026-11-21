-- Импортируй этот файл в phpMyAdmin (вкладка "Импорт")
CREATE DATABASE IF NOT EXISTS adidas_shop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE adidas_shop;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  category VARCHAR(50) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL,
  image VARCHAR(255) DEFAULT NULL,   -- например: ultraboost.jpg (лежит в assets/img/products/)
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  total DECIMAL(10,2) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  quantity INT NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id)
);

INSERT INTO products (name, category, description, price) VALUES
('Ultraboost Light', 'Shoes', 'Responsive running shoes with a light, springy sole for daily miles.', 190.00),
('Samba OG', 'Shoes', 'Classic low-profile indoor football shoe turned street icon.', 100.00),
('Gazelle', 'Shoes', 'Suede sneaker with a soft feel and a timeless silhouette.', 110.00),
('Forum Low', 'Shoes', 'Basketball heritage in a clean everyday low-top.', 100.00),
('Essentials Hoodie', 'Clothing', 'Soft fleece hoodie with a roomy fit and kangaroo pocket.', 65.00),
('Adicolor Track Jacket', 'Clothing', 'Retro track jacket with three-stripe sleeves.', 80.00),
('Tiro Training Pants', 'Clothing', 'Tapered pants with zip ankles, made for training and travel.', 55.00),
('Classic Backpack', 'Accessories', 'Roomy backpack with padded straps and a front pocket.', 45.00),
('Trefoil Cap', 'Accessories', 'Adjustable cotton cap with an embroidered logo.', 25.00),
('Crew Socks 3-pack', 'Accessories', 'Cushioned cotton-blend socks for everyday wear.', 18.00);
