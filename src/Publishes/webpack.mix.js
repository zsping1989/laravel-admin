const { mix } = require('laravel-mix');

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
    resolve: {
        alias: {
            "public": path.resolve(__dirname, 'resources/assets/js/public/')
        }
    }
});

mix.js('resources/assets/js/admin/app.js', 'public/js/admin') .version();
mix.js('resources/assets/js/home/app.js', 'public/js/home') .version();
mix.js('resources/assets/js/open/app.js', 'public/js/open') .version();
mix.sass('resources/assets/sass/app.scss', 'public/css').version();


