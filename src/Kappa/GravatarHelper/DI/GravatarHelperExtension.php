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

use Flame\Modules\Providers\ITemplateHelpersProvider;
use Nette\DI\CompilerExtension;

/**
 * Class GravatarHelperExtension
 * @package Kappa\GravatarHelper\DI
 */
class GravatarHelperExtension extends CompilerExtension implements ITemplateHelpersProvider
{
	public function loadConfiguration()
	{
		$config = $this->getConfig(array(
			'default' => 'mm'
		));
		$builder = $this->getContainerBuilder();
		$builder->addDefinition($this->prefix('gravatarHelper'))
			->setClass('Kappa\GravatarHelper\GravatarHelper')
			->addSetup('setDefaultImage', array($config['default']));
	}

	/**
	 * Return list of helpers definitions or providers
	 *
	 * @return array
	 */
	public function getHelpersConfiguration()
	{
		$config = $this->getConfig(array('name' => 'gravatar'));
		return array(
			$config['name'] => array($this->prefix('@gravatarHelper'), 'process')
		);
	}
}