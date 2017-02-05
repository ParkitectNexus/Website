var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass(['app.scss', 'wiki.scss'], 'public/css/app.css');

    mix.scripts(['*.js'], 'public/js/app.js');

    mix.version([
        'css/app.css',
        'css/wiki.css',
        'js/app.js'
    ]);

    mix.copy(
        'resources/assets/libs/bootstrap-sass/assets/fonts',
        'public/build/fonts'
    );

    mix.copy("node_modules/bootstrap-sass/assets/fonts","public/build/fonts");
});
