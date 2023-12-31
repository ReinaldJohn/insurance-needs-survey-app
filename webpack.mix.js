// const mix = require("laravel-mix");
// const moment = require("moment"); // CommonJS syntax

// mix.js(["resources/js/common_functions.js", "assets/validate.js"], "public/js")
//     .scripts(
//         ["resources/js/common_scripts.min.js"],
//         "public/js/common_scripts.min.js"
//     )
//     .styles(
//         ["resources/css/bootstrap.min.css", ""],
//         "public/css/bootstrap.min.css"
//     )
//     .sass("resources/sass/styles.scss", "public/css/styles.scss")
//     .postCss(
//         "resources/css/style.css",
//         "resources/css/vendors.css",
//         "public/css",
//         [require("postcss-custom-properties")]
//     );

// // mix.copy("resources/css/bs-icon-font/*", "public/fonts")
// //     .copy("resources/css/bs-icon-font/fonts/*", "public/fonts")
// //     .copy("resources/css/smiles_icon_fonts/font/*", "public/fonts");

const mix = require("laravel-mix");

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

// mix.override((webpackConfig) => {
//     webpackConfig.plugins.forEach((plugin) => {
//         if (plugin.constructor.name === "FriendlyErrorsWebpackPlugin") {
//             plugin.options.clearConsole = false;
//         }
//     });
// });

mix.js("resources/js/app.js", "public/js")
    .js("resources/js/bootstrap.js", "public/js")
    .js(["resources/js/common_functions.js"], "public/js/common.js")
    .js(
        [
            "resources/js/reservation_wizard_func.js",
            "resources/js/daterangepicker_func.js",
            "resources/js/quotation_wizard_func.js",
            "resources/js/registration_wizard_func.js",
            "resources/js/autocomplete_func.js",
            "resources/js/review_wizard_func.js",
            "resources/js/parallax.js",
            "resources/js/owl-carousel.js",
        ],
        "public/js/plugins.js"
    )
    .postCss("resources/css/app.css", "public/css")

    .postCss("resources/css/style.css", "public/css")
    .postCss("resources/css/custom.css", "public/css")
    .copy("resources/img", "public/img")
    .sourceMaps();
