<?php
/**
 * myGengo API Client
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that came
 * with this package in the file LICENSE.txt. It is also available 
 * through the world-wide-web at this URL:
 * http://mygengo.com/services/api/dev-docs/mygengo-code-license
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@mygengo.com so we can send you a copy immediately.
 *
 * @category   myGengo
 * @package    API Client Library
 * @copyright  Copyright (c) 2009-2010 myGengo, Inc. (http://mygengo.com)
 * @license    http://mygengo.com/services/api/dev-docs/mygengo-code-license   New BSD License
 */

class myGengo_Api_Service extends myGengo_Api
{
    /**
     * @param string $api_key the public API key.
     * @param string $private_key the private API key.
     */
    public function __construct($api_key = null, $private_key = null)
    {
        parent::__construct($api_key, $private_key);
    }

    /**
     * translate/service/languages (GET)
     *
     * Returns a list of supported languages and their language codes.
     *
     * @param string $format The OPTIONAL response format: xml or json (default).
     * @param array|string $params (DEPRECATED) If passed should contain all the
     * necessary parameters for the request including the api_key and
     * api_sig
     */
    public function getLanguages($format = null, $params = null)
    {
        $this->setParamsNotId($format, $params);
        $baseurl = $this->config->get('baseurl', null, true);
        $baseurl .= "translate/service/languages/";
        $this->response = $this->client->get($baseurl, $format, $params);
    }

    /**
     * translate/service/language_pairs (GET)
     *
     * Returns supported translation language pairs, tiers, and credit
     * prices.
     *
     * @param string $format The OPTIONAL response format: xml or json (default).
     * @param array|string $params (DEPRECATED) If passed should contain all the
     * necessary parameters for the request including the api_key and
     * api_sig
     */
    public function getLanguagePair($format = null, $params = null)
    {
        $this->setParamsNotId($format, $params);
        $baseurl = $this->config->get('baseurl', null, true);
        $baseurl .= "translate/service/language_pairs/";
        $this->response = $this->client->get($baseurl, $format, $params);
    }

    /**
     * translate/service/quote (POST)
     *
     * Submits a job or group of jobs to quote.
     *
     * @param array $jobs An array of payloads (a payload being itself an array of string)
     * of jobs to create.
     */
    public function quote($jobs)
    {
        $data = array('jobs' => $jobs);

        // create the query
        $params = array('api_key' => $this->config->get('api_key', null, true), '_method' => 'post',
                'ts' => gmdate('U'),
                'data' => json_encode($data));
        // sort and sign
        ksort($params);
        $enc_params = json_encode($params);
        $params['api_sig'] = myGengo_Crypto::sign($enc_params, $this->config->get('private_key', null, true));

        $format = $this->config->get('format', null, true);
        $baseurl = $this->config->get('baseurl', null, true);
        $baseurl .= 'translate/service/quote';
        $this->response = $this->client->post($baseurl, $format, $params);
    }
}
