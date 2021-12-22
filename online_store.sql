-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2021 at 04:22 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'General'),
(2, 'Sports'),
(4, 'Fashion'),
(5, 'Beverage'),
(6, 'Food'),
(7, 'Desserts');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `dateofbirth` date NOT NULL,
  `registrationdateandtime` datetime NOT NULL DEFAULT current_timestamp(),
  `accountstatus` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`username`, `email`, `firstname`, `lastname`, `password`, `gender`, `dateofbirth`, `registrationdateandtime`, `accountstatus`) VALUES
('kinako', 'kinako@gmail.com', 'kinaa', 'kinako', 'e10adc3949ba59abbe56e057f20f883e', 0, '1995-12-15', '2021-12-20 06:47:03', 1),
('lala', 'lala@gmail.com', 'manaka', 'lala', 'e10adc3949ba59abbe56e057f20f883e', 1, '2001-06-06', '0000-00-00 00:00:00', 1),
('mirei', 'mriei@gmail.com', 'mirei', 'UKI', 'e10adc3949ba59abbe56e057f20f883e', 1, '2000-03-06', '2021-11-28 11:15:32', 1),
('polaa', '', 'pola', 'polaaaaaa', 'd41d8cd98f00b204e9800998ecf8427e', 1, '1996-11-25', '2021-11-17 03:39:07', 1),
('pripara', 'mamiya.shinran@gmail.com', 'pro', 'pri', 'e10adc3949ba59abbe56e057f20f883e', 1, '2000-11-16', '0000-00-00 00:00:00', 1),
('xiaotong', 'xiao.tong0709@gmail.com', 'xiaotong', 'gan', 'e10adc3949ba59abbe56e057f20f883e', 1, '2001-09-07', '0000-00-00 00:00:00', 1),
('yueling', 'yue.ling0709@gmail.com', 'yue', 'ling', 'e10adc3949ba59abbe56e057f20f883e', 1, '2001-07-09', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `orderdetailsid` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`orderdetailsid`, `order_id`, `product_id`, `quantity`) VALUES
(1, 1, 20, 1),
(2, 1, 13, 2),
(3, 1, 5, 3),
(16, 8, 21, 3),
(17, 8, 20, 3),
(18, 8, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer` varchar(100) NOT NULL,
  `orderdateandtime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer`, `orderdateandtime`) VALUES
(1, 'yueling', '2021-12-15 10:08:58'),
(8, 'pripara', '2021-12-20 20:07:26');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `category` int(11) NOT NULL,
  `price` double NOT NULL,
  `promotionprice` double NOT NULL,
  `manufacturedate` date NOT NULL,
  `expireddate` date NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `category`, `price`, `promotionprice`, `manufacturedate`, `expireddate`, `created`, `modified`) VALUES
(1, 'Basketball', 'A ball used in the NBA.', 2, 39.99, 0, '0000-00-00', '0000-00-00', '2015-08-02 12:04:03', '2021-12-01 02:50:53'),
(5, 'Trash Can', 'It will help you maintain cleanliness.', 1, 3.95, 0, '0000-00-00', '0000-00-00', '2015-08-02 12:16:08', '2021-12-01 02:50:53'),
(13, 'baseball', 'baseball ', 2, 16, 11.5, '2021-11-09', '2021-11-30', '2021-11-08 15:35:54', '2021-12-01 02:50:53'),
(20, 'cup noodle', 'noodle', 6, 2, 1.3, '2021-12-14', '2023-12-16', '2021-12-15 02:11:14', '2021-12-15 01:11:14'),
(21, 'cookies', 'chipsmoree', 6, 5, 4, '2021-12-14', '2021-12-30', '2021-12-20 06:43:16', '2021-12-20 05:43:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`orderdetailsid`),
  ADD KEY `ForeignKeyConstraintOrder` (`order_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foreignkeyconstraintcustomer` (`customer`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `CategoryForeignKey` (`category`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `orderdetailsid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `ForeignKeyConstraintOrder` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `foreignkeyconstraintcustomer` FOREIGN KEY (`customer`) REFERENCES `customers` (`username`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `CategoryForeignKey` FOREIGN KEY (`category`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
