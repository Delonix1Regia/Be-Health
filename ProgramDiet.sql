-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for programdiet
CREATE DATABASE IF NOT EXISTS `programdiet` /*!40100 DEFAULT CHARACTER SET armscii8 COLLATE armscii8_bin */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `programdiet`;

-- Dumping structure for table programdiet.consul_session
CREATE TABLE IF NOT EXISTS `consul_session` (
  `id_session` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL DEFAULT '0',
  `id_nutrisionist` int NOT NULL DEFAULT '0',
  `date_session` date NOT NULL,
  `topic` varchar(50) COLLATE armscii8_bin NOT NULL,
  `content` varchar(1000) COLLATE armscii8_bin NOT NULL,
  PRIMARY KEY (`id_session`),
  KEY `FK_consul_session_user` (`id_user`),
  KEY `FK_consul_session_nutrisionist` (`id_nutrisionist`),
  CONSTRAINT `FK_consul_session_nutrisionist` FOREIGN KEY (`id_nutrisionist`) REFERENCES `nutrisionist` (`id_nutrisionist`),
  CONSTRAINT `FK_consul_session_user` FOREIGN KEY (`id_user`) REFERENCES `data_diri` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table programdiet.consul_session: ~7 rows (approximately)
INSERT INTO `consul_session` (`id_session`, `id_user`, `id_nutrisionist`, `date_session`, `topic`, `content`) VALUES
	(1, 1, 3, '2024-06-01', 'Weight Management', 'Discussed diet plans and exercise routines.'),
	(2, 2, 1, '2024-06-02', 'Sports Nutrition', 'Reviewed protein intake and supplements.'),
	(3, 3, 2, '2024-06-03', 'Clinical Nutrition', 'Talked about managing dietary restrictions.'),
	(4, 1, 4, '2024-06-04', 'Pediatric Nutrition', 'Reviewed child\'s diet and growth.'),
	(5, 2, 5, '2024-06-05', 'Public Health Nutrition', 'Discussed community nutrition initiatives.'),
	(6, 3, 1, '2024-06-06', 'Sports Nutrition', 'Reviewed training diet and hydration.'),
	(7, 1, 2, '2024-06-07', 'Weight Management', 'Reviewed progress and adjusted diet plan.');

-- Dumping structure for table programdiet.exercises
CREATE TABLE IF NOT EXISTS `exercises` (
  `id_exercises` int NOT NULL AUTO_INCREMENT,
  `exercise_name` varchar(100) COLLATE armscii8_bin NOT NULL,
  `type_ofexercise` varchar(100) COLLATE armscii8_bin NOT NULL,
  `calory_burned` decimal(50,0) NOT NULL,
  `duration` decimal(65,0) NOT NULL,
  `level_difficulity` varchar(50) COLLATE armscii8_bin NOT NULL,
  PRIMARY KEY (`id_exercises`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table programdiet.exercises: ~20 rows (approximately)
INSERT INTO `exercises` (`id_exercises`, `exercise_name`, `type_ofexercise`, `calory_burned`, `duration`, `level_difficulity`) VALUES
	(1, 'Running', 'Cardio', 600, 30, 'Medium'),
	(2, 'Swimming', 'Cardio', 500, 45, 'Medium'),
	(3, 'Cycling', 'Cardio', 400, 60, 'Medium'),
	(4, 'Yoga', 'Flexibility', 200, 60, 'Easy'),
	(5, 'Weight Lifting', 'Strength', 350, 45, 'Hard'),
	(6, 'Pilates', 'Flexibility', 250, 60, 'Easy'),
	(7, 'HIIT', 'Cardio', 700, 30, 'Hard'),
	(8, 'Boxing', 'Cardio', 800, 60, 'Hard'),
	(9, 'Dancing', 'Cardio', 300, 60, 'Medium'),
	(10, 'Hiking', 'Cardio', 600, 120, 'Medium'),
	(11, 'Rowing', 'Cardio', 550, 45, 'Medium'),
	(12, 'Jump Rope', 'Cardio', 700, 30, 'Hard'),
	(13, 'CrossFit', 'Strength', 800, 60, 'Hard'),
	(14, 'Stair Climbing', 'Cardio', 450, 30, 'Medium'),
	(15, 'Elliptical Trainer', 'Cardio', 300, 30, 'Easy'),
	(16, 'Kickboxing', 'Cardio', 750, 60, 'Hard'),
	(17, 'Zumba', 'Cardio', 400, 60, 'Medium'),
	(18, 'Tai Chi', 'Flexibility', 150, 60, 'Easy'),
	(19, 'Powerlifting', 'Strength', 600, 90, 'Hard'),
	(20, 'Rock Climbing', 'Strength', 650, 60, 'Hard');

-- Dumping structure for table programdiet.foods
CREATE TABLE IF NOT EXISTS `foods` (
  `id_food` int NOT NULL AUTO_INCREMENT,
  `food_name` varchar(100) COLLATE armscii8_bin NOT NULL,
  `raw_material` varchar(100) COLLATE armscii8_bin NOT NULL,
  `calory_produced` int NOT NULL DEFAULT '0',
  `category` varchar(100) COLLATE armscii8_bin NOT NULL,
  `tutorial` varchar(1000) COLLATE armscii8_bin NOT NULL,
  PRIMARY KEY (`id_food`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table programdiet.foods: ~20 rows (approximately)
INSERT INTO `foods` (`id_food`, `food_name`, `raw_material`, `calory_produced`, `category`, `tutorial`) VALUES
	(21, 'Spaghetti Carbonara', 'Pasta, Eggs, Cheese, Bacon', 450, 'Italian', '1. Boil pasta. 2. Fry bacon. 3. Mix eggs and cheese. 4. Combine all.'),
	(22, 'Chicken Curry', 'Chicken, Curry Powder, Coconut Milk', 600, 'Indian', '1. Cook chicken. 2. Add spices. 3. Add coconut milk. 4. Simmer.'),
	(23, 'Sushi', 'Rice, Fish, Seaweed', 300, 'Japanese', '1. Cook rice. 2. Slice fish. 3. Roll with seaweed.'),
	(24, 'Beef Tacos', 'Beef, Tortillas, Cheese, Lettuce', 500, 'Mexican', '1. Cook beef. 2. Prepare toppings. 3. Assemble tacos.'),
	(25, 'Chocolate Cake', 'Flour, Cocoa, Sugar, Eggs', 350, 'Dessert', '1. Mix ingredients. 2. Bake. 3. Frost.'),
	(26, 'Caesar Salad', 'Lettuce, Croutons, Caesar Dressing', 200, 'Salad', '1. Chop lettuce. 2. Add croutons. 3. Toss with dressing.'),
	(27, 'Pancakes', 'Flour, Eggs, Milk', 250, 'Breakfast', '1. Mix ingredients. 2. Cook on griddle.'),
	(28, 'Tom Yum Soup', 'Shrimp, Lemongrass, Lime', 150, 'Thai', '1. Boil broth. 2. Add ingredients. 3. Simmer.'),
	(29, 'Hamburger', 'Beef, Bun, Lettuce, Tomato', 600, 'American', '1. Grill beef. 2. Assemble burger.'),
	(30, 'Pad Thai', 'Rice Noodles, Tofu, Peanuts', 400, 'Thai', '1. Cook noodles. 2. Stir-fry ingredients. 3. Combine.'),
	(31, 'Falafel', 'Chickpeas, Herbs, Spices', 300, 'Middle Eastern', '1. Blend ingredients. 2. Form balls. 3. Fry.'),
	(32, 'Apple Pie', 'Apples, Flour, Sugar, Butter', 450, 'Dessert', '1. Prepare crust. 2. Add filling. 3. Bake.'),
	(33, 'Vegetable Stir-fry', 'Mixed Vegetables, Soy Sauce', 150, 'Asian', '1. Chop vegetables. 2. Stir-fry. 3. Add sauce.'),
	(34, 'Fish and Chips', 'Fish, Potatoes, Flour', 700, 'British', '1. Batter fish. 2. Fry fish and chips.'),
	(35, 'Ratatouille', 'Zucchini, Eggplant, Tomatoes', 200, 'French', '1. Slice vegetables. 2. Layer in dish. 3. Bake.'),
	(36, 'Miso Soup', 'Miso Paste, Tofu, Seaweed', 100, 'Japanese', '1. Boil water. 2. Add ingredients. 3. Simmer.'),
	(37, 'Butter Chicken', 'Chicken, Butter, Tomato Sauce', 600, 'Indian', '1. Cook chicken. 2. Add sauce. 3. Simmer.'),
	(38, 'Paella', 'Rice, Seafood, Saffron', 500, 'Spanish', '1. Cook rice. 2. Add seafood. 3. Simmer with spices.'),
	(39, 'Baklava', 'Phyllo Dough, Nuts, Honey', 450, 'Middle Eastern', '1. Layer dough and nuts. 2. Bake. 3. Add syrup.'),
	(40, 'Lasagna', 'Pasta, Cheese, Meat Sauce', 600, 'Italian', '1. Layer ingredients. 2. Bake.');

-- Dumping structure for table programdiet.komentar
CREATE TABLE IF NOT EXISTS `komentar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `komentar` text NOT NULL,
  `tanggal` datetime NOT NULL,
  `id_topik` int NOT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `topik_komentar` (`id_topik`),
  KEY `user_komenter` (`id_user`),
  CONSTRAINT `topik_komentar` FOREIGN KEY (`id_topik`) REFERENCES `topik` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `user_komenter` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table programdiet.komentar: ~4 rows (approximately)
INSERT INTO `komentar` (`id`, `komentar`, `tanggal`, `id_topik`, `id_user`) VALUES
	(1, 'gatau', '2024-06-18 13:34:07', 4, 1),
	(2, 'halo', '2024-06-18 13:41:10', 4, 1),
	(3, 'halo', '2024-06-18 13:41:16', 4, 1),
	(7, 'hayolohhhh', '2024-06-18 20:34:26', 2, 1),
	(11, 'ff', '2024-06-20 00:20:35', 6, 1),
	(12, 'jalo', '2024-06-20 07:50:51', 6, 1);

-- Dumping structure for table programdiet.nutrisionist
CREATE TABLE IF NOT EXISTS `nutrisionist` (
  `id_nutrisionist` int NOT NULL AUTO_INCREMENT,
  `nm_nutrisionist` varchar(50) COLLATE armscii8_bin NOT NULL,
  `expertise` varchar(50) COLLATE armscii8_bin NOT NULL,
  `experience` int NOT NULL DEFAULT '0',
  `total_rating` decimal(20,6) NOT NULL DEFAULT '0.000000',
  PRIMARY KEY (`id_nutrisionist`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table programdiet.nutrisionist: ~5 rows (approximately)
INSERT INTO `nutrisionist` (`id_nutrisionist`, `nm_nutrisionist`, `expertise`, `experience`, `total_rating`) VALUES
	(1, 'Alice Johnson', 'Weight Management', 10, 4.800000),
	(2, 'Bob Smith', 'Sports Nutrition', 8, 4.500000),
	(3, 'Carol Williams', 'Clinical Nutrition', 15, 4.900000),
	(4, 'David Brown', 'Pediatric Nutrition', 5, 4.200000),
	(5, 'Eve Davis', 'Public Health Nutrition', 12, 4.700000);

-- Dumping structure for table programdiet.nutrisionist_ratings
CREATE TABLE IF NOT EXISTS `nutrisionist_ratings` (
  `id_rating` int NOT NULL AUTO_INCREMENT,
  `id_nutrisionist` int NOT NULL DEFAULT '0',
  `id_user` int NOT NULL DEFAULT '0',
  `comment` varchar(1000) COLLATE armscii8_bin DEFAULT NULL,
  `rating` decimal(20,6) NOT NULL,
  PRIMARY KEY (`id_rating`),
  KEY `FK_nutrisionist_ratings_nutrisionist` (`id_nutrisionist`),
  KEY `FK_nutrisionist_ratings_user` (`id_user`),
  CONSTRAINT `FK_nutrisionist_ratings_nutrisionist` FOREIGN KEY (`id_nutrisionist`) REFERENCES `nutrisionist` (`id_nutrisionist`),
  CONSTRAINT `FK_nutrisionist_ratings_user` FOREIGN KEY (`id_user`) REFERENCES `data_diri` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table programdiet.nutrisionist_ratings: ~5 rows (approximately)
INSERT INTO `nutrisionist_ratings` (`id_rating`, `id_nutrisionist`, `id_user`, `comment`, `rating`) VALUES
	(1, 1, 2, 'Very knowledgeable and helpful.', 4.900000),
	(2, 2, 3, 'Great advice for athletes!', 4.700000),
	(3, 3, 1, 'Helped me with my diet plan.', 4.800000),
	(4, 4, 2, 'Excellent with children’s nutrition.', 4.600000),
	(5, 5, 3, 'Provided valuable public health insights.', 4.700000);

-- Dumping structure for table programdiet.topik
CREATE TABLE IF NOT EXISTS `topik` (
  `id` int NOT NULL AUTO_INCREMENT,
  `judul` text NOT NULL,
  `deskripsi` text,
  `tanggal` datetime NOT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `topik_user` (`id_user`),
  CONSTRAINT `topik_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table programdiet.topik: ~2 rows (approximately)
INSERT INTO `topik` (`id`, `judul`, `deskripsi`, `tanggal`, `id_user`) VALUES
	(2, 'Sakit perut dua hari terakhir', 'Halooooo', '2024-06-18 11:05:23', 1),
	(4, 'Berat badan turun drastis selama 2 hari, apakah sehat?', 'halo ini kenapa woyyyy', '2024-06-18 12:56:35', 1),
	(6, 'hai', 'a', '2024-06-20 00:11:50', 1);

-- Dumping structure for table programdiet.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nama` varchar(255) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL,
  `umur` int NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL DEFAULT '',
  `tinggi_badan` int NOT NULL,
  `berat_badan` int NOT NULL,
  `activity_level` int NOT NULL,
  `calory_needs` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table programdiet.users: ~4 rows (approximately)
INSERT INTO `users` (`id`, `username`, `nama`, `password`, `email`, `level`, `umur`, `no_hp`, `gender`, `tinggi_badan`, `berat_badan`, `activity_level`, `calory_needs`) VALUES
	(1, 'Admin', 'Tini', '12345', 'admin@gmail.com', 'Admin', 20, '82338973448', '0', 189, 60, 0, 2000),
	(2, 'User13', 'Tono', '12345', 'diahaer1320@gmail.com', 'User', 0, '', '', 0, 0, 0, 0),
	(3, 'User3', 'Tina', '12345', 'diahaer1320@gmail.com', 'User', 0, '', '', 0, 0, 0, 0),
	(4, 'User1', 'Titi', '123456', 'diahaer1320@gmail.com', 'User', 0, '', '', 0, 0, 0, 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
