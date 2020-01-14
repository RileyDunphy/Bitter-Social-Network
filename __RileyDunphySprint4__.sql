CREATE DATABASE  IF NOT EXISTS `bitter-rileydunphy` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `bitter-rileydunphy`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: bitter-rileydunphy
-- ------------------------------------------------------
-- Server version	5.7.26

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `follows`
--

DROP TABLE IF EXISTS `follows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `follows` (
  `follow_id` int(11) NOT NULL AUTO_INCREMENT,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  PRIMARY KEY (`follow_id`),
  KEY `FK_follows` (`from_id`),
  KEY `FK_follows2` (`to_id`),
  CONSTRAINT `FK_follows` FOREIGN KEY (`from_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `FK_follows2` FOREIGN KEY (`to_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `follows`
--

LOCK TABLES `follows` WRITE;
/*!40000 ALTER TABLE `follows` DISABLE KEYS */;
INSERT INTO `follows` VALUES (1,20,13),(2,20,14),(3,17,16),(4,12,20),(5,12,22),(6,12,17),(7,12,14),(8,12,21),(9,26,18),(10,26,13),(11,26,17),(12,26,14),(13,26,24),(14,26,16),(15,26,12),(16,26,21),(17,26,23),(18,26,20),(19,26,19),(20,26,22),(21,26,15),(22,20,17),(23,20,22),(24,20,26),(25,20,21),(26,20,27),(27,20,16),(28,20,18),(29,20,12),(30,16,17),(31,16,14),(32,16,21),(33,16,26),(34,16,15);
/*!40000 ALTER TABLE `follows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL AUTO_INCREMENT,
  `tweet_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`like_id`),
  KEY `FK_tweet_id_idx` (`tweet_id`),
  KEY `FK_user_id_idx` (`user_id`),
  CONSTRAINT `FK_tweet_id` FOREIGN KEY (`tweet_id`) REFERENCES `tweets` (`tweet_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tweets`
--

DROP TABLE IF EXISTS `tweets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tweets` (
  `tweet_id` int(11) NOT NULL AUTO_INCREMENT,
  `tweet_text` varchar(280) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `original_tweet_id` int(11) NOT NULL DEFAULT '0',
  `reply_to_tweet_id` int(11) NOT NULL DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tweet_id`),
  KEY `FK_tweets` (`user_id`),
  CONSTRAINT `FK_tweets` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tweets`
--

LOCK TABLES `tweets` WRITE;
/*!40000 ALTER TABLE `tweets` DISABLE KEYS */;
INSERT INTO `tweets` VALUES (1,'hello',14,0,0,'2019-10-21 18:06:45'),(2,'hello',14,0,0,'2019-10-21 18:07:18'),(3,'hello',14,0,0,'2019-10-21 18:07:30'),(4,'new tweet',14,0,0,'2019-10-22 22:37:04'),(5,'gsdg',14,0,0,'2019-10-22 22:56:53'),(6,'gsdg',14,0,0,'2019-10-22 22:57:16'),(7,'sfas',14,0,0,'2019-10-22 22:57:22'),(8,'Hello World',14,0,0,'2019-10-23 11:59:10'),(9,'Hello from root',20,0,0,'2019-10-23 12:00:20'),(10,'Hello Guys',17,0,0,'2019-10-23 12:03:42'),(11,'Hello from NewUser',21,0,0,'2019-10-23 12:04:12'),(12,'Hello from RileyD',12,0,0,'2019-10-23 12:04:35'),(13,'hello',26,0,0,'2019-11-01 17:48:14'),(14,'Hello from GBush',26,0,0,'2019-11-01 17:48:53'),(15,'Hello from GBush',26,14,0,'2019-11-01 18:10:37'),(16,'Hello from GBush',26,14,0,'2019-11-01 18:10:44'),(17,'hello',26,13,0,'2019-11-01 18:10:48'),(18,'Hello Guys',26,10,0,'2019-11-01 18:10:52'),(19,'Hello World',20,8,0,'2019-11-04 15:07:27'),(20,'Hello World',20,19,0,'2019-11-04 15:08:19'),(21,'Hello Guys',20,18,0,'2019-11-04 15:08:36'),(22,'Hello Guys',20,10,0,'2019-11-04 15:14:27'),(23,'is this a reply',20,0,0,'2019-11-04 20:40:30'),(24,'is this a reply???',20,0,0,'2019-11-04 20:41:00'),(25,'jhk',20,0,0,'2019-11-04 20:52:48'),(26,'kjhkjhk',20,0,0,'2019-11-04 20:53:39'),(27,'kjhkjhk',20,0,0,'2019-11-04 21:00:57'),(28,'kjhkjhk',20,0,0,'2019-11-04 21:01:00'),(29,'28',20,0,0,'2019-11-05 12:24:58'),(30,'hello',20,0,0,'2019-11-05 12:26:03'),(31,'gdsgsd',20,0,0,'2019-11-05 12:30:29'),(32,'Hello',20,0,0,'2019-11-05 13:01:54'),(33,'reply to hello',20,0,32,'2019-11-05 13:07:15'),(34,'reply to hello',20,0,32,'2019-11-05 13:07:48'),(35,'sfafasf',20,0,33,'2019-11-05 13:17:52'),(36,'second reply',20,0,32,'2019-11-05 16:05:59'),(37,'third reply',20,0,32,'2019-11-05 16:06:23'),(38,'Hey Santa',16,0,8,'2019-11-05 16:08:33'),(39,'Hey Santa',16,38,0,'2019-11-05 16:10:51'),(40,'Reply to your reply',16,0,38,'2019-11-05 16:11:11'),(41,'reply to the reply',16,0,38,'2019-11-05 16:42:31'),(42,'Hey Santa',16,38,0,'2019-11-05 16:42:50'),(43,'Reply to a retweet',16,0,42,'2019-11-05 16:49:12'),(44,'reply to a reply',16,0,43,'2019-11-05 16:49:36'),(45,'another reply',16,0,42,'2019-11-05 16:59:42'),(46,'jello',16,0,39,'2019-11-05 17:01:35'),(47,'another reply',16,45,0,'2019-11-05 17:18:05'),(48,'ghgjhgjh',16,0,47,'2019-11-06 17:52:26'),(49,'hello',16,0,47,'2019-11-06 18:32:08'),(50,'hello',16,0,47,'2019-11-06 18:34:25'),(51,'svvsa',16,0,47,'2019-11-06 18:47:15'),(52,'saf',16,0,47,'2019-11-06 18:48:05'),(53,'fsaf',16,0,47,'2019-11-06 19:54:51'),(54,'fsaf',16,0,47,'2019-11-06 19:54:56'),(55,'new comment',16,0,47,'2019-11-06 19:55:24'),(56,'asgsag',16,0,13,'2019-11-06 19:56:38'),(57,'sfaf',16,0,47,'2019-11-06 19:59:48'),(58,'sfdgfdsg',16,0,47,'2019-11-06 20:00:31'),(59,'fasfsf',16,0,15,'2019-11-06 20:01:18'),(60,'fasfas',16,0,17,'2019-11-06 20:02:16'),(61,'sfsf',16,0,18,'2019-11-06 20:05:01'),(62,'Hello Guys',16,10,0,'2019-11-06 20:10:23'),(63,'reply',16,0,62,'2019-11-06 20:10:30'),(64,'fasfas',16,0,62,'2019-11-06 20:33:43'),(65,'dgsdg',16,0,62,'2019-11-06 20:34:59'),(66,'sfasf',16,0,62,'2019-11-06 20:35:39'),(67,'dgsdg',16,65,0,'2019-11-06 20:41:21'),(68,'daf',16,0,67,'2019-11-06 20:41:25'),(69,'daf',16,0,67,'2019-11-06 20:41:33'),(70,'sfasf',16,0,67,'2019-11-06 20:45:21'),(71,'adsgasd',16,0,67,'2019-11-06 20:46:05'),(72,'gasgsa',16,0,67,'2019-11-06 20:56:02'),(73,'gasgsa',16,0,67,'2019-11-06 20:56:47'),(74,'asfas',16,0,67,'2019-11-06 20:56:53'),(75,'asfassfasf',16,0,67,'2019-11-06 20:56:59'),(76,'Hello',16,0,67,'2019-11-06 20:59:53'),(77,'Hello',16,0,67,'2019-11-06 20:59:59'),(78,'Whats up',16,0,67,'2019-11-06 21:03:03'),(79,'whats ',16,0,67,'2019-11-06 21:04:15'),(80,'Hello',16,0,67,'2019-11-06 21:05:19'),(81,'Hello',16,0,67,'2019-11-06 21:05:33'),(82,'another reply',16,45,0,'2019-11-06 21:06:38'),(83,'sfasf',16,0,82,'2019-11-06 21:06:46'),(84,'fasfas',16,0,82,'2019-11-06 21:07:35'),(85,'hello',16,0,82,'2019-11-06 21:07:57'),(86,'hello',16,0,82,'2019-11-06 21:07:57'),(87,'hello',16,0,82,'2019-11-06 21:07:57'),(88,'hello',16,0,82,'2019-11-06 21:08:05'),(89,'next',16,0,82,'2019-11-06 21:10:01'),(90,'ok',16,0,82,'2019-11-06 21:11:31'),(91,'ok',16,90,0,'2019-11-06 21:12:34'),(92,'Ajax',16,0,91,'2019-11-06 21:12:39'),(93,'another comment',16,0,82,'2019-11-06 21:13:45'),(94,'another comment',16,0,82,'2019-11-06 21:14:11'),(95,'Hello',16,0,91,'2019-11-06 22:37:06'),(96,'hello',16,0,91,'2019-11-06 22:37:40');
/*!40000 ALTER TABLE `tweets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `screen_name` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `address` varchar(200) NOT NULL,
  `province` varchar(50) NOT NULL,
  `postal_code` varchar(7) NOT NULL,
  `contact_number` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `url` varchar(50) NOT NULL,
  `description` varchar(160) NOT NULL,
  `location` varchar(50) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `profile_pic` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (12,'Riley','Dunphy','RIleyD','$2y$10$FDpB6svyEcJetMdmi9fPfeF2iHkC/jhvE3a9EuCr8n8Y3In5cWbK6','41 jennings drive','New Brunswick','e3a4y9','5064499073','rileydunphy@live.ca','nbcc.ca','Programming Student','fredericton','2019-10-11 13:08:40','2015-01-15 04.51.29.jpg'),(13,'Nick','Taggart','nick','$2y$10$qsdlQAsGlz8ZBYdaQHRffelrcPav2SObG8PdjgXX7mf.tioMoKzeG','26 Duffie Drive','New Brunswick','e3a1v3','3512523523','nick.taggart@nbcc.ca','nbcc.ca','Teacher','Classroom','2019-10-11 13:25:02',NULL),(14,'Santa','Claus','SantaClaus','$2y$10$Wks6OXqxrh6hIiD3p20yXulFTbZRwOLyVKoXWI9ZPNuKIojhoK2t.','North Pole','Manitoba','E3A 1V3','3512523523','santaclaus@northpole.com','usa.com','I\'m santa','north pole','2019-10-11 13:26:35',NULL),(15,'Mrs','Claus','MrsClause','$2y$10$892fou8cMtxlhOucXolp9eK3C6r6lhH79tPW8RCue3tYavOlKiNXu','237 brookside drive apt 7','New Brunswick','e3a 1v3','3512523523','mrsclaus@northpole.com','localhost','The real mrs claus','north pole','2019-10-11 13:27:16','11800552_1688806018018960_3366582576243298505_n.jpg'),(16,'Easter','Bunny','EasterBun','$2y$10$DElQBa3EUdWC7HZuxNuCeOm8YC7YArqfgIJVKhHwf1.asCpRxigkC','Easter Bunny Drive','Manitoba','E3A 1V3','3512523523','easterbunny@easterbunny.com','usa.com','the easter bunny','fasfasfa','2019-10-11 13:27:56','20191015_091738[1605].jpg'),(17,'Tooth','Fairy','ToothF','$2y$10$UDey0DsHkAERddul.db0lO0WZZiEWvvW4SzLWTRqFsyDnPm2WJxBO','Tooth Fairy st','Prince Edward Island','E3A 1V3','3512523523','toothfairy@tf.com','toothfairy.com','tooth fairy','who knows','2019-10-11 13:28:54',NULL),(18,'Donald','Trump','RealDonald','$2y$10$iVQED4rbWpGQ35s8OYZy8.JcecGOUYkZrNJqf6J4phbB9YJw3bAHu','White House','Nunavut','E3A 1V3','5063434343','donaldtrump@usa.com','usa.com','President','White House','2019-10-11 16:27:58',NULL),(19,'Justin','Trudeau','JustinTrudeau','$2y$10$mG.alsEDWP2Fyodwa5sqZe/.D9myLRvc9RABsXhzWYzUUecfOEJKO','Parliament Hill','Ontario','e3a1v3','3512523523','jt@jt.com','canada.com','Prime Minister','Parliament Hill','2019-10-11 16:28:53',NULL),(20,'Riley','Dunphy','root','$2y$10$sOnr58HBeY4cVjyfDmG/TuVlQed0paUb1QjKRa8DwSs/F5w9kjExu','41 jennings drive','New Brunswick','e3a4y9','5064499073','rileydunphy@live.ca','','Programming Student','','2019-10-15 16:55:02','20191015_091738[1605].jpg'),(21,'Riley','Dunphy','NewUser','$2y$10$xmDhj37lNn4jGhK0hVTIKuRJ3DDD700SKAvgTxfTVS9z/PF.wN6Pm','41 jennings drive','New Brunswick','sdfsdf','5064499073','rileydunphy@live.ca','','Programming Studentadsgasdgsdg','','2019-10-15 16:57:16',NULL),(22,'Riley','Dunphy','NewUSer2','$2y$10$/F5gcDNfjh..FnOEYVY6i.ZKq5TQ4Mz1G0olO3HSsR8g1Iujkrvaa','41 jennings drive','New Brunswick','sd','5064499073','rileydunphy@live.ca','','sdasdas','','2019-10-15 17:04:59',NULL),(23,'Riley','Dunphy','NewUser3','$2y$10$vnM9Wi3zcphxkkDm7qJh8ujSGg5o2d70WP/RIJPnwYyDlR6jnfvae','41 jennings drive','New Brunswick','fs','5064499073','rileydunphy@live.ca','','sfa','','2019-10-15 17:07:55',NULL),(24,'Riley','Dunphy','NewUser4','$2y$10$Gm.UJtix56uKbgLBa5FhgeAE52MH/xuqCt2xLknF3ARKpCP5a29nG','41 jennings drive','New Brunswick','e3a 4y9','5064499073','rileydunphy@live.ca','nbcc.ca','sfagsaf','','2019-10-15 18:16:08',NULL),(25,'Barack','Obama','Obama','$2y$10$plLqsWH66n8vejL5sAmLGeQBrmZimcusXDVC23RbWhdqrm8td65Ey','White House','Quebec','E3A 1V3','sfasf','barckobama@f.com','barackobama.com','president','America','2019-10-29 19:49:33',NULL),(26,'George','Bush','GBush','$2y$10$HXY8bY/JXD9/NjpluQV5S.16zX3SSfKu.gkaxtwoLn5xZzHpRa0pq','41 jennings drive','New Brunswick','E3A 1V3','506-449-9073','georgebush@us.com','','fredericton','','2019-10-30 17:26:26','2015-01-15 04.51.29.jpg'),(27,'George','Washington','GWash','$2y$10$Id55RxJnIW5VII0FPql06.Zct5gCWAtJSZdfo/A3OmGGSGZvKFTBC','41 jennings drive','New Brunswick','E3A 1V3','506-449-9073','georgebush@us.com','','fredericton','','2019-10-30 17:43:15',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-11-06 18:43:20
