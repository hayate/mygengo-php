<?php

require_once '../init.php';

class ApiUploadTest extends PHPUnit_Framework_TestCase
{
    const FILEPATH_1 = '/home/andrea/srv/mygengo-php/assets/video_on_demand.txt';
    const FILEPATH_2 = '/home/andrea/srv/mygengo-php/assets/japanese_file.docx';
    const FILEPATH_3 = '/home/andrea/srv/mygengo-php/assets/test_files/english/basics/sushi_en.doc';

    private $key;
    private $secret;
    protected $filepaths = array();

    public function setUp()
    {
        // matt's keys
        // $this->key = 'VAyOZuW5iy]YdGgOT^J8LP%%r[#OmdAMd+dU*-GFl5GY7PBddN7e~cehmZ4OdQib';
        // $this->secret = 'c*N#{euN-W^SMsry_}3HYqpo0__KqKXTND)%veuO$}b$d=#goWPH2*MLDn=q@uTD';
        // andrea's keys
        $this->key = 'iICUnakpx1(zjWi@3vauoM3(F9C2-XOSvJZ9q)-M(DhTDq7m$BEY@2obFFcA-CgW';
        $this->secret = 'sZ1JYn@-06(o[#8@ulzEq{1W~)|5aI#IzSHZ#eafa50dn~dA=th=fdEXRbv8~|)K';
    }

    public function test_success_service_quote()
    {
        $job_01 = array('type' => 'file',
                        'lc_src' => 'en',
                        'lc_tgt' => 'ja',
                        'file_key' => 'file_01',
                        'tier' => 'standard',);

        $job_02 = array('type' => 'file',
                        'lc_src' => 'en',
                        'lc_tgt' => 'ja',
                        'file_key' => 'file_02',
                        'tier' => 'standard',);

        $job_03 = array('type' => 'file',
                        'lc_src' => 'en',
                        'lc_tgt' => 'ja',
                        'file_key' => 'file_03',
                        'tier' => 'standard',);

        $service = myGengo_Api::factory('service', $this->key, $this->secret);
        // TODO: CHANGE THIS URL OR COMMENT IT TO USE THE ONE IN CONFIG FILE
        $service->setBaseUrl('http://gengo.andrea/v1/');
        // $service->setBaseUrl('http://qa.gengo.com/v1/');

        $service->quote(array($job_01, $job_02, $job_03), array('file_01' => self::FILEPATH_1,
                                                                'file_02' => self::FILEPATH_2,
                                                                'file_03' => self::FILEPATH_3,));
        $body = $service->getResponseBody();
        $response = json_decode($body, true);
        $this->assertEquals($response['opstat'], 'ok');
        $this->assertTrue(isset($response['response']));
        $this->assertTrue(is_array($response['response']['jobs']));

        foreach ($response['response']['jobs'] as $job)
        {
            $this->assertTrue(isset($job['unit_count']));
            $this->assertTrue(isset($job['credits']));
            $this->assertTrue(isset($job['eta']));
            $this->assertTrue(isset($job['currency']));
            $this->assertTrue(isset($job['identifier']));
            $this->assertTrue(isset($job['type']));
            $this->assertTrue(isset($job['lc_src']));
            $this->assertTrue(isset($job['body']));
            $this->assertTrue(isset($job['title']));
        }
    }
}
