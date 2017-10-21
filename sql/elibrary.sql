# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: tolujimoh.me (MySQL 5.7.19-0ubuntu0.16.04.1)
# Database: elibrary
# Generation Time: 2017-10-21 20:07:15 +0000
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
  `bookFileLocation` varchar(100) DEFAULT NULL,
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
  `categoryID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(50) DEFAULT NULL,
  `categoryStatus` tinyint(4) DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `dateAdded` datetime DEFAULT CURRENT_TIMESTAMP,
  `dateModified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isActive` int(11) DEFAULT NULL,
  PRIMARY KEY (`categoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table app_course
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_course`;

CREATE TABLE `app_course` (
  `courseID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `departmentID` int(11) DEFAULT NULL,
  `levelID` int(11) DEFAULT NULL,
  `courseName` varchar(50) DEFAULT NULL,
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



# Dump of table app_faculty
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_faculty`;

CREATE TABLE `app_faculty` (
  `facultyID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `facultyName` varchar(50) DEFAULT NULL,
  `facultyStatus` tinyint(4) DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `dateAdded` datetime DEFAULT CURRENT_TIMESTAMP,
  `dateModifed` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isActive` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`facultyID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table app_level
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_level`;

CREATE TABLE `app_level` (
  `levelID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `levelName` varchar(50) DEFAULT NULL,
  `levelStatus` tinyint(4) DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `dateAdded` datetime DEFAULT CURRENT_TIMESTAMP,
  `dateModified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isActive` int(11) DEFAULT NULL,
  PRIMARY KEY (`levelID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `app_level` WRITE;
/*!40000 ALTER TABLE `app_level` DISABLE KEYS */;

INSERT INTO `app_level` (`levelID`, `levelName`, `levelStatus`, `createdBy`, `dateAdded`, `dateModified`, `isActive`)
VALUES
	(1,'100',1,NULL,'2017-10-15 22:43:01','2017-10-15 22:43:24',1),
	(2,'200',1,NULL,'2017-10-15 22:43:04','2017-10-15 22:43:26',1),
	(3,'300',1,NULL,'2017-10-15 22:43:07','2017-10-15 22:43:28',1),
	(4,'400',1,NULL,'2017-10-15 22:43:10','2017-10-15 22:43:30',1),
	(5,'500',1,NULL,'2017-10-15 22:43:14','2017-10-15 22:43:33',1);

/*!40000 ALTER TABLE `app_level` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table app_past_question_type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_past_question_type`;

CREATE TABLE `app_past_question_type` (
  `typeID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `typeName` varchar(50) DEFAULT NULL,
  `typeStatus` tinyint(4) DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `dateAdded` datetime DEFAULT CURRENT_TIMESTAMP,
  `dateModified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isActive` int(11) DEFAULT NULL,
  PRIMARY KEY (`typeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `app_past_question_type` WRITE;
/*!40000 ALTER TABLE `app_past_question_type` DISABLE KEYS */;

INSERT INTO `app_past_question_type` (`typeID`, `typeName`, `typeStatus`, `createdBy`, `dateAdded`, `dateModified`, `isActive`)
VALUES
	(1,'Exam',1,NULL,'2017-10-15 23:53:25','2017-10-15 23:53:47',1);

/*!40000 ALTER TABLE `app_past_question_type` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table app_past_questions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_past_questions`;

CREATE TABLE `app_past_questions` (
  `questionID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `courseID` int(11) DEFAULT NULL,
  `typeID` int(11) DEFAULT NULL,
  `semesterID` int(11) DEFAULT NULL,
  `questionYear` varchar(50) DEFAULT NULL,
  `questionFileLocation` varchar(100) DEFAULT NULL,
  `questionStatus` tinyint(4) DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `dateAdded` datetime DEFAULT CURRENT_TIMESTAMP,
  `dateModified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isActive` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`questionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table app_project
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_project`;

CREATE TABLE `app_project` (
  `projectID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `courseID` int(11) DEFAULT NULL,
  `projectName` varchar(50) DEFAULT NULL,
  `projectYear` int(11) DEFAULT NULL,
  `projectFileLocation` varchar(100) DEFAULT NULL,
  `projectStatus` tinyint(4) DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `dateAdded` datetime DEFAULT CURRENT_TIMESTAMP,
  `dateModified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isActive` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`projectID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table app_semester
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_semester`;

CREATE TABLE `app_semester` (
  `semesterID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `semesterName` varchar(50) DEFAULT NULL,
  `semesterStatus` tinyint(4) DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `dateAdded` datetime DEFAULT CURRENT_TIMESTAMP,
  `dateModified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isActive` int(11) DEFAULT NULL,
  PRIMARY KEY (`semesterID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `app_semester` WRITE;
/*!40000 ALTER TABLE `app_semester` DISABLE KEYS */;

INSERT INTO `app_semester` (`semesterID`, `semesterName`, `semesterStatus`, `createdBy`, `dateAdded`, `dateModified`, `isActive`)
VALUES
	(1,'1st Semester',1,NULL,'2017-10-15 23:51:42','2017-10-15 23:51:55',1),
	(2,'2nd Semester',1,NULL,'2017-10-15 23:51:48','2017-10-15 23:51:57',1);

/*!40000 ALTER TABLE `app_semester` ENABLE KEYS */;
UNLOCK TABLES;


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

LOCK TABLES `app_user` WRITE;
/*!40000 ALTER TABLE `app_user` DISABLE KEYS */;

INSERT INTO `app_user` (`userID`, `accessID`, `departmentID`, `username`, `userPass`, `userFname`, `userLname`, `userEmail`, `userMobile`, `userMatricNo`, `userLevel`, `userImage`, `userStatus`, `dateAdded`, `dateModified`, `isActive`)
VALUES
	(1,1,NULL,'kolo','f507e18050f11adf5366fe8afe3c2c0ba746300806512655e03f47243617e585','Silas','Kolo','cylarzkolo@gmail.com','',NULL,5,NULL,1,'2017-10-16 00:10:49','2017-10-16 00:13:43',1);

/*!40000 ALTER TABLE `app_user` ENABLE KEYS */;
UNLOCK TABLES;


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

LOCK TABLES `app_user_access` WRITE;
/*!40000 ALTER TABLE `app_user_access` DISABLE KEYS */;

INSERT INTO `app_user_access` (`accessID`, `accessName`, `accessStatus`, `dateAdded`, `dateModified`, `isActive`)
VALUES
	(1,'admin',1,'2017-10-16 00:09:45','2017-10-16 00:10:15',1),
	(2,'enumerator',1,'2017-10-16 00:09:56','2017-10-16 00:10:17',1),
	(3,'app',1,'2017-10-16 00:10:04','2017-10-16 00:10:19',1);

/*!40000 ALTER TABLE `app_user_access` ENABLE KEYS */;
UNLOCK TABLES;


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
