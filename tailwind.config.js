/** @type {import("tailwindcss").Config} */
module.exports = {
    purge: {
        content: [
            "./resources/**/*.blade.php",
            "./resources/**/*.js",
            "./vendor/wireui/wireui/resources/**/*.blade.php",
            "./vendor/wireui/wireui/ts/**/*.ts",
            "./vendor/wireui/wireui/src/View/**/*.php",
        ],
    },
    theme: {
        extend: {},
    },
    presets: [
        require("./vendor/wireui/wireui/tailwind.config.js"),
    ],
    plugins: [
        require("@tailwindcss/aspect-ratio"),
        require("@tailwindcss/typography"),
        require("@tailwindcss/forms"),
    ],
};
