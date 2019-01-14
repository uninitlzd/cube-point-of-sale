const mix = require('laravel-mix');
const workboxPlugin = require('workbox-webpack-plugin')


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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .extract([
        'axios',
        'bootstrap',
        'jquery',
        'vue', 'vue-axios', 'vue-data-tables', 'vue-router', 'vuebar', 'vuex', 'vue-offline', 'vuex-persist',
        'element-ui',
        'lodash',
        'popper.js',
        'accounting-js'
    ])

if (mix.inProduction()) {
    mix.webpackConfig({
        plugins: [
            new workboxPlugin.InjectManifest({
                swSrc: 'public/sw-offline.js', // more control over the caching
                swDest: 'sw.js', // the service-worker file name
                importsDirectory: 'service-worker', // have a dedicated folder for sw files,
                maximumFileSizeToCacheInBytes: 10 * 1024 * 1024,
                templatedUrls: {
                    '/': 'resources/views/main.blade.php',
                }
            })
        ]
    })
}
