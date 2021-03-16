<?php
require_once __DIR__.'/initialize.php';

/**
 * Test class for mfwUserAgent.
 * Generated by PHPUnit on 2013-01-03 at 02:17:51.
 */
class mfwUserAgentTest extends PHPUnit_Framework_TestCase
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
	 * @dataProvider androidProvider
	 */
	public function testAndroid($uastr,$subtype)
	{
		$ua = new mfwUserAgent($uastr);
		$this->assertEquals($uastr,$ua->getString());
		$this->assertEquals('Android',$ua->getType());
		$this->assertEquals($subtype,$ua->getSubType());

		$this->assertTrue($ua->isAndroid());
		$this->assertFalse($ua->isIOS());
		$this->assertTrue($ua->isSmartPhone());
		$this->assertFalse($ua->isDocomo());
		$this->assertFalse($ua->isAu());
		$this->assertFalse($ua->isSoftBank());
		$this->assertFalse($ua->isPC());
	}

	/**
	 */
	public function androidProvider()
	{
		return array(
			array(
				'Mozilla/5.0 (Linux; U; Android 1.5; ja-jp; GDDJ-09 Build/CDB56) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1',
				array(
					'version' => '1.5',
					'major_version' => '1',
					'minor_version' => '5',
					'device' => 'GDDJ-09',
					'browser' => null,
					)
				),
			array(
				'Mozilla/5.0 (Linux; Android 4.0.4; Galaxy Nexus Build/IMM76B) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.133 Mobile Safari/535.19',
				array(
					'version' => '4.0.4',
					'major_version' => '4',
					'minor_version' => '0',
					'device' => 'Galaxy Nexus',
					'browser' => 'Chrome',
					)
				),
			array(
				'Mozilla/5.0 (Android; Linux armv71; rv:2.1.1) Gecko/20110415 Firefox/4.0.2pre Fennec/4.0.1',
				array(
					'version' => null,
					'major_version' => null,
					'minor_version' => null,
					'device' => null,
					'browser' => 'FireFox',
					)
				),
			array(
				'Opera/9.80 (Android 2.1-update1; Linux; Opera Mobi/ADR-1104201100; U; en) Presto/2.7.81 Version/11.00',
				array(
					'version' => '2.1-update1',
					'major_version' => '2',
					'minor_version' => '1',
					'device' => null,
					'browser' => 'Opera',
					)
				),
			);
	}

	/**
	 * @dataProvider iosProvider
	 */
	public function testIOS($uastr,$type,$subtype)
	{
		$ua = new mfwUserAgent($uastr);
		$this->assertEquals($uastr,$ua->getString());
		$this->assertEquals($type,$ua->getType());
		$this->assertEquals($subtype,$ua->getSubType());

		$this->assertFalse($ua->isAndroid());
		$this->assertTrue($ua->isIOS());
		$this->assertTrue($ua->isSmartPhone());
		$this->assertFalse($ua->isDocomo());
		$this->assertFalse($ua->isAu());
		$this->assertFalse($ua->isSoftBank());
		$this->assertFalse($ua->isPC());
	}

	/**
	 */
	public function iosProvider()
	{
		return array(
			array(
				'Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420+ (KHTML, like Gecko) Version/3.0 Mobile/1C28 Safari/419.3',
				'iPhone',
				array(
					'version' => null,
					'major_version' => null,
					'minor_version' => null,
					)
				),
			array(
				'Mozilla/5.0 (iPhone; U; CPU iPhone OS 3_1_3 like Mac OS X; ja-jp) AppleWebKit/528.18 (KHTML, like Gecko) Version/4.0 Mobile/7E18 Safari/528.16',
				'iPhone',
				array(
					'version' => '3_1_3',
					'major_version' => '3',
					'minor_version' => '1',
					)
				),
			array(
				'Mozilla/5.0 (iPod; U; CPU iPhone OS 4_3_5 like Mac OS X; ja-jp) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8L1 Safari/6533.18.5',
				'iPod',
				array(
					'version' => '4_3_5',
					'major_version' => '4',
					'minor_version' => '3',
					)
				),
			array(
				'Mozilla/5.0 (iPad; CPU OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A403 Safari/8536.25',
				'iPad',
				array(
					'version' => '6_0',
					'major_version' => '6',
					'minor_version' => '0',
					)
				),
			array(
				'Mozilla/5.0 (iPod touch; CPU iPhone OS 7_0 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11A465 Safari/9537.53',
				'iPod',
				array(
					'version' => '7_0',
					'major_version' => '7',
					'minor_version' => '0',
					)
				),
			);
	}

	/**
	 * @dataProvider docomoProvider
	 */
	public function testDocomo($uastr,$uid,$subtype)
	{
		if($uid){
			$_SERVER['HTTP_X_DCMGUID'] = $uid;
		}
		else{
			unset($_SERVER['HTTP_X_DCMGUID']);
		}

		$ua = new mfwUserAgent($uastr);
		$this->assertEquals($uastr,$ua->getString());
		$this->assertEquals('DoCoMo',$ua->getType());
		$this->assertEquals($subtype,$ua->getSubType());

		$this->assertFalse($ua->isAndroid());
		$this->assertFalse($ua->isIOS());
		$this->assertFalse($ua->isSmartPhone());
		$this->assertTrue($ua->isDocomo());
		$this->assertFalse($ua->isAu());
		$this->assertFalse($ua->isSoftBank());
		$this->assertFalse($ua->isPC());
	}

	/**
	 */
	public function docomoProvider()
	{
		return array(
			array(
				'DoCoMo/1.0/X503i/c10/ser0123456789a',
				null,
				array(
					'version' => '1.0',
					'device' => 'X503i',
					'uid' => null,
					)
				),
			array(
				'DoCoMo/2.0 F2051(c100;TB;ser1234567890abcde;icc0987654321abcdefghij)',
				'0123abc',
				array(
					'version' => '2.0',
					'device' => 'F2051',
					'uid' => '0123abc',
					)
				),
			);
	}

	/**
	 * @dataProvider auProvider
	 */
	public function testAu($uastr,$uid,$subtype)
	{
		if($uid){
			$_SERVER['HTTP_X_UP_SUBNO'] = $uid;
		}
		else{
			unset($_SERVER['HTTP_X_UP_SUBNO']);
		}

		$ua = new mfwUserAgent($uastr);
		$this->assertEquals($uastr,$ua->getString());
		$this->assertEquals('au',$ua->getType());
		$this->assertEquals($subtype,$ua->getSubType());

		$this->assertFalse($ua->isAndroid());
		$this->assertFalse($ua->isIOS());
		$this->assertFalse($ua->isSmartPhone());
		$this->assertFalse($ua->isDocomo());
		$this->assertTrue($ua->isAu());
		$this->assertFalse($ua->isSoftBank());
		$this->assertFalse($ua->isPC());
	}

	/**
	 */
	public function auProvider()
	{
		return array(
			array(
				'KDDI-HI31 UP.Browser/6.2.0.5 (GUI) MMP/2.0',
				'01234567890123_ab.ezweb.ne.jp',
				array(
					'device' => 'HI31',
					'hdml_only' => false,
					'uid' => '01234567890123_ab.ezweb.ne.jp',
					)
				),
			array(
				'UP.Browser/3.01-HI02 UP.Link/3.2.1.2',
				null,
				array(
					'device' => 'HI02',
					'hdml_only' => true,
					'uid' => null,
					)
				),
			);
	}

	/**
	 * @dataProvider softbankProvider
	 */
	public function testSoftBank($uastr,$uid,$subtype)
	{
		if($uid){
			$_SERVER['HTTP_X_JPHONE_UID'] = $uid;
		}
		else{
			unset($_SERVER['HTTP_X_JPHONE_UID']);
		}

		$ua = new mfwUserAgent($uastr);
		$this->assertEquals($uastr,$ua->getString());
		$this->assertEquals('SoftBank',$ua->getType());
		$this->assertEquals($subtype,$ua->getSubType());

		$this->assertFalse($ua->isAndroid());
		$this->assertFalse($ua->isIOS());
		$this->assertFalse($ua->isSmartPhone());
		$this->assertFalse($ua->isDocomo());
		$this->assertFalse($ua->isAu());
		$this->assertTrue($ua->isSoftBank());
		$this->assertFalse($ua->isPC());
	}

	/**
	 */
	public function softbankProvider()
	{
		return array(
			array(
				'SoftBank/1.0/830SH/SHJ001/SN012345678901234 Browser/NetFront/3.4 Profile/MIDP-2.0 Configuration/CLDC-1.1',
				'a0123456789abcdef',
				array(
					'device' => '830SH',
					'version' => '1.0',
					'uid' => '0123456789abcdef',
					)
				),
			array(
				'J-PHONE/5.0/V801SA/SN123456789012345 SA/0001JP Profile/MIDP-1.0 Configuration/CLDC-1.0 Ext-Profile/JSCL-1.1.0',
				null,
				array(
					'device' => 'V801SA',
					'version' => '5.0',
					'uid' => null,
					)
				),
			array(
				'Vodafone/1.0/V802SE/SEJ001 Browser/VF-Browser/1.0 Profile/MIDP-2.0 Configuration/CLDC-1.1',
				null,
				array(
					'device' => 'V802SE',
					'version' => '1.0',
					'uid' => null,
					)
				),
			array(
				'MOT-V980/80.2F.2E. MIB/2.2.1 Profile/MIDP-2.0 Configuration/CLDC-1.1',
				null,
				array(
					'device' => 'V702MO',
					'version' => null,
					'uid' => null,
					)
				),
			array(
				'MOT-C980/80.2F.2E. MIB/2.2.1 Profile/MIDP-2.0 Configuration/CLDC-1.1 ',
				'abcdefg123456789',
				array(
					'device' => 'V702sMO',
					'version' => null,
					'uid' => 'bcdefg123456789',
					)
				),
			);
	}

	/**
	 */
	public function testFromHttpHeader()
	{
		$uastr = 'Mozilla/5.0 (Linux; U; Android 1.5; ja-jp; GDDJ-09 Build/CDB56) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1';
		$_SERVER['HTTP_USER_AGENT'] = $uastr;
		$subtype = array(
			'version' => '1.5',
			'major_version' => '1',
			'minor_version' => '5',
			'device' => 'GDDJ-09',
			'browser' => null,
			);

		$ua = new mfwUserAgent();
		$this->assertEquals($uastr,$ua->getString());
		$this->assertEquals('Android',$ua->getType());
		$this->assertEquals($subtype,$ua->getSubType());

		$this->assertTrue($ua->isAndroid());
		$this->assertFalse($ua->isIOS());
		$this->assertTrue($ua->isSmartPhone());
		$this->assertFalse($ua->isDocomo());
		$this->assertFalse($ua->isAu());
		$this->assertFalse($ua->isSoftBank());
		$this->assertFalse($ua->isPC());

	}

}
?>
