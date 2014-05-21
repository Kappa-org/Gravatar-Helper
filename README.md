# Kappa\Gravata [![Build Status](https://travis-ci.org/Kappa-org/Gravatar-Helper.svg?branch=master)](https://travis-ci.org/Kappa-org/Gravatar-Helper)

Simple class for better getting avatars from service gravatar.com

## Requirements:

* PHP 5.3.3 or higher
* [nette/nette](http://nette.org/) 2.1.* and 2.2.*
* [kappa/filesystem](https://github.com/Kappa-org/FileSystem) 4.2.*
* [kappa/utils](https://github.com/Kappa-org/Utils) 1.0.*

## Installation

The best way to install Kappa\Utils is using Composer:
```bash
$ composer require kappa/gravatar:@dev
```

and register extension:

```yaml
extensions:
	gravatar: Kappa\Gravatar\DI\GravatarExtension
```

## Usages

You can set cache directory for faster displaying avatars

```yaml
gravatar:
	cacheDir: %wwwDir%/gravatar #default
```

Into presenter or control where you can use this helper add filter (helper)

```php
$template->addFilter('gravatar', array($this->gravatar, 'getAvatar')) // for Nette 2.2
$template->registerHelper('gravatar', array($this->gravatar, 'getAvatar')) // for Nette 2.1
```

Usages in template:

```html
<img src="$user->getEmail()|gravatar:30">
```