DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `subcategories`;
CREATE TABLE `subcategories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `grades`;
CREATE TABLE `grades` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `value` decimal(4,3) DEFAULT 0.000,
  `lat` decimal(8,6) DEFAULT 0.000000,
  `lon` decimal(9,6) DEFAULT 0.000000,
  `category_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `subtags`;
CREATE TABLE `subtags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `grade_id` bigint(20) unsigned NOT NULL,
  `lat` decimal(8,6) DEFAULT 0.000000,
  `lon` decimal(9,6) DEFAULT 0.000000,
  `category_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `subcategory_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`grade_id`) REFERENCES `grades` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categories`(`name`, `description`) VALUES ('Accessibility','🏙️ Urban accessibility refers 
to how easy it is for people to get around and interact with cities. It includes things like good public transportation, 
safe sidewalks, and buildings that everyone can use. When cities are designed with accessibility in mind, 
it benefits everyone, not just those with disabilities. 🚶‍♀️🌆'), ('Urban Noise', '🌆 Urban noise refers to all the 
sounds you hear in a city. It includes things like traffic, construction, people talking, and more. Imagine the hustle and 
bustle of a busy street – that’s part of urban noise! 🚗🏙️'), ('Safety', '🏙️ Urban safety is about making sure cities 
are places where everyone can feel secure and relaxed. It’s all about having the right things in place 
to stop accidents and crime from happening. Think of it as the city’s way of giving you a high-five for safety! ✋🌃'), 
('Amenities', '🏙️ Urban amenities are like the little extras that make city life more enjoyable. 
Think of them as the sprinkles on top of an ice cream cone! 🍦');

INSERT INTO `subcategories`(`id`, `name`, `category_id`) VALUES (0, 'Transportation Networks', 62), (1, 'Pedestrian Infrastructure', 62), 
(2, 'Universal Design', 62), (3, 'Public Facilities', 62), (4, 'Digital Accessibility', 62), (5, 'Affordability', 62);