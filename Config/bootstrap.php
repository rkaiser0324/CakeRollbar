<?php
// Include the vendor files
App::import(
    'Vendor',
    'CakeRollbar.Rollbar',
    array('file' => 'rollbar.php')
);
App::uses('Rollbar', 'CakeRollbar.Vendor');

/**
 * Configuration array loaded from APP/Config/private.php, with the format:
 * 
 * $config = [
 *      ...
 *      'Rollbar' => [
 *          'access_token' => '7318e704865a47f1a92209cce4a544de',   // required
 *          'environment' => 'development',                         // required
 *          ...
 *      ]
 * ];
 * 
 * See rollbar.ini for documentation on the other options.
 */
Configure::config(
    'CakeRollbar', 
    new PhpReader(ROOT.DS.APP_DIR.DS.'Config'.DS.'private')
);
Configure::load('', 'CakeRollbar');
$config = Configure::read('Rollbar');

if (!function_exists('rollbar_get_current_user'))
{
    /**
     * Configures the user detection for the system.  This function can be declared in APP/Config/bootstrap.php
     * if you want to use different logic (e.g., your User model might not have a username field).
     * 
     * @return mixed
     */
    function rollbar_get_current_user() {
        $retval = null;
        App::uses('AuthComponent', 'Controller/Component');
        $user = AuthComponent::user();
        if (!is_null($user)) {           
            $retval = array(
                'id' => $user['id'], // required - value is a string
                'username' => $user['username'], // optional - value is a string
                'email' => $user['email'] // optional - value is a string
            );
        }
        return $retval;
    }
}
$config['person_fn'] = 'rollbar_get_current_user';

$config['root'] = WWW_ROOT;

Rollbar::init($config);

App::uses('RollbarErrorHandler', 'CakeRollbar.Lib');

Configure::write('Error', array(
        'handler' => 'RollbarErrorHandler::handleError',
        'level' => E_ALL & ~E_DEPRECATED,
        'trace' => true
));

Configure::write('Exception', array(
        'handler' => 'RollbarErrorHandler::handleException',
        'renderer' => 'ExceptionRenderer',
        'log' => true
));