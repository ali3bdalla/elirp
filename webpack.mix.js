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
    .sass('resources/scss/app.scss', 'public/css/app.css', {
        sassOptions: {
            outputStyle: 'nested',
        },
        implementation: require('node-sass')
    })
    .copyDirectory('resources/assets','public/assets')
    .webpackConfig(require('./webpack.config'));

if (mix.inProduction()) {
    mix.version();
}

if (!mix.inProduction()) {
    mix.browserSync('elirp-next.test');
}
