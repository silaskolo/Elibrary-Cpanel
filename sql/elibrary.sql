# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.1.26-MariaDB)
# Database: elibrary
# Generation Time: 2017-10-15 11:00:10 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table app_author
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_author`;

CREATE TABLE `app_author` (
  `authorID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `authorName` varchar(50) DEFAULT NULL,
  `authorStatus` tinyint(4) DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `dateAdded` datetime DEFAULT CURRENT_TIMESTAMP,
  `dateModified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isActive` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`authorID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table app_book
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_book`;

CREATE TABLE `app_book` (
  `bookID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `categoryID` int(11) DEFAULT NULL,
  `authorID` int(11) DEFAULT NULL,
  `bookName` varchar(100) DEFAULT NULL,
  `bookLocation` varchar(100) DEFAULT NULL,
  `bookCover` varchar(100) DEFAULT NULL,
  `bookStatus` tinyint(4) DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `dateAdded` datetime DEFAULT CURRENT_TIMESTAMP,
  `dateModified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isActive` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`bookID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table app_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_category`;

CREATE TABLE `app_category` (
  `categoryId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(50) DEFAULT NULL,
  `categoryStatus` tinyint(4) DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `dateAdded` datetime DEFAULT CURRENT_TIMESTAMP,
  `dateModified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isActive` int(11) DEFAULT NULL,
  PRIMARY KEY (`categoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table app_course
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_course`;

CREATE TABLE `app_course` (
  `courseID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `departmentID` int(11) DEFAULT NULL,
  `courseName` varchar(50) DEFAULT NULL,
  `courseLevel` int(11) DEFAULT NULL,
  `courseStatus` tinyint(4) DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `dateAdded` datetime DEFAULT CURRENT_TIMESTAMP,
  `dateModified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isActive` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`courseID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table app_department
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_department`;

CREATE TABLE `app_department` (
  `departmentID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `facultyID` int(11) DEFAULT NULL,
  `departmentName` varchar(50) DEFAULT NULL,
  `departmentStatus` tinyint(4) DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `dateAdded` datetime DEFAULT CURRENT_TIMESTAMP,
  `dateModifed` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isActive` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`departmentID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table app_past_questions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_past_questions`;

CREATE TABLE `app_past_questions` (
  `questionID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `courseID` int(11) DEFAULT NULL,
  `questionName` varchar(50) DEFAULT NULL,
  `questionLocation` varchar(100) DEFAULT NULL,
  `questionCover` varchar(100) DEFAULT NULL,
  `questionStatus` tinyint(4) DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `dateAdded` datetime DEFAULT CURRENT_TIMESTAMP,
  `dateModified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isActive` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`questionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table app_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_user`;

CREATE TABLE `app_user` (
  `userID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `accessID` int(11) NOT NULL,
  `departmentID` int(11) DEFAULT NULL,
  `username` varchar(50) NOT NULL DEFAULT '',
  `userPass` varchar(100) NOT NULL DEFAULT '',
  `userFname` varchar(100) DEFAULT NULL,
  `userLname` varchar(100) DEFAULT NULL,
  `userEmail` varchar(100) DEFAULT NULL,
  `userMobile` varchar(20) DEFAULT NULL,
  `userMatricNo` varchar(20) DEFAULT NULL,
  `userLevel` int(11) DEFAULT NULL,
  `userImage` varchar(100) DEFAULT NULL,
  `userStatus` tinyint(4) NOT NULL,
  `dateAdded` datetime DEFAULT CURRENT_TIMESTAMP,
  `dateModified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isActive` tinyint(4) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table app_user_access
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_user_access`;

CREATE TABLE `app_user_access` (
  `accessID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `accessName` varchar(11) DEFAULT NULL,
  `accessStatus` tinyint(4) DEFAULT NULL,
  `dateAdded` datetime DEFAULT CURRENT_TIMESTAMP,
  `dateModified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isActive` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`accessID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table app_user_preference
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_user_preference`;

CREATE TABLE `app_user_preference` (
  `preferenceID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `bookID` int(11) DEFAULT NULL,
  `questionID` int(11) DEFAULT NULL,
  `projectID` int(11) DEFAULT NULL,
  `preferenceStatus` tinyint(4) DEFAULT NULL,
  `dateAdded` datetime DEFAULT CURRENT_TIMESTAMP,
  `dateModified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isActive` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`preferenceID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
