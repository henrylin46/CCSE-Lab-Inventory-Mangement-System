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
  `customerID` int(11) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile` int(11) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `matricNumber` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `identification` varchar(100) NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerID`, `fullName`, `email`, `mobile`, `password`, `matricNumber`, `address`, `status`, `identification`, `createdOn`) VALUES
(1, 'Student1', 'student1@student.upm.edu.my', 123456789, '81dc9bdb52d04dc20036dbd8313ed055', 200000, 'UPM', 'Active', 'AB1234567', '2022-12-21 10:48:07'),
(2, 'Student2', 'student2@student.upm.edu.my', 987654321, '81dc9bdb52d04dc20036dbd8313ed055', 300000, 'UPM', 'Active', 'CD1234567', '2022-1-4 10:48:07');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `productID` int(11) NOT NULL,
  `itemNumber` varchar(255) NOT NULL,
  `itemName` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL DEFAULT '0',
  `stock` int(11) NOT NULL DEFAULT 0,
  `imageURL` varchar(255) NOT NULL DEFAULT 'imageNotAvailable.jpg',
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `barcode` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`productID`, `itemNumber`, `itemName`, `location`, `stock`, `imageURL`, `status`, `barcode`, `description`) VALUES
(1, '1', 'Bread Board', 'LAB1', 1, '1671452143_111671452058_.pic.jpg', 'Active', 'ABC-abc-1234', 'Description1'),
(2, '2', 'Buzzer', 'LAB2', 1, '1671452232_121671452058_.pic.jpg', 'Active', '', 'Description2'),
(3, '3', '330mOhm Resistor', 'LAB3', 9, '1671452353_131671452060_.pic.jpg', 'Active', '', 'Description3');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `purchaseID` int(11) NOT NULL,
  `itemNumber` varchar(255) NOT NULL,
  `purchaseDate` date NOT NULL,
  `itemName` varchar(255) NOT NULL,
  `unitPrice` float NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `vendorName` varchar(255) NOT NULL DEFAULT 'Test Vendor',
  `vendorID` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`purchaseID`, `itemNumber`, `purchaseDate`, `itemName`, `unitPrice`, `quantity`, `vendorName`, `vendorID`) VALUES
(39, '1', '2018-05-24', 'First Bag', 1600, 10, 'Johnson and Johnsons Co.', 3),
(40, '2', '2018-05-18', 'First Bag', 2341, 2, 'Louise Vitton Bag', 4),
(41, '4', '2018-05-07', 'Leather Bag', 1234, 3, 'Johnson and Johnsons Co.', 3),
(42, '1', '2018-05-24', 'First Bag', 345, 12, 'Louise Vitton Bag', 4),
(43, '5', '2018-05-03', 'Travel Bag', 35, 3, 'Johnson and Johnsons Co.', 3),
(44, '5', '2018-05-16', 'Travel Bag', 3000, 2, 'ABC Company', 1),
(45, '5', '2018-05-21', 'Travel Bag', 3000, 10, 'Sample Vendor 222', 2),
(46, '4', '2018-05-19', 'Leather Bag', 1200, 4, 'Johnson and Johnsons Co.', 3),
(47, '2', '2018-05-10', 'School Bag', 2, 1, 'Sample Vendor 222', 2),
(48, '1', '2018-05-12', 'Handbag', 2, 9, 'ABC Company', 1),
(50, '14', '2018-05-15', 'Hiking Bag', 1000, 5, 'Louise Vitton Bag', 4),
(51, '11', '2018-05-11', 'First Aid Bag', 1121, 1, 'ABC Company', 1),
(52, '1', '2018-05-21', 'First Bag', 1235, 2, 'Sample Vendor 222', 2);

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
    `saleID` int(11) NOT NULL,
    `itemNumber` varchar(255) NOT NULL,
    `customerID` int(11) NOT NULL,
    `customerName` varchar(255) NOT NULL,
    `itemName` varchar(255) NOT NULL,
    `saleDate` date NOT NULL,
    `quantity` int(11) NOT NULL DEFAULT 0,
    `purpose` varchar(255) NOT NULL,
    `requestStatus` varchar(255) NOT NULL DEFAULT 'Requested'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`saleID`, `itemNumber`, `customerID`, `customerName`, `itemName`, `saleDate`, `quantity`, `purpose`, `requestStatus`) VALUES
(1, '2', 200000, 'Student1', 'Buzzer', '2023-1-4', 1, 'fyp', 'Requested'),
(2, '2', 300000, 'Student2', 'Buzzer', '2023-1-4', 1, 'fyp', 'Requested');
-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `fullName`, `username`, `password`, `status`) VALUES
(1, 'Admin', 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `vendorID` int(11) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` int(11) NOT NULL,
  `phone2` int(11) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `district` varchar(30) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `createdOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`vendorID`, `fullName`, `email`, `mobile`, `phone2`, `address`, `address2`, `city`, `district`, `status`, `createdOn`) VALUES
(1, 'ABC Company', '', 2343567, 0, '80, Ground Floor, ABC Shopping Complex', '46th Avenue', 'Kolpetty', 'Colombo', 'Active', '2018-05-05 05:48:44'),
(2, 'Sample Vendor 222', 'sample@volvo.com', 99828282, 283730183, '123, A Road, B avenue', 'Pitipana', 'Nugegoda', 'Mannar', 'Disabled', '2018-05-05 06:12:02'),
(3, 'Johnson and Johnsons Co.', '', 32323, 0, '34, Malwatta Road, Kottawa', 'Pannipitiya', 'Maharagama', 'Colombo', 'Active', '2018-05-05 06:28:33'),
(4, 'Louise Vitton Bag', 'vitton@vitton.usa.com', 323234938, 0, '45, Palmer Valley, 5th Crossing', 'Delaware', 'Palo Alto', 'Batticaloa', 'Active', '2018-05-05 06:29:41'),
(6, 'Test Vendor', 'test@vendor.com', 43434, 47569937, 'Test address', 'Test address 2', 'Test City', 'Trincomalee', 'Active', '2018-05-05 06:53:14'),
(7, 'Bags Co. Exporters Ltd.', '', 1111, 0, 'Sea Road, Bambalapitiya', '', '', 'Colombo', 'Active', '2018-05-15 10:36:54'),
(8, 'New Bags Exporters', '', 191938930, 0, '123, A Road, B avenue, ', 'Gilford Crescent', 'Colpetty', 'Colombo', 'Active', '2018-05-16 12:36:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerID`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`productID`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`purchaseID`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`saleID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`vendorID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `purchaseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `saleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `vendorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
