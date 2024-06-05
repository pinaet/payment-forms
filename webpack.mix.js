const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .js('resources/js/app.js', 'public/js')
    .js('resources/js/datatable.js', 'public/js')
    .js('resources/js/datatable-event.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

mix
    .setResourceRoot('../'); //solve fonts not found

mix
    .js('resources/js/admin-index.js', 'public/js')
    .js('resources/js/validate-input.js', 'public/js')
    .js('resources/js/school-fee-index.js', 'public/js')
    .js('resources/js/application-fee-input.js', 'public/js')
    .js('resources/js/application-fee-index.js', 'public/js')
    .js('resources/js/event-order-index.js', 'public/js')
    .sourceMaps(false, 'source-map')

mix
    .js('resources/js/alumni-form-result.js', 'public/js')
    .js('resources/js/alumni-report.js', 'public/js')
    .js('resources/js/event-report.js', 'public/js')
    .sass('resources/sass/plain-report.scss', 'public/css');

mix
    .sass('resources/sass/util.scss', 'public/css')
    .sass('resources/sass/main.scss', 'public/css');
