<?php
/**
 * This file is part of the Kappa\GravatarHelper package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace Kappa\GravatarHelper\DI;

use Nette\DI\CompilerExtension;

/**
 * Class GravatarHelperExtension
 * @package Kappa\GravatarHelper\DI
 */
class GravatarHelperExtension extends CompilerExtension
{
	private $defaultConfig = array(
		'wwwDir' => '%wwwDir%',
		'cacheDir' => '%wwwDir%/gravatar_cache'
	);

	public function loadConfiguration()
	{
		$config = $this->getConfig($this->defaultConfig);
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('cacheStorage'))
			->setClass('Kappa\GravatarHelper\CacheStorage', array($config['cacheDir'], $config['wwwDir']));

		$builder->addDefinition($this->prefix('gravatar'))
			->setClass('Kappa\GravatarHelper\Gravatar', array($this->prefix('@cacheStorage')));
	}
}