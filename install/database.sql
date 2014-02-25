CREATE TABLE IF NOT EXISTS `at_users` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) DEFAULT NULL COMMENT '1 - teacher, 2 - student',
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `surname` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `zip` varchar(20) DEFAULT NULL,
  `country_id` int(11) NOT NULL DEFAULT '1',
  `city` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
   city_id int(11) NOT NULL DEFAULT '1',
  `raion` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `status` int(11) not null DEFAULT 0 COMMENT '0 - not activated, 1 - activated, 2 - bann',
  `user_pic` varchar(100) DEFAULT NULL,
  `skype` varchar(100) DEFAULT NULL,
  `price` decimal(18,2) DEFAULT '0.00',
  `use_contact_form` tinyint(1) DEFAULT '0',
  `info` varchar(5000) DEFAULT NULL,
  PRIMARY KEY (`u_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

create table at_cities
(
 city_id int(11) NOT NULL auto_increment,
 city varchar(80) NOT NULL DEFAULT '',
 latitude float (10,6) null,
 longitude float (10,6) null,
 zoom int default 12,
 PRIMARY KEY (city_id)
)
ENGINE=MyISAM  DEFAULT CHARSET=utf8;

create table at_countries
(
 c_id int(11) NOT NULL auto_increment,
 country varchar(80) not null,
 PRIMARY KEY (c_id)
)
ENGINE=MyISAM  DEFAULT CHARSET=utf8;
