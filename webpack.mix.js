const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');

//HOME
mix.js('resources/js/project_scripts/home/index.js', 'public/js/home');

//USER
mix.js('resources/js/project_scripts/user/index.js', 'public/js/user');
