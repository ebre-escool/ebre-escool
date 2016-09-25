const elixir = require('laravel-elixir');

require('laravel-elixir-vue');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss')
        .less('app.less', './public/css/app_less.css')
        .less('./node_modules/toastr/toastr.less')
        .styles([
            './public/css/app.css',
            './node_modules/font-awesome/css/font-awesome.css',
            './node_modules/admin-lte/dist/css/skins/_all-skins.css',
            './public/css/app_less.css',
            './node_modules/icheck/skins/all.css',
            './public/css/toastr.css'
        ])
        .copy('node_modules/font-awesome/fonts/*.*','public/fonts/')
        .copy('node_modules/ionicons/dist/fonts/*.*','public/fonts/')
        .webpack('app.js');
    //Adminlte
    mix.less('adminlte-app.less');
    mix.less('admin-lte/AdminLTE.less');
    mix.less('bootstrap/bootstrap.less');
    //App
    mix.less('adminlte-app.less');
});
