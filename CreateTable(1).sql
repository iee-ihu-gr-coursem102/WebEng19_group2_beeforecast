--

-- Table structure for table `users`

--

CREATE TABLE IF NOT EXISTS `users` (

  `id` int(8) NOT NULL AUTO_INCREMENT,

  `username` varchar(55) NOT NULL,

  `first_name` varchar(55) NOT NULL,

  `last_name` varchar(55) NOT NULL,

  `password` varchar(50) NOT NULL,

  `email` varchar(55) NOT NULL,

  `role` int NOT NULL DEFAULT 0,

  PRIMARY KEY (`id`)

);

--

-- Table structure for table `beehive`

--

CREATE TABLE IF NOT EXISTS `beehive` (

  `id` int(10) NOT NULL AUTO_INCREMENT,

  `location` varchar(55) NOT NULL,

  `muncipality` varchar(55) NOT NULL,

  `area` varchar(55) NOT NULL,

  `user_id` int(8) NOT NULL,

  `plithos_kipselwn` int(4) NOT NULL,

  `info` varchar(55) NOT NULL,

  PRIMARY KEY (`id`),

  FOREIGN KEY (`id`) REFERENCES users(`id`) 

);



--

-- Administrator record

--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `password`, `email`, `role`) VALUES

('1','admin','The', 'Administrator','123', 'admin@admin.gr','1');

© 2020 GitHub, Inc.
Terms
Privacy
Security
Status
Help
