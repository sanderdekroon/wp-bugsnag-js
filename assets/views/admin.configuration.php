<form method="POST" action="<?php echo admin_url('options-general.php?page=bugsnag-js'); ?>">
    <input type="hidden" name="bugsnagjs_nonce" value="<?php echo wp_create_nonce('bugsnagjs_update_settings'); ?>">

    <?php foreach ($notices->get() as $notice) : ?>
        <div class="notice notice-<?php echo $notice['positive'] ? 'success' : 'error'; ?>">
            <p><?php echo esc_html($notice['message']); ?></p>
        </div>
    <?php endforeach; ?>

    <h3><?php echo __('Bugsnag Browser settings', 'sdk-bugsnag-js'); ?></h3>
    <p><?php echo __('Bugsnag automatically detects errors & crashes in Javascript files for all plugins & themes.', 'sdk-bugsnag-js'); ?></p>

    <p><?php echo __("Errors are sent to your Bugsnag Dashboard for you to view and debug. If you do not have an account yet, simply signup at", 'sdk-bugsnag-js'); ?> <a href="https://bugsnag.com/" target="_BLANK">bugsnag.com</a>.</p>

    <div class="form__row">
        <div class="form__row-label">
            <label><?php echo __('API Key', 'sdk-bugsnag-js'); ?></label>
        </div>
        <div class="form__row-input">
            <label>
                <input type="text" name="bugsnagjs_api_key" value="<?php echo $apiKey->get(); ?>" placeholder="<?php echo __('Bugsnag Browser API Key', 'sdk-bugsnag-js'); ?>">
            </label>
        </div>
    </div>

    <div class="form__row">
        <div class="form__row-label"></div>
        <div class="form__row-input">
            <input type="submit" class="button-primary" name="bugsnagjs_save_settings" value="<?php echo __('Save', 'sdk-bugsnag-js'); ?>">
        </div>
    </div>

    <div class="form__row">
        <div class="form__row-label">
            <p><strong><?php echo __('Custom options', 'sdk-bugsnag-js'); ?></strong></p>
        </div>
        <div class="form__row-input">
            <p><?php echo sprintf(
                __('If you want to add custom configuration options, use the %1$s filter. View %2$s to see which options are available.', 'sdk-bugsnag-js'),
                '<code>bugsnagjs_configuration_options</code>',
                '<a href="https://docs.bugsnag.com/platforms/javascript/configuration-options/" target="_BLANK">' . __('the Bugsnag documentation', 'sdk-bugsnag-js') . '</a>'
            ); ?></p>
        </div>
    </div>
</form>
