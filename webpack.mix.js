const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js').vue()
    .sass('resources/scss/app.scss', 'public/css/app.css')
    .sass('resources/scss/template/sb-admin-2.scss', 'public/css/sb-admin-2.css')
    .sass('resources/scss/sb-admin-rtl.scss', 'public/css/sb-admin-rtl.css')
    .copyDirectory('resources/img','public/img')
    .copyDirectory('resources/template','public/template')
    .webpackConfig(require('./webpack.config'));

if (mix.inProduction()) {
    mix.version();
}

if (!mix.inProduction()) {
    mix.browserSync('elirp-next.test');
}
