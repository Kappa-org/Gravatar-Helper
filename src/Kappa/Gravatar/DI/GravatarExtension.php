<?php
/**
 * This file is part of the Kappa\Gravatar package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace Kappa\Gravatar\DI;

use Nette\DI\CompilerExtension;

/**
 * Class GravatarExtension
 * @package Kappa\Gravatar\DI
 */
class GravatarExtension extends CompilerExtension
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
			->setClass('Kappa\Gravatar\CacheStorage', array($config['cacheDir'], $config['wwwDir']));

		$builder->addDefinition($this->prefix('gravatar'))
			->setClass('Kappa\Gravatar\Gravatar', array($this->prefix('@cacheStorage')));
	}
}