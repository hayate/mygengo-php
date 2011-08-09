<?php

/**
 *	Get the status of a myGengo job.
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
 *	Get an instance of an job Client
 */
$mygengo = myGengo_Api::factory('job');
$job_id = 42;

/**
 *	Now we can actually get it...
 */
$mygengo->getJob($job_id, 'json', $params); 

/**
 *	Show the server response in depth if you need it.
 */
echo $mygengo->getResponseBody();

/**
 *	End of getTranslationJob.php
 */
