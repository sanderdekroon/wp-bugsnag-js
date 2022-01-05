import Bugsnag from '@bugsnag/js'

if (
    typeof window.bugsnagjs === 'object' &&
    typeof window.bugsnagjs.apiKey === 'string'
) {
    Bugsnag.start(window.bugsnagjs);
} else {
    console.warn('The Bugsnag error reporting script was loaded, but no API key was found!');
}
