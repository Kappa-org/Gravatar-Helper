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
use thomaswelton\GravatarLib\Gravatar;

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
	 * @return $this
	 */
	public function setDefaultImage($url)
	{
		$this->defaultImage = $url;

		return $this;
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
