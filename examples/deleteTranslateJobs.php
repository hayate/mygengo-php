<?php

/**
 * Delete a list of jobs already sent into myGengo, but not started yet.
 */

require_once '../init.php';

// TODO: this example assumes you replaced the 3 values below.
$api_key = 'your-public-api-key';
$private_key = 'your private-api-key';
$job_ids = array(1, 2); // A list of job ids.

// Get an instance of Jobs Client
$job_client = myGengo_Api::factory('jobs', $api_key, $private_key);

// Cancel the job.
$job_client->cancel($job_ids);

// Display the server response.
echo $job_client->getResponseBody();

/**
 * Typical response:
 {"opstat":"ok","response":{}}
 */

?>
