-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2018 at 04:14 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
(10, 'Gas'),
(1, 'Medicine'),
(11, 'Oil');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `mobile` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `address`, `mobile`) VALUES
(1, 'Swajan', 'Khulna', 1571777609),
(2, 'Shahidul', 'Gopalgonj', NULL),
(62, 'Mr. xx', NULL, NULL),
(63, 'mr Karim khan', NULL, NULL),
(64, 'humaon islam', NULL, NULL),
(65, 'arman', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customerduepayment`
--

CREATE TABLE `customerduepayment` (
  `id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `saleId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customerduepayment`
--

INSERT INTO `customerduepayment` (`id`, `amount`, `saleId`) VALUES
(1, 2, 3),
(2, 503, 4),
(3, 38, 5),
(4, 0, 6);

-- --------------------------------------------------------

--
-- Table structure for table `due`
--

CREATE TABLE `due` (
  `id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `saleId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `due`
--

INSERT INTO `due` (`id`, `amount`, `saleId`) VALUES
(1, 103, 1),
(2, 3453, 2),
(3, 22, 3),
(4, 503, 4),
(5, 38, 5),
(6, 0, 6);

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
-- Table structure for table `memono`
--

CREATE TABLE `memono` (
  `id` int(11) NOT NULL,
  `Chicken` int(11) NOT NULL DEFAULT '1',
  `Feed` int(11) NOT NULL DEFAULT '1',
  `Medicine` int(11) NOT NULL DEFAULT '1',
  `Oil` int(11) NOT NULL DEFAULT '1',
  `Gas` int(11) NOT NULL DEFAULT '1',
  `partyPayment` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `memono`
--

INSERT INTO `memono` (`id`, `Chicken`, `Feed`, `Medicine`, `Oil`, `Gas`, `partyPayment`) VALUES
(1, 4, 4, 2, 1, 1, 5);

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
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `details` varchar(255) DEFAULT NULL,
  `amount` float NOT NULL,
  `date` date NOT NULL,
  `customerId` int(11) DEFAULT NULL,
  `saleId` int(11) DEFAULT NULL,
  `partyPaymentMemoNo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `details`, `amount`, `date`, `customerId`, `saleId`, `partyPaymentMemoNo`) VALUES
(1, 'Cash on Chicken : 1', 0, '2018-02-28', 1, 1, 1),
(2, 'Cash on Feed : 2', 10000, '2018-02-28', 2, 2, 2),
(3, NULL, 40, '2018-02-28', NULL, 3, NULL),
(4, NULL, 3000, '2018-03-02', NULL, 4, NULL),
(5, NULL, 50, '2018-03-02', NULL, 5, NULL),
(6, NULL, 16, '2018-03-02', NULL, 6, NULL),
(7, NULL, 10, '2018-03-02', NULL, 3, NULL),
(8, 'chicken-3: 1pca golu return', 90, '2018-03-02', 1, NULL, 3),
(11, NULL, 10, '2018-03-03', NULL, 3, NULL),
(12, 'cash on returns Feed-2', 2000, '2018-03-03', 2, NULL, 4);

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
(6, 1, 15, 6),
(7, 1, 10, 7),
(8, 1, 8, 8),
(9, 1, 40, 9),
(10, 1, 10, 10),
(11, 1, 90, 11),
(12, 1, 2000, 12),
(13, 1, 1500, 13);

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `id` int(11) NOT NULL,
  `total` float NOT NULL,
  `date` date NOT NULL,
  `saleId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `returns`
--

INSERT INTO `returns` (`id`, `total`, `date`, `saleId`) VALUES
(1, 10, '2018-03-03', 3),
(2, 5000, '2018-03-03', 2),
(3, 2000, '2018-03-03', 2);

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
(1, 20, 5, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
  `id` int(11) NOT NULL,
  `total` float NOT NULL,
  `comission` float NOT NULL,
  `net` float NOT NULL,
  `date` date NOT NULL,
  `customerId` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `memoNo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`id`, `total`, `comission`, `net`, `date`, `customerId`, `categoryId`, `memoNo`) VALUES
(1, 105, 2, 103, '2018-02-28', 1, 2, 1),
(2, 13515, 62, 13453, '2018-02-28', 2, 3, 2),
(3, 65, 3, 62, '2018-02-28', 62, 2, 2),
(4, 3515, 12, 3503, '2018-03-02', 63, 3, 3),
(5, 115, 27, 88, '2018-03-02', 64, 1, 1),
(6, 18, 2, 16, '2018-03-02', 65, 2, 3);

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
(1, 1, 15, 1, 6),
(2, 1, 90, 1, 11),
(3, 1, 15, 2, 3),
(4, 6, 2000, 2, 12),
(5, 1, 1500, 2, 13),
(6, 1, 15, 3, 6),
(7, 1, 40, 3, 9),
(8, 1, 10, 3, 7),
(9, 1, 15, 4, 3),
(10, 1, 2000, 4, 12),
(11, 1, 1500, 4, 13),
(12, 17, 5, 5, 4),
(13, 10, 3, 5, 5),
(14, 1, 10, 6, 7),
(15, 1, 8, 6, 8);

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
(2, 300, 1, '2018-01-03', 9),
(3, 25, 1, '2018-01-03', 2),
(4, 450, 1, '2018-01-15', 10);

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
(2, 'Chiken 29 days', 10),
(3, 'boiler', 3),
(4, 'pantonix', 1),
(5, 'napa', 1),
(6, 'Chicken four days', 2),
(7, 'abcd', 2),
(8, 'xyz', 2),
(9, 'chicken six days', 2),
(10, 'good', 11),
(11, 'Golu', 2),
(12, 'BS', 3),
(13, 'BG', 3);

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
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customerduepayment`
--
ALTER TABLE `customerduepayment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `saleId` (`saleId`);

--
-- Indexes for table `due`
--
ALTER TABLE `due`
  ADD PRIMARY KEY (`id`),
  ADD KEY `saleId` (`saleId`);

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
-- Indexes for table `memono`
--
ALTER TABLE `memono`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `party`
--
ALTER TABLE `party`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customerId` (`customerId`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customerId` (`customerId`),
  ADD KEY `saleId` (`saleId`);

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
  ADD KEY `categoryId` (`saleId`);

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
  ADD KEY `customerId` (`customerId`),
  ADD KEY `type` (`categoryId`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT for table `customerduepayment`
--
ALTER TABLE `customerduepayment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `due`
--
ALTER TABLE `due`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
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
-- AUTO_INCREMENT for table `memono`
--
ALTER TABLE `memono`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `party`
--
ALTER TABLE `party`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `price`
--
ALTER TABLE `price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `returnsproducts`
--
ALTER TABLE `returnsproducts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `soldproducts`
--
ALTER TABLE `soldproducts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `due`
--
ALTER TABLE `due`
  ADD CONSTRAINT `due_ibfk_1` FOREIGN KEY (`saleId`) REFERENCES `sale` (`id`);

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
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`customerId`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`saleId`) REFERENCES `sale` (`id`);

--
-- Constraints for table `price`
--
ALTER TABLE `price`
  ADD CONSTRAINT `price_ibfk_1` FOREIGN KEY (`subCategoryId`) REFERENCES `subcategory` (`id`);

--
-- Constraints for table `returns`
--
ALTER TABLE `returns`
  ADD CONSTRAINT `returns_ibfk_1` FOREIGN KEY (`saleId`) REFERENCES `sale` (`id`);

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
  ADD CONSTRAINT `sale_ibfk_2` FOREIGN KEY (`customerId`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `sale_ibfk_3` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`);

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
