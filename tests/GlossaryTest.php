<?php

require_once '../init.php';

class GlossaryTest extends PHPUnit_Framework_TestCase
{
    protected $key;
    protected $secret;

    public function setUp()
    {
        $this->key = '$A|jE1=#4mataA_mDicSboIn$s7C)^eKJz|opJDmwJ}-th{[OzMmo2KyNQO-Y(0i';
        $this->secret = 'njI0j1nYh(]{5RVJ7h#[~ja~^m5xfXA9Dpox)IG}oq6Hyiwv])Pt=gWmYtgCcA#U';
    }

	public function test_download_glossary()
	{
		$glossary_id = 394;
        $glossary = myGengo_Api::factory('glossary', $this->key, $this->secret);
        $glossary->setBaseUrl('http://mygengo.andrea/v1/');
        $glossary->downloadGlossary($glossary_id);

        $body = $glossary->getResponseBody();
        $response = json_decode($body, true);
        if (empty($response))
        {
            printf("%s\n", 'Response could not be json decoded.');
			if (is_array($body))
			{
				printf("%s\n", 'body is an array');
				foreach ($body as $key => $val)
				{
					printf("%s -> %s\n", $key, $val);
				}
			}
			else {
				printf('%s\n', 'body is not and array');
				if (is_string($body))
				{
					printf('%s\n', 'body is a string');
				}
			}
            printf("%s\n", $body);
        }
		printf("%s\n", $body);
	}

    public function xxxx_get_glossaries_v1()
    {
        $glossary = myGengo_Api::factory('glossary', $this->key, $this->secret);
        $glossary->setBaseUrl('http://mygengo.andrea/v1/');

        $page_size = 10;
        $glossary->getGlossaries($page_size);

        $body = $glossary->getResponseBody();
        $response = json_decode($body, true);
        if (empty($response))
        {
            printf("%s\n", 'response could not be json decoded.');
            printf("%s\n", $body);
        }

        $this->assertEquals('ok', $response['opstat']);
        $this->assertTrue(isset($response['response']));
        $this->assertTrue(is_array($response['response']));
    }

    public function xxxx_get_glossaries_v2()
    {
        $glossary = myGengo_Api::factory('glossary', $this->key, $this->secret);
        $glossary->setBaseUrl('http://mygengo.andrea/v2/');

        $page_size = 10;
        $glossary->getGlossaries($page_size);

        $body = $glossary->getResponseBody();
        $response = json_decode($body, true);
        if (empty($response))
        {
            printf("%s\n", 'response could not be json decoded.');
            printf("%s\n", $body);
        }

        $this->assertEquals('ok', $response['opstat']);
        $this->assertTrue(isset($response['response']));
        $this->assertTrue(is_array($response['response']));
    }

    public function xxxx_retrieve_glossary()
    {
        // to do this test we first retrieve many glossary then we retrieve one by one
        $glossary = myGengo_Api::factory('glossary', $this->key, $this->secret);
        $glossary->setBaseUrl('http://mygengo.andrea/v2/');

        $page_size = 10;
        // retrieve all the glossary at once
        $glossary->getGlossaries($page_size);

        $body = $glossary->getResponseBody();
        $response = json_decode($body, true);
        if (empty($response))
        {
            printf("%s\n", 'response could not be json decoded.');
            printf("%s\n", $body);
            return;
        }

        $this->assertTrue(isset($response['response']));
        $this->assertEquals($response['opstat'], 'ok');
        $this->assertTrue(isset($response['response']));
        $this->assertTrue(is_array($response['response']));

        // retrieve glossaries one by one
        foreach ($response['response'] as $gloss)
        {
            $glossary->getGlossary($gloss['id']);
            $body = $glossary->getResponseBody();
            $res = json_decode($body, true);
            if ( empty($res))
            {
                printf("Response could not be json decode:\n %s\n", $body);
                return;
            }
            $this->assertTrue(isset($res['response']));
            $this->assertEquals($res['opstat'], 'ok');
            $this->assertTrue(isset($res['response']));
            $this->assertTrue(is_array($res['response']));
        }
    }

    public function xxxx_use_glossary()
    {
        $glossary = myGengo_Api::factory('glossary', $this->key, $this->secret);
        $glossary->setBaseUrl('http://mygengo.andrea/v1/');

        $page_size = 10;
        $glossary->getGlossaries($page_size);

        $body = $glossary->getResponseBody();
        $response = json_decode($body, true);
        if (empty($response))
        {
            printf("%s\n", 'response could not be json decoded.');
            printf("%s\n", $body);
            return;
        }
        $this->assertTrue(isset($response['response']));
        $this->assertEquals($response['opstat'], 'ok');
        $this->assertTrue(isset($response['response']));
        $this->assertTrue(is_array($response['response']));


        $job1 = array(
                'type' => 'text',
                'slug' => 'API Job test',
                //'body_src' => 'Liverpool Football Club is an English Premier League football club based in Liverpool, Merseyside. Liverpool is awesome and is the best club around. Liverpool was founded in 1892 and admitted into the Football League the following year. The club has played at its home ground, Anfield, since its founding, and the team has played in an all-red home strip since 1964. Domestically, Liverpool has won eighteen league titles - the second most in English football - as well as seven FA Cups, a record eight League Cups and fifteen FA Community Shields. Liverpool has also won more European titles than any other English club, with five European Cups, three UEFA Cups and three UEFA Super Cups.',
                'body_src' => 'Hello Forza Roma',
                'lc_src' => 'en',
                'lc_tgt' => 'ja',
                'tier' => 'standard',
                'glossary_id' => $response['response'][0]['id'],
                'force' => 1, // optional. Default to 0.
                // 'auto_approve' => 1, // optional. Default to 0.
                'custom_data' => '1234567日本語'
                );

        $job2 = array(
                'type' => 'text',
                'slug' => 'API Job test',
                'body_src' => 'Liverpool Football Club is an English Premier League football club based in Liverpool, Merseyside. Liverpool is awesome and is the best club around. Liverpool was founded in 1892 and admitted into the Football League the following year. The club has played at its home ground, Anfield, since its founding, and the team has played in an all-red home strip since 1964. Domestically, Liverpool has won eighteen league titles - the second most in English football - as well as seven FA Cups, a record eight League Cups and fifteen FA Community Shields. Liverpool has also won more European titles than any other English club, with five European Cups, three UEFA Cups and three UEFA Super Cups.',
                'lc_src' => 'en',
                'lc_tgt' => 'ja',
                'tier' => 'standard',
                'glossary_id' => $response['response'][0]['id'],
                'force' => 1, // optional. Default to 0.
                // 'auto_approve' => 1, // optional. Default to 0.
                'custom_data' => '1234567日本語',
                );

        $jobs = array($job1, $job2);

        // Get an instance of Jobs Client
        $job_client = myGengo_Api::factory('jobs', $this->key, $this->secret);
        $job_client->setBaseUrl('http://mygengo.andrea/v1/');

        // Post the jobs. The second parameter is optional and determinates whether or
        // not the jobs are submitted as a group (default: false).
        $job_client->postJobs($jobs, false);

        // Display the server response.
        $body = $job_client->getResponseBody();
        $response = json_decode($body, true);
        if (empty($response))
        {
            printf("%s\n", 'response could not be json decoded.');
            printf("%s\n", $body);
            return;
        }
        else if ($response['opstat'] != 'ok')
        {
            printf("%s\n", 'server response error: ');
            print_r($response);
            return;
        }

        $this->assertTrue(isset($response['response']));
        $this->assertEquals($response['opstat'], 'ok');
        $this->assertTrue(isset($response['response']));
        $this->assertTrue(is_array($response['response']));
    }
}
