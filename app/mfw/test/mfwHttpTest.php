<?php
require_once __DIR__.'/initialize.php';


class mfwHttpWithoutVerifySSL extends mfwHttp
{
	protected static function initialize_curl($url,$headers,$timeout)
	{
		$curl = parent::initialize_curl($url,$headers,$timeout);
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
		return $curl;
	}
}


/**
 * Test class for mfwHttp.
 * Generated by PHPUnit on 2013-01-02 at 21:19:06.
 */
class mfwHttpTest extends PHPUnit_Framework_TestCase
{
	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	/**
	 */
	public function testGet()
	{
		mfwServerEnv::setEnv('unittest');

		$url = 'http://unittest.local/unittest.php';
		$headers = array();
		$html = mfwHttp::get($url,$headers,$res);

		$this->assertEquals(200,$res['status']);
		$this->assertEquals('OK',$res['status_msg']);
		$this->assertTrue(in_array('Content-Type: text/html',$res['headers']));
		$this->assertTrue(strpos($html,'METHOD: GET')!==false);

		$url = 'http://unittest.local/404notfound';
		$html = mfwHttp::get($url,$headers,$res);

		$this->assertEquals(404,$res['status']);
		$this->assertEquals('Not Found',$res['status_msg']);
	}

	public function testGetWithoutProxy()
	{
		elb_start();
		mfwServerEnv::setEnv('noserver');
		$url = 'http://unittest.local/unittest.php';
		$headers = array();
		$html = mfwHttp::get($url,$headers,$res);
		elb_get_clean();

		$this->assertEquals(200,$res['status']);
		$this->assertEquals('OK',$res['status_msg']);
		$this->assertTrue(in_array('Content-Type: text/html',$res['headers']));
		$this->assertTrue(strpos($html,'METHOD: GET')!==false);
	}

	/**
	 */
	public function testPost()
	{
		mfwServerEnv::setEnv('unittest');

		$url = 'http://unittest.local/unittest.php';
		$headers = array();
		$body = array('a'=>'b','c'=>'d');
		$html = mfwHttp::post($url,$body,$headers,$res);

		$this->assertEquals(200,$res['status']);
		$this->assertEquals('OK',$res['status_msg']);
		$this->assertTrue(in_array('Content-Type: text/html',$res['headers']));
		$this->assertTrue(strpos($html,'METHOD: POST')!==false);
		$this->assertTrue(strpos($html,'HEADER: Content-Type: application/x-www-form-urlencoded')!==false);
		$this->assertTrue(strpos($html,'STDIN: a=b&c=d')!==false);

		$body = json_encode($body);
		$headers[] = 'Content-Type: application/json';
		$html = mfwHttp::post($url,$body,$headers,$res);
		$this->assertEquals(200,$res['status']);
		$this->assertTrue(strpos($html,'HEADER: Content-Type: application/json')!==false);
		$this->assertTrue(strpos($html,"STDIN: $body")!==false);
	}

	/**
	 */
	public function testPut()
	{
		mfwServerEnv::setEnv('unittest');

		$url = 'http://unittest.local/unittest.php';
		$headers = array();
		$body = array('a'=>'b','c'=>'d');
		$html = mfwHttp::put($url,$body,$headers,$res);

		$this->assertEquals(200,$res['status']);
		$this->assertEquals('OK',$res['status_msg']);
		$this->assertTrue(in_array('Content-Type: text/html',$res['headers']));
		$this->assertTrue(strpos($html,'METHOD: PUT')!==false);
		$this->assertTrue(strpos($html,'HEADER: Content-Type: application/x-www-form-urlencoded')!==false);
		$this->assertTrue(strpos($html,'STDIN: a=b&c=d')!==false);

		$body = json_encode($body);
		$headers[] = 'Content-Type: application/json';
		$html = mfwHttp::put($url,$body,$headers,$res);

		$this->assertEquals(200,$res['status']);
		$this->assertTrue(strpos($html,'HEADER: Content-Type: application/json')!==false);
		$this->assertTrue(strpos($html,"STDIN: $body")!==false);
	}

	/**
	 */
	public function testDelete()
	{
		mfwServerEnv::setEnv('unittest');

		$url = 'http://unittest.local/unittest.php';
		$headers = array();
		$html = mfwHttp::delete($url,$headers,$res);

		$this->assertEquals(200,$res['status']);
		$this->assertEquals('OK',$res['status_msg']);
		$this->assertTrue(strpos($html,'METHOD: DELETE')!==false);
	}

	/**
	 */
	public function testTimeout()
	{
		mfwServerEnv::setEnv('noserver');
		$url = 'http://unittest.local/sleep.php?p=3';
		$headers = array();
		elb_start();
		$html = mfwHttp::get($url,$headers,$res,1);
		elb_get_clean();

		$this->assertEquals(0,$res['status']);
		$this->assertNull($html);
	}

	public function testHttpsWithProxy()
	{
		mfwServerEnv::setEnv('unittest');
		$url = 'https://unittest.local/unittest.php';
		$headers = array();
		$html = mfwHttpWithoutVerifySSL::get($url,$headers,$res);

		$this->assertEquals(200,$res['status']);
		$this->assertEquals('OK',$res['status_msg']);
		$this->assertTrue(in_array('Content-Type: text/html',$res['headers']));
		$this->assertTrue(strpos($html,'METHOD: GET')!==false);
	}

	/**
	 */
	public function testComposeParams()
	{
		$input = array(
			0 => 1,
			'a' => '<hoge>',
			'a&b+c d' => 'http://example.com/',
			);
		$exp = '0=1&a=%3Choge%3E&a%26b%2Bc+d=http%3A%2F%2Fexample.com%2F';
		$output = mfwHttp::composeParams($input);
		$this->assertEquals($exp,$output);

		$input = array();
		$output = mfwHttp::composeParams($input);
		$this->assertEquals('',$output);
	}

	/**
	 * @dataProvider composeUrlProvider
	 */
	public function testComposeURL($base,$params,$expurl)
	{
		$url = mfwHttp::composeURL($base,$params);
		$this->assertEquals($expurl,$url);
	}

	public function composeUrlProvider()
	{
		return array(
			array(
				'http://www.example.com/index.php',
				array('a'=>'b','c'=>'d'),
				'http://www.example.com/index.php?a=b&c=d',
				),
			array(
				'http://www.example.com/index.php?a=1&b=2',
				array('c'=>'d'),
				'http://www.example.com/index.php?a=1&b=2&c=d',
				),
			array(
				'http://www.example.com/index.php?a=1&b=2#anchor',
				array('c'=>'d'),
				'http://www.example.com/index.php?a=1&b=2&c=d#anchor',
				),
			array(
				'http://www.example.com/index.php?a=1&b=2#anchor',
				array(),
				'http://www.example.com/index.php?a=1&b=2#anchor',
				),
			array(
				'http://www.example.com/index.php#anchor',
				array('a'=>1,'b'=>2),
				'http://www.example.com/index.php?a=1&b=2#anchor',
				),
			array(
				'http://www.example.com/index.php?#',
				array(),
				'http://www.example.com/index.php#',
				),
			);
	}

	/**
	 * @dataProvider extractUrlProvider
	 */
	public function testExtractURL($input,$expbase,$expparams,$expanchor)
	{
		list($base,$params,$anchor) = mfwHttp::extractURL($input);
		$this->assertEquals($expbase,$base);
		$this->assertEquals($expparams,$params);
		$this->assertEquals($expanchor,$anchor);
	}

	public function extractUrlProvider()
	{
		return array(
			array(
				'http://www.example.com/index.php?a=b&c=d#asdfg',
				'http://www.example.com/index.php',
				array('a'=>'b','c'=>'d'),
				'asdfg'
				),
			array(
				'http://www.example.com/index.php',
				'http://www.example.com/index.php',
				array(),
				null,
				),
			array(
				'http://www.example.com/index.php?',
				'http://www.example.com/index.php',
				array(),
				null,
				),
			array(
				'http://www.example.com/index.php?abc=123',
				'http://www.example.com/index.php',
				array('abc'=>'123'),
				null,
				),
			array(
				'http://www.example.com/index.php#',
				'http://www.example.com/index.php',
				array(),
				'',
				),
			array(
				'http://www.example.com/index.php#qwerty',
				'http://www.example.com/index.php',
				array(),
				'qwerty',
				),
			array(
				'http://www.example.com/index.php?#zxcvb',
				'http://www.example.com/index.php',
				array(),
				'zxcvb',
				),
			);
	}
}
?>
