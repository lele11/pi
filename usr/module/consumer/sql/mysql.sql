CREATE TABLE `{oauth_clientID}` {
	`id` bigint(20) NOT NULL auto_increment,
	`name` varchar(32) NOT NULL,
	`server`  varchar(32) NOT NULL,
	`client_id` varchar(32) NOT NULL,
	`client_secret`	 varchar(32) NOT NULL,
	`server_host` varchar(200) NOT NULL,
	PRIMARY KEY  (`id`)
};

