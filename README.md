# Kappa\GravataHelper [![Build Status](https://travis-ci.org/Kappa-org/Gravatar-Helper.svg?branch=master)](https://travis-ci.org/Kappa-org/Gravatar-Helper)

Simple class for better getting avatars from service gravatar.com

## Requirements:

* PHP 5.3.3 or higher
* [Nette framework](http://nette.org/) 2.1.*
* [Flame\Modules](https://github.com/flame-org/modules) 1.0.*
* [thomaswelton/gravatarlib](https://github.com/thomaswelton/gravatarlib/) 0.1.*

## Installation

The best way to install Kappa\Utils is using Composer:
```bash
$ composer require kappa/gravatar-helper:@dev
```

and register extension:

```neon
extensions:
	- Flame\Modules\DI\ModulesExtension
	Gravatar: Kappa\Gravatar\DI\GravatarExtension
```

## Usages

You can set helper name and default image in config:

```yaml
Gravatar:
	name: myName
	default: http://example.com/defaultImg.png
```

Default image is used if email has not avatar and helper name is used in template
```html
<img src="{$user->getEmail()|myName:30|noescape}">
```

*Second parametr is avatar display size*

**You must use ```noescape``` helper when you can use default image without ```noescape``` default image do not work!**