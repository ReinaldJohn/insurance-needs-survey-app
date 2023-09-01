const mix = require("laravel-mix");

mix.js(
    [
        "resources/js/common_scripts.min.js",
        "resources/js/common_functions.js",
        "assets/validate.js",
    ],
    "public/js"
)
    .sass("resources/sass/styles.scss", "public/css")
    .postCss(
        [
            "resources/css/bootstrap.min.css",
            "resources/css/style.css",
            "resources/css/vendors.css",
            "resources/css/custom.css",
        ],
        "public/css",
        [require("postcss-custom-properties")]
    );

mix.copy("resources/css/bs-icon-font/*", "public/fonts")
    .copy("resources/css/bs-icon-font/fonts/*", "public/fonts")
    .copy("resources/css/smiles_icon_fonts/font/*", "public/fonts");
