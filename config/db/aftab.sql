-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2018 at 04:22 AM
-- Server version: 10.1.24-MariaDB
-- PHP Version: 7.1.6

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
(1, 'Medicine');

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
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `address`) VALUES
(1, 'Swajan', 'Khulna'),
(2, 'Shahidul', 'Gopalgonj'),
(10, 'Rahim', NULL);

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
(1, 'chair buying', 400, '2018-01-19', 3);

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
(2, 'House rent'),
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

--
-- Dumping data for table `party`
--

INSERT INTO `party` (`id`, `quota`, `customerId`) VALUES
(1, 10, 1),
(2, 20, 2);

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
(2, 20, 25, 2),
(3, 10, 15, 3),
(4, 4, 5, 4),
(5, 2, 3, 5),
(6, 1, 1, 6),
(7, 1, 1, 7),
(8, 1, 1, 8),
(9, 1, 1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `id` int(11) NOT NULL,
  `comission` float NOT NULL,
  `date` date NOT NULL,
  `partyId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `returns`
--

INSERT INTO `returns` (`id`, `comission`, `date`, `partyId`) VALUES
(1, 5, '2018-02-05', 2),
(2, 2, '2018-02-05', 1),
(3, 0, '2018-02-05', 2);

-- --------------------------------------------------------

--
-- Table structure for table `returnsproducts`
--

CREATE TABLE `returnsproducts` (
  `id` int(11) NOT NULL,
  `pcs` int(11) NOT NULL,
  `unitPrice` int(11) NOT NULL,
  `returnsId` int(11) NOT NULL,
  `subCategoryId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `returnsproducts`
--

INSERT INTO `returnsproducts` (`id`, `pcs`, `unitPrice`, `returnsId`, `subCategoryId`) VALUES
(1, 1, 15, 1, 3),
(2, 2, 5, 1, 4),
(3, 10, 1, 2, 6),
(4, 7, 1, 2, 8),
(5, 5, 1, 2, 9),
(6, 1, 15, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
  `id` int(11) NOT NULL,
  `comission` float NOT NULL,
  `date` date NOT NULL,
  `customerId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`id`, `comission`, `date`, `customerId`) VALUES
(1, 12, '2018-02-01', 1),
(2, 5, '2018-02-01', 10),
(3, 1, '2018-02-02', 1),
(4, 10, '2018-02-05', 1),
(5, 2, '2018-02-05', 1),
(6, 10, '2018-02-05', 2);

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
(4, 2, 15, 2, 3),
(5, 1, 1, 3, 1),
(6, 1, 1, 3, 9),
(7, 4, 25, 4, 2),
(8, 2, 1, 4, 7),
(9, 6, 1, 5, 6),
(10, 3, 1, 5, 8),
(11, 3, 25, 6, 2),
(12, 5, 1, 6, 6);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `pcs` int(11) NOT NULL,
  `unitPrice` float NOT NULL,
  `date` date NOT NULL,
  `subCategoryId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `pcs`, `unitPrice`, `date`, `subCategoryId`) VALUES
(1, 200, 1, '2018-01-20', 3),
(2, 300, 1, '2018-01-19', 3),
(3, 45, 1, '2018-01-19', 2),
(4, 45, 1, '2018-01-15', 1),
(5, 50, 1, '2018-01-20', 3),
(6, 100, 2, '2018-01-20', 3);

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
(1, 'Whatever', 2),
(2, 'Chiken 2 days', 2),
(3, 'boiler', 3),
(4, 'pantonix', 1),
(5, 'napa', 1),
(6, 'Chicken four days', 2),
(7, 'abcd', 2),
(8, 'xyz', 2),
(9, 'chicken six days', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `userName` varchar(60) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  ADD KEY `partyId` (`partyId`);

--
-- Indexes for table `returnsproducts`
--
ALTER TABLE `returnsproducts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `saleId` (`returnsId`),
  ADD KEY `subCategoryId` (`subCategoryId`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `creditsale`
--
ALTER TABLE `creditsale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `expensecategory`
--
ALTER TABLE `expensecategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `party`
--
ALTER TABLE `party`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `price`
--
ALTER TABLE `price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `returnsproducts`
--
ALTER TABLE `returnsproducts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `soldproducts`
--
ALTER TABLE `soldproducts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
-- Constraints for table `returns`
--
ALTER TABLE `returns`
  ADD CONSTRAINT `returns_ibfk_1` FOREIGN KEY (`partyId`) REFERENCES `party` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `returnsproducts`
--
ALTER TABLE `returnsproducts`
  ADD CONSTRAINT `returnsproducts_ibfk_1` FOREIGN KEY (`returnsId`) REFERENCES `returns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `returnsproducts_ibfk_2` FOREIGN KEY (`subCategoryId`) REFERENCES `subcategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
