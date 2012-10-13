<?php

require_once '../init.php';

class ApiUploadTest extends PHPUnit_Framework_TestCase
{
    const FILEPATH_1 = '/home/andrea/Desktop/Press_Release.pdf';
    const FILEPATH_2 = '/home/andrea/Desktop/Press_Release.pdf';
    const FILEPATH_3 = '/home/andrea/docs/en_ja_original.txt';
    const FILEPATH_4 = '/home/andrea/docs/en_ja_original.txt';
    const FILEPATH_5 = '/home/andrea/Desktop/Seiya_testing/liverpool_translation.txt';
    // const FILEPATH_2 = '/home/andrea/Desktop/YM_Art_Prize_press_release_London_Art_Fair.pdf';
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

    public function xxxx_file_types_upload()
    {
        $service = myGengo_Api::factory('service', $this->key, $this->secret);
        $service->setBaseUrl('http://mygengo.andrea/v1/');

        for ($i = 0; $i < count($this->filepaths); $i++)
        {
            $job = array(
                'type' => 'text',
                'lc_src' => 'en',
                'lc_tgt' => 'es',
                'file_key' => "file_0{$i}",
                'tier' => 'standard',
            );
            $service->quote(array($job), array("file_0{$i}" => $this->filepaths[$i]));

            $response = $service->getResponseBody();
            // check response
            $json = json_decode($response, true);
            if (empty($json))
            {
                printf("%s\n", $response);
            }
            else {
                print_r($json);
            }
        }
    }

    public function xxxx_quote_upload()
    {
        $filepath = '/home/andrea/Desktop/Seiya_testing/liverpool_translation.txt';
        $job_01 = array('type' => 'text',
                        'lc_src' => 'en',
                        'lc_tgt' => 'ja',
                        'file_key' => 'file_01',
                        'tier' => 'standard',);

        $service = myGengo_Api::factory('service', $this->key, $this->secret);
        $service->setBaseUrl('http://api.qa.gengo.com/v1/');
        $service->quote(array($job_01), array('file_01' => self::FILEPATH_1));
        $body = $service->getResponseBody();

        $response = json_decode($body, true);
        $this->assertEquals($response['opstat'], 'ok');
        $this->assertTrue(isset($response['response']));

        // post job
        $jobapi = myGengo_Api::factory('job', $this->key, $this->secret);
        // TODO: CHANGE THIS URL OR COMMENT IT TO USE THE ONE IN CONFIG FILE
        $jobapi->setBaseUrl('http://mygengo.andrea/v1/');

        for ($i = 0; $i < count($response['response']['jobs']); $i++)
        {
            $job = array('type' => 'file',
                         'identifier' => $response['response']['jobs'][$i]['identifier'],
                         'custom_data' => sprintf("hello i am file_0%d", $i+1),);

            $jobapi->postJob($job);

            $res = $jobapi->getResponseBody();
            $json = json_decode($res, true);
            if (! $json)
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
            $this->assertTrue(isset($res['response']['job']['job_id']));
            $this->assertTrue(isset($res['response']['job']['status']));
            $this->assertTrue(isset($res['response']['job']['src_file_link']));
        }
    }

    public function test_success_service_quote()
    {
        $job_01 = array('type' => 'text',
                        'lc_src' => 'en',
                        'lc_tgt' => 'es',
                        'file_key' => 'file_01',
                        'tier' => 'standard',);

        $job_02 = array('type' => 'text',
                        'lc_src' => 'en',
                        'lc_tgt' => 'es',
                        'file_key' => 'file_02',
                        'tier' => 'standard',);

        $service = myGengo_Api::factory('service', $this->key, $this->secret);

        // TODO: CHANGE THIS URL OR COMMENT IT TO USE THE ONE IN CONFIG FILE
        // $service->setBaseUrl('http://mygengo.andrea/v1/');
        $service->setBaseUrl('http://qa.gengo.com/v1/');
        $service->quote(array($job_01, $job_02), array('file_01' => self::FILEPATH_3, 'file_02' => self::FILEPATH_4));
        $body = $service->getResponseBody();

        var_dump($body);

        $response = json_decode($body, true);
        $this->assertEquals($response['opstat'], 'ok');
        $this->assertTrue(isset($response['response']));

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
    }

    public function xxxx_success_order_job()
    {
        // first get a quote
        $job_01 = array('type' => 'text',
                        'lc_src' => 'en',
                        'lc_tgt' => 'es',
                        'file_key' => 'file_01',
                        'tier' => 'standard',);

        $job_02 = array('type' => 'text',
                        'lc_src' => 'en',
                        'lc_tgt' => 'es',
                        'file_key' => 'file_02',
                        'tier' => 'pro',);

        // get quote
        $service = myGengo_Api::factory('service', $this->key, $this->secret);
        // TODO: CHANGE THIS URL OR COMMENT IT TO USE THE ONE IN CONFIG FILE
        $service->setBaseUrl('http://mygengo.andrea/v1/');
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
        $jobapi = myGengo_Api::factory('job', $this->key, $this->secret);
        // TODO: CHANGE THIS URL OR COMMENT IT TO USE THE ONE IN CONFIG FILE
        $jobapi->setBaseUrl('http://mygengo.andrea/v1/');

        $glossary = myGengo_Api::factory('glossary', $this->key, $this->secret);
        $glossary->setBaseUrl('http://mygengo.andrea/v1/');

        $page_size = 10;
        // retrieve all the glossary at once
        $glossary->getGlossaries($page_size);

        $body = $glossary->getResponseBody();
        $glores = json_decode($body, true);
        if (empty($glores))
        {
            printf("%s\n", 'response could not be json decoded.');
            printf("%s\n", $body);
            return;
        }

        for ($i = 0; $i < count($response['response']['jobs']); $i++)
        {
            $job = array('type' => 'file',
                         'identifier' => $response['response']['jobs'][$i]['identifier'],
                         'custom_data' => sprintf("hello i am file_0%d", $i+1),
                         'comment' => sprintf("Test comment please translate file: file_0%d", $i+1),
                         'glossary_id' => $glores['response'][0]['id'],
                         'use_preferred' => true,);

            $jobapi->postJob($job);

            $res = $jobapi->getResponseBody();
            $json = json_decode($res, true);
            if (! $json)
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
            $this->assertTrue(isset($res['response']['job']['job_id']));
            $this->assertTrue(isset($res['response']['job']['status']));
            $this->assertTrue(isset($res['response']['job']['src_file_link']));
        }
    }

    public function xxxx_success_get_job()
    {
        $jobapi = myGengo_Api::factory('job', $this->key, $this->secret);
        $jobapi->setBaseUrl('http://mygengo.andrea/v1/');
        $jobapi->getJob(815854);

        $body = $jobapi->getResponseBody();
        $response = json_decode($body, true);
        if (empty($response))
        {
            print_r($body);
        }
        else {
            // view response
            print_r($response);
        }
    }
}
