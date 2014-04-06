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

use Kappa\FileNotFoundException;
use Kappa\InvalidArgumentException;
use Kappa\UrlNotFoundException;
use Kappa\Utils\Validators;
use Nette\Object;

class GravatarHelper extends Object
{
	/** @var string */
	private $gravatarUrl = "http://www.gravatar.com/avatar/";

	/** @var string */
	private $gravatarDefault;

	/** @var int */
	private $size;

	/** @var string */
	private $emailHash;

	/**
	 * @param null|string $gravatarUrl
	 * @param null $gravatarDefault
	 * @throws \Kappa\InvalidArgumentException
	 * @throws \Kappa\UrlNotFoundException
	 * @throws \Kappa\FileNotFoundException
	 */
	public function __construct($gravatarUrl = null, $gravatarDefault = null)
	{
		if($gravatarDefault && !is_string($gravatarDefault))
			throw new InvalidArgumentException("Class " . __CLASS__ . " requires string as second parameter");
		if ($gravatarDefault !== null && !file_exists($gravatarDefault))
			throw new FileNotFoundException(__CLASS__, $gravatarDefault);
		if ($this->gravatarUrl != $gravatarUrl && $gravatarUrl) {
			if(!is_string($gravatarUrl))
				throw new InvalidArgumentException("Class " . __CLASS__ . " requires string or null as first parameter");
			$this->gravatarUrl = $gravatarUrl;
		}
		if (!Validators::isConnected($this->gravatarUrl))
			throw new UrlNotFoundException(__METHOD__, $this->gravatarUrl);
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
		$url = $this->gravatarUrl;
		$url .= $this->emailHash;
		$url .= '?d=';
		$url .= $this->gravatarDefault;
		$url .= '&s=';
		$url .= $this->size;
		return $url;
	}
}
