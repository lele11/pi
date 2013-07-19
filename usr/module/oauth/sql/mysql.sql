CREATE TABLE `{client}` (
  `id` bigint(20) NOT NULL auto_increment,
  `client_id` varchar(32) NOT NULL,
  `client_name` varchar(32) NOT NULL,
  `client_secret` varchar(32) NOT NULL,
  `uid` bigint(20) NOT NULL,
  `redirect_uri` varchar(200) NOT NULL,
  `type` varchar(32) NOT NULL,
  `scope` varchar(32) NOT NULL,
  `grant_type` varchar(32) NOT NULL,
  `client_desc` varchar(200),
  `time_create` int(20) default NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE `{authorization_code}` (
  `id` bigint(20) NOT NULL auto_increment,
  `client_id` varchar(32) NOT NULL,
  `scope` varchar(32) NOT NULL,
  `resource_owner` varchar(32) NOT NULL,
  `redirect_uri` varchar(32) NOT NULL,
  `code` varchar(40) NOT NULL,  
  `expires` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ;

CREATE TABLE `{access_token}` (
  `id` bigint(20) NOT NULL auto_increment,
  `client_id` varchar(32) NOT NULL,
  `resource_owner` varchar(32) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires` int(11) NOT NULL,
  `scope` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE `{refresh_token}` (
  `id` bigint(20) NOT NULL auto_increment,
  `client_id` varchar(32) NOT NULL,
  `resource_owner` varchar(32) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);


CREATE TABLE `{user_authorization}` (
  `id` bigint(20) NOT NULL auto_increment,
  `cid` varchar(32) NOT NULL,
  `uid` varchar(32) NOT NULL,
  `scope` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
);

