<?php

require_once '../init.php';

class PostJobsTest extends PHPUnit_Framework_TestCase
{
    private $key;
    private $secret;

    public function setUp()
    {
        $this->key = 'iICUnakpx1(zjWi@3vauoM3(F9C2-XOSvJZ9q)-M(DhTDq7m$BEY@2obFFcA-CgW';
        $this->secret = 'sZ1JYn@-06(o[#8@ulzEq{1W~)|5aI#IzSHZ#eafa50dn~dA=th=fdEXRbv8~|)K';
    }

    public function test_post_jobs()
    {
        $job1 = array('type' => 'text',
                      'slug' => 'API Job test',
                      'body_src' => 'First test.',
                      'lc_src' => 'en',
                      'lc_tgt' => 'ja',
                      'tier' => 'standard',
                      'force' => 1, // optional. Default to 0.
                      // 'auto_approve' => 1, // optional. Default to 0.
                      'custom_data' => '1234567日本語');


        $job2 = array('type' => 'text',
                      'slug' => 'API Job test',
                      'body_src' => 'second test.',
                      'lc_src' => 'en',
                      'lc_tgt' => 'ja',
                      'tier' => 'standard',
                      'force' => 1, // optional. Default to 0.
                      // 'auto_approve' => 1, // optional. Default to 0.
                      'custom_data' => '1234567日本語');


        // $jobs = array('job_01' => $job1, 'job_02' => $job2);
        $jobs = array($job1, $job2);

        // Get an instance of Jobs Client
        $job_client = myGengo_Api::factory('jobs', $this->key, $this->secret);
        $job_client->setBaseUrl('http://gengo.andrea/v2/');

        // Post the jobs. The second parameter is optional and determinates whether or
        // not the jobs are submitted as a group (default: false).
        $job_client->postJobs($jobs, true);

        // Display the server response.
        echo $job_client->getResponseBody();

    }
}
