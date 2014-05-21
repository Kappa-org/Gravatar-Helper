<?php
/**
 * This file is part of the Kappa\GravatarHelper package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace Kappa\GravatarHelper;

use Kappa\FileSystem\File;
use Nette\Object;
use Nette\Utils\DateTime;

/**
 * Class CacheStorage
 * @package Kappa\GravatarHelper
 */
class CacheStorage extends Object
{
	/** @var string */
	private $tempDirectory;

	/** @var string */
	private $publicDir;

	/**
	 * @param string $path
	 * @param string $publicDir
	 * @throws DirectoryNotFoundException
	 */
	public function __construct($path, $publicDir)
	{
		$path = realpath($path);
		$publicDir = realpath($publicDir);
		if (!$path) {
			throw new DirectoryNotFoundException("Directory '{$path}' has not been found");
		}
		if (!$publicDir) {
			throw new DirectoryNotFoundException("Directory '{$publicDir}' has not been found");
		}
		$this->tempDirectory = $path;
		$this->publicDir = $publicDir;
	}

	/**
	 * @param string $url
	 * @return File
	 */
	public function getAvatarCache($url)
	{
		return $this->invalidateAvatarCache($url)->getInfo()->getRelativePath($this->publicDir);
	}

	/**
	 * @param string $url
	 * @return File
	 */
	private function invalidateAvatarCache($url)
	{
		$headers = get_headers($url);
		$lastUpdate = str_replace('Last-Modified: ', '', $headers[8]);
		$datetime = new DateTime($lastUpdate);
		$cacheFile = $this->getCachePath($url);
		if (is_file($cacheFile)) {
			$file = File::open($cacheFile);
			if ($datetime->getTimestamp() > $file->getInfo()->getMTime()) {
				return $this->createAvatarCache($url);
			} else {
				return $file;
			}
		} else {
			return $this->createAvatarCache($url);
		}
	}

	/**
	 * @param string $url
	 * @return File
	 */
	private function createAvatarCache($url)
	{
		$file = File::fromUrl($url, $this->getCachePath($url));

		return $file;
	}

	/**
	 * @param string $url
	 * @return string
	 */
	private function getCachePath($url)
	{
		return $this->tempDirectory . DIRECTORY_SEPARATOR . $this->getCacheName($url) . '.png';
	}

	/**
	 * @param string $url
	 * @return string
	 */
	private function getCacheName($url)
	{
		return md5($url);
	}
} 