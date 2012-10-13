<?php

require_once '../init.php';

class MultiUploadTest extends PHPUnit_Framework_TestCase
{
    const FILEPATH_3 = '/home/andrea/srv/mygengo-php/files/japanese_file.docx';// '/home/andrea/Desktop/Press_Release.pdf';
    const FILEPATH_4 = '/home/andrea/srv/mygengo-php/files/test.txt';// '/home/andrea/Desktop/Press_Release.pdf';
    const FILEPATH_1 = '/home/andrea/Desktop/Seiya_testing/liverpool_translation.txt';
    const FILEPATH_2 = '/home/andrea/Desktop/Seiya_testing/liverpool_translation.txt';

    private $key;
    private $secret;
    protected $filepaths = array();


    public function setUp()
    {
        // matt's keys
        // $this->key = 'VAyOZuW5iy]YdGgOT^J8LP%%r[#OmdAMd+dU*-GFl5GY7PBddN7e~cehmZ4OdQib';
        // $this->secret = 'c*N#{euN-W^SMsry_}3HYqpo0__KqKXTND)%veuO$}b$d=#goWPH2*MLDn=q@uTD';
        // andrea's keys
        $this->key = '$A|jE1=#4mataA_mDicSboIn$s7C)^eKJz|opJDmwJ}-th{[OzMmo2KyNQO-Y(0i';
        $this->secret = 'njI0j1nYh(]{5RVJ7h#[~ja~^m5xfXA9Dpox)IG}oq6Hyiwv])Pt=gWmYtgCcA#U';
        $basepath = dirname(dirname(__file__)) .'/files/';
        foreach (scandir($basepath) as $file)
        {
            if ($file != '.' && $file != '..')
            {
                $this->filepaths[] = "{$basepath}{$file}";
            }
        }
    }

	public function xxxx_upload_single_file()
	{
		$jobs = array();
		$files = array();
	    $jobs[] = array('type' => 'text',
		                'lc_src' => 'en',
				        'lc_tgt' => 'es',
						'file_key' => "file_01",
		                'tier' => 'standard',
					   );
		$files['file_01'] = '/home/andrea/srv/mygengo-php/files/test.txt';

	    $service = myGengo_Api::factory('service', $this->key, $this->secret);
        $service->setBaseUrl('http://gengo.andrea/v1/');
        $service->quote($jobs, $files);

        $body = $service->getResponseBody();
		$response = json_decode($body, true);

        $job = array('type' => 'file',
					  'identifier' => $response['response']['jobs'][0]['identifier'],
                      'custom_data' => sprintf("date:  %s, hello i am file_0%d", date('r'), 1),
                      'comment' => sprintf("Test comment, please translate file file_0%d", 1),
                      'use_preferred' => false,);

	    $service = myGengo_Api::factory('job', $this->key, $this->secret);
        $service->setBaseUrl('http://gengo.andrea/v1/');
		$service->postJob($job);

        $body = $service->getResponseBody();
		print_r($body);
	}


    /**
     * this test fails because it timesout
     */
    public function xxx_file_types_upload()
    {
        $jobs = array();
        $files = array();
        for ($i = 0; $i < count($this->filepaths); $i++)
        {
            $jobs[] = array(
                'type' => 'text',
                'lc_src' => 'en',
                'lc_tgt' => 'es',
                'file_key' => "file_0{$i}",
                'tier' => 'standard',
            );
            $files["file_0{$i}"] = $this->filepaths[$i];
        }
        // get quote
        $service = myGengo_Api::factory('service', $this->key, $this->secret);
        // TODO: CHANGE THIS URL OR COMMENT IT TO USE THE ONE IN CONFIG FILE
        $service->setBaseUrl('http://gengo.andrea/v1/');
        $service->quote($jobs, $files);

        $response = $service->getResponseBody();
        // check response
        $json = json_decode($response, true);
        if (empty($json))
        {
            printf("%s\n", $response);
        }
        else {
            printf("%s\n", print_r($json, true));
        }
    }

    public function test_multi_upload()
    {
        $job_01 = array('type' => 'text',
                        'lc_src' => 'en',
                        'lc_tgt' => 'es',
                        'file_key' => 'file_01',
                        'tier' => 'pro',);

        $job_02 = array('type' => 'text',
                        'lc_src' => 'en',
                        'lc_tgt' => 'es',
                        'file_key' => 'file_02',
                        'tier' => 'standard',);

        // get quote
        $service = myGengo_Api::factory('service', $this->key, $this->secret);
        // TODO: CHANGE THIS URL OR COMMENT IT TO USE THE ONE IN CONFIG FILE
        $service->setBaseUrl('http://gengo.andrea/v1/');
        $service->quote(array($job_01, $job_02), array('file_01' => self::FILEPATH_3, 'file_02' => self::FILEPATH_4));

        $response = $service->getResponseBody();
        // check response
        $json = json_decode($response, true);
        if (empty($json))
        {
            printf("%s\n", $response);
        }
        else {
            $response = $json;
        }
        // view quote response
        printf("%s\n", 'quote response:');
        print_r($response);

        $this->assertEquals($response['opstat'], 'ok');
        $this->assertTrue(isset($response['response']));
        $this->assertTrue(is_array($response['response']['jobs']));

        // post job
        $jobapi = myGengo_Api::factory('jobs', $this->key, $this->secret);
        // TODO: CHANGE THIS URL OR COMMENT IT TO USE THE ONE IN CONFIG FILE
        $jobapi->setBaseUrl('http://gengo.andrea/v1/');
        $jobs = array();


        for ($i = 0; $i < count($response['response']['jobs']); $i++)
        {
            $jobs["job_0{$i}"] = array('type' => 'file',
                            'identifier' => $response['response']['jobs'][$i]['identifier'],
                            'custom_data' => sprintf("date:  %s, hello i am file_0%d", date('r'), $i+1),
                            'comment' => sprintf("Test comment, please translate file file_0%d", $i+1),
                            'use_preferred' => true,);
        }

        /*
        $jobs[] = array('type' => 'file',
                        'identifier' => '3426054c9ab31fffc430925a3a0f508425770bc2be0b9ae131daddb9af840993',
                        'custom_data' => 'hello i am file_01',
                        'comment' => 'Translate this file_01 properly please',
                        'use_preferred' => true,);

        $jobs[] = array('type' => 'file',
                        'identifier' => 'ba466de2ea609d24859b62b9410577368d872eddffca30bd397736af13c303c7',
                        'custom_data' => 'hello i am file_02',
                        'comment' => 'Translate this file_02 properly please',
                        'use_preferred' => true,);
        */

        $as_group = true;
        $jobapi->postJobs($jobs, false);

        $res = $jobapi->getResponseBody();
        $json = json_decode($res, true);
        if (empty($json))
        {
            printf("%s\n", 'could not json decode!');
            print_r($res);
        }
        else {
            $res = $json;
        }

        // view response
        printf("%s\n", 'order response:');
        print_r($res);

        $this->assertTrue(isset($res['opstat']));
        $this->assertTrue(isset($res['response']));
        $this->assertTrue(isset($res['response']['jobs']));
        for ($i = 0; $i < count($res['response']['jobs']); $i++)
        {
            $this->assertTrue(isset($res['response']['jobs'][$i]["job_0{$i}"]['job_id']));
            $this->assertTrue(isset($res['response']['jobs'][$i]["job_0{$i}"]['status']));
            $this->assertTrue(isset($res['response']['jobs'][$i]["job_0{$i}"]['src_file_link']));
        }
    }
}
