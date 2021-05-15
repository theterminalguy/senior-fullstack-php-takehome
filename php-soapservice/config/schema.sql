CREATE TABLE `companies` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `created_at` timestamp,
  `updated_at` timestamp,
  `name` varchar(255),
  `email` varchar(255),
  `logo_url` varchar(255),
  `address` varchar(255),
  `country` varchar(255),
  `tax_rate` decimal(5,2)
);
