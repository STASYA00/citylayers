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

INSERT INTO `categories`(`name`, `description`, `color`) VALUES ('Beauty','Reflects how visually appealing and attractive a place is.', 'C4B5F0'), 
('Sound', 'Refers to the pleasantness of noises in a certain place.', 'B1CDEF'), 
('Movement', 'Shows how easy and convenient it is to move around an area, whether you are walking, cycling, or using a wheelchair.', '5DB3B5'), 
('Protection', 'Indicates how safe and protected a place is from traffic and other urban hazards.', '3ACE8E'), 
('Climate comfort', 'Reflects how comfortable the climate feels in an area, considering heat, rain cover, wind shelter and more.', 'A1F7B9;
'),('Activities', 'Represent the usability of a place for the citizens.', 'FFE7A4') ;

INSERT INTO `subcategories`(`name`, `subcategory`, `category`) VALUES ('Buildings',  'Architecture & sights',  1 ),
            ('Landmarks',  'Architecture & sights', 1 ),
            ('Colours',  'Architecture & sights', 1 ),
            ('Street Art',  'Architecture & sights', 1 ),
            ('Trees',  'Nature', 1 ),
            ('Plants',  'Nature', 1 ),
            ('Gardens',  'Nature', 1 ),
            ('Water',  'Nature', 1 ),
            ('Cleanliness',  'Care', 1 ),
            ('Smell',  'Care', 1 ),

            ('Water',  'Nature', 2 ),
            ('Wind',  'Nature', 2 ),
            ('Animals',  'Nature', 2 ),
            ('Voices',  'Human sounds', 2 ),
            ('Crowds',  'Human sounds', 2 ),
            ('Children',  'Human sounds', 2 ),
            ('Music',  'City noises', 2),
            ('Traffic',  'City noises', 2),
            ('Construction',  'City noises', 2),

            ('Walking', 'Accessibility',  3),
            ('Cycling',  'Accessibility', 3 ),
            ('Wheelchair access',  'Accessibility', 3),
            ('Benches',  'Comfort', 3 ),
            ('Stairs',  'Comfort', 3),
            ('Sidewalks',  'Comfort', 3 ),
            ('Crosswalks',  'Connectivity', 3),
            ('Public transport',  'Connectivity', 3),
            ('Wayfinding',  'Connectivity', 3),

            ('Cars',  'Protection from traffic',  4 ),
            ('Visibility',  'Protection from traffic', 4 ),
            ('Traffic signs',  'Protection from traffic',4 ),
            ('Children safety', 'People safety',  4),
            ('Animal safety',  'People safety', 4),
            ('Lighting',  'People safety', 4),
            ('Pavement quality',  'Quality of roads & buildings', 4 ),
            ('Road condition',  'Quality of roads & buildings', 4 ),
            ('Building condition',  'Quality of roads & buildings', 4 ),

            ('Heat',  'Weather',5),
            ('Humidity',  'Weather', 5),
            ('Airflow',  'Weather', 5 ),
            ('Shade',  'Climate protection', 5),
            ('Rain cover',  'Climate protection', 5),
            ('Wind shelter',  'Climate protection', 5),

            ('Sports',  'Everyday activities', 6),
            ('Shopping',  'Everyday activities', 6),
            ('Food',  'Everyday activities', 6 ),
            ('Dog parks', 'Social activities',  6),
            ('Playground',  'Social activities', 6 ),
            ('Relaxation',  'Social activities',6),
            ('Friends meetup', 'Social activities', 6),
            ('Coffee',  'Social activities', 6 ),
            ('Toilet', 'Essential needs', 6 ),
            ('Drinking water', 'Essential needs',  6 );




INSERT INTO `questions`(`category_id`, `question`) VALUES 
(1, 'How would you rate the beauty of this space?' ),
(1, 'Which features of beauty are you rating?' ),
(2, 'What do you think of the sounds around you?' ),
(2, 'Which sounds are you rating?' ),
(3, 'How would you rate the movement around this place?' ),
(3, 'Which aspects of movement are you rating?' ),
(4, 'How would you rate the protection in this place?' ),
(4, 'Which types of protection are you rating?' ),
(5, 'How comfortable do you find the climate here?' ),
(5, 'Which types of climate (protection) are you rating?' ),
(6, 'How enjoyable are the available activities in this area?' ),
(6, 'Which activities are you rating?' );

 ALTER TABLE `places`
	DROP COLUMN name,
	DROP COLUMN image,
	DROP COLUMN parent_id,
    DROP COLUMN description,
    ADD longitude DECIMAL,
    ADD latitude DECIMAL