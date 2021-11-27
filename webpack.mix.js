let mix = require('laravel-mix');

mix.js('resources/assets/js/app.js', 'public/js')
.sass('resources/compile_css/app.scss', 'public/css');