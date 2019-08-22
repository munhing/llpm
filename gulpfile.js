var elixir = require('laravel-elixir');

require('laravel-elixir-vueify');

elixir(function(mix) {
    // mix.browserify('app.js');
    mix.browserify('main.js');
    // mix.browserify('search.js');
    // mix.browserify('vueapp.js');
});