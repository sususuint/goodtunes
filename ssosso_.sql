-- MySQL dump 10.13  Distrib 8.0.31, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: mysql
-- ------------------------------------------------------
-- Server version	8.0.31-google

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `ssosso`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `ssosso` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `ssosso`;

DELIMITER $$
--
-- Procedures
--
CREATE PROCEDURE `findUserAvg` (IN `username` VARCHAR(30), OUT `avgRating` FLOAT)   SELECT AVG(rating) INTO avgRating FROM review WHERE user_id = username$$

DELIMITER ;
--
-- Table structure for table `added_to`
--

DROP TABLE IF EXISTS `added_to`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `added_to` (
  `song_name` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `release_date` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_id` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `playlist_num` int DEFAULT NULL,
  KEY `song_name` (`song_name`,`release_date`),
  KEY `user_id` (`user_id`,`playlist_num`),
  CONSTRAINT `added_to_ibfk_1` FOREIGN KEY (`song_name`, `release_date`) REFERENCES `song` (`song_name`, `release_date`),
  CONSTRAINT `added_to_ibfk_2` FOREIGN KEY (`user_id`, `playlist_num`) REFERENCES `playlist` (`user_id`, `playlist_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `added_to`
--

LOCK TABLES `added_to` WRITE;
/*!40000 ALTER TABLE `added_to` DISABLE KEYS */;
INSERT INTO `added_to` VALUES ('Fire','4/20/2013','def456',1),('Whatcha Say','1/2/2014','sbs3ja',1),('She Used to Be Mine','11/18/2017','sia3yd',1),('Whatcha Say','1/2/2014','sia3yd',1),('Anyone','8/18/2023','sia3yd',1),('Heartless','1/2/2014','om4kud',1),('Anyone','8/18/2023','om4kud',1),('Youngblood','4/29/2022','om4kud',1),('Youngblood','4/29/2022','abc123',1),('Be My Guest','09/26/1959','abc123',1),('Heartless','1/2/2014','abc123',1),('Youngblood','4/29/2022','sbs3ja',2);
/*!40000 ALTER TABLE `added_to` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `artist`
--

DROP TABLE IF EXISTS `artist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `artist` (
  `stage_name` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
  `age` int DEFAULT NULL,
  `artist_type` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`stage_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `artist`
--

LOCK TABLES `artist` WRITE;
/*!40000 ALTER TABLE `artist` DISABLE KEYS */;
INSERT INTO `artist` VALUES ('Caroline Spence',0,'Singer/Songwriter'),('Dave Matthews Band',32,'Pop/Rock Band'),('Hullabahoos',36,'Acapella Group'),('Omisha',21,'Indian Fusion Singer'),('Panda Bear',45,'Indie Rock Singer'),('Parachute',22,'Pop/Rock Band'),('Sons of Bill',18,'American roots rock outfit'),('Spicmacay',33,'Acapella Group'),('Suhayla',22,'Bangladeshi Fusion Singer'),('Tommy Boyce',55,'Pop/Rock Singer'),('Virginia Belles',46,'Acapella Group');
/*!40000 ALTER TABLE `artist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `artist_fun_facts`
--

DROP TABLE IF EXISTS `artist_fun_facts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `artist_fun_facts` (
  `fun_fact` varchar(3000) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stage_name` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  KEY `stage_name` (`stage_name`),
  CONSTRAINT `artist_fun_facts_ibfk_1` FOREIGN KEY (`stage_name`) REFERENCES `artist` (`stage_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `artist_fun_facts`
--

LOCK TABLES `artist_fun_facts` WRITE;
/*!40000 ALTER TABLE `artist_fun_facts` DISABLE KEYS */;
INSERT INTO `artist_fun_facts` VALUES ('SPICMACAY promotes Indian Classical music amongst the youth!','Spicmacay'),('SPICMACAY is popular with brown parents','Spicmacay'),('Hullabahoos is award-winning','Hullabahoos'),('Hullabahoos is student-run and all-male at UVA','Hullabahoos'),('The Virginia Belles are the oldest female acapella group at UVA','Virginia Belles'),('The Virginia Belles were established as the female counterpart to the Virginia Gentlemen','Virginia Belles'),('The band has a violinist and saxophonist','Dave Matthews Band'),('Dave Matthews worked as a bartender before forming the band','Dave Matthews Band'),('His real name is Noah Benjamin Lennox!','Panda Bear'),('He is a co-founding member of the band Animal Collective','Panda Bear'),('He was part of the duo Boyce and Hart','Tommy Boyce'),('He helped songwrite for The Monkees','Tommy Boyce'),('It was formed by childhood friends','Parachute'),('Some members were part of the Virginia Gentlemen at UVA','Parachute'),('She is currently based in Nashville, TN.','Caroline Spence'),('She has been featured on the Rolling Stone','Caroline Spence'),('The band formed at the University of Virginia','Sons of Bill'),('Their most successful album is Love and Logic','Sons of Bill'),('Suhayla was a member of Ektaal Acapella','Suhayla'),('Suhayla studies computer science when she isn’t singing','Suhayla'),('Omisha is known for her soothing, soft voice that gives a signature sound to any arrangement','Omisha'),('Omisha was a member of Ektaal Acapella','Omisha');
/*!40000 ALTER TABLE `artist_fun_facts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `country` (
  `country_name` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
  `popular_genre` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `popular_song` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`country_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country`
--

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` VALUES ('argentina','Hip hop/Rap/R&b','Lollipop'),('australia','Pop','greedy'),('austria','Hip hop/Rap/R&b','Si No Estas'),('bangladesh','Other','Ahoban'),('bolivia','Latin/Reggaeton','PERRO NEGRO'),('brazil','Other','Let\'s Go 4'),('bulgaria','Pop','По, по, по'),('canada','Pop','greedy'),('chile','Hip hop/Rap/R&b','ANDO'),('china','Pop','Qi Shi Dou Mei You'),('colombia','Latin/Reggaeton','PERRO NEGRO'),('costa_rica','Latin/Reggaeton','PERRO NEGRO'),('czech_republic','Hip hop/Rap/R&b','Dopamin'),('denmark','Pop','Skarpt Lys'),('dominican_republic','Latin/Reggaeton','MONACO'),('ecuador','Latin/Reggaeton','PERRO NEGRO'),('egypt','Hip hop/Rap/R&b','سيبك من اللي خلع - من فيلم حمص وحلاوة'),('el_salvador','Latin/Reggaeton','PERRO NEGRO'),('finland','Pop','Taulut (feat. Costi)'),('france','Pop','Si No Estás'),('germany','Hip hop/Rap/R&b','Si No Estás'),('greece','Hip hop/Rap/R&b','G63'),('guatemala','Latin/Reggaeton','PERRO NEGRO'),('honduras','Latin/Reggaeton','MONACO'),('hong_kong','Pop','濤'),('hungary','Pop','Rampapapam'),('iceland','Pop','Skína'),('india','Other','Tu hai kahan'),('indonesia','Pop','penjaga hati'),('ireland','Pop','Stick Season'),('italy','Hip hop/Rap/R&b','EVERYDAY (feat. Shiva, ANNA, Geolier)'),('japan','Pop','Show'),('lithuania','Pop','Strangers'),('malaysia','Pop','Seven (feat. Latto) (Explicit Ver.)'),('mexico','Latin/Reggaeton','Que Onda'),('mongolia','Pop','Toiron Bujie'),('morocco','Hip hop/Rap/R&b','3DABI'),('netherlands','Pop','Si No Estás'),('new_zealand','Pop','Water'),('nicaragua','Latin/Reggaeton','MONACO'),('norway','Pop','Si No Estás'),('pakistan','Pop','Tu hai kahan'),('panama','Latin/Reggaeton','MONACO'),('paraguay','Latin/Reggaeton','Según Quién'),('peru','Latin/Reggaeton','PERRO NEGRO'),('philippines','Pop','ERE'),('poland','Hip hop/Rap/R&b','BFF'),('portugal','Other','Si No Estás'),('puerto_rico','Latin/Reggaeton','Monaco'),('romania','Pop','Cleopatra'),('russia','Pop','Showdown'),('saudi_arabia','Pop','This Is The Life'),('singapore','Pop','Seven (feat. Latto) (Explicit Ver.)'),('south_africa','Pop','iPlan'),('south_korea','Pop','Seven'),('spain','Hip hop/Rap/R&b','Si No Estás'),('sweden','Pop','Det kommer aldrig va over for mig - Spot'),('switzerland','Pop','Si No Estás'),('taiwan','Pop','Seven'),('thailand','Pop','Seven (feat. Latto) (Explicit Ver.)'),('turkey','Hip hop/Rap/R&b','Ateşe Düştüm'),('ukraine','Pop','Знайди мене'),('united_kingdom','Pop','Strangers'),('uruguay','Hip hop/Rap/R&b','Lollipop'),('usa','Hip hop/Rap/R&b','IDGAF (feat. Yeat)'),('venezuela','Latin/Reggaeton','PERRO NEGRO'),('vietnam','Pop','Seven');
/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `performs`
--

DROP TABLE IF EXISTS `performs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `performs` (
  `song_name` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `release_date` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stage_name` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  KEY `song_name` (`song_name`,`release_date`),
  KEY `stage_name` (`stage_name`),
  CONSTRAINT `performs_ibfk_1` FOREIGN KEY (`song_name`, `release_date`) REFERENCES `song` (`song_name`, `release_date`),
  CONSTRAINT `performs_ibfk_2` FOREIGN KEY (`stage_name`) REFERENCES `artist` (`stage_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `performs`
--

LOCK TABLES `performs` WRITE;
/*!40000 ALTER TABLE `performs` DISABLE KEYS */;
INSERT INTO `performs` VALUES ('Whatcha Say','1/2/2014','Hullabahoos'),('Heartless','1/2/2014','Hullabahoos'),('Anyone','8/18/2023','Hullabahoos'),('Youngblood','4/29/2022','Hullabahoos'),('She Used to Be Mine','11/18/2017','Virginia Belles'),('Fire','4/20/2013','Virginia Belles'),('Motion Sickness','11/12/2022','Virginia Belles'),('SPICMACAY at UVA on WTJU\'s Folk & Beyond','11/30/2017','Spicmacay'),('So Much To Say','04/30/1996','Dave Matthews Band'),('Bros','11/04/2006','Panda Bear'),('Be My Guest','09/26/1959','Tommy Boyce'),('White Dress','05/17/2011','Parachute'),('Sit Here and Love Me','02/14/2019','Caroline Spence'),('Santa Ana Winds','03/27/2012','Sons of Bill'),('Fun','03/17/2022','Suhayla'),('So much Fun','03/17/2022','Omisha');
/*!40000 ALTER TABLE `performs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `playlist`
--

DROP TABLE IF EXISTS `playlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `playlist` (
  `user_id` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
  `playlist_num` int NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` varchar(3000) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`,`playlist_num`),
  CONSTRAINT `playlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `site_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `playlist`
--

LOCK TABLES `playlist` WRITE;
/*!40000 ALTER TABLE `playlist` DISABLE KEYS */;
INSERT INTO `playlist` VALUES ('abc123',1,'Shower Playlist','These are some songs I play in the shower.'),('def456',1,'The Belles being awesome','Just a bunch of songs by the ACTUAL best acapella group ever'),('om4kud',1,'Hullabahoos','Just a bunch of songs by the best acapella group ever'),('om4kud',3,'hi','hi'),('om4kud',4,'HEY','HEY'),('sbs3ja',1,'Driving in the Rain Playlist','These are some songs I play when I drive in the rain.'),('sbs3ja',2,'favorites','These are my favorite songs!'),('sbs3ja',3,'Sad Songs','sad music'),('sia3yd',1,'Calm Vibes','These songs are super nice and calming.');
/*!40000 ALTER TABLE `playlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `review` (
  `song_name` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
  `release_date` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
  `review_number` int NOT NULL,
  `rating` float DEFAULT NULL,
  `review_text` varchar(3000) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`song_name`,`release_date`,`user_id`,`review_number`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `review_ibfk_1` FOREIGN KEY (`song_name`, `release_date`) REFERENCES `song` (`song_name`, `release_date`),
  CONSTRAINT `review_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `site_user` (`user_id`),
  CONSTRAINT `ratingMax` CHECK (((`rating` <= 5) and (`rating` >= 0)))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review`
--

LOCK TABLES `review` WRITE;
/*!40000 ALTER TABLE `review` DISABLE KEYS */;
INSERT INTO `review` VALUES ('Anyone','8/18/2023','om4kud',3,2.4,'this is not good but i can\'t stop listening'),('Anyone','8/18/2023','sbs3ja',3,4.3,'The Hullabahoos only disappoint sometimes!'),('Anyone','8/18/2023','sia3yd',2,5,'I listen to this whenever I’m around anyone. Incredible.'),('Anyone','8/18/2023','test',1,4,'This song is for anyone and everyone!'),('Be My Guest','09/26/1959','abc123',2,3.1,'I don’t know how to feel.'),('Be My Guest','09/26/1959','def456',2,4.1,'I will be their guest! I love it!'),('Bros','11/04/2006','def456',1,5,'I remember life with my bros…'),('Fire','4/20/2013','om4kud',1,2.1,'This is fire (on mute)'),('Heartless','1/2/2014','sbs3ja',2,2.5,'I’m feeling heartless with this.'),('Motion Sickness','11/12/2022','om4kud',2,1.1,'This gave me motion sickness'),('She Used to Be Mine','11/18/2017','sia3yd',3,5,'This is what I listen to in the rain.'),('So Much To Say','04/30/1996','abc123',1,1.1,'I have nothing to say about this'),('Whatcha Say','1/2/2014','sbs3ja',1,4.3,'Great song by the Hullabahoos!'),('Youngblood','4/29/2022','sia3yd',1,2.3,'This was too youthful');
/*!40000 ALTER TABLE `review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_user`
--

DROP TABLE IF EXISTS `site_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `site_user` (
  `user_id` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
  `pass_word` varchar(256) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `age` int DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `checkAge` CHECK ((`age` >= 18))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_user`
--

LOCK TABLES `site_user` WRITE;
/*!40000 ALTER TABLE `site_user` DISABLE KEYS */;
INSERT INTO `site_user` VALUES ('abc123','$2y$10$FLca2AXd80UCh6l/FisWjucIUDes0GGsYSDMa94BJu.ex1yF8jQqO','abc123@virginia.edu','fake1',25),('abc1234','$2y$10$VqEd.l2F9/aipz/i1UXLDetBMJp2DVa1hgcB9dQgDEw43zqGIre6u','alphabet@gmail.com','qwertyana',20),('boop','$2y$10$lWiNGcjPgKyLfx07rNn1D.tvGKX39vdEnku8K2sSBaOmqePGD1oyG','fartfart@gmail.com','Hello',34),('def456','$2y$10$qaI5KExEWKtMTfPa9eADq.V4tmPk0i7D5BMV5jGjE89un4u38huIC','def456@virginia.edu','fake2',50),('om4kud','$2y$10$BCCbmYHs1qpuGa82OEd3TecI8zFFi9NBGQTEVKAiYMazuOdlYEKIS','om4kud@virginia.edu','Omisha',21),('sbs3ja','$2y$10$RsYldzWNgZOUd1vpj6456OWpqv4vzYNuMA9klAFguW/eQDy4Lsk0i','sbs3ja@virginia.edu','sai',21),('sia3yd','$2y$10$qX4TCd2joTeCStAYZ9EkJ.DENFjgM8R8fHNna../HSUn2Z2Yqcd1S','sia3yd@virginia.edu','suhayla',22),('test','$2y$10$.t030DE46StI3QRt39dLLuCKNv.a22uxwmOHJxiGsgRH3oCbbmcOe','test@gmail.com','test',20);
/*!40000 ALTER TABLE `site_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `song`
--

DROP TABLE IF EXISTS `song`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `song` (
  `song_name` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
  `release_date` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
  `energy` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `duration` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`song_name`,`release_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `song`
--

LOCK TABLES `song` WRITE;
/*!40000 ALTER TABLE `song` DISABLE KEYS */;
INSERT INTO `song` VALUES ('Anyone','8/18/2023','Moody/Emotional','3:33'),('Be My Guest','09/26/1959','Upbeat','2:08'),('Bros','11/04/2006','Hypnotic','12:31'),('Fire','4/20/2013','Fast/Upbeat','3:19'),('Fun','03/17/2022','Moody','2:28'),('Heartless','1/2/2014','Moody/Emotional','2:58'),('Motion Sickness','11/12/2022','Emotional/Upset','3:32'),('Santa Ana Winds','03/27/2012','Moody','4:28'),('She Used to Be Mine','11/18/2017','Emotional/Slow','4:04'),('Sit Here and Love Me','02/14/2019','Moody','3:25'),('So much Fun','03/17/2022','Moody','2:29'),('So Much To Say','04/30/1996','Emotional','3:05'),('SPICMACAY at UVA on WTJU\'s Folk & Beyond','11/30/2017','Calming','26:11'),('Whatcha Say','1/2/2014','Calm/Melodious','4:17'),('White Dress','05/17/2011','Upbeat','3:36'),('Youngblood','4/29/2022','Moody/Emotional/Intense','1:45');
/*!40000 ALTER TABLE `song` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `song_genre`
--

DROP TABLE IF EXISTS `song_genre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `song_genre` (
  `song_name` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `release_date` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `genre` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  KEY `song_name` (`song_name`,`release_date`),
  CONSTRAINT `song_genre_ibfk_1` FOREIGN KEY (`song_name`, `release_date`) REFERENCES `song` (`song_name`, `release_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `song_genre`
--

LOCK TABLES `song_genre` WRITE;
/*!40000 ALTER TABLE `song_genre` DISABLE KEYS */;
INSERT INTO `song_genre` VALUES ('Whatcha Say','1/2/2014','Pop'),('Heartless','1/2/2014','Pop'),('Anyone','8/18/2023','Pop'),('Youngblood','4/29/2022','Pop'),('She Used to Be Mine','11/18/2017','Pop'),('Fire','4/20/2013','Pop'),('Motion Sickness','11/12/2022','Pop'),('SPICMACAY at UVA on WTJU\'s Folk & Beyond','11/30/2017','Other'),('So Much To Say','04/30/1996','Rock'),('Bros','11/04/2006','Pop'),('Be My Guest','09/26/1959','R&b'),('Be My Guest','09/26/1959','Hip Hop'),('White Dress','05/17/2011','Rock'),('Sit Here and Love Me','02/14/2019','Pop'),('Santa Ana Winds','03/27/2012','Indie'),('Fun','03/17/2022','Other'),('So much Fun','03/17/2022','Other');
/*!40000 ALTER TABLE `song_genre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `where_from`
--

DROP TABLE IF EXISTS `where_from`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `where_from` (
  `country_name` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stage_name` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  KEY `country_name` (`country_name`),
  KEY `stage_name` (`stage_name`),
  CONSTRAINT `where_from_ibfk_1` FOREIGN KEY (`country_name`) REFERENCES `country` (`country_name`),
  CONSTRAINT `where_from_ibfk_2` FOREIGN KEY (`stage_name`) REFERENCES `artist` (`stage_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `where_from`
--

LOCK TABLES `where_from` WRITE;
/*!40000 ALTER TABLE `where_from` DISABLE KEYS */;
INSERT INTO `where_from` VALUES ('india','Spicmacay'),('usa','Hullabahoos'),('usa','Virginia Belles'),('usa','Dave Matthews Band'),('usa','Panda Bear'),('usa','Tommy Boyce'),('usa','Parachute'),('usa','Caroline Spence'),('usa','Sons of Bill'),('india','Omisha'),('bangladesh','Suhayla');
/*!40000 ALTER TABLE `where_from` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-12-04  9:42:29
