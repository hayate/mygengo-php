<?php

/**
 * Updates a job to translate.
 */

// TODO: this example assumes you replaced the 2 values below.
$api_key = 'your-public-api-key';
$private_key = 'your private-api-key';

$usage = "Usage: php -f putTranslateJobs.php [action] [job_ids] {captchas}
[action] is one of (approve, revise, reject).
[job_ids] is a comma-separated list of job ids.
If [action] is 'reject', provide a comma-separated list of [captchas]. \n";

if ($argc < 3
    || !in_array($argv[1], array('approve', 'revise', 'reject'))
    || ($argv[1] == 'reject' && $argc < 4))
{
    echo $usage;
    exit;
}

$action = $argv[1];
$job_ids = explode(',', $argv[2]);
if ($action == 'reject')
{
    $captchas = explode(',', $argv[3]);
}

require_once '../init.php';

// Get an instance of Jobs Client
$jobs_client = myGengo_Api::factory('jobs', $api_key, $private_key);

// The update call has been divided into 3 meaningful methods, one for each action.
switch ($action)
{
    case 'approve':
        $approve = array();
        foreach($job_ids as $job_id)
        {
            $approve[] = array(
                'job_id' => $job_id,
                'rating' => 5,
                'for_translator' => 'Thanks, nice translation.',
                'for_mygengo' =>'myGengo really gives me great satisfaction!',
                'public' => 1 // Can myGengo share your feedback publicly (optional, default 0)?
                );
        }
        $jobs_client->approve($approve);
        break;

    case 'revise':
        $revise = array();
        foreach($job_ids as $job_id)
        {
            $revise[] = array(
                'job_id' => $job_id,
                'comment' =>'Nice but not perfect. Could you check the first word?'
                );
        }
        $jobs_client->revise($revise);
        break;

    case 'reject':
        $reject = array();
        foreach($job_ids as $id => $job_id)
        {
            $reject[] = array(
                'job_id' => $job_id,
                'reason' => 'incomplete',
                'comment' => 'It seems the translator did not finish the job.',
                'captcha' => $captchas[$id],
                // 'follow_up' => 'cancel' // optional. Default: 'requeue'
                );
        }
        $jobs_client->reject($reject);
}

// Display the server response.
echo $jobs_client->getResponseBody();

/**
 * Typical response of any of these queries when they succeed:
 {"opstat":"ok","response":{}}
 */

?>
