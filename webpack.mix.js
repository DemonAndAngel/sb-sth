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
mix.webpackConfig({
    module: {
        rules:[
            {
                test: /\.less$/,
                loader: 'less-loader',
                options: {
                    sourceMap: true,
                    javascriptEnabled: true // <- enable this option
                }
            }
        ]
    }
});
mix.js('resources/js/app.js', 'public/js').version();
