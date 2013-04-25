#Kappa:Gravatart helper [![Build Status](https://travis-ci.org/Kappa-org/Gravatar-Helper.png?branch=master)](https://travis-ci.org/Kappa-org/Gravatar-Helper)

Simple system for getting avatars from service gravatar.com

###Requirements:
- PHP 5.3.*
- [Nette framework](http://nette.org/) 2.0.*
- [Kappa:Framework](https://github.com/Kappa-org/Framework)

###Install

1. Step - Add this package into your project
```json
	"require":{
		"kappa/gravatar-helper" : "dev-master"
	}
```

2. Step - Registre this package in config
```neon
	nette:
		template:
			helperLoaders: \Kappa\Templating\Helpers
			helpers:
				gravatar: @Gravatar::gravatar
	services:
		Gravatar: Kappa\Templating\Helpers\GravatarHelper(gravatar.com link - not required, default image - not required)
```

**3. Step - Clean temp directory!**

Complete! :)

###Work with Thumbnails helper
```php
// Presenter
class HomepagePresenter extends \Kappa\Application\UI\Presenter
{
	public function renderDefault()
	{
		$this->template->email = "email@exampl.ecom";
	}
}
```
```html
<!-- Layout -->
<img src={$email|gravatar:50}>
```
First parameter is image size
