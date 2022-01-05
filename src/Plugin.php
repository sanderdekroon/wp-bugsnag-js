<?php

declare(strict_types=1);

namespace Sanderdekroon\BugsnagJs;

class Plugin
{
    protected ?Container $container = null;

    public function setup(Container $container = null): void
    {
        $this->container = $container ?: new Container();
        // And this is were the magic happens ( ͡° ͜ʖ ͡°)
        $this->container->set(Container::class, fn(Container $container): Container => $container);

        $pluginConfig = new ConfigFileLoader(dirname(__DIR__) . '/config/container.php');

        foreach ($pluginConfig->get() as $abstract => $value) {
            $this->container->set($abstract, $value);
        }
    }

    public function boot(): void
    {
        $this->registerServiceProviders();
    }

    protected function registerServiceProviders(): void
    {
        $this->container->get(ScriptServiceProvider::class)->register();
        $this->container->get(SettingsServiceProvider::class)->register();
    }
}
