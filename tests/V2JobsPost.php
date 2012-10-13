<?php

require_once '../init.php';

class PostJobsTest extends PHPUnit_Framework_TestCase
{
    private $key;
    private $secret;

    public function setUp()
    {
        $this->key = '$A|jE1=#4mataA_mDicSboIn$s7C)^eKJz|opJDmwJ}-th{[OzMmo2KyNQO-Y(0i';
        $this->secret = 'njI0j1nYh(]{5RVJ7h#[~ja~^m5xfXA9Dpox)IG}oq6Hyiwv])Pt=gWmYtgCcA#U';
    }

    public function test_post_jobs()
    {
        $job1 = array(
                'type' => 'text',
                'slug' => 'API Liverpool 1',
                'body_src' => 'Liverpool_1 Football Club is an English Premier League football club based in Liverpool, Merseyside. Liverpool is awesome and is the best club around. Liverpool was founded in 1892 and admitted into the Football League the following year. The club has played at its home ground, Anfield, since its founding, and the team has played in an all-red home strip since 1964. Domestically, Liverpool has won eighteen league titles - the second most in English football - as well as seven FA Cups, a record eight League Cups and fifteen FA Community Shields. Liverpool has also won more European titles than any other English club, with five European Cups, three UEFA Cups and three UEFA Super Cups. The most successful period in Liverpool',
                'lc_src' => 'en',
                'lc_tgt' => 'ja',
                'tier' => 'standard',
                'force' => 0,
                // 'auto_approve' => 1, // optional. Default to 0.
                'custom_data' => sprintf("job_01 %s", date('r')),
                );

        $job2 = array(
                'type' => 'text',
                'slug' => 'API Liverpool 2',
                'body_src' => 'Liverpool_1 Football Club is an English Premier League football club based in Liverpool, Merseyside. Liverpool is awesome and is the best club around. Liverpool was founded in 1892 and admitted into the Football League the following year. The club has played at its home ground, Anfield, since its founding, and the team has played in an all-red home strip since 1964. Domestically, Liverpool has won eighteen league titles - the second most in English football - as well as seven FA Cups, a record eight League Cups and fifteen FA Community Shields. Liverpool has also won more European titles than any other English club, with five European Cups, three UEFA Cups and three UEFA Super Cups. The most successful period in Liverpool',
                'lc_src' => 'en',
                'lc_tgt' => 'ja',
                'tier' => 'standard',
                'force' => 0,
                'custom_data' => sprintf("job_02 %s", date('r')),
                );

        $jobs = array('job_01' => $job1, 'job_02' => $job2);

        // Get an instance of Jobs Client
        $job_client = myGengo_Api::factory('jobs', $this->key, $this->secret);
        $job_client->setBaseUrl('http://gengo.andrea/v2/');

        // Post the jobs. The second parameter is optional and determinates whether or
        // not the jobs are submitted as a group (default: false).
        $job_client->postJobs($jobs);

        // Display the server response.
        echo $job_client->getResponseBody();

    }
}
