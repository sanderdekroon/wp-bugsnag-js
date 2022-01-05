<?php

use Sanderdekroon\BugsnagJs\ApiKey;
use Sanderdekroon\BugsnagJs\Container;
use Sanderdekroon\BugsnagJs\Utility\Request;
use Sanderdekroon\BugsnagJs\Storage\OptionStorage;

return [
    'plugin.name'       => 'Bugsnag for Browser (Javascript)',
    'plugin.slug'       => 'bugsnag-js',
    'plugin.version'    => '1.0.0',
    'plugin.path'       => dirname(__DIR__),
    'plugin.url'        => plugins_url(basename(dirname(__DIR__))),

    Request::class => fn() => Request::fromGlobal(),
    ApiKey::class => fn() => new ApiKey(new OptionStorage()),

    'view.admin.configuration' => function (Container $container) {
        return $container->get('plugin.path') . '/assets/views/admin.configuration.php';
    },
];
