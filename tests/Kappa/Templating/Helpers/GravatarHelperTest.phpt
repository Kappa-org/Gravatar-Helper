<?php
/**
 * GravatarHelperTest.phpt
 *
 * @author Ondřej Záruba <zarubaondra@gmail.com>
 * @date 25.4.13
 *
 * @package Kappa
 */
 
namespace Kappa\Tests\Templating\Helpers;

use Kappa\Tests;
use Kappa\Templating\Helpers;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

class GravatarHelperTest extends Tests\TestCase
{
	/** @var \Kappa\Templating\Helpers\GravatarHelper */
	private $gravatarHelper;

	public function setUp()
	{
		$this->gravatarHelper = new Helpers\GravatarHelper();
	}

	public function testConstructor()
	{
		Assert::throws(function () {
			new Helpers\GravatarHelper("http://zaruba-ondrej.cz/no-exist-web-page");
		}, '\Kappa\UrlNotFoundException');
		Assert::throws(function () {
			new Helpers\GravatarHelper(array('some'));
		}, '\Kappa\InvalidArgumentException');
		Assert::throws(function () {
			new Helpers\GravatarHelper("http://google.com", array('some'));
		}, '\Kappa\InvalidArgumentException');
	}

	public function testGravatar()
	{
		Assert::same('http://www.gravatar.com/avatar/cb3045d1eb66dda5eae9ae2f96edeee9?d=&s=50', $this->gravatarHelper->gravatar("info@example.com", 50));
	}
}

\run(new GravatarHelperTest());