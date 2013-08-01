CREATE TABLE `{oauth_client}` (
	`id` bigint(20) NOT NULL auto_increment,
	`module` varchar(32) NOT NULL,
	`server`  varchar(32) NOT NULL,
	`client_id` varchar(32) NOT NULL,
	`client_secret`	 varchar(32) NOT NULL,
	`server_host` varchar(200) NOT NULL,
	`create_time` int(11) NOT NULL,
	PRIMARY KEY  (`id`)
);

