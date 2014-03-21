CREATE TABLE IF NOT EXISTS `at_users` (
  u_id int(11) NOT NULL AUTO_INCREMENT,
  type int(11) NOT NULL DEFAULT 2 COMMENT '1 - teacher, 2 - student',
  email varchar(255) NOT NULL DEFAULT '',
  password varchar(32) NOT NULL DEFAULT '',
  fio varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  zip varchar(20) DEFAULT NULL,
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
  s_id int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (u_id)
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