let mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');
const webpack = require('webpack');

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

mix.js('resources/assets/js/app.js', 'public/js')
    .extract([
        'moment'
    ])
    .sass('resources/assets/sass/app.scss', 'public/css/app.css')
    .webpackConfig({
        plugins: [
            new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/)
        ]
    })
    .options({
        processCssUrls: false,
        postCss:        [tailwindcss('./tailwind.js')],
    });
