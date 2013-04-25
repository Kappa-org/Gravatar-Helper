<?php
/**
 * GravatarHelper.php
 *
 * @author Ondřej Záruba <zarubaondra@gmail.com>
 * @date 15.2.13
 *
 * @package Kappa
 */

namespace Kappa\Templating\Helpers;

use Kappa\FileNotFoundException;
use Kappa\UrlNotFoundException;
use Kappa\Utils\Validators;
use Nette\Object;

class GravatarHelper extends Object
{
	const GRAVATAR_URL = "http://www.gravatar.com/avatar/";

	/** @var string */
	private $gravatarDefault;

	/** @var int */
	private $size;

	/** @var string */
	private $emailHash;

	/**
	 * @param null $gravatarDefault
	 * @throws \Kappa\UrlNotFoundException
	 * @throws \Kappa\FileNotFoundException
	 */
	public function __construct($gravatarDefault = null)
	{
		if ($gravatarDefault !== null && !file_exists($gravatarDefault))
			throw new FileNotFoundException(__CLASS__, $gravatarDefault);
		if(!Validators::isConnected(self::GRAVATAR_URL))
			throw new UrlNotFoundException(__METHOD__, self::GRAVATAR_URL);
		$this->gravatarDefault = urlencode($gravatarDefault);
	}

	/**
	 * @param string $email
	 * @param int $size
	 * @return string
	 */
	public function gravatar($email, $size)
	{
		$this->emailHash = $this->createEmailHash($email);
		$this->size = $size;
		return $this->createUrl();
	}

	/**
	 * @param string $email
	 * @return string
	 */
	private function createEmailHash($email)
	{
		$email = trim($email);
		$email = strtolower($email);
		$email = md5($email);
		return $email;
	}

	/**
	 * @return string
	 */
	private function createUrl()
	{
		$url = self::GRAVATAR_URL;
		$url .= $this->emailHash;
		$url .= '?d=';
		$url .= $this->gravatarDefault;
		$url .= '&s=';
		$url .= $this->size;
		return $url;
	}
}
