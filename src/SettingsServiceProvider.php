<?php

declare(strict_types=1);

namespace Sanderdekroon\BugsnagJs;

use Sanderdekroon\BugsnagJs\Utility\Notices;
use Sanderdekroon\BugsnagJs\Utility\Request;

class SettingsServiceProvider extends ServiceProvider
{
    protected Request $request;
    protected Notices $notices;

    public function __construct(Container $container, Request $request)
    {
        parent::__construct($container);

        $this->request = $request;
        $this->notices = new Notices();
    }

    public function register(): void
    {
        add_action('admin_menu', [$this, 'addSubmenuPage']);
        add_action('admin_init', [$this, 'saveSettings']);
        add_filter('plugin_action_links', [$this, 'addSettingsLink'], 10, 2);
    }

    public function addSubmenuPage(): void
    {
        add_submenu_page(
            'options-general.php',
            $this->container->get('plugin.name'),
            $this->container->get('plugin.name'),
            'manage_options',
            $this->container->get('plugin.slug'),
            [$this, 'renderSettingsPage']
        );
    }

    public function renderSettingsPage(): void
    {
        $viewPath = (string) $this->container->get('view.admin.configuration');

        if (! file_exists($viewPath) || ! is_readable($viewPath)) {
            printf("Something went wrong while loading the configuration view.");

            return;
        }

        ob_start();

        $notices = $this->notices;
        $apiKey = $this->container->get(ApiKey::class);
        require $viewPath;

        print ob_get_clean();
    }

    public function saveSettings(): bool
    {
        if (! $this->request->isPost() || ! $this->request->has('bugsnagjs_api_key')) {
            return false;
        }

        $nonce = (string) $this->request->get('bugsnagjs_nonce', '');

        if (! $nonce || wp_verify_nonce($nonce, 'bugsnagjs_update_settings') === false) {
            $this->notices->addFailure(
                __('Unable to update Bugsnag settings: invalid nonce.', 'sdk-bugsnag-js')
            );

            return false;
        }

        $apiKey = sanitize_text_field($this->request->get('bugsnagjs_api_key', ''));

        if ($this->container->get(ApiKey::class)->get() === $apiKey) {
            $this->notices->addSuccess(
                __('The API key was not updated, because it has not changed.', 'sdk-bugsnag-js')
            );

            return true;
        }

        if (! $this->container->get(ApiKey::class)->update($apiKey)) {
            $this->notices->addFailure(
                __('The API key could not be updated.', 'sdk-bugsnag-js')
            );

            return false;
        }

        $this->notices->addSuccess(
            __('The API key was updated succesfully.', 'sdk-bugsnag-js')
        );

        return true;
    }

    public function addSettingsLink(array $links, string $file): array
    {
        if (dirname($file) === basename($this->container->get('plugin.path'))) {
            $links['settings'] = sprintf(
                '<a href="%1$s" target="_BLANK">%2$s</a>',
                admin_url('options-general.php?page=bugsnag-js'),
                __('Settings', 'sdk-bugsnag-js')
            );

            $links['sourcecode'] = sprintf(
                '<a href="https://github.com/sanderdekroon/wp-bugsnag-js" target="_BLANK">%s</a>',
                __('Source code', 'sdk-bugsnag-js')
            );
        }

        return $links;
    }
}
