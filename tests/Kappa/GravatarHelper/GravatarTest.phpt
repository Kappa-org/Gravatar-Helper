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

use Kappa\GravatarHelper\Gravatar;
use Kappa\Tester\TestCase;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Class GravatarHelperTest
 * @package Kappa\GravatarHelper\Tests
 */
class GravatarHelperTest extends TestCase
{
	/** @var \Kappa\GravatarHelper\Gravatar */
	private $gravatar;

	protected function setUp()
	{
		$this->gravatar = new Gravatar();
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

	public function testGetAvatar()
	{
		$url = 'http://www.gravatar.com/avatar/';
		$url_sec = 'https://secure.gravatar.com/avatar/';
		$email = 'test@test.com';
		$gravatar = new Gravatar();
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
}

\run(new GravatarHelperTest());