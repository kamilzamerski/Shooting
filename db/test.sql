CREATE TABLE `club` (
  `id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `license_no` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `club` (`id`, `created_at`, `updated_at`, `name`, `license_no`) VALUES
(4, '2018-01-15 21:10:49', '2018-01-15 21:10:49', 'ZKS Warsaw', '1/C/2018'),
(5, '2018-01-15 21:19:49', '2018-01-15 21:19:49', 'Legia Warsaw', '2/C/2018');


ALTER TABLE `club`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `license_no` (`license_no`);


ALTER TABLE `club`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;


CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `club_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `event` (`id`, `created_at`, `updated_at`, `name`, `date`, `club_id`) VALUES
(1, '2018-01-15 21:18:18', '2018-01-15 21:18:18', 'Country Cup', '2018-01-01', 4);


ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `club_id` (`club_id`);


ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`club_id`) REFERENCES `club` (`id`);


CREATE TABLE `shooter` (
`id` int(11) NOT NULL,
`created_at` datetime NOT NULL,
`updated_at` datetime DEFAULT NULL,
`name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`club_id` int(11) NOT NULL,
`license_no` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `shooter` (`id`, `created_at`, `updated_at`, `name`, `club_id`, `license_no`) VALUES
(2, '2018-01-15 21:11:21', '2018-01-15 21:11:21', 'Kamil Zamerski', 4, '1/S/2018'),
(3, '2018-01-15 21:20:22', '2018-01-15 21:20:22', 'Tomek Romek', 4, '2/S/2018'),
(4, '2018-01-15 21:20:41', '2018-01-15 21:20:41', 'Marek Roman', 5, '3/S/2018'),
(5, '2018-01-15 21:21:01', '2018-01-15 21:21:01', 'Antek Szprycha', 5, '7/S/2018');


ALTER TABLE `shooter`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `license_no` (`license_no`),
ADD KEY `club_id` (`club_id`);


ALTER TABLE `shooter`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;


ALTER TABLE `shooter`
ADD CONSTRAINT `shooter_ibfk_1` FOREIGN KEY (`club_id`) REFERENCES `club` (`id`);


CREATE TABLE `result` (
  `id` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `event_id` int(11) NOT NULL,
  `shooter_id` int(11) NOT NULL,
  `competition` int(11) NOT NULL,
  `point_sum` float NOT NULL,
  `time_sum` float DEFAULT NULL,
  `results` json NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `result` (`id`, `created_at`, `updated_at`, `event_id`, `shooter_id`, `competition`, `point_sum`, `time_sum`, `results`) VALUES
(1, '2018-01-15 22:42:01', '2018-01-15 23:04:42', 1, 2, 1, 92, NULL, '{\"in10\": 2, \"points\": {\"0\": 10, \"1\": 10, \"2\": 10, \"3\": 10, \"4\": 9, \"5\": 9, \"6\": 9, \"7\": 9, \"8\": 8, \"9\": 8, \"10\": 7, \"11\": 6, \"12\": 5, \"13\": 4, \"14\": 4}}');


ALTER TABLE `result`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `shooter_id` (`shooter_id`);


ALTER TABLE `result`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `result`
  ADD CONSTRAINT `result_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
  ADD CONSTRAINT `result_ibfk_2` FOREIGN KEY (`shooter_id`) REFERENCES `shooter` (`id`);