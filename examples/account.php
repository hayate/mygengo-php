<?php
/**
 * account api example
 * account/balance (GET)
 * account/stats (GET)
 */

require_once '../init.php';

// get configs
$config = myGengo_Config::getInstance();

// create some default parameters
$params = array();
$params['ts'] = gmdate('U');
$params['api_key'] = $config->get('api_key', null, true);
ksort($params);
$query = http_build_query($params);
$params['api_sig'] = myGengo_Crypto::sign($query, $config->get('private_key', null, true));

// get an instance of Account Client
$account = myGengo_Api::factory('account');


/**
 * account/balance (GET)
 * Retrieves account balance in credits
 */
$account->getBalance('json', $params);
// echo back server response
echo $account->getResponseBody();
echo "\n\n";

/**
 * account/stats (GET)
 * Retrieves account stats, such as orders made.
 */
$account->getStats('json', $params);
// echo back server response
echo $account->getResponseBody();
echo "\n\n";