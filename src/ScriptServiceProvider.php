<?php

declare(strict_types=1);

namespace Sanderdekroon\BugsnagJs;

class ScriptServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts'], PHP_INT_MIN);
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdminStyle']);
    }

    public function enqueueScripts(): void
    {
        $apiKey = $this->container->get(ApiKey::class)->get();
        if (empty($apiKey)) {
            return;
        }

        wp_enqueue_script(
            'bugsnagjs_script',
            $this->container->get('plugin.url') . '/assets/dist/js/front.js',
            [],
            $this->container->get('plugin.version'),
            true
        );

        wp_localize_script(
            'bugsnagjs_script',
            'bugsnagjs',
            apply_filters('bugsnagjs_configuration_options', compact('apiKey'))
        );
    }

    public function enqueueAdminStyle(): void
    {
        wp_enqueue_style(
            'bugsnagjs_admin_styles',
            $this->container->get('plugin.url') . '/assets/dist/css/admin.css',
            [],
            $this->container->get('plugin.version')
        );
    }
}
