-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Aug 07, 2009 at 03:54 AM
-- Server version: 5.0.45
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `bill_processing`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `bill`
-- 

CREATE TABLE `bill` (
  `Bill_No` varchar(35) NOT NULL,
  `Supplier_ID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Amount` double NOT NULL,
  `Approved_Amount` double default NULL,
  `Budget_ID` int(11) NOT NULL,
  `Bill_Type` varchar(25) NOT NULL,
  `Start_Date` date default NULL,
  `End_Date` date default NULL,
  PRIMARY KEY  (`Bill_No`),
  KEY `Supplier_ID` (`Supplier_ID`),
  KEY `Budget_ID` (`Budget_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `bill`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `bill_item`
-- 

CREATE TABLE `bill_item` (
  `Bill_No` varchar(35) NOT NULL,
  `Item_ID` int(11) NOT NULL,
  PRIMARY KEY  (`Bill_No`,`Item_ID`),
  KEY `Item_ID` (`Item_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `bill_item`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `bill_process`
-- 

CREATE TABLE `bill_process` (
  `Process_ID` int(11) NOT NULL auto_increment,
  `Bill_No` varchar(35) NOT NULL,
  `File_ID` int(35) NOT NULL,
  `Date_Of_Verify` date default NULL,
  `Date_Of_Receipt` date NOT NULL,
  `Date_Of_Cash` date default NULL,
  `Status` enum('Pending','Processing','Completed') NOT NULL,
  `Date_Received_HOO` date default NULL,
  `User_Name` varchar(20) NOT NULL,
  PRIMARY KEY  (`Process_ID`),
  KEY `Bill_No` (`Bill_No`),
  KEY `File_ID` (`File_ID`),
  KEY `User_Name` (`User_Name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `bill_process`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `budget`
-- 

CREATE TABLE `budget` (
  `Budget_ID` int(11) NOT NULL auto_increment,
  `Start_Year` year(4) NOT NULL,
  `End_Year` year(4) NOT NULL,
  `Budget_Head` varchar(30) NOT NULL,
  `Amount` double NOT NULL,
  PRIMARY KEY  (`Budget_ID`),
  UNIQUE KEY `Budget_Head` (`Budget_Head`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `budget`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `employee`
-- 

CREATE TABLE `employee` (
  `user_name` varchar(20) NOT NULL,
  `create_date` date NOT NULL,
  `password` varchar(100) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `division` char(7) NOT NULL,
  `location` varchar(40) NOT NULL,
  `designation` char(7) NOT NULL,
  `email` varchar(40) NOT NULL,
  `intercom` char(4) NOT NULL,
  `phone` char(10) default NULL,
  PRIMARY KEY  (`user_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `employee`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `file`
-- 

CREATE TABLE `file` (
  `File_ID` int(11) NOT NULL auto_increment,
  `File_No` varchar(35) NOT NULL,
  PRIMARY KEY  (`File_ID`),
  UNIQUE KEY `File_No` (`File_No`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `file`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `item`
-- 

CREATE TABLE `item` (
  `Item_No` int(11) NOT NULL auto_increment,
  `Item_Details` varchar(100) NOT NULL,
  `Item_Name` varchar(40) NOT NULL,
  PRIMARY KEY  (`Item_No`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `item`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `supplier`
-- 

CREATE TABLE `supplier` (
  `Supplier_ID` int(11) NOT NULL auto_increment,
  `Name` varchar(50) NOT NULL,
  `Address` varchar(100) NOT NULL,
  PRIMARY KEY  (`Supplier_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `supplier`
-- 


-- 
-- Constraints for dumped tables
-- 

-- 
-- Constraints for table `bill`
-- 
ALTER TABLE `bill`
  ADD CONSTRAINT `bill_ibfk_1` FOREIGN KEY (`Supplier_ID`) REFERENCES `supplier` (`Supplier_ID`),
  ADD CONSTRAINT `bill_ibfk_2` FOREIGN KEY (`Budget_ID`) REFERENCES `budget` (`Budget_ID`);

-- 
-- Constraints for table `bill_item`
-- 
ALTER TABLE `bill_item`
  ADD CONSTRAINT `bill_item_ibfk_5` FOREIGN KEY (`Bill_No`) REFERENCES `bill` (`Bill_No`),
  ADD CONSTRAINT `bill_item_ibfk_6` FOREIGN KEY (`Item_ID`) REFERENCES `item` (`Item_No`);

-- 
-- Constraints for table `bill_process`
-- 
ALTER TABLE `bill_process`
  ADD CONSTRAINT `bill_process_ibfk_7` FOREIGN KEY (`Bill_No`) REFERENCES `bill` (`Bill_No`),
  ADD CONSTRAINT `bill_process_ibfk_8` FOREIGN KEY (`File_ID`) REFERENCES `file` (`File_ID`);
