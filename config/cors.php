<?php
/**
 * Created by PhpStorm.
 * User: mioji
 * Date: 18/2/6
 * Time: 上午12:54
 */
return [
	/*
	|--------------------------------------------------------------------------
	| Laravel CORS
	|--------------------------------------------------------------------------
	|
	| allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
	| to accept any value.
	|
	*/
	'supportsCredentials' => false,
	'allowedOrigins' => ['*'],
	'allowedHeaders' => ['Content-Type', 'X-Requested-With','token'],
	'allowedMethods' => ['*'], // ex: ['GET', 'POST', 'PUT',  'DELETE']
	'exposedHeaders' => [],
	'maxAge' => 0,
];