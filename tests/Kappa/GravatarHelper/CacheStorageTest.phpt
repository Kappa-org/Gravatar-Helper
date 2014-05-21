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
use Kappa\Tester\TestCase;
use Tester\Assert;
use Tester\Helpers;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Class CacheStorage
 * @package Kappa\GravatarHelper\Tests
 */
class CacheStorageTest extends TestCase
{
	/** @var \Kappa\GravatarHelper\CacheStorage */
	private $cacheStorage;
	
	/** @var string */
	private $tempDirectory;

	protected function setUp()
	{
		$tempDirectory = __DIR__ . '/../../data/cache';
		if (!is_dir($tempDirectory)) {
			mkdir($tempDirectory);
		}
		$this->tempDirectory = realpath($tempDirectory);
		$this->cacheStorage = new CacheStorage($tempDirectory, $tempDirectory);
	}

	public function testGetAvatarCache()
	{
		$emailHash = md5('test@test.com');
		$url = 'http://www.gravatar.com/avatar/http://www.gravatar.com/avatar/' . $emailHash;
		$urlHash = md5($url);
		$cacheFile = $this->tempDirectory . DIRECTORY_SEPARATOR . $urlHash . '.png';
		Assert::false(is_file($cacheFile));
		Assert::same('/' . $urlHash . '.png', $this->cacheStorage->getAvatarCache($url));
		Assert::true(is_file($cacheFile));
	}

	protected function tearDown()
	{
		Helpers::purge($this->tempDirectory);
	}
}

\run(new CacheStorageTest());