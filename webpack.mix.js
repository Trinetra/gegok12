const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 | Tailwind 3 runs via PostCSS (postcss.config.js); no Mix Tailwind/PurgeCSS.
 */

mix.js("resources/assets/js/app.js", "public/js")
    .vue()
    .extract()
    .sass("resources/assets/sass/app.scss", "public/css");

if (mix.inProduction()) {
    mix.version();
} else {
    mix.sourceMaps();
}
