-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
<<<<<<< HEAD
-- Generation Time: Feb 01, 2018 at 05:41 PM
-- Server version: 10.1.24-MariaDB
-- PHP Version: 7.1.6
=======
-- Generation Time: Jan 26, 2018 at 06:52 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7
>>>>>>> 0e486218b854674421be9b26ee3c0692a955ef84

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aftab`
--

-- --------------------------------------------------------

--
-- Table structure for table `bankdeposite`
--

CREATE TABLE `bankdeposite` (
  `id` int(11) NOT NULL,
  `tokenNo` varchar(100) NOT NULL,
  `bankName` varchar(200) NOT NULL,
  `netAmount` float NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bankdeposite`
--

INSERT INTO `bankdeposite` (`id`, `tokenNo`, `bankName`, `netAmount`, `date`) VALUES
(2, '13133', 'IBBL', 50000, '2018-01-13');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(2, 'Chicken'),
(3, 'Feed'),
(1, 'Medicine'),
(4, 'Mobi Cash Returns');

-- --------------------------------------------------------

--
-- Table structure for table `creditsale`
--

CREATE TABLE `creditsale` (
  `id` int(11) NOT NULL,
  `pcs` int(11) NOT NULL,
  `unitPrice` float NOT NULL,
  `netAmount` float NOT NULL,
  `date` date NOT NULL,
  `partyId` int(11) NOT NULL,
  `subCategoryId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `address` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

<<<<<<< HEAD
--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `address`) VALUES
(1, 'Swajan', 'Khulna'),
(2, 'Shahidul', 'Gopalgonj'),
(10, 'Rahim', NULL);

=======
>>>>>>> 0e486218b854674421be9b26ee3c0692a955ef84
-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `id` int(11) NOT NULL,
  `details` text NOT NULL,
  `netAmount` float NOT NULL,
  `date` date NOT NULL,
  `expenseCategoryId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`id`, `details`, `netAmount`, `date`, `expenseCategoryId`) VALUES
(2, 'Test Expense', 50000, '2018-01-12', 4),
(3, 'Test Expense', 50000, '2018-01-03', 4),
(4, 'Test Expenses', 1037, '2018-01-18', 5),
(5, 'Test Expense', 51, '2018-01-17', 3),
(6, 'Test Expensefads', 50000, '2018-01-17', 5);

-- --------------------------------------------------------

--
-- Table structure for table `expensecategory`
--

CREATE TABLE `expensecategory` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expensecategory`
--

INSERT INTO `expensecategory` (`id`, `name`) VALUES
(2, 'House Rent'),
(4, 'Others'),
(5, 'Salary'),
(3, 'Stationary'),
(1, 'Transport');

-- --------------------------------------------------------

--
-- Table structure for table `party`
--

CREATE TABLE `party` (
  `id` int(11) NOT NULL,
  `quota` float NOT NULL,
  `customerId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `price`
--

CREATE TABLE `price` (
  `id` int(11) NOT NULL,
  `buy` float NOT NULL,
  `sale` float NOT NULL,
  `subCategoryId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `price`
--

INSERT INTO `price` (`id`, `buy`, `sale`, `subCategoryId`) VALUES
(1, 1, 1, 1),
(2, 33, 37, 2);

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `id` int(11) NOT NULL,
<<<<<<< HEAD
  `comission` float NOT NULL,
=======
  `pcs` int(11) NOT NULL,
  `unitPrice` float NOT NULL,
  `netAmount` float NOT NULL,
>>>>>>> 0e486218b854674421be9b26ee3c0692a955ef84
  `date` date NOT NULL,
  `customerId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

<<<<<<< HEAD
INSERT INTO `sale` (`id`, `comission`, `date`, `customerId`) VALUES
(1, 12, '2018-02-01', 1),
(2, 5, '2018-02-01', 10);

-- --------------------------------------------------------

--
-- Table structure for table `soldproducts`
--

CREATE TABLE `soldproducts` (
  `id` int(11) NOT NULL,
  `pcs` int(11) NOT NULL,
  `unitPrice` int(11) NOT NULL,
  `saleId` int(11) NOT NULL,
  `subCategoryId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `soldproducts`
--

INSERT INTO `soldproducts` (`id`, `pcs`, `unitPrice`, `saleId`, `subCategoryId`) VALUES
(1, 2, 25, 1, 2),
(2, 2, 1, 1, 1),
(3, 3, 5, 2, 4),
(4, 2, 15, 2, 3);
=======
CREATE TABLE `sale` (
  `id` int(11) NOT NULL,
  `pcs` int(11) NOT NULL,
  `unitPrice` float NOT NULL,
  `netAmount` float NOT NULL,
  `date` date NOT NULL,
  `customerId` int(11) NOT NULL,
  `subCategoryId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
>>>>>>> 0e486218b854674421be9b26ee3c0692a955ef84

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `pcs` int(11) NOT NULL,
  `unitPrice` float NOT NULL,
  `netAmount` float NOT NULL,
  `date` date NOT NULL,
  `subCategoryId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `pcs`, `unitPrice`, `netAmount`, `date`, `subCategoryId`) VALUES
(2, 30000, 1, 30000, '2018-01-12', 1),
(3, 20000, 33, 660000, '2018-01-13', 2),
(4, 25, 33, 825, '2018-01-13', 2),
(5, 30000, 1, 30000, '2018-01-13', 1),
(6, 20000, 33, 660000, '2018-01-17', 2);

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE `subcategory` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `categoryId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`id`, `name`, `categoryId`) VALUES
(1, 'Whatever', 3),
(2, 'Chiken 2 days', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `userName` varchar(60) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `userName`, `phone`, `password`) VALUES
(6, 'Shahid', '1234567890', '7a6b318ebb24d5bb9a1a3f8d566ebaaa50d7f30f0b4c0a5fb0004365ad45bda9');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bankdeposite`
--
ALTER TABLE `bankdeposite`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`name`);

--
-- Indexes for table `creditsale`
--
ALTER TABLE `creditsale`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subCategoryId` (`subCategoryId`),
  ADD KEY `customerId` (`partyId`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenseCategoryId` (`expenseCategoryId`);

--
-- Indexes for table `expensecategory`
--
ALTER TABLE `expensecategory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`name`);

--
-- Indexes for table `party`
--
ALTER TABLE `party`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customerId` (`customerId`);

--
-- Indexes for table `price`
--
ALTER TABLE `price`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subCategoryId_2` (`subCategoryId`),
  ADD KEY `subCategoryId` (`subCategoryId`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subCategoryId` (`subCategoryId`),
  ADD KEY `customerId` (`customerId`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customerId` (`customerId`);

--
-- Indexes for table `soldproducts`
--
ALTER TABLE `soldproducts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `saleId` (`saleId`),
  ADD KEY `subCategoryId` (`subCategoryId`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subCategoryId` (`subCategoryId`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`name`),
  ADD KEY `categoryId` (`categoryId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userName` (`userName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bankdeposite`
--
ALTER TABLE `bankdeposite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `creditsale`
--
ALTER TABLE `creditsale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
<<<<<<< HEAD
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
=======
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
>>>>>>> 0e486218b854674421be9b26ee3c0692a955ef84
--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `expensecategory`
--
ALTER TABLE `expensecategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `party`
--
ALTER TABLE `party`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `price`
--
ALTER TABLE `price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
<<<<<<< HEAD
--
-- AUTO_INCREMENT for table `soldproducts`
--
ALTER TABLE `soldproducts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
=======
>>>>>>> 0e486218b854674421be9b26ee3c0692a955ef84
--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `creditsale`
--
ALTER TABLE `creditsale`
  ADD CONSTRAINT `creditsale_ibfk_1` FOREIGN KEY (`subCategoryId`) REFERENCES `subcategory` (`id`),
  ADD CONSTRAINT `creditsale_ibfk_2` FOREIGN KEY (`partyId`) REFERENCES `party` (`id`);

--
-- Constraints for table `expense`
--
ALTER TABLE `expense`
  ADD CONSTRAINT `expense_ibfk_1` FOREIGN KEY (`expenseCategoryId`) REFERENCES `expensecategory` (`id`);

--
-- Constraints for table `party`
--
ALTER TABLE `party`
  ADD CONSTRAINT `party_ibfk_1` FOREIGN KEY (`customerId`) REFERENCES `customer` (`id`);

--
-- Constraints for table `price`
--
ALTER TABLE `price`
  ADD CONSTRAINT `price_ibfk_1` FOREIGN KEY (`subCategoryId`) REFERENCES `subcategory` (`id`);

--
-- Constraints for table `sale`
--
ALTER TABLE `sale`
  ADD CONSTRAINT `sale_ibfk_2` FOREIGN KEY (`customerId`) REFERENCES `customer` (`id`);

--
-- Constraints for table `soldproducts`
--
ALTER TABLE `soldproducts`
  ADD CONSTRAINT `soldproducts_ibfk_1` FOREIGN KEY (`saleId`) REFERENCES `sale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `soldproducts_ibfk_2` FOREIGN KEY (`subCategoryId`) REFERENCES `subcategory` (`id`);

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`subCategoryId`) REFERENCES `subcategory` (`id`);

--
-- Constraints for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD CONSTRAINT `subcategory_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
