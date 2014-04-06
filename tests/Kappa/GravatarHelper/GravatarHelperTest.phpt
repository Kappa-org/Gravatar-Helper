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
		$gravatar = new GravatarHelper();
		Assert::type('Kappa\GravatarHelper\GravatarHelper', $gravatar->setDefaultImage('http://static-data.zaruba-ondrej.cz/gravatar-test.png'));
		Assert::same('https://secure.gravatar.com/avatar/2cf33add0750773d62c5fd9e2354514b?s=30&r=g&d=http://static-data.zaruba-ondrej.cz/gravatar-test.png', $gravatar->process('noemail@zaruba-ondrej.cz', 30));
	}
}

\run(new GravatarHelperTest());