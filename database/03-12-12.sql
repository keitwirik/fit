CREATE TABLE IF NOT EXISTS `sessions` (
  `user_id` int(10) NOT NULL,
  `session_id` varchar(50) NOT NULL,
  `last_seen` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
