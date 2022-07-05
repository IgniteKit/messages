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
			'settings' => [
				'passive'     => 0,
				'durable'     => 1,
				'exclusive'   => 0,
				'auto_delete' => 0
			]
		]
	]
];