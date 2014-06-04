Animate
=======

A simple PHP wrapper around Animate.css.

## Installation

You can install this package via Composer by including the following in your `composer.json`:

```json
{
    "require": {
        "jsila/animate": "0.1.0"
    }
}
```

It depends on `php>=5.4` and `Animate.css`.

### Laravel 4

If you are using Laravel 4, you can also register the `AnimateServiceProvider` for easier integration with the framework.

To do so, just update the `providers` array in your `app/config/app.php`:

```php
    'providers' => array(
        //...
        'JSila\Animate\AnimateServiceProvider'
    ),
```

`AnimateServiceProvider` will also add alias for `Animate` facade.

## Usage with Laravel

This package generates string of classes based on which animation you specify as a method to a `Animate` class instance. For all animations please refer to [GitHub page for Animate.css](http://daneden.github.io/animate.css/).

For example, if you want `zoomIn` animation (for which the output will be `animated zoomIn`), you will get it like this:

```php
    Animate::zoomIn();
```

You can also provide options when generating class string for a specific animation. These options are:

```php
$options = [
    'infinite', // boolean
    'duration', // string
    'delay', // string
    'direction', // string
    'iteration-count' // int
];
```

Please note that last four options are CSS3 `animations` properties so specify values accordingly.

Each option will add another class to the class string. Some classes are already defined in `Animate.css`, some are generated dinamically and are accessible from URL which points to CSS.

For example, if you want `zoomIn` animation to run infinitely and is delayed for 0.2s, than this code will do the trick:

```php
    Animate::zoomIn(['infinite' => true, 'delay' => '.2s']);
```

If you use Laravel 4, that url to CSS defaults to `/css/animate_custom_classes.css` (you can change it, just publish package configurationd).

### Usage as a stand-alone

Classes that are dynamically created are stored in session variable `classes`. You will first need to make an implementation of `JSila\Animate\SessionInterface` interface which is a dependency to `JSila\Animate\Animate` class (eg. `MySession`).

Than you will also have to generate CSS response. `JSila\Animate\Animate` class provides `generateCSS` method, which generates CSS string of classes, but this does act as a response.

Stand-alone example:

```php
$animate = new JSila\Animate\Animate(new Acme\Animate\Session\MySession); // this assumes MySession class is saved in Acme/Animate/Session
$animate->zoomIn(['infinite' => true, 'delay' => '.2s']);
```
