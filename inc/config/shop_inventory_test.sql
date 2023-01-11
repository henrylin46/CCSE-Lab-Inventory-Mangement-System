-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 21, 2022 at 12:09 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customerID` int(11) NOT NULL AUTO_INCREMENT,
  `fullName` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile` int(11) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `matricNumber` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `identification` varchar(100) NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`customerID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerID`, `fullName`, `email`, `mobile`, `password`, `matricNumber`, `address`, `status`, `identification`, `createdOn`) VALUES
(NULL, 'Student1', 'student1@student.upm.edu.my', 123456789, '81dc9bdb52d04dc20036dbd8313ed055', 200000, 'UPM', 'Active', 'AB1234567', '2022-12-21 10:48:07'),
(NULL, 'Student2', 'student2@student.upm.edu.my', 987654321, '81dc9bdb52d04dc20036dbd8313ed055', 300000, 'UPM', 'Active', 'CD1234567', '2022-1-4 10:48:07');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `itemID` int(11) NOT NULL AUTO_INCREMENT,
  `itemNumber` varchar(255) NOT NULL,
  `itemName` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL DEFAULT '0',
  `stock` int(11) NOT NULL DEFAULT 0,
  `imageURL` varchar(255) NOT NULL DEFAULT 'imageNotAvailable.jpg',
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `barcode` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`itemID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`itemID`, `itemNumber`, `itemName`, `location`, `stock`, `imageURL`, `status`, `barcode`, `description`) VALUES
(NULL, '1', 'Bread Board', 'LAB1', 1, '1671452143_111671452058_.pic.jpg', 'Active', 'ABC-abc-1234', 'Description1'),
(NULL, '2', 'Buzzer', 'LAB2', 1, '1671452232_121671452058_.pic.jpg', 'Active', '', 'Description2'),
(NULL, '3', '330mOhm Resistor', 'LAB3', 9, '1671452353_131671452060_.pic.jpg', 'Active', '', 'Description3');

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
    `saleID` int(11) NOT NULL NOT NULL AUTO_INCREMENT,
    `itemNumber` varchar(255) NOT NULL,
    `customerID` int(11) NOT NULL,
    `customerName` varchar(255) NOT NULL,
    `itemName` varchar(255) NOT NULL,
    `saleDate` date NOT NULL,
    `quantity` int(11) NOT NULL DEFAULT 0,
    `purpose` varchar(255) NOT NULL,
    `requestStatus` varchar(255) NOT NULL DEFAULT 'Requested',
    PRIMARY KEY (`saleID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`saleID`, `itemNumber`, `customerID`, `customerName`, `itemName`, `saleDate`, `quantity`, `purpose`, `requestStatus`) VALUES
(NULL, '2', 200000, 'Student1', 'Buzzer', '2023-1-4', 1, 'fyp', 'Requested'),
(NULL, '2', 300000, 'Student2', 'Buzzer', '2023-1-4', 1, 'fyp', 'Requested');

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `borrowRequest` (
    `borrowRequestID` int(11) NOT NULL AUTO_INCREMENT,
    `matricNumber` int(11) NOT NULL,
    `itemNumber` varchar(255) NOT NULL,
    `borrowQuantity` int(11) NOT NULL DEFAULT 0,
    `borrowPurpose` varchar(255) NOT NULL,
    `borrowRequestDate` timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`borrowRequestID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sale`
--

INSERT INTO `borrowRequest` (`borrowRequestID`, `matricNumber`, `itemNumber`, `borrowQuantity`, `borrowPurpose`)VALUES
(NULL, 200000, '2', 1, 'fyp'),
(NULL, 300000, '2', 1, 'fyp');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `fullName` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `fullName`, `username`, `password`, `status`) VALUES
(NULL, 'Admin', 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'Active');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
