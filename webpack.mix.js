let mix = require('laravel-mix');

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

const notInProduction = !mix.inProduction();

mix.js('resources/assets/js/app.js', 'public/js');
mix.sass('resources/assets/sass/app.scss', 'public/css');

if (notInProduction) {
  mix.webpackConfig({
    devtool: 'source-map'
  });
}
