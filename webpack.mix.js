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




//backend
mix.js([
    //'public/backend/plugins/jquery/jquery.min.js',
    'resources/js/app.js',
    //'public/backend/plugins/bootstrap/js/bootstrap.bundle.min.js',
    //'public/backend/dist/js/adminlte.min.js',
], 'public/app.js');
    

// mix.styles([
//     'public/backend/plugins/fontawesome-free/css/all.min.css',
//     'public/backend/dist/css/adminlte.min.css'
// ], 'public/backend/app.css');