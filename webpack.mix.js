let mix = require('laravel-mix')

mix
  .setPublicPath('src/public')
  .js('src/resources/js/search.js', 'js')
