<?php
return [
	
	'default_connection' => 'local',

	'connections' => [

		'local' => [
			'scheme' 	=> 'http',
            'host' 		=> 'localhost',
            'port' 		=> 7474,
            'auth' 		=> false,
            'user' 		=> null,
            'password' 	=> null
		]
	],

	'connection_timeout' => null,
	'auto_format_response' => true

];