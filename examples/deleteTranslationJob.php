<?php

/**
 *	Delete a job already sent into myGengo.
 */

require_once '../init.php';

$config = myGengo_Config::getInstance();

/**
 *	Default params for job request. 
 */
$params = array(
	'ts' => gmdate('U'),
	'api_key' => $config->get('api_key', null, true)
);
ksort($params);
$query = http_build_query($params);
$params['api_sig'] = myGengo_Crypto::sign($query, $config->get('private_key', null, true));

/**
 *	Get an instance of Job Client
 */
$job_client = myGengo_Api::factory('job');

/**
 *	Now we can actually delete it...
 */
$job_client->deleteJob($job_id, 'json');

/**
 *	Show the server response in depth if you need it.
 */
echo $job_client->getResponseBody();

/**
 *	End of deleteTranslationJob.php
 */
