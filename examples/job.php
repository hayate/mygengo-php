<?php
/**
 * job api example
 * translate/job/{id} (PUT)
 * translate/job/{id} (GET)
 * translate/job/{id} (DELETE)
 * translate/job/{id}/comments (GET)
 * translate/job/{id}/comment (POST)
 * translate/job/{id}/feedback (GET)
 * translate/job/{id}/revisions (GET)
 * translate/job/{id}/revision/{rev_id} (GET)
 * translate/job/{id}/preview (GET)
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

// get an instance of Job Client
$job_client = myGengo_Api::factory('job');
// get job_id from config file
$job_id = $config->get('job_id', null, true);



// --------------------------------------------------------------
// Create a job for submition
// --------------------------------------------------------------
$job = array(
    'type' => 'text',
    'slug' => 'API Job 1 test',
    'body_src' => 'Text to be translated goes here.',
    'lc_src' => 'en',
    'lc_tgt' => 'ja',
    'tier' => 'standard',
    'auto_approve' => 'true',
    'custom_data' => '1234567日本語'
);
// pack the jobs
$data = array('job' => $job);

// create the query
$params = array('api_key' => $config->get('api_key', null, true), '_method' => 'post',
                'ts' => gmdate('U'),
                'data' => json_encode($data));
// sort and sign
ksort($params);
$enc_params = json_encode($params);
$params['api_sig'] = myGengo_Crypto::sign($enc_params, $config->get('private_key', null, true));

$job_client->postJob('json', $params);
// echo back server response
echo $job_client->getResponseBody();
echo "\n\n";
exit();


/**
 * translate/job/{id} (GET)
 *
 * Retrive a job
 */
$job_client->getJob($job_id, 'json', $params);
// echo back server response
echo $job_client->getResponseBody();
echo "\n\n";

/**
 * translate/job/{id}/comments (GET)
 *
 * Retrieves the comment thread for a job
 */
$job_client->getComments($job_id, 'json', $params);
// echo back server response
echo $job_client->getResponseBody();
echo "\n\n";

/**
 * translate/job/{id}/feedback (GET)
 *
 * Retrieves the feedback
 */
$job_client->getFeedback($job_id, 'xml', $params);
// echo back server response
echo $job_client->getResponseBody();
echo "\n\n";

/**
 * translate/job/{id}/revisions (GET)
 *
 * Gets list of revision resources for a job.
 */
$job_client->getRevisions($job_id, 'json', $params);
// echo back server response
echo $job_client->getResponseBody();
echo "\n\n";

/**
 * translate/job/{id}/revision/{rev_id}
 *
 * Gets specific revision for a job.
 */
$job_client->getRevision($job_id, null, 'json', $params);
// echo back server response
echo $job_client->getResponseBody();
echo "\n\n";

/**
 * translate/job/{id} (PUT)
 *
 * Updates a job to translate.
 *
 * ACTION:
 * purchase
 */
$job_client->putPurchase($job_id, 'json');
// echo back server response
echo $job_client->getResponseBody();
echo "\n\n";


/**
 * translate/job/{id} (PUT)
 * Updates a job to translate.
 *
 * ACTION:
 * "revise" - returns this job back to the translator for revisions
 */
$private_key = $config->get('private_key', null, true);
$revise = array();
$revise['ts'] = gmdate('U');
$revise['api_key'] = $config->get('api_key', null, true);
$revise['data'] = json_encode(array('action' => 'revise',
                                    'comment' => 'Not happy with translation.'));
ksort($revise);
$query = json_encode($revise);
$revise['api_sig'] = myGengo_Crypto::sign($query, $private_key);

$job_client->putRevise($job_id, 'json', $revise);
// echo back server response
echo $job_client->getResponseBody();
echo "\n\n";

/**
 * translate/job/{id} (PUT)
 * Updates a job to translate.
 *
 * ACTION:
 * "approve" - approves job
 * other parameters
 * rating (required)
 * 1 (poor) to 5 (fantastic)
 * for_translator (optional)
 * comments for the translator
 * for_mygengo (optional)
 * comments for myGengo staff (private)
 * public (optional)
 * 1 (true) / 0 (false, default).  whether myGengo can share this feedback publicly
 */
$private_key = $config->get('private_key', null, true);
$approve = array();
$approve['ts'] = gmdate('U');
$approve['api_key'] = $config->get('api_key', null, true);
$approve['data'] = json_encode(array('action' => 'approve',
                                     'rating' => 5));
ksort($approve);
$query = json_encode($approve);
$approve['api_sig'] = myGengo_Crypto::sign($query, $private_key);

$job_client->putApprove($job_id, 'json', $approve);
// echo back server response
echo $job_client->getResponseBody();
echo "\n\n";

/**
 * translate/job/{id} (PUT)
 * Updates a job to translate.
 *
 * ACTION:
 * "reject" - rejects the translation
 * other parameters
 * reason (required)
 * "quality", "incomplete", "other"
 * comment (required)
 * captcha (required)
 * the captcha image text. Each job in a "reviewable" state will
 * have a captcha_url value, which is a URL to an image.  This
 * captcha value is required only if a job is to be rejected.
 * follow_up (optional)
 * "requeue" (default) or "cancel"
 */
$private_key = $config->get('private_key', null, true);
$reject = array();
$reject['ts'] = gmdate('U');
$reject['api_key'] = $config->get('api_key', null, true);
$reject['data'] = json_encode(array('action' => 'reject',
                                    'comment' => 'This translation is not really the best.',
                                    'reason' => 'quality',
                                    'captcha' => 'UXPX',
                                    'follow_up' => 'cancel'));
ksort($reject);
$query = json_encode($reject);
$reject['api_sig'] = myGengo_Crypto::sign($query, $private_key);

$job_client->putReject($job_id, 'json', $reject);
// echo back server response
echo $job_client->getResponseBody();
echo "\n\n";

/**
 * translate/job/{id}/comment (POST)
 * Submits a new comment to the job's comment thread.
 */
$private_key = $config->get('private_key', null, true);
$comment = array();
$comment['ts'] = gmdate('U');
$comment['api_key'] = $config->get('api_key', null, true);
$comment['data'] = json_encode(array('body' => 'This is a comment'));
ksort($comment);
$query = json_encode($comment);
$comment['api_sig'] = myGengo_Crypto::sign($query, $private_key);
$job_client->postComment($job_id, 'json', $comment);
// echo back server response
echo $job_client->getResponseBody();
echo "\n\n";

/**
 * translate/job/{id} (DELETE)
 * Cancels the job. You can only cancel a job if it has not been
 * started already by a translator.
 */
$job_client->deleteJob($job_id, 'json');
// echo back server response
echo $job_client->getResponseBody();
echo "\n\n";


/**
 * translate/job/{id}/preview (GET)
 * Renders a JPEG preview of the translated text
 * N.A. - if the request is valid, a raw JPEG stream is returned.
 */
$job_client->previewJob($job_id);
// echo back server response
echo $job_client->getResponseBody();
echo "\n\n";
