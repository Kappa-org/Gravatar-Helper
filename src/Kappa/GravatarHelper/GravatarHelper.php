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

use emberlabs\GravatarLib\Gravatar;
use Nette\Object;

/**
 * Class GravatarHelper
 * @package Kappa\GravatarHelper
 */
class GravatarHelper extends Object
{
	/** @var string */
	private $defaultImage;

	/**
	 * @param string $url
	 */
	public function setDefaultImage($url)
	{
		$this->defaultImage = $url;
	}

	/**
	 * @param string $email
	 * @param int $size
	 * @return string
	 */
	public function process($email, $size)
	{
		$gravatar = $this->getGravatar();
		$gravatar->setAvatarSize($size);

		return urldecode($gravatar->get($email));
	}

	/**
	 * @return Gravatar
	 */
	private function getGravatar()
	{
		$gravatar = new Gravatar();
		$gravatar->enableSecureImages();
		if ($this->defaultImage) {
			$gravatar->setDefaultImage($this->defaultImage);
		}

		return $gravatar;
	}
}
