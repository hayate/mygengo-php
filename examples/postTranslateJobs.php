<?php
/**
 * Submits one or several jobs to translate.
 */

require_once '../init.php';

// TODO: this example assumes you replaced the 2 values below.
$api_key = 'your-public-api-key';
$private_key = 'your private-api-key';

$job1 = array(
        'type' => 'text',
        'slug' => 'API Job test',
        'body_src' => 'First test.',
        'lc_src' => 'en',
        'lc_tgt' => 'ja',
        'tier' => 'standard',
        // 'force' => 1, // optional. Default to 0.
        // 'auto_approve' => 1, // optional. Default to 0.
        'custom_data' => '1234567日本語'
        );

$job2 = array(
        'type' => 'text',
        'slug' => 'API Job test',
        'body_src' => 'second test.',
        'lc_src' => 'en',
        'lc_tgt' => 'ja',
        'tier' => 'standard',
        // 'force' => 1, // optional. Default to 0.
        // 'auto_approve' => 1, // optional. Default to 0.
        'custom_data' => '1234567日本語'
        );

$jobs = array($job1, $job2);

// Get an instance of Jobs Client
$job_client = myGengo_Api::factory('jobs', $api_key, $private_key);

// Post the jobs. The second parameter is optional and determinates whether or
// not the jobs are submitted as a group (default: false).
$job_client->postJobs($jobs, true);

// Display the server response.
echo $job_client->getResponseBody();

/**
 * Typical response:
 {"opstat":"ok","response":{"group_id":22751,"jobs":[
    [{"job_id":"384996","slug":"API Job test","body_src":"First test.",
        "lc_src":"en","lc_tgt":"ja","unit_count":"2","tier":"standard","credits":"0.10",
        "status":"available","eta":"","ctime":1313505765,"auto_approve":"0","custom_data":"1234567\u65e5\u672c\u8a9e",
        "body_tgt":"Machine translation while waiting","mt":1}],
     {"1":{"job_id":"384997","slug":"API Job test","body_src":"second test.",
        "lc_src":"en","lc_tgt":"ja","unit_count":"2","tier":"standard","credits":"0.10",
        "status":"available","eta":"","ctime":1313505765,"auto_approve":"0","custom_data":"1234567\u65e5\u672c\u8a9e",
        "body_tgt":"Machine translation again","mt":1}}]}}
 */

?>
