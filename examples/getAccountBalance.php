<?php

/**
 *	Get your myGengo account balance.
 */

require_once '../init.php';

$config = myGengo_Config::getInstance();

/**
 *	Default params for request. 
 */
$params = array(
	'ts' => gmdate('U'),
	'api_key' => $config->get('api_key', null, true)
);
ksort($params);
$query = http_build_query($params);
$params['api_sig'] = myGengo_Crypto::sign($query, $config->get('private_key', null, true));

/**
 *	Get an instance of an account Client
 */
$account = myGengo_Api::factory('account');

/**
 *	Now we can actually get it...
 */
$account->getBalance('json', $param); 

/**
 *	Show the server response in depth if you need it.
 */
echo $account->getResponseBody();

/**
 *	End of getAccountBalance.php
 */
