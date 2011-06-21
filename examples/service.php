<?php
/**
 * service api example
 * translate/service/languages (GET)
 * translate/service/language_pairs (GET)
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

// get an instance of Service Client
$service = myGengo_Api::factory('service');

/**
 * translate/service/languages (GET)
 * Returns a list of supported languages and their language codes.
 */
$service->getLanguages('json', $params);
// echo back server response
echo $service->getResponseBody();
echo "\n\n";

/**
 * translate/service/language_pairs (GET)
 * Returns supported translation language pairs, tiers, and credit
 * prices.
 */
$service->getLanguagePair('json', $params);
// echo back server response
echo $service->getResponseBody();
echo "\n\n";