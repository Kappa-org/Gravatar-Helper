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

use Kappa\GravatarHelper\GravatarHelper;
use Kappa\Tester\TestCase;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Class GravatarHelperTest
 * @package Kappa\GravatarHelper\Tests
 */
class GravatarHelperTest extends TestCase
{
	public function testGravatar()
	{

	}
}

\run(new GravatarHelperTest());