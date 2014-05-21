<?php
/**
 * GravatarHelper.php
 *
 * @author Ondřej Záruba <zarubaondra@gmail.com>
 * @date 15.2.13
 *
 * @package Kappa
 */

namespace Kappa\GravatarHelper;

use Nette\Object;

/**
 * Class Gravatar
 * @package Kappa\GravatarHelper
 */
class Gravatar extends Object
{
	/** @var string */
	private $defaultImage;

	/**
	 * @param string $url
	 * @return $this
	 */
	public function setDefaultImage($url)
	{
		$this->defaultImage = $url;

		return $this;
	}
}
