-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2024 at 08:33 AM
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

CREATE DEFINER=`root`@`localhost` FUNCTION `empty_cart` (`idC` INT) RETURNS INT(11)  BEGIN
DELETE FROM cart_products WHERE idClient = idC;
RETURN 1;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `idAdmin` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `phoneNumber` varchar(10) NOT NULL,
  `photo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`idAdmin`, `email`, `password`, `lastName`, `firstName`, `phoneNumber`, `photo`) VALUES
(1, 'admin@gmail.com', 'admin', 'ziani', 'zakaria', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `idAdmin` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `phoneNumber` varchar(10) NOT NULL,
  `photo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`idAdmin`, `email`, `password`, `lastName`, `firstName`, `phoneNumber`, `photo`) VALUES
(1, 'admin@gmail.com', 'admin', 'ziani', 'zakaria', '', '');

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
(1, 'fes', 'morocco', '2154862', '33, machin truc', 1),
(2, 'berlin', 'Germany', '2154862', '33, machin truc', 2),
(3, 'meknes', 'morocco', '2154862', '33, machin truc', 1),
(4, 'Midelt', 'morocco', '2154862', '33, machin truc', 3),
(5, 'Casablanca', 'morocco', '2154862', '33, machin truc', 4),
(6, 'Khnifra', 'morocco', '2154862', '33, machin truc', 5),
(10, 'meknes', 'morocco', '50000', 'machin truc', 1),
(11, 'meknes', 'morocco', '50000', 'machin truc', 1),
(12, 'meknes', 'morocco', '50000', 'machin truc', 1),
(13, 'casablanca', 'morocco', '12345', 'test, testtesttest', 7),
(14, 'casablanca', 'morocco', '12345', 'test1, test2test3', 8),
(15, 'Missour', 'morocco', '33250', '21, rue narjiss', 5),
(16, 'Midelt', 'morocco', '12345', 'test1, test2', 5),
(17, 'Midelt', 'morocco', '12345', 'test1, test2', 5),
(18, 'Missour', 'morocco', '33250', '21, rue Narjiss, quartier administratif, Missour', 3),
(19, 'Missour', 'morocco', '33250', '21, rue Narjiss, quartier administratif, Missour', 3);

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
-- Table structure for table `catalog`
--

CREATE TABLE `catalog` (
  `idCatalog` int(11) NOT NULL,
  `name_cat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catalog_products`
--

CREATE TABLE `catalog_products` (
  `idCatalog` int(11) NOT NULL,
  `idProduct` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `idCategory` int(11) NOT NULL,
  `description_cat` varchar(1000) NOT NULL,
  `idParent_cat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 
-- Dumping data for table `category`
--

INSERT INTO `category` (`idCategory`, `description_cat`, `idParent_cat`) VALUES
(1, 'Components', 0),
(2, 'Peripherals', 0),
(3, 'Graphics Card', 1),
(4, 'Motherboard', 1),
(5, 'Processor', 1),
(6, 'RAM', 1),
(7, 'Accessories', 1),
(8, 'Storage', 1),
(9, 'Drive', 1),
(10, 'Fan', 1),
(11, 'Sound Card', 1),
(12, 'Monitor', 2),
(14, 'Mouse', 2),
(15, 'Keyboard', 2),
(16, 'Mouse Pad', 2),
(17, 'Gaming PC', 0),
(18, 'Portable PC', 0),
(20, 'AMD Build', 17),
(21, 'INTEL Build', 17);

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `idClient` int(11) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(20) NOT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `user_img` varchar(100) DEFAULT NULL,
  `creationDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`idClient`, `lastName`, `firstName`, `email`, `password`, `phone`, `user_img`, `creationDate`) VALUES
(2, 'salamat', 'fatima zahrae', 'salamat.fatimazahrae@gmail.com', '1234', NULL, NULL, '2020-11-29'),
(3, 'zakaria', 'ziani', 'zakariaziani99@gmail.com', '1234', NULL, NULL, '2020-12-30'),
(4, 'baya', 'ziyad', 'baya@gmail.com', '1234', '123456789', NULL, '0000-00-00'),
(5, 'boutera', 'youssef', 'boutera@gmail.com', '1234', NULL, NULL, '2021-01-16');

-- --------------------------------------------------------

--
-- Table structure for table `loyal_client`
--

CREATE TABLE `loyal_client` (
  `idClient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loyal_client`
--

INSERT INTO `loyal_client` (`idClient`) VALUES
(2),
(3),
(5);

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
(0, 1, '2020-12-28 20:23:25', 1207.5, 1),
(1, 2, '2020-12-30 00:19:41', 19200, 2),
(2, 3, '2020-12-30 00:34:00', 6580, 2),
(3, 4, '2020-12-30 00:39:07', 16770, 1),
(4, 5, '2020-12-31 16:35:27', 3170, 1),
(70, 3, '2021-01-30 14:39:55', 3690, 1),
(73, 4, '2024-09-27 21:08:07', 1791, 1),
(74, 4, '2024-09-27 21:09:31', 1821, 1);

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
(53, 15, 5),
(54, 2, 1),
(54, 10, 2),
(54, 21, 1),
(55, 2, 1),
(55, 10, 2),
(55, 21, 1),
(56, 2, 1),
(56, 10, 2),
(56, 21, 1),
(57, 2, 1),
(57, 10, 2),
(57, 21, 1),
(58, 2, 1),
(58, 10, 1),
(58, 21, 1),
(59, 9, 1),
(61, 20, 1),
(62, 20, 1),
(65, 20, 1),
(66, 6, 1),
(67, 20, 1),
(68, 6, 1),
(70, 12, 1),
(70, 14, 1),
(73, 7, 1),
(74, 7, 1);

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
(5, 12),
(16, 19);

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
(2, 0, 1, '2020-12-26 17:11:50', 1),
(3, 1, 0, '2020-12-26 17:19:34', 2),
(4, 2, 1, '2020-12-26 17:23:57', 3),
(5, 3, 0, '2020-12-26 17:50:24', 4),
(6, 4, 2, '2020-12-26 18:24:18', 5),
(7, 30, 0, '2020-12-26 18:30:14', 6),
(8, 31, 0, '2020-12-26 18:33:20', 7),
(9, 32, 0, '2020-12-26 18:36:59', 8),
(10, 50, 0, '2020-12-28 14:07:31', 9),
(11, 51, 0, '2020-12-28 15:12:22', 10),
(12, 52, 0, '2020-12-28 18:33:20', 11),
(13, 53, 0, '2020-12-28 20:24:11', 12),
(14, 55, 0, '2020-12-30 00:27:50', 13),
(15, 57, 0, '2020-12-30 00:35:17', 14),
(16, 59, 0, '2020-12-31 17:04:24', 15),
(17, 60, 0, '2020-12-31 17:08:42', 16),
(18, 67, 0, '2021-01-06 15:43:06', 17),
(19, 69, 0, '2021-01-30 12:25:26', 18),
(20, 70, 0, '2021-01-30 14:40:06', 19);

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
(4, 20, 3),
(16, 6, 1);

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
  `promo` float NOT NULL DEFAULT 0,
  `stock` int(11) NOT NULL,
  `idCategory` int(11) NOT NULL,
  `sold` int(11) NOT NULL DEFAULT 0,
  `shipped` int(1) NOT NULL DEFAULT 1,
  `brand` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`idProduct`, `name_prod`, `description_prod`, `price`, `img_prod`, `promo`, `stock`, `idCategory`, `sold`, `shipped`, `brand`) VALUES
(2, 'DELL Laptop i7', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis noexercit ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id.', 1700, 'dell.webp', 12.5, 8, 18, 50, 2, 8),
(3, 'ASUS Laptop', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis noexercit ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id.', 1350, 'Asus.png', 19, 0, 18, 12, 1, 2),
(4, 'Gaming PC ALIEN Build', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis noexercit ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id.', 2790, 'alien.jpg', 50, 6, 17, 13, 2, 0),
(6, 'NVIDIA RTX 2080', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis noexercit ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id.', 1890, 'palit rtx.jpg', 15, 9, 3, 9, 1, 6),
(7, 'Nvidia ZOTAC', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis noexercit ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id.', 2530, 'zotac.jpg', 30, 3, 3, 5, 2, 2),
(8, 'PC MSI Ryzen 5', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis noexercit ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id.', 2500, '1.jpg', 0, 12, 20, 5, 1, 7),
(9, 'ACER Monitor - PREDATOR', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis noexercit ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id.', 1200, 'acer ecran.jpg', 17.5, 18, 12, 2, 2, 1),
(10, 'MSI Monitor - 120Hz', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis noexercit ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id.', 800, 'msi ecran.jpg', 46.5, 3, 12, 6, 1, 4),
(11, 'SAMSUNG Monitor', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis noexercit ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id.', 1000, 'moniteur lcd.jpg', 9.5, 20, 12, 0, 2, 6),
(12, 'MSI GTX 2060 Graphics Card', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis noexercit ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id.', 950, 'GTX ventus.jpg', 13.5, 9, 3, 6, 1, 4),
(13, 'ACER Mouse - 1800 DPI', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis noexercit ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id.', 250, 'acer souris.jpg', 6, 30, 14, 0, 1, 1),
(14, 'MARVO L-21 Optical Mouse', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis noexercit ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id.', 150, 'souris gamer.jpg', 40, 19, 14, 1, 1, 7),
(15, 'JEDEL K90 Gaming Mouse', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis noexercit ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id.', 250, 'souris roccat.jpg', 0, 10, 14, 5, 2, 3),
(16, 'Razer Scorpion F13', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis noexercit ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id.', 1000, 'clavier2.jpg', 37.5, 5, 15, 0, 2, 3),
(17, 'Razer Scorpion - Special Edition', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis noexercit ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id.', 2225, 'clavier2.jpg', 26, 14, 15, 1, 1, 3),
(18, 'MSI GTX 1080 Graphics Card', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis noexercit ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id.', 1500, 'geforce.jpg', 18, 10, 3, 5, 2, 4),
(19, 'Gaming PC - AMD Ryzen 5', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis noexercit ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id.', 2600, 'amd1.png', 15, 3, 20, 0, 2, 7),
(20, 'Gaming PC - AMD Ryzen 9', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis noexercit ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id.', 900, 'amd2.png', 22, 3, 20, 1, 1, 7),
(21, 'Gaming PC - Intel i7', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis noexercit ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id.', 3000, 'intel1.png', 5.5, 4, 21, 2, 2, 0);

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`idAdmin`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`idAdmin`);

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`idAddress`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`idClient`,`idProduct`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`brand`);

--
-- Indexes for table `catalog`
--
ALTER TABLE `catalog`
  ADD PRIMARY KEY (`idCatalog`);

--
-- Indexes for table `catalog_products`
--
ALTER TABLE `catalog_products`
  ADD PRIMARY KEY (`idCatalog`,`idProduct`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`idCategory`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`idClient`);

--
-- Indexes for table `loyal_client`
--
ALTER TABLE `loyal_client`
  ADD PRIMARY KEY (`idClient`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`idOrder`);

--
-- Indexes for table `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`idOrder`,`idProduct`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`codeCoupon`);

--
-- Indexes for table `wish`
--
ALTER TABLE `wish`
  ADD PRIMARY KEY (`idClient`,`idProduct`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`idDelivery`);

--
-- Indexes for table `cart_products`
--
ALTER TABLE `cart_products`
  ADD PRIMARY KEY (`idClient`,`idProduct`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`idProduct`);

--
-- Indexes for table `delivery_types`
--
ALTER TABLE `delivery_types`
  ADD PRIMARY KEY (`id_type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `idAdmin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `idAdmin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `idAddress` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
  MODIFY `idClient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `idOrder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `idDelivery` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `idProduct` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `delivery_types`
--
ALTER TABLE `delivery_types`
  MODIFY `id_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;