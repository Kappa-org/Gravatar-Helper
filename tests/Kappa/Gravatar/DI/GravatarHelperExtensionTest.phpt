<?php
/**
 * This file is part of the Kappa\Gravatar package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 * 
 * @testCase
 */

namespace Kappa\Gravatar\Tests;

use Kappa\Tester\TestCase;
use Nette\DI\Container;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

class GravatarExtensionTest extends TestCase
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
		Assert::type('Kappa\Gravatar\Gravatar', $service);
	}

	public function testCacheStorage()
	{
		$service = $this->container->getService('gravatar.cacheStorage');
		Assert::type('Kappa\Gravatar\CacheStorage', $service);
	}
}

\run(new GravatarExtensionTest(getContainer()));