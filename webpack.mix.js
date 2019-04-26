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

mix
    .js('resources/assets/js/modules/globales.js', 'public/js')
    .js('resources/assets/js/app.js', 'public/js')
    .js('resources/assets/js/appLogin.js', 'public/js')
    .js('resources/assets/js/appPeople.js', 'public/js')
    .js('resources/assets/js/appMesas.js', 'public/js')
    .js('resources/assets/js/appIngreso.js', 'public/js')
    .js('resources/assets/js/appOrdenes.js', 'public/js')
    .js('resources/assets/js/appCobrar.js', 'public/js')
    .js('resources/assets/js/appReporte.js', 'public/js')
    .js('resources/assets/js/appUtensilios.js', 'public/js')
    .js('resources/assets/js/appProveedores.js','public/js')
    .js('resources/assets/js/appPlanilla.js','public/js')
;
