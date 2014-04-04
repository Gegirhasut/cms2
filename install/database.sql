CREATE TABLE IF NOT EXISTS `at_users` (
  u_id int(11) NOT NULL AUTO_INCREMENT,
  subjects int(11) NOT NULL DEFAULT 0,
  email varchar(255) NOT NULL DEFAULT '',
  password varchar(32) NOT NULL DEFAULT '',
  fio varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  phone varchar(100) DEFAULT NULL,
  country int(11) NOT NULL DEFAULT 0,
  city int(11) NOT NULL DEFAULT 0,
  region int(11) NOT NULL DEFAULT 0,
  status int(11) not null DEFAULT 0 COMMENT '0 - not activated, 1 - activated, 2 - bann',
  user_pic varchar(100) DEFAULT NULL,
  skype varchar(100) DEFAULT NULL,
  use_contact_form bool DEFAULT false,
  subscribe bool DEFAULT false,
  info varchar(5000) NOT NULL DEFAULT '',
  messages int(11) DEFAULT 0,
  i_am_teacher bool DEFAULT false,
  last_login timestamp default CURRENT_TIMESTAMP,
  last_notified timestamp default '0000-00-00 00:00:00',
  source_id int(11) DEFAULT NULL,
  PRIMARY KEY (u_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `at_users_autologin` (
  ua_id int(11) NOT NULL AUTO_INCREMENT,
  u_id int(11) NOT NULL,
  code varchar(32) not null,
  page varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (ua_id),
  UNIQUE KEY (u_id, page)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `at_reg_sources` (
  rs_id int(11) NOT NULL AUTO_INCREMENT,
  source varchar(1000) NOT NULL DEFAULT '',
  source_md5 varchar(32) NOT NULL DEFAULT '',
  cnt int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (rs_id),
  UNIQUE (source_md5)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

create table at_activations
(
 a_id int(11) NOT NULL auto_increment,
 u_id int(11) NOT NULL,
 code varchar(32) not null,
 PRIMARY KEY (a_id)
)
ENGINE=MyISAM  DEFAULT CHARSET=utf8;

create table at_change_email
(
 ce_id int(11) NOT NULL auto_increment,
 u_id int(11) NOT NULL,
 code varchar(32) not null,
 email varchar(255) NOT NULL DEFAULT '',
 PRIMARY KEY (ce_id),
 INDEX (code),
 UNIQUE(code, email, u_id)
)
ENGINE=MyISAM  DEFAULT CHARSET=utf8;

create table at_remind_password
(
 rp_id int(11) NOT NULL auto_increment,
 u_id int(11) NOT NULL,
 code varchar(32) not null,
 email varchar(255) NOT NULL DEFAULT '',
 PRIMARY KEY (rp_id),
 INDEX (code),
 UNIQUE(code, email)
)
ENGINE=MyISAM  DEFAULT CHARSET=utf8;

create table at_rubrics
(
 r_id int(11) NOT NULL auto_increment,
 title varchar(30) NOT NULL DEFAULT '',
 r_url varchar(30) NOT NULL DEFAULT '',
 sort  int(11) NOT NULL DEFAULT 9999,
 PRIMARY KEY (r_id),
 INDEX (sort)
)
ENGINE=MyISAM  DEFAULT CHARSET=utf8;

create table at_subjects
(
 s_id int(11) NOT NULL auto_increment,
 subject varchar(50) NOT NULL DEFAULT '',
 subject_po varchar(100) NOT NULL DEFAULT '',
 url varchar(50) NOT NULL DEFAULT '',
 r_id int(11) NOT NULL,
 cnt int(11) NOT NULL,
 PRIMARY KEY (s_id),
 INDEX (url)
)
ENGINE=MyISAM  DEFAULT CHARSET=utf8;

create table at_user_subjects
(
 us_id int(11) NOT NULL auto_increment,
 u_id int(11) NOT NULL,
 s_id int(11) NOT NULL,
 duration int(11) NOT NULL,
 cost double(9,2) NOT NULL,
 PRIMARY KEY (us_id),
 INDEX (u_id),
 UNIQUE(u_id, s_id)
)
ENGINE=MyISAM  DEFAULT CHARSET=utf8;

create table at_pages
(
 s_id int(11) NOT NULL auto_increment,
 title varchar(255) NOT NULL,
 description varchar(255) NOT NULL,
 keywords varchar(255) NOT NULL,
 url varchar(255) NOT NULL,
 text text NOT NULL,
 PRIMARY KEY (s_id)
)
ENGINE=MyISAM  DEFAULT CHARSET=utf8;

create table at_messages
(
 m_id int(11) NOT NULL auto_increment,
 subject varchar(255) NOT NULL DEFAULT '',
 message varchar(5000) NOT NULL DEFAULT '',
 u_id_from int(11) NOT NULL,
 u_id_to int(11) NOT NULL,
 readed boolean DEFAULT 0,
 posted_time timestamp DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (m_id),
 INDEX (u_id_from, posted_time),
 INDEX (u_id_to, posted_time)
)
ENGINE=MyISAM  DEFAULT CHARSET=utf8;

create table at_messages_log
(
 ml_id int(11) NOT NULL auto_increment,
 m_id int(11) NOT NULL,
 show_u int(11) NOT NULL,
 is_out boolean DEFAULT 0,
 another_u int(11) NOT NULL,
 posted_time timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY (ml_id),
 INDEX (show_u, posted_time),
 UNIQUE (show_u, another_u)
)
ENGINE=MyISAM  DEFAULT CHARSET=utf8;

create table at_school_rubrics
(
 sr_id int(11) NOT NULL auto_increment,
 title varchar(30) NOT NULL DEFAULT '',
 r_url varchar(30) NOT NULL DEFAULT '',
 PRIMARY KEY (sr_id)
)
ENGINE=MyISAM  DEFAULT CHARSET=utf8;

create table at_school_subjects
(
 ss_id int(11) NOT NULL auto_increment,
 subject varchar(50) NOT NULL DEFAULT '',
 subject_po varchar(100) NOT NULL DEFAULT '',
 url varchar(50) NOT NULL DEFAULT '',
 sr_id int(11) NOT NULL,
 PRIMARY KEY (ss_id),
 INDEX (url)
)
ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `at_schools` (
  s_id int(11) NOT NULL AUTO_INCREMENT,
  sr_id int(11) DEFAULT NULL,
  email varchar(255) NOT NULL DEFAULT '',
  password varchar(32) NOT NULL DEFAULT '',
  school_name varchar(255) NOT NULL DEFAULT '',
  status int(11) not null DEFAULT 0 COMMENT '0 - not activated, 1 - activated, 2 - bann',
  banner varchar(100) DEFAULT NULL,
  website varchar(100) DEFAULT NULL,
  info varchar(5000) NOT NULL DEFAULT '',
  source_id int(11) DEFAULT NULL,
  PRIMARY KEY (s_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `at_school_addresses` (
  sa_id int(11) NOT NULL AUTO_INCREMENT,
  s_id int(11) DEFAULT NULL,
  phones varchar(100) DEFAULT NULL,
  emails varchar(255) NOT NULL DEFAULT '',
  country int(11) NOT NULL DEFAULT 0,
  city int(11) NOT NULL DEFAULT 0,
  region int(11) NOT NULL DEFAULT 0,
  street varchar(200) NOT NULL DEFAULT '',
  latitude double(9,6) NOT NULL DEFAULT 0,
  longitude double(9,6) NOT NULL DEFAULT 0,
  PRIMARY KEY (sa_id),
  INDEX (s_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

create table at_school_school_subjects
(
 sss_id int(11) NOT NULL auto_increment,
 s_id int(11) NOT NULL,
 ss_id int(11) NOT NULL,
 PRIMARY KEY (sss_id),
 INDEX (s_id),
 UNIQUE(s_id, ss_id)
)
ENGINE=MyISAM  DEFAULT CHARSET=utf8;

create table at_school_activations
(
 sa_id int(11) NOT NULL auto_increment,
 s_id int(11) NOT NULL,
 code varchar(32) not null,
 PRIMARY KEY (sa_id)
)
ENGINE=MyISAM  DEFAULT CHARSET=utf8;

create table at_change_email_school
(
 ces_id int(11) NOT NULL auto_increment,
 s_id int(11) NOT NULL,
 code varchar(32) not null,
 email varchar(255) NOT NULL DEFAULT '',
 PRIMARY KEY (ces_id),
 INDEX (code),
 UNIQUE(code, email, s_id)
)
ENGINE=MyISAM  DEFAULT CHARSET=utf8;

create table at_remind_password_school
(
 rps_id int(11) NOT NULL auto_increment,
 s_id int(11) NOT NULL,
 code varchar(32) not null,
 email varchar(255) NOT NULL DEFAULT '',
 PRIMARY KEY (rps_id),
 INDEX (code),
 UNIQUE(code, email)
)
ENGINE=MyISAM  DEFAULT CHARSET=utf8;
