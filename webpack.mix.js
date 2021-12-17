const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');

//HOME
mix.js('resources/js/project_scripts/home/index.js', 'public/js/home');

//HOME USER
mix.js('resources/js/project_scripts/homeUser/index.js', 'public/js/homeUser');

//USER
mix.js('resources/js/project_scripts/user/index.js', 'public/js/user');

//RESTAURANT
mix.js('resources/js/project_scripts/restaurant/index.js', 'public/js/restaurant');
mix.js('resources/js/project_scripts/restaurant/create.js', 'public/js/restaurant');
mix.js('resources/js/project_scripts/restaurant/update.js', 'public/js/restaurant');

//CATEGORY
mix.js('resources/js/project_scripts/category/index.js', 'public/js/category');

//PLATE
mix.js('resources/js/project_scripts/plate/index.js', 'public/js/plate');
