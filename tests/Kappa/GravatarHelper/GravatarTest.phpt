<?php
/**
 * This file is part of the Kappa\GravatarHelper package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 * 
 * @testCase
 */

namespace Kappa\GravatarHelper\Tests;

use Kappa\GravatarHelper\CacheStorage;
use Kappa\GravatarHelper\Gravatar;
use Kappa\Tester\TestCase;
use Tester\Assert;
use Tester\Helpers;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Class GravatarHelperTest
 * @package Kappa\GravatarHelper\Tests
 */
class GravatarHelperTest extends TestCase
{
	/** @var \Kappa\GravatarHelper\Gravatar */
	private $gravatar;

	/** @var string */
	private $tempDirectory;

	protected function setUp()
	{
		$this->tempDirectory = __DIR__ . '/../../data/cache';
		if (!is_dir($this->tempDirectory)) {
			mkdir($this->tempDirectory);
		}
		$this->gravatar = new Gravatar(new CacheStorage($this->tempDirectory, $this->tempDirectory));
		$this->gravatar->disableCache();
	}

	public function testDefaultImage()
	{
		Assert::type(get_class($this->gravatar), $this->gravatar->setDefaultImage(__FILE__));
		Assert::same(__FILE__, $this->gravatar->getDefaultImage());
		Assert::type(get_class($this->gravatar), $this->gravatar->setDefaultImage('http://zaruba-ondrej.cz'));
		Assert::same('http://zaruba-ondrej.cz', $this->gravatar->getDefaultImage());
		$self = $this;
		Assert::throws(function () use ($self) {
			$self->gravatar->setDefaultImage('http://no');
		}, 'Kappa\GravatarHelper\UrlNotFoundException');
		Assert::throws(function () use ($self) {
			$self->gravatar->setDefaultImage('no_file');
		}, 'Kappa\GravatarHelper\FileNotFoundException');
	}

	public function testSize()
	{
		Assert::type(get_class($this->gravatar), $this->gravatar->setSize(200));
		Assert::same(200, $this->gravatar->getSize());
		$self = $this;
		Assert::throws(function() use ($self) {
			$self->gravatar->setSize('adsasd');
		}, 'Kappa\GravatarHelper\InvalidArgumentException');
	}

	public function testForceDefault()
	{
		Assert::false($this->gravatar->getForceDefault());
		Assert::type(get_class($this->gravatar), $this->gravatar->enableForceDefault());
		Assert::true($this->gravatar->getForceDefault());
		Assert::type(get_class($this->gravatar), $this->gravatar->disableForceDefault());
		Assert::false($this->gravatar->getForceDefault());
	}

	public function testRating()
	{
		Assert::type(get_class($this->gravatar), $this->gravatar->setRating('g'));
		Assert::same('g', $this->gravatar->getRating());
		$self = $this;
		Assert::throws(function () use ($self) {
			$self->gravatar->setRating('c');
		}, 'Kappa\GravatarHelper\InvalidArgumentException');
	}

	public function testSecureRequest()
	{
		Assert::false($this->gravatar->getSecureRequest());
		Assert::type(get_class($this->gravatar), $this->gravatar->enableSecureRequest());
		Assert::true($this->gravatar->getSecureRequest());
		Assert::type(get_class($this->gravatar), $this->gravatar->disableSecureRequest());
		Assert::false($this->gravatar->getSecureRequest());
	}

	public function testCache()
	{
		Assert::false($this->gravatar->getCache());
		Assert::type(get_class($this->gravatar), $this->gravatar->enableCache());
		Assert::true($this->gravatar->getCache());
		Assert::type(get_class($this->gravatar), $this->gravatar->disableCache());
		Assert::false($this->gravatar->getCache());
	}

	public function testGetAvatar()
	{
		$url = 'http://www.gravatar.com/avatar/';
		$url_sec = 'https://secure.gravatar.com/avatar/';
		$email = 'test@test.com';
		$gravatar = new Gravatar(new CacheStorage($this->tempDirectory, $this->tempDirectory));
		$gravatar->disableCache();
		Assert::same($url . md5($email), $gravatar->getAvatar($email));
		$gravatar->enableSecureRequest();
		Assert::same($url_sec . md5($email), $gravatar->getAvatar($email));
		$gravatar->disableSecureRequest()
			->setSize(1)
			->setRating('g');
		Assert::match('~[?&]size=~', $gravatar->getAvatar($email));
		Assert::match('~[?&]rating=~', $gravatar->getAvatar($email));
	}

	public function testConst()
	{
		Assert::same('http://www.gravatar.com/avatar/', Gravatar::URL);
		Assert::same('https://secure.gravatar.com/avatar/', Gravatar::SECURE_URL);
	}

	public function testCacheStorage()
	{
		$email = 'test@test.com';
		$url = 'http://www.gravatar.com/avatar/' . md5($email);
		$expectedFileName = md5($url) . '.png';
		$expectedFile = $this->tempDirectory . '/' . $expectedFileName;
		$gravatar = new Gravatar(new CacheStorage($this->tempDirectory, $this->tempDirectory));

		Assert::false(is_file($expectedFile));
		$gravatar->disableCache();
		Assert::false($gravatar->getCache());
		Assert::same($url, $gravatar->getAvatar($email));;
		Assert::false(is_file($expectedFile));

		Assert::false(is_file($expectedFile));
		$gravatar->enableCache();
		Assert::true($gravatar->getCache());
		Assert::same('/' . $expectedFileName, $gravatar->getAvatar($email));;
		Assert::true(is_file($expectedFile));
	}

	protected function tearDown()
	{
		Helpers::purge($this->tempDirectory);
	}
}

\run(new GravatarHelperTest());