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
mix.js('resources/assets/js/danhsachnguoidung.js', 'public/js/danhsachnguoidung2.js');
mix.js('resources/assets/js/login.js', 'public/js/login.js');
mix.js('resources/assets/js/profile.js', 'public/js/profile.js');
mix.js('resources/assets/js/register.js', 'public/js/register.js');