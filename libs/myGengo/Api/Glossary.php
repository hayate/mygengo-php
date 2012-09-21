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

class myGengo_Api_Glossary extends myGengo_Api
{
    /**
     * @param string $api_key the public API key.
     * @param string $private_key the private API key.
     */
    public function __construct($api_key = null, $private_key = null)
    {
        parent::__construct($api_key, $private_key);
    }

	public function downloadGlossary($glossary_id)
	{
        $params = array();
        $params['ts'] = gmdate('U');
        $params['api_key'] = $this->config->get('api_key', null, true);
        $private_key = $this->config->get('private_key', null, true);
        ksort($params);
        $query = http_build_query($params);
        $params['api_sig'] = myGengo_Crypto::sign($query, $private_key);

        $this->setParamsNotId($format, $params);
        $baseurl = $this->config->get('baseurl', null, true);
        $baseurl .= "translate/glossary/download/{$glossary_id}";
        $this->response = $this->client->get($baseurl, $format, $params);
	}

    /**
     * translate/glossary (GET)
     *
     * Retrieves a list of glossaries
     *
     * @param int|string $page_size Either all or the max number of glossary to return
     * @param string $format The response format, xml or json
     */
    public function getGlossaries($page_size = 'all', $format = null)
    {
        $params = array();
        $params['ts'] = gmdate('U');
        $params['page_size'] = $page_size;
        $params['api_key'] = $this->config->get('api_key', null, true);
        $private_key = $this->config->get('private_key', null, true);
        ksort($params);
        $query = http_build_query($params);
        $params['api_sig'] = myGengo_Crypto::sign($query, $private_key);

        $this->setParamsNotId($format, $params);
        $baseurl = $this->config->get('baseurl', null, true);
        $baseurl .= "translate/glossary";
        $this->response = $this->client->get($baseurl, $format, $params);
    }

    /**
     * translate/glossary (GET)
     *
     * Retrieves a list of glossaries
     *
     * @param int|string $page_size Either all or the max number of glossary to return
     * @param string $format The response format, xml or json
     */
    public function getGlossary($glossary_id, $format = null)
    {
        $params = array();
        $params['ts'] = gmdate('U');
        $params['api_key'] = $this->config->get('api_key', null, true);
        $private_key = $this->config->get('private_key', null, true);
        ksort($params);
        $query = http_build_query($params);
        $params['api_sig'] = myGengo_Crypto::sign($query, $private_key);

        $this->setParamsNotId($format, $params);
        $baseurl = $this->config->get('baseurl', null, true);
        $baseurl .= "translate/glossary/{$glossary_id}";
        $this->response = $this->client->get($baseurl, $format, $params);
    }
}
