CakeRollbar
===========

CakePHP 2.X plugin to integrate with the [Rollbar](https://rollbar.com) service.

Installation
------------

1. Via Composer, include the plugin inside your project.

2. In `bootstrap.php`, load the plugin.  You can also declare `rollbar_get_current_user()` there if you don't want the default behavior.

```php
CakePlugin::load('CakeRollbar', array(
    'bootstrap' => true,
    'path' => ROOT . DIRECTORY_SEPARATOR . APP_DIR . '/Vendor/rkaiser0324/CakeRollbar/'
    ));

/*
function rollbar_get_current_user() {
    // See bootstrap.php in the plugin for the return format.
    return $retval;
}
*/
```

3. Update `APP/Config/private.php` with the settings for your Rollbar account.  See `bootstrap.php` in the plugin for the various options. 
