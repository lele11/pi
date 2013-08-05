<?php
$config = array();

$config['category'] = array(
 	array(
 		'title' => 'general',
 		'name'	=> 'General',
 	),

 );

$config['item'] = array(
 	'client_id' 	 => array(
 		'title' 		=> 'Client Id',
 		'description' 	=> 'this id is generated by oauth server',
 		'edit'			=> 'text',
 		'value'			=> '',
 		'filter'		=> 'LONG',
 		'category'		=> 'general'
 	),
 	'client_secret'	 => array(
 		'title' 		=> 'Client Secret',
 		'description' 	=> 'this secret is generated by oauth server',
 		'edit'			=> 'text',
 		'value'			=> '',
 		'filter'		=> 'LONG',
 		'category'		=> 'general'
 	),
 	'server_name'	 => array(
 		'title'			=> '服务器名称',
 		'description'	=> 'Name of Service Provider',
 		'edit'			=> 'text',
 		'value'			=> '',
 		'filter'		=> 'LONG',
 		'category'		=> 'general',
 	),
 	'server_host'	 => array(
 		'title' 		=> '授权服务器域名',
 		'description' 	=> 'the host of Oauth Server',
 		'edit'			=> 'text',
 		'value'			=> '',
 		'filter'		=> 'LONG',
 		'category'		=> 'general'
 	),
);
return $config;