<?php

require_once '../init.php';

class JobTest extends PHPUnit_Framework_TestCase
{
    private $key;
    private $secret;

    public function setUp()
    {
        $this->key = 'gOG6~PZq3Y{1On$C8evx(~I|1TzaHE3zlagsq-#U(-P2-6KZUVneT9OvX47i)rwv';
        $this->secret = 'MPkp0)jV(3ad~DkcJQ)j@wz4TVEBJdLyIhKfT]Mr$g-[2Np]qQ[UmXhY^syA$H]e';
    }

    public function test_post_job_force_true_v2()
    {
        $job = array(
            'type' => 'text',
            'slug' => 'API Job test',
            'body_src' => 'Please translate this text form English to Japanese, thank you.',
            'lc_src' => 'en',
            'lc_tgt' => 'ja',
            'tier' => 'standard',
			//'content_type' => 'html',
			'content_type' => 'wysiwyg_html',
            'force' => 1, // optional. Default to 0.
            // 'auto_approve' => 1, // optional. Default to 0.
            // 'custom_data' => 'i should have html content_type',
			'custom_data' => 'i should have wysiwyg_html content_type',
            'max_chars' => 140,
            );

        // Get an instance of Job Client
        $job_client = myGengo_Api::factory('job', $this->key, $this->secret);
        $job_client->setBaseUrl('http://gengo.andrea/v2/');
        // $job_client->setBaseUrl('http://qa.gengo.com/v1/');

        // Post a new job.
        $job_client->postJob($job);

        // Display the server response.
        $body = $job_client->getResponseBody();
        $response = json_decode($body, true);
        if (empty($response))
        {
            printf("%s\n", 'Failed to parse json response');
            printf("%s\n", $body);
        }
        else {
            $this->assertTrue(isset($response['opstat']));
            $this->assertEquals($response['opstat'], 'ok');
        }
    }

    public function xxxx_post_job_force_false()
    {
        $job = array(
            'type' => 'text',
            'slug' => 'API Job test',
            'body_src' => 'Please translate this text form English to Japanese, thank you.',
            'lc_src' => 'en',
            'lc_tgt' => 'ja',
            'tier' => 'standard',
			//'content_type' => 'html',
			'content_type' => 'wysiwyg_html',
            'force' => 0, // optional. Default to 0.
            // 'auto_approve' => 1, // optional. Default to 0.
            // 'custom_data' => 'i should have html content_type',
			'custom_data' => 'i should have wysiwyg_html content_type',
            'max_chars' => 140,
            );

        // Get an instance of Job Client
        $job_client = myGengo_Api::factory('job', $this->key, $this->secret);
        $job_client->setBaseUrl('http://gengo.andrea/v1/');
        // $job_client->setBaseUrl('http://qa.gengo.com/v1/');

        // Post a new job.
        $job_client->postJob($job);

        // Display the server response.
        $body = $job_client->getResponseBody();
        $response = json_decode($body, true);
        if (empty($response))
        {
            printf("%s\n", 'Failed to parse json response');
            printf("%s\n", $body);
        }
        else {
            $this->assertTrue(isset($response['opstat']));
            $this->assertEquals($response['opstat'], 'ok');
        }
    }

    public function xxxx_post_job_force_true()
    {
        $job = array(
            'type' => 'text',
            'slug' => 'API Job test',
            'body_src' => 'Please translate this text form English to Japanese, thank you.',
            'lc_src' => 'en',
            'lc_tgt' => 'ja',
            'tier' => 'standard',
			//'content_type' => 'html',
			'content_type' => 'wysiwyg_html',
            'force' => 1, // optional. Default to 0.
            // 'auto_approve' => 1, // optional. Default to 0.
            // 'custom_data' => 'i should have html content_type',
			'custom_data' => 'i should have wysiwyg_html content_type',
            'max_chars' => 140,
            );

        // Get an instance of Job Client
        $job_client = myGengo_Api::factory('job', $this->key, $this->secret);
        $job_client->setBaseUrl('http://gengo.andrea/v1/');
        // $job_client->setBaseUrl('http://qa.gengo.com/v1/');

        // Post a new job.
        $job_client->postJob($job);

        // Display the server response.
        $body = $job_client->getResponseBody();
        $response = json_decode($body, true);
        if (empty($response))
        {
            printf("%s\n", 'Failed to parse json response');
            printf("%s\n", $body);
        }
        else {
            $this->assertTrue(isset($response['opstat']));
            $this->assertEquals($response['opstat'], 'ok');
        }
    }

    public function xxxx_post_jobs_max_chars_success_v2()
    {
        $job1 = array(
                'type' => 'text',
                'slug' => 'API Job test',
                'body_src' => 'Liverpool Football Club is an English Premier League football club based in Liverpool, Merseyside. Liverpool is awesome and is the best club around. Liverpool was founded in 1892 and admitted into the Football League the following year. The club has played at its home ground, Anfield, since its founding, and the team has played in an all-red home strip since 1964. Domestically, Liverpool has won eighteen league titles - the second most in English football - as well as seven FA Cups, a record eight League Cups and fifteen FA Community Shields. Liverpool has also won more European titles than any other English club, with five European Cups, three UEFA Cups and three UEFA Super Cups.',
                'lc_src' => 'en',
                'lc_tgt' => 'ja',
                'tier' => 'standard',
                'force' => 1, // optional. Default to 0.
                // 'auto_approve' => 1, // optional. Default to 0.
                'custom_data' => '1234567日本語',
                'max_chars' => 140, 
                );

        $job2 = array(
                'type' => 'text',
                'slug' => 'API Job test',
                'body_src' => 'Liverpool Football Club is an English Premier League football club based in Liverpool, Merseyside. Liverpool is awesome and is the best club around. Liverpool was founded in 1892 and admitted into the Football League the following year. The club has played at its home ground, Anfield, since its founding, and the team has played in an all-red home strip since 1964. Domestically, Liverpool has won eighteen league titles - the second most in English football - as well as seven FA Cups, a record eight League Cups and fifteen FA Community Shields. Liverpool has also won more European titles than any other English club, with five European Cups, three UEFA Cups and three UEFA Super Cups.',
                'lc_src' => 'en',
                'lc_tgt' => 'ja',
                'tier' => 'standard',
                'force' => 1, // optional. Default to 0.
                // 'auto_approve' => 1, // optional. Default to 0.
                'custom_data' => '1234567日本語',
                'max_chars' => 200, 
                );

        $jobs = array($job1, $job2);

        // Get an instance of Jobs Client
        $job_client = myGengo_Api::factory('jobs', $this->key, $this->secret);
        $job_client->setBaseUrl('http://gengo.andrea/v2/');

        // Post the jobs. The second parameter is optional and determinates whether or
        // not the jobs are submitted as a group (default: false).
        $job_client->postJobs($jobs, true);

        // server respone
        $body = $job_client->getResponseBody();
        $response = json_decode($body, true);
        if (empty($response))
        {
            printf("%s\n", 'Failed to parse json response');
            printf("%s\n", $body);            
        }
        else {
            $this->assertTrue(isset($response['opstat']));
            $this->assertEquals($response['opstat'], 'ok');
        }
    }

    public function xxxx_post_jobs_max_chars_failure_v2()
    {
        $job1 = array(
                'type' => 'text',
                'slug' => 'API Job test',
                'body_src' => 'Liverpool Football Club is an English Premier League football club based in Liverpool, Merseyside. Liverpool is awesome and is the best club around. Liverpool was founded in 1892 and admitted into the Football League the following year. The club has played at its home ground, Anfield, since its founding, and the team has played in an all-red home strip since 1964. Domestically, Liverpool has won eighteen league titles - the second most in English football - as well as seven FA Cups, a record eight League Cups and fifteen FA Community Shields. Liverpool has also won more European titles than any other English club, with five European Cups, three UEFA Cups and three UEFA Super Cups.',
                'lc_src' => 'en',
                'lc_tgt' => 'ja',
                'tier' => 'standard',
                'force' => 1, // optional. Default to 0.
                // 'auto_approve' => 1, // optional. Default to 0.
                'custom_data' => '1234567日本語',
                'max_chars' => 'hello', 
                );

        $job2 = array(
                'type' => 'text',
                'slug' => 'API Job test',
                'body_src' => 'Liverpool Football Club is an English Premier League football club based in Liverpool, Merseyside. Liverpool is awesome and is the best club around. Liverpool was founded in 1892 and admitted into the Football League the following year. The club has played at its home ground, Anfield, since its founding, and the team has played in an all-red home strip since 1964. Domestically, Liverpool has won eighteen league titles - the second most in English football - as well as seven FA Cups, a record eight League Cups and fifteen FA Community Shields. Liverpool has also won more European titles than any other English club, with five European Cups, three UEFA Cups and three UEFA Super Cups.',
                'lc_src' => 'en',
                'lc_tgt' => 'ja',
                'tier' => 'standard',
                'force' => 1, // optional. Default to 0.
                // 'auto_approve' => 1, // optional. Default to 0.
                'custom_data' => '1234567日本語',
                'max_chars' => 'world', 
                );

        $jobs = array($job1, $job2);

        // Get an instance of Jobs Client
        $job_client = myGengo_Api::factory('jobs', $this->key, $this->secret);
        $job_client->setBaseUrl('http://gengo.andrea/v2/');

        // Post the jobs. The second parameter is optional and determinates whether or
        // not the jobs are submitted as a group (default: false).
        $job_client->postJobs($jobs, true);

        // server respone
        $body = $job_client->getResponseBody();
        $response = json_decode($body, true);
        if (empty($response))
        {
            printf("%s\n", 'Failed to parse json response');
            printf("%s\n", $body);            
        }
        else {
            $this->assertTrue(isset($response['opstat']));
            $this->assertEquals($response['opstat'], 'error');
            foreach ($response['err'] as $err)
            {
                $key = key($err);
                $this->assertEquals($err[$key]['code'], 1353);
            }
        }
    }


    public function xxxx_post_jobs_max_chars_success()
    {
        $job1 = array(
                'type' => 'text',
                'slug' => 'API Job test',
                'body_src' => 'Liverpool Football Club is an English Premier League football club based in Liverpool, Merseyside. Liverpool is awesome and is the best club around. Liverpool was founded in 1892 and admitted into the Football League the following year. The club has played at its home ground, Anfield, since its founding, and the team has played in an all-red home strip since 1964. Domestically, Liverpool has won eighteen league titles - the second most in English football - as well as seven FA Cups, a record eight League Cups and fifteen FA Community Shields. Liverpool has also won more European titles than any other English club, with five European Cups, three UEFA Cups and three UEFA Super Cups.',
                'lc_src' => 'en',
                'lc_tgt' => 'ja',
                'tier' => 'standard',
                'force' => 1, // optional. Default to 0.
                // 'auto_approve' => 1, // optional. Default to 0.
                'custom_data' => '1234567日本語',
                'max_chars' => 140, 
                );

        $job2 = array(
                'type' => 'text',
                'slug' => 'API Job test',
                'body_src' => 'Liverpool Football Club is an English Premier League football club based in Liverpool, Merseyside. Liverpool is awesome and is the best club around. Liverpool was founded in 1892 and admitted into the Football League the following year. The club has played at its home ground, Anfield, since its founding, and the team has played in an all-red home strip since 1964. Domestically, Liverpool has won eighteen league titles - the second most in English football - as well as seven FA Cups, a record eight League Cups and fifteen FA Community Shields. Liverpool has also won more European titles than any other English club, with five European Cups, three UEFA Cups and three UEFA Super Cups.',
                'lc_src' => 'en',
                'lc_tgt' => 'ja',
                'tier' => 'standard',
                'force' => 1, // optional. Default to 0.
                // 'auto_approve' => 1, // optional. Default to 0.
                'custom_data' => '1234567日本語',
                'max_chars' => 200, 
                );

        $jobs = array($job1, $job2);

        // Get an instance of Jobs Client
        $job_client = myGengo_Api::factory('jobs', $this->key, $this->secret);
        $job_client->setBaseUrl('http://gengo.andrea/v1/');

        // Post the jobs. The second parameter is optional and determinates whether or
        // not the jobs are submitted as a group (default: false).
        $job_client->postJobs($jobs, true);

        // server respone
        $body = $job_client->getResponseBody();
        $response = json_decode($body, true);
        if (empty($response))
        {
            printf("%s\n", 'Failed to parse json response');
            printf("%s\n", $body);            
        }
        else {
            $this->assertTrue(isset($response['opstat']));
            $this->assertEquals($response['opstat'], 'ok');
        }
    }

    public function xxxx_post_jobs_max_chars_failure()
    {
        $job1 = array(
                'type' => 'text',
                'slug' => 'API Job test',
                'body_src' => 'Liverpool Football Club is an English Premier League football club based in Liverpool, Merseyside. Liverpool is awesome and is the best club around. Liverpool was founded in 1892 and admitted into the Football League the following year. The club has played at its home ground, Anfield, since its founding, and the team has played in an all-red home strip since 1964. Domestically, Liverpool has won eighteen league titles - the second most in English football - as well as seven FA Cups, a record eight League Cups and fifteen FA Community Shields. Liverpool has also won more European titles than any other English club, with five European Cups, three UEFA Cups and three UEFA Super Cups.',
                'lc_src' => 'en',
                'lc_tgt' => 'ja',
                'tier' => 'standard',
                'force' => 1, // optional. Default to 0.
                // 'auto_approve' => 1, // optional. Default to 0.
                'custom_data' => '1234567日本語',
                'max_chars' => 'hello', 
                );

        $job2 = array(
                'type' => 'text',
                'slug' => 'API Job test',
                'body_src' => 'Liverpool Football Club is an English Premier League football club based in Liverpool, Merseyside. Liverpool is awesome and is the best club around. Liverpool was founded in 1892 and admitted into the Football League the following year. The club has played at its home ground, Anfield, since its founding, and the team has played in an all-red home strip since 1964. Domestically, Liverpool has won eighteen league titles - the second most in English football - as well as seven FA Cups, a record eight League Cups and fifteen FA Community Shields. Liverpool has also won more European titles than any other English club, with five European Cups, three UEFA Cups and three UEFA Super Cups.',
                'lc_src' => 'en',
                'lc_tgt' => 'ja',
                'tier' => 'standard',
                'force' => 1, // optional. Default to 0.
                // 'auto_approve' => 1, // optional. Default to 0.
                'custom_data' => '1234567日本語',
                'max_chars' => 'world', 
                );

        $jobs = array($job1, $job2);

        // Get an instance of Jobs Client
        $job_client = myGengo_Api::factory('jobs', $this->key, $this->secret);
        $job_client->setBaseUrl('http://gengo.andrea/v1/');

        // Post the jobs. The second parameter is optional and determinates whether or
        // not the jobs are submitted as a group (default: false).
        $job_client->postJobs($jobs, true);

        // server respone
        $body = $job_client->getResponseBody();
        $response = json_decode($body, true);
        if (empty($response))
        {
            printf("%s\n", 'Failed to parse json response');
            printf("%s\n", $body);            
        }
        else {
            $this->assertTrue(isset($response['opstat']));
            $this->assertEquals($response['opstat'], 'error');
            $this->assertEquals($response['err']['code'], 1353);            
        }
    }

    public function xxxx_post_job_max_chars_failure()
    {
        $job = array(
            'type' => 'text',
            'slug' => 'API Job test',
            'body_src' => 'Please translate this text form English to Japanese, thank you.',
            'lc_src' => 'en',
            'lc_tgt' => 'ja',
            'tier' => 'standard',
			//'content_type' => 'html',
			'content_type' => 'wysiwyg_html',
            'force' => 1, // optional. Default to 0.
            // 'auto_approve' => 1, // optional. Default to 0.
            // 'custom_data' => 'i should have html content_type',
			'custom_data' => 'i should have wysiwyg_html content_type',
            // here max char is a string
            'max_chars' => 'hello',
            );

        // Get an instance of Job Client
        $job_client = myGengo_Api::factory('job', $this->key, $this->secret);
        $job_client->setBaseUrl('http://gengo.andrea/v1/');
        // $job_client->setBaseUrl('http://qa.gengo.com/v1/');

        // Post a new job.
        $job_client->postJob($job);

        // Display the server response.
        $body = $job_client->getResponseBody();
        $response = json_decode($body, true);
        if (empty($response))
        {
            printf("%s\n", 'Failed to parse json response');
            printf("%s\n", $body);
        }
        else {
            $this->assertTrue(isset($response['opstat']));
            $this->assertEquals($response['opstat'], 'error');
            $this->assertEquals($response['err']['code'], 1353);
        }
    }

    public function xxxx_post_job_max_chars_success()
    {
        $job = array(
            'type' => 'text',
            'slug' => 'API Job test',
            'body_src' => 'Please translate this text form English to Japanese, thank you.',
            'lc_src' => 'en',
            'lc_tgt' => 'ja',
            'tier' => 'standard',
			//'content_type' => 'html',
			'content_type' => 'wysiwyg_html',
            'force' => 1, // optional. Default to 0.
            // 'auto_approve' => 1, // optional. Default to 0.
            // 'custom_data' => 'i should have html content_type',
			'custom_data' => 'i should have wysiwyg_html content_type',
            'max_chars' => 140,
            );

        // Get an instance of Job Client
        $job_client = myGengo_Api::factory('job', $this->key, $this->secret);
        $job_client->setBaseUrl('http://gengo.andrea/v1/');
        // $job_client->setBaseUrl('http://qa.gengo.com/v1/');

        // Post a new job.
        $job_client->postJob($job);

        // Display the server response.
        $body = $job_client->getResponseBody();
        $response = json_decode($body, true);
        if (empty($response))
        {
            printf("%s\n", 'Failed to parse json response');
            printf("%s\n", $body);
        }
        else {
            $this->assertTrue(isset($response['opstat']));
            $this->assertEquals($response['opstat'], 'ok');
        }
    }

    public function xxxx_approve_job()
    {
        $job = array(
            'type' => 'text',
            'slug' => 'API Job test',
            'body_src' => 'Please translate this text form English to Japanese, thank you.',
            'lc_src' => 'en',
            'lc_tgt' => 'ja',
            'tier' => 'standard',
			//'content_type' => 'html',
			'content_type' => 'wysiwyg_html',
            'force' => 1, // optional. Default to 0.
            // 'auto_approve' => 1, // optional. Default to 0.
            // 'custom_data' => 'i should have html content_type',
			'custom_data' => 'i should have wysiwyg_html content_type',
            );

        // Get an instance of Job Client
        $job_client = myGengo_Api::factory('job', $this->key, $this->secret);
        $job_client->setBaseUrl('http://gengo.andrea/v1/');
        // $job_client->setBaseUrl('http://qa.gengo.com/v1/');

        // Post a new job.
        $job_client->postJob($job);

        // Display the server response.
        $body = $job_client->getResponseBody();
        $response = json_decode($body, true);
        if (! $response)
        {
            printf("%s\n", 'Failed to parse json response');
            printf("%s\n", $body);
        }
        else {
            $this->assertTrue(isset($response['opstat']));
            printf("%s\n", print_r($response, true));
        }        

        $job_id = $response['response']['job']['job_id'];
        $payload = array('rating' => 5,
                         'for_translator' => 'Thanks, nice translation.',
                         'for_mygengo' =>'myGengo really gives me great satisfaction!',
                         'public' => 1,);
        $job_client->approve($job_id, $payload);
        $body = $job_client->getResponseBody();
        $response = json_decode($body, true);
    }
}
