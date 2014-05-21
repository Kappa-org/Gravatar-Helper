<?php
/**
 * Gravatar.php
 *
 * @author Ondřej Záruba <zarubaondra@gmail.com>
 * @date 15.2.13
 *
 * @package Kappa
 */

namespace Kappa\Gravatar;

use Kappa\Utils\Validators;
use Nette\Object;

/**
 * Class Gravatar
 * @package Kappa\Gravatar
 */
class Gravatar extends Object
{
	const URL = 'http://www.gravatar.com/avatar/';

	const SECURE_URL = 'https://secure.gravatar.com/avatar/';

	/** @var string */
	private $defaultImage = null;

	/** @var int|float */
	private $size = null;

	/** @var bool */
	private $forceDefault = false;

	/** @var string */
	private $rating = null;

	/** @var bool */
	private $secureRequest = false;

	/** @var bool */
	private $cache = true;

	/** @var \Kappa\Gravatar\CacheStorage */
	private $cacheStorage;

	/**
	 * @param CacheStorage $cacheStorage
	 */
	public function __construct(CacheStorage $cacheStorage)
	{
		$this->cacheStorage = $cacheStorage;
	}

	/**
	 * @param string $path
	 * @return $this
	 * @throws UrlNotFoundException
	 * @throws FileNotFoundException
	 */
	public function setDefaultImage($path)
	{
		$extra = array('404', 'mm', 'identicon', 'monsterid', 'wavatar', 'retro', 'blank');
		if (Validators::isUrl($path)) {
			if (!Validators::checkHttpStatus($path, array(200))) {
				throw new UrlNotFoundException("Url '{$path}' has not been found");
			}
		} else {
			if (!in_array($path, $extra) && !is_file($path)) {
				throw new FileNotFoundException("File '{$path}' has not been found");
			}
		}
		$this->defaultImage = $path;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getDefaultImage()
	{
		return $this->defaultImage;
	}

	/**
	 * @param  integer|float $size
	 * @return $this
	 * @throws InvalidArgumentException
	 */
	public function setSize($size)
	{
		if (!is_numeric($size)) {
			throw new InvalidArgumentException("Size must be number");
		}
		$this->size = $size;

		return $this;
	}

	/**
	 * @return float|int
	 */
	public function getSize()
	{
		return $this->size;
	}

	/**
	 * @return $this
	 */
	public function enableForceDefault()
	{
		$this->forceDefault = true;

		return $this;
	}

	/**
	 * @return $this
	 */
	public function disableForceDefault()
	{
		$this->forceDefault = false;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getForceDefault()
	{
		return $this->forceDefault;
	}

	/**
	 * @param string $rating
	 * @return $this
	 * @throws InvalidArgumentException
	 */
	public function setRating($rating)
	{
		$allowed = array('g', 'pg', 'r', 'x');
		if (!in_array($rating, $allowed)) {
			throw new InvalidArgumentException("Rating '{$rating}' is not allowed");
		}
		$this->rating = $rating;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getRating()
	{
		return $this->rating;
	}

	/**
	 * @return $this
	 */
	public function enableSecureRequest()
	{
		$this->secureRequest = true;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getSecureRequest()
	{
		return $this->secureRequest;
	}

	public function enableCache()
	{
		$this->cache = true;

		return $this;
	}

	public function disableCache()
	{
		$this->cache = false;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getCache()
	{
		return $this->cache;
	}

	/**
	 * @return $this
	 */
	public function disableSecureRequest()
	{
		$this->secureRequest = false;

		return $this;
	}

	/**
	 * @param string $email
	 * @param int|float $size
	 * @return string
	 */
	public function getAvatar($email, $size = null)
	{
		$emailHash = md5(trim(strtolower($email)));
		$url = $this->getUrl($emailHash);
		if ($size) {
			$this->setSize($size);
		}

		return ($this->cache) ? $this->cacheStorage->getAvatarCache($url) : $url;
	}

	/**
	 * @param string $emailHash
	 * @return string
	 */
	private function getUrl($emailHash)
	{
		$first = true;
		$url = ($this->getSecureRequest()) ? self::SECURE_URL : self::URL;
		$url .= $emailHash;
		if ($this->getDefaultImage()) {
			$url .= ($first) ? '?default=' . $this->getDefaultImage() : '&default=' . $this->getDefaultImage();
		}
		if ($this->getSize()) {
			$url .= ($first) ? '?size=' . $this->getSize() : '&size=' . $this->getSize();
		}
		if ($this->getForceDefault()) {
			$url .= ($first) ? '?forcedefault=y' : '&forcedefault=y';
		}
		if ($this->getRating()) {
			$url .= ($first) ? '?rating=' . $this->getRating() : '&rating=' . $this->getRating();
		}

		return $url;
	}
}
