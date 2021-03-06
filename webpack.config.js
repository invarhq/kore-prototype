var Encore = require('@symfony/webpack-encore');
var WebpackShellPlugin = require('webpack-shell-plugin');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())

    // uncomment to create hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // will create public/build/app.js and public/build/app.css
    .addEntry('app', './src/view/assets/js/app.js')
    .addStyleEntry('appCss', './src/view/assets/css/app.css')
    .enableVueLoader()

    // uncomment to define the assets of the project
    // .addEntry('js/app', './assets/js/app.js')
    // .addStyleEntry('css/app', './assets/css/app.scss')

    // uncomment if you use Sass/SCSS files
    // .enableSassLoader()

    // uncomment for legacy applications that require $/jQuery as a global variable
    // .autoProvidejQuery()
;



module.exports = Encore.getWebpackConfig();
