-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2024 at 03:46 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce3`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `category_idName` (`idCat` INT) RETURNS VARCHAR(1000) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  BEGIN
         DECLARE nameCat varchar(50);
         SELECT desp_cat INTO nameCat FROM category WHERE idCategory=idCat;
    RETURN nameCat;
    END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `empty_cart` (`idC` INT) RETURNS INT(11)  BEGIN
DELETE FROM cart_products WHERE idClient = idC;
RETURN 1;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `product_idName` (`idP` INT) RETURNS VARCHAR(50) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  BEGIN
         DECLARE nameP varchar(50);
         SELECT name_prod INTO nameP FROM product WHERE idProduct=idP;
    RETURN nameP;
    END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `product_idPrice` (`idP` INT) RETURNS FLOAT  BEGIN
         DECLARE priceP float;
         SELECT price INTO priceP FROM product WHERE idProduct=idP;
    RETURN priceP;
    END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `product_idPromo` (`idP` INT) RETURNS INT(11)  BEGIN
DECLARE promoP float;
SELECT promo INTO promoP FROM product WHERE idProduct = idP;
RETURN promoP;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `stock_sold` (`idP` INT, `quantity` INT) RETURNS INT(11)  BEGIN
	UPDATE product SET stock = (SELECT stock FROM product WHERE idProduct = idP) - quantity, sold = (SELECT sold FROM product WHERE idProduct = idP) + quantity WHERE idProduct = idP;
	RETURN 1;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `idAddress` int(11) NOT NULL,
  `city` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `zipCode` varchar(20) NOT NULL,
  `details` varchar(100) NOT NULL,
  `idClient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`idAddress`, `city`, `country`, `zipCode`, `details`, `idClient`) VALUES
(2, 'berlin', 'Germany', '2154862', '33, machin truc', 2),
(4, 'Midelt', 'morocco', '2154862', '33, machin truc', 3),
(5, 'Casablanca', 'morocco', '2154862', '33, machin truc', 4),
(6, 'Khnifra', 'morocco', '2154862', '33, machin truc', 5),
(15, 'Missour', 'morocco', '33250', '21, rue narjiss', 5),
(16, 'Midelt', 'morocco', '12345', 'test1, test2', 5),
(17, 'Midelt', 'morocco', '12345', 'test1, test2', 5),
(18, 'Missour', 'morocco', '33250', '21, rue Narjiss, quartier administratif, Missour', 3),
(19, 'Missour', 'morocco', '33250', '21, rue Narjiss, quartier administratif, Missour', 3),
(20, 'a', 'a', '1', '1', 4);

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `idAdmin` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(42) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `phoneNumber` varchar(10) DEFAULT NULL,
  `photo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`idAdmin`, `email`, `password`, `lastName`, `firstName`, `phoneNumber`, `photo`) VALUES
(1, 'admin@gmail.com', 'admin', 'ziani', 'zakaria', '', ''),
(2, 'admin2@gmail.com', 'admin2', 'bee', 'bee', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `alembic_version`
--

CREATE TABLE `alembic_version` (
  `version_num` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alembic_version`
--

INSERT INTO `alembic_version` (`version_num`) VALUES
('077dcfcc4235');

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `brand` int(9) NOT NULL,
  `brand_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`brand`, `brand_name`) VALUES
(1, 'Acer'),
(2, 'Asus'),
(3, 'HP'),
(4, 'Msi'),
(5, 'Alien'),
(6, 'Predator'),
(7, 'Lcd'),
(8, 'Dell');

-- --------------------------------------------------------

--
-- Table structure for table `cart_products`
--

CREATE TABLE `cart_products` (
  `idClient` int(11) NOT NULL,
  `idProduct` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_products`
--

INSERT INTO `cart_products` (`idClient`, `idProduct`, `quantity`) VALUES
(4, 20, 3);

-- --------------------------------------------------------

--
-- Table structure for table `catalog`
--

CREATE TABLE `catalog` (
  `idCatalog` int(11) NOT NULL,
  `name_cat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `catalog` (`idCatalog`, `name_cat`) VALUES
(1, 'Component'),
(2, 'Peripherals'),
(3, 'Gaming PC'),
(4, 'Portable PC');


-- --------------------------------------------------------

--
-- Table structure for table `catalog_products`
--

CREATE TABLE `catalog_products` (
  `idCatalog` int(11) NOT NULL,
  `idProduct` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `catalog_products` (`idCatalog`, `idProduct`) VALUES
(1, 1),  -- NVIDIA RTX 2080 (Graphics Card)
(1, 2),  -- Nvidia ZOTAC (Graphics Card)
(1, 3),  -- MSI GTX 1080 Graphics Card
(1, 4),  -- MSI GTX 2060 Graphics Card
(2, 5),  -- ACER Monitor - PREDATOR (Monitor)
(2, 6),  -- MSI Monitor - 120Hz (Monitor)
(2, 7),  -- SAMSUNG Monitor (Monitor)
(2, 8),  -- ACER Mouse - 1800 DPI (Mouse)
(2, 9),  -- MARVO L-21 Optical Mouse (Mouse)
(2, 10), -- JEDEL K90 Gaming Mouse (Mouse)
(2, 11), -- Razer Scorpion F13 (Keyboard)
(2, 12), -- Razer Scorpion - Special Edition (Keyboard)
(3, 13), -- Gaming PC - AMD Ryzen 5 (Gaming PC)
(3, 14), -- Gaming PC - AMD Ryzen 9 (Gaming PC)
(3, 15), -- Gaming PC - Intel i7 (Gaming PC)
(3, 16), -- Gaming PC ALIEN Build (Gaming PC)
(3, 17), -- PC MSI Ryzen 5 (Gaming PC)
(4, 18), -- ASUS Laptop (Portable PC)
(4, 19); -- DELL Laptop i7 (Portable PC)


-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `idCategory` int(11) NOT NULL,
  `description_cat` varchar(1000) NOT NULL,
  `idCatalog` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`idCategory`, `description_cat`, `idCatalog`) VALUES
(1, 'Graphics Card', 1),
(2, 'Motherboard', 1),
(3, 'Processor', 1),
(4, 'RAM', 1),
(5, 'Accessories', 1),
(6, 'Storage', 1),
(7, 'Drive', 1),
(8, 'Fan', 1),
(9, 'Sound Card', 1),
(10, 'Monitor', 2),
(11, 'Mouse', 2),
(12, 'Keyboard', 2),
(13, 'Mouse Pad', 2),
(14, 'AMD Build', 3),
(15, 'INTEL Build', 3);


-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `idClient` int(11) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(42) DEFAULT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `user_img` varchar(100) DEFAULT NULL,
  `creationDate` date NOT NULL,
  `is_admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`idClient`, `lastName`, `firstName`, `email`, `password`, `phone`, `user_img`, `creationDate`, `is_admin`) VALUES
(2, 'salamat', 'fatima zahrae', 'salamat.fatimazahrae@gmail.com', '1234', NULL, NULL, '2020-11-29', 0),
(3, 'zakaria', 'ziani', 'zakariaziani99@gmail.com', '1234', NULL, NULL, '2020-12-30', 0),
(4, 'baya', 'ziyad', 'baya@gmail.com', '1234', '123456789', NULL, '0000-00-00', 0),
(5, 'boutera', 'youssef', 'boutera@gmail.com', '1234', NULL, NULL, '2021-01-16', 0),
(12, 'a', 'a', 'a@a', 'a', '1', NULL, '2024-10-31', 0);

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `codeCoupon` varchar(10) NOT NULL,
  `value` int(11) NOT NULL,
  `expiration_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `idDelivery` int(11) NOT NULL,
  `idOrder` int(11) NOT NULL,
  `status_del` int(11) NOT NULL,
  `date_del` datetime NOT NULL,
  `idAddress` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`idDelivery`, `idOrder`, `status_del`, `date_del`, `idAddress`) VALUES
(3, 1, 0, '2020-12-26 17:19:34', 2),
(5, 3, 0, '2020-12-26 17:50:24', 4),
(6, 4, 2, '2020-12-26 18:24:18', 5),
(20, 70, 0, '2021-01-30 14:40:06', 19),
(21, 77, 0, '2024-10-30 23:39:38', 20);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_types`
--

CREATE TABLE `delivery_types` (
  `id_type` int(11) NOT NULL,
  `name_type` varchar(50) NOT NULL,
  `delivery_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_types`
--

INSERT INTO `delivery_types` (`id_type`, `name_type`, `delivery_price`) VALUES
(1, 'standard', 20),
(2, 'express', 50);

-- --------------------------------------------------------

--
-- Table structure for table `loyal_client`
--

CREATE TABLE `loyal_client` (
  `idClient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `idOrder` int(11) NOT NULL,
  `idClient` int(11) NOT NULL,
  `date_order` datetime NOT NULL,
  `total_order` float NOT NULL,
  `id_deliveryType` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`idOrder`, `idClient`, `date_order`, `total_order`, `id_deliveryType`) VALUES
(1, 2, '2020-12-30 00:19:41', 19200, 2),
(2, 3, '2020-12-30 00:34:00', 6580, 2),
(3, 4, '2020-12-30 00:39:07', 16770, 1),
(4, 5, '2020-12-31 16:35:27', 3170, 1),
(70, 3, '2021-01-30 14:39:55', 3690, 1),
(73, 4, '2024-09-27 21:08:07', 1791, 1),
(74, 4, '2024-09-27 21:09:31', 1821, 1),
(77, 4, '2024-10-30 23:39:38', 1700, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE `order_products` (
  `idOrder` int(11) NOT NULL,
  `idProduct` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_products`
--

INSERT INTO `order_products` (`idOrder`, `idProduct`, `quantity`) VALUES
(70, 12, 1),
(70, 14, 1),
(73, 7, 1),
(74, 7, 1),
(77, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `idProduct` int(11) NOT NULL,
  `name_prod` varchar(50) NOT NULL,
  `description_prod` varchar(500) NOT NULL,
  `price` float NOT NULL,
  `img_prod` varchar(100) NOT NULL,
  `promo` float DEFAULT 0,
  `stock` int(11) NOT NULL,
  `idCategory` int(11) NOT NULL,
  `sold` int(11) DEFAULT 0,
  `shipped` tinyint(1) DEFAULT 1,
  `brand` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`idProduct`, `name_prod`, `description_prod`, `price`, `img_prod`, `promo`, `stock`, `idCategory`, `sold`, `shipped`, `brand`) VALUES
(1, 'NVIDIA RTX 2080', 'Card đồ họa hiệu suất cao.', 1890, 'palit rtx.jpg', 15, 9, 3, 9, 1, 6),
(2, 'Nvidia ZOTAC', 'Card đồ họa hiệu suất cao.', 2530, 'zotac.jpg', 30, 3, 3, 5, 2, 2),
(3, 'MSI GTX 1080 Graphics Card', 'Card đồ họa hiệu suất cao.', 1500, 'geforce.jpg', 18, 10, 3, 5, 2, 4),
(4, 'MSI GTX 2060 Graphics Card', 'Card đồ họa hiệu suất cao.', 950, 'GTX ventus.jpg', 13.5, 9, 3, 6, 1, 4),
(5, 'ACER Monitor - PREDATOR', 'Màn hình độ phân giải cao.', 1200, 'acer ecran.jpg', 17.5, 18, 12, 2, 2, 1),
(6, 'MSI Monitor - 120Hz', 'Màn hình tần số quét cao.', 800, 'msi ecran.jpg', 46.5, 3, 12, 6, 1, 4),
(7, 'SAMSUNG Monitor', 'Màn hình độ phân giải cao.', 1000, 'moniteur lcd.jpg', 9.5, 20, 12, 0, 2, 6),
(8, 'ACER Mouse - 1800 DPI', 'Chuột độ chính xác cao.', 250, 'acer souris.jpg', 6, 30, 14, 0, 1, 1),
(9, 'MARVO L-21 Optical Mouse', 'Chuột độ chính xác cao.', 150, 'souris gamer.jpg', 40, 19, 14, 1, 1, 7),
(10, 'JEDEL K90 Gaming Mouse', 'Chuột chơi game độ chính xác cao.', 250, 'souris roccat.jpg', 0, 10, 14, 5, 2, 3),
(11, 'Razer Scorpion F13', 'Bàn phím hiệu suất cao.', 1000, 'clavier2.jpg', 37.5, 5, 15, 0, 2, 3),
(12, 'Razer Scorpion - Special Edition', 'Bàn phím hiệu suất cao.', 2225, 'clavier2.jpg', 26, 14, 15, 1, 1, 3),
(13, 'Gaming PC - AMD Ryzen 5', 'PC chơi game hiệu suất cao.', 2600, 'amd1.png', 15, 3, 20, 0, 2, 7),
(14, 'Gaming PC - AMD Ryzen 9', 'PC chơi game hiệu suất cao.', 900, 'amd2.png', 22, 3, 20, 1, 1, 7),
(15, 'Gaming PC - Intel i7', 'PC chơi game hiệu suất cao.', 3000, 'intel1.png', 5.5, 4, 21, 2, 2, 0),
(16, 'Gaming PC ALIEN Build', 'PC chơi game hiệu suất cao.', 2790, 'alien.jpg', 50, 6, 17, 13, 2, 0),
(17, 'PC MSI Ryzen 5', 'PC hiệu suất cao.', 2500, '1.jpg', 0, 12, 20, 5, 1, 7),
(18, 'ASUS Laptop', 'Laptop hiệu suất cao.', 1350, 'Asus.png', 19, 0, 18, 12, 1, 2),
(19, 'DELL Laptop i7', 'Laptop hiệu suất cao.', 1700, 'dell.webp', 12.5, 8, 18, 50, 2, 8);

UPDATE `product`
SET `idCategory` = 
    CASE 
        WHEN `name_prod` LIKE '%Graphics Card%' THEN 1
        WHEN `name_prod` LIKE '%Monitor%' THEN 10
        WHEN `name_prod` LIKE '%Mouse%' THEN 11
        WHEN `name_prod` LIKE '%Keyboard%' THEN 12
        WHEN `name_prod` LIKE '%Gaming PC - AMD%' THEN 14
        WHEN `name_prod` LIKE '%Gaming PC - Intel%' THEN 15
        WHEN `name_prod` LIKE '%Laptop%' THEN 18
        ELSE `idCategory`  -- Keep existing value if no match
    END;

UPDATE `product`
SET `brand` = 
    CASE 
        WHEN UPPER(`name_prod`) LIKE '%ACER%' THEN 1
        WHEN UPPER(`name_prod`) LIKE '%ASUS%' THEN 2
        WHEN UPPER(`name_prod`) LIKE '%HP%' THEN 3
        WHEN UPPER(`name_prod`) LIKE '%MSI%' THEN 4
        WHEN UPPER(`name_prod`) LIKE '%ALIEN%' THEN 5
        WHEN UPPER(`name_prod`) LIKE '%PREDATOR%' THEN 6
        WHEN UPPER(`name_prod`) LIKE '%LCD%' THEN 7
        WHEN UPPER(`name_prod`) LIKE '%DELL%' THEN 8
        ELSE `brand`  -- Keep existing value if no match
    END;


-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `idClient` int(11) NOT NULL,
  `idProduct` int(11) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `rating` enum('0','1','2','3','4','5') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`idClient`, `idProduct`, `comment`, `rating`) VALUES
(4, 6, 'i luv u\r\nbest fan ever\r\n', '3'),
(4, 7, '', '3'),
(4, 11, '', '3'),
(4, 15, '', '3'),
(4, 16, '', '3'),
(4, 20, '', '3'),
(4, 21, '', '3'),
(5, 6, 'gg', '3');

-- --------------------------------------------------------

--
-- Table structure for table `wish`
--

CREATE TABLE `wish` (
  `idClient` int(11) NOT NULL,
  `idProduct` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wish`
--

INSERT INTO `wish` (`idClient`, `idProduct`) VALUES
(5, 7),
(5, 11),
(5, 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`idAddress`),
  ADD KEY `idClient` (`idClient`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`idAdmin`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `alembic_version`
--
ALTER TABLE `alembic_version`
  ADD PRIMARY KEY (`version_num`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`brand`);

--
-- Indexes for table `cart_products`
--
ALTER TABLE `cart_products`
  ADD PRIMARY KEY (`idClient`,`idProduct`),
  ADD KEY `idProduct` (`idProduct`);

--
-- Indexes for table `catalog`
--
ALTER TABLE `catalog`
  ADD PRIMARY KEY (`idCatalog`);

--
-- Indexes for table `catalog_products`
--
ALTER TABLE `catalog_products`
  ADD PRIMARY KEY (`idCatalog`,`idProduct`),
  ADD KEY `idProduct` (`idProduct`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`idCategory`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`idClient`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`codeCoupon`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`idDelivery`),
  ADD KEY `idOrder` (`idOrder`),
  ADD KEY `idAddress` (`idAddress`);

--
-- Indexes for table `delivery_types`
--
ALTER TABLE `delivery_types`
  ADD PRIMARY KEY (`id_type`);

--
-- Indexes for table `loyal_client`
--
ALTER TABLE `loyal_client`
  ADD PRIMARY KEY (`idClient`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`idOrder`),
  ADD KEY `idClient` (`idClient`),
  ADD KEY `id_deliveryType` (`id_deliveryType`);

--
-- Indexes for table `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`idOrder`,`idProduct`),
  ADD KEY `idProduct` (`idProduct`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`idProduct`),
  ADD KEY `idCategory` (`idCategory`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`idClient`,`idProduct`),
  ADD KEY `idProduct` (`idProduct`);

--
-- Indexes for table `wish`
--
ALTER TABLE `wish`
  ADD PRIMARY KEY (`idClient`,`idProduct`),
  ADD KEY `idProduct` (`idProduct`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `idAddress` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `idAdmin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `brand` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `catalog`
--
ALTER TABLE `catalog`
  MODIFY `idCatalog` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `idCategory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `idClient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `idDelivery` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `delivery_types`
--
ALTER TABLE `delivery_types`
  MODIFY `id_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `idOrder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `idProduct` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`),
  ADD CONSTRAINT `address_ibfk_2` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`);

--
-- Constraints for table `cart_products`
--
ALTER TABLE `cart_products`
  ADD CONSTRAINT `cart_products_ibfk_1` FOREIGN KEY (`idProduct`) REFERENCES `product` (`idProduct`),
  ADD CONSTRAINT `cart_products_ibfk_2` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`),
  ADD CONSTRAINT `cart_products_ibfk_3` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`),
  ADD CONSTRAINT `cart_products_ibfk_4` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`);

--
-- Constraints for table `catalog_products`
--
ALTER TABLE `catalog_products`
  ADD CONSTRAINT `catalog_products_ibfk_1` FOREIGN KEY (`idProduct`) REFERENCES `product` (`idProduct`),
  ADD CONSTRAINT `catalog_products_ibfk_2` FOREIGN KEY (`idCatalog`) REFERENCES `catalog` (`idCatalog`);

--
-- Constraints for table `delivery`
--
ALTER TABLE `delivery`
  ADD CONSTRAINT `delivery_ibfk_1` FOREIGN KEY (`idOrder`) REFERENCES `order` (`idOrder`),
  ADD CONSTRAINT `delivery_ibfk_2` FOREIGN KEY (`idAddress`) REFERENCES `address` (`idAddress`),
  ADD CONSTRAINT `delivery_ibfk_3` FOREIGN KEY (`idAddress`) REFERENCES `address` (`idAddress`),
  ADD CONSTRAINT `delivery_ibfk_4` FOREIGN KEY (`idAddress`) REFERENCES `address` (`idAddress`),
  ADD CONSTRAINT `delivery_ibfk_5` FOREIGN KEY (`idAddress`) REFERENCES `address` (`idAddress`),
  ADD CONSTRAINT `delivery_ibfk_6` FOREIGN KEY (`idAddress`) REFERENCES `address` (`idAddress`);

--
-- Constraints for table `loyal_client`
--
ALTER TABLE `loyal_client`
  ADD CONSTRAINT `loyal_client_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`),
  ADD CONSTRAINT `loyal_client_ibfk_2` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`),
  ADD CONSTRAINT `loyal_client_ibfk_3` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`),
  ADD CONSTRAINT `loyal_client_ibfk_4` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`),
  ADD CONSTRAINT `order_ibfk_3` FOREIGN KEY (`id_deliveryType`) REFERENCES `delivery_types` (`id_type`),
  ADD CONSTRAINT `order_ibfk_4` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`),
  ADD CONSTRAINT `order_ibfk_5` FOREIGN KEY (`id_deliveryType`) REFERENCES `delivery_types` (`id_type`),
  ADD CONSTRAINT `order_ibfk_6` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`),
  ADD CONSTRAINT `order_ibfk_7` FOREIGN KEY (`id_deliveryType`) REFERENCES `delivery_types` (`id_type`);

--
-- Constraints for table `order_products`
--
ALTER TABLE `order_products`
  ADD CONSTRAINT `order_products_ibfk_1` FOREIGN KEY (`idProduct`) REFERENCES `product` (`idProduct`),
  ADD CONSTRAINT `order_products_ibfk_2` FOREIGN KEY (`idOrder`) REFERENCES `order` (`idOrder`),
  ADD CONSTRAINT `order_products_ibfk_3` FOREIGN KEY (`idProduct`) REFERENCES `product` (`idProduct`),
  ADD CONSTRAINT `order_products_ibfk_4` FOREIGN KEY (`idOrder`) REFERENCES `order` (`idOrder`),
  ADD CONSTRAINT `order_products_ibfk_5` FOREIGN KEY (`idProduct`) REFERENCES `product` (`idProduct`),
  ADD CONSTRAINT `order_products_ibfk_6` FOREIGN KEY (`idOrder`) REFERENCES `order` (`idOrder`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`idCategory`) REFERENCES `category` (`idCategory`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`idCategory`) REFERENCES `category` (`idCategory`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`idProduct`) REFERENCES `product` (`idProduct`),
  ADD CONSTRAINT `review_ibfk_3` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`),
  ADD CONSTRAINT `review_ibfk_4` FOREIGN KEY (`idProduct`) REFERENCES `product` (`idProduct`);

--
-- Constraints for table `wish`
--
ALTER TABLE `wish`
  ADD CONSTRAINT `wish_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`),
  ADD CONSTRAINT `wish_ibfk_2` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`),
  ADD CONSTRAINT `wish_ibfk_3` FOREIGN KEY (`idProduct`) REFERENCES `product` (`idProduct`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
