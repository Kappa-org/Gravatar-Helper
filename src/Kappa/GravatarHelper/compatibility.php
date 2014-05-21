<?php
/**
 * This file is part of the Kappa\GravatarHelper package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

if (!class_exists('Image\Utils\DateTime')) {
	class_alias('Nette\DateTime', 'Nette\Utils\DateTime');
}