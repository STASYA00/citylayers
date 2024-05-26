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

INSERT INTO `categories`(`name`, `description`, `color`) VALUES ('Beauty','Urban Beauty significantly impacts our cities and enhances our quality of life. It goes beyond aesthetics, influencing mental health. Green spaces, harmonious architecture, and inspiring public art contribute to a sense of calm and contentment, making city life more enjoyable. Additionally, beautiful cities foster social connections, attract tourists, and boost property values, creating vibrant and livable urban environments!', 'C4B5F0'), ('Sound', ' It’s not just noise; it’s the heartbeat of the city. From car horns and jackhammers to children playing and street music, these sounds define urban life. They’re not detached from the city; they are the city itself.', 'B1CDEF'), ('Movement', 'Movement within an urban environment is pivotal to its vibrancy and efficiency. This category evaluates the ease of transit, encompassing the availability and accessibility of public transportation, walkability, and cycling infrastructure. It reflects how well a city facilitates the flow of people and goods, ensuring a dynamic and connected urban experience.', '5DB3B5'), 
('Protection', 'Protection assesses the level of safety and risk mitigation within an urban area. It includes factors such as crime rates, emergency services availability, lighting, and infrastructure resilience. A safe city ensures peace of mind for its inhabitants and encourages community engagement', '3ACE8E;
'), ('Climate comfort', 'Climate Comfort evaluates the suitability of a city’s climate for human habitation. It considers factors such as temperature, humidity, air quality, and natural disasters.', 'A1F7B9;
;
'),('Activities', 'Urban Activities assesses the richness of cultural, recreational, and social experiences within a city. It encompasses factors such as the availability of parks, theaters, museums, restaurants, and community events. A thriving urban area fosters diverse activities that enhance residents’ quality of life and attract visitors.', 'FFE7A4;
') ;

INSERT INTO `subcategories`(`id`, `name`, `category_id`) VALUES (0, 'Transportation Networks', 62), (1, 'Pedestrian Infrastructure', 62), 
(2, 'Universal Design', 62), (3, 'Public Facilities', 62), (4, 'Digital Accessibility', 62), (5, 'Affordability', 62);

 ALTER TABLE `places`
	DROP COLUMN name,
	DROP COLUMN image,
	DROP COLUMN parent_id,
    DROP COLUMN description,
    ADD longitude DECIMAL,
    ADD latitude DECIMAL