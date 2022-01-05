<?php

/**
 * Plugin Name: Bugsnag for Browser (Javascript)
 * Plugin URI: https://github.com/sanderdekroon/wp-bugsnag-js
 * Description: Easily add Bugsnag error monitoring for your front-end
 * Author: sanderdekroon
 * Author URI: https://github.com/sanderdekroon/
 * Version: 1.0.0
 * Text Domain: sdk-bugsnag-js
 */

namespace Sanderdekroon\BugsnagJs;

require __DIR__ . '/vendor/autoload.php';

$plugin = new Plugin();
$plugin->setup();
$plugin->boot();
