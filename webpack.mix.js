// webpack.mix.js

let mix = require('laravel-mix');

mix
    .sass('src/styles/*.scss', 'dist/styles/')
    .css('src/styles/*.css', 'dist/styles/')
    .sass('src/styles/compat/5.9/*.scss', 'dist/styles/compat/5.9/')
    .copy('src/index.php', 'dist/')
    .copyDirectory('src/assets/', 'dist/assets/')
    .copyDirectory('src/settings/', 'dist/settings/')
    // .copyDirectory('src/**', 'dist/')