const mix = require('laravel-mix');
const fs = require('fs');

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

 const jsDirs = [
    {
        in: 'resources/js',
        out: 'js',
    },
    {
        in: 'resources/js/screens',
        out: 'js/screens',
    },
    {
        in: 'resources/js/screens/auth',
        out: 'js/screens/auth',
    },
    {
        in: 'resources/js/screens/news',
        out: 'js/screens/news',
    },
    {

        in: 'resources/js/screens/customer',
        out: 'js/screens/customer',
    },
    {
        in: 'resources/js/screens/user',
        out: 'js/screens/user',
    },
    {
        in: 'resources/js/screens/item',
        out: 'js/screens/item',
    },
    {
        in: 'resources/js/screens/push',
        out: 'js/screens/push',
    },
    {
        in: 'resources/js/screens/priority',
        out: 'js/screens/priority',
    },
];

let cssDirs = [
    {
        in: 'resources/css',
        out: 'css',
    },
    {
        in: 'resources/css/screens',
        out: 'css/screens',
    },
    {
        in: 'resources/css/screens/auth',
        out: 'css/screens/auth',
    },
    {
        in: 'resources/css/screens/item',
        out: 'css/screens/item',
    },
    {
        in: 'resources/css/screens/push',
        out: 'css/screens/push',
    },
    {
        in: 'resources/css/screens/priority',
        out: 'css/screens/priority',
    },
];

let getFiles = function (dir) {
    // get all 'files' in this directory
    // filter directories
    return fs.readdirSync(dir).filter(file => {
        return fs.statSync(`${dir}/${file}`).isFile();
    });
};

jsDirs.forEach(function (path) {
    getFiles(path.in).forEach(function (filepath) {
        mix.js(path.in + '/' + filepath, path.out);
    });
});

cssDirs.forEach(function (path) {
    getFiles(path.in).forEach(function (filepath) {
        mix.css(path.in + '/' + filepath, path.out);
    });
});

mix.copy('resources/js/library/jquery-validation/additional-setting.js', 'public/js/library/jquery-validation/additional-setting.js');

mix.version();
mix.disableNotifications();
