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

//ccs
mix.styles([
    'resources/assets/css/jquery-ui.css',
    'resources/assets/css/bootstrap.min.css',
], 'public/assets/css/main.css')
//js
mix.styles([
    'resources/assets/js/jquery-3.5.1.min.js'
],'public/assets/js/main.js')
