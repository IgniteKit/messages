<?php

/*******************************/
/*     exchanges Configuration    */
/*******************************/

return [
	'default'  => 'RabbitMQ',
	'adapters' => [
		'RabbitMQ' => [
			'hostname' => 'localhost',
			'username' => 'guest',
			'password' => 'guest',
			'port'     => 5672,
		]
	]
];