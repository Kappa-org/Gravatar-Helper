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

use Kappa\Tester\TestCase;
use Nette\DI\Container;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

class GravatarHelperExtensionTest extends TestCase
{
	/** @var \Nette\DI\Container */
	private $container;

	/**
	 * @param Container $container
	 */
	public function __construct(Container $container)
	{
		$this->container = $container;
	}

	public function testGravatar()
	{
		$service = $this->container->getService('gravatar.gravatar');
		Assert::type('Kappa\GravatarHelper\Gravatar', $service);
	}

	public function testCacheStorage()
	{
		$service = $this->container->getService('gravatar.cacheStorage');
		Assert::type('Kappa\GravatarHelper\CacheStorage', $service);
	}
}

\run(new GravatarHelperExtensionTest(getContainer()));