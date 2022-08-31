/** @type {import("tailwindcss").Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./vendor/wireui/wireui/resources/**/*.blade.php",
        "./vendor/wireui/wireui/ts/**/*.ts",
        "./vendor/wireui/wireui/src/View/**/*.php",
        "./vendor/livewire-ui-modal/**/*.blade.php",
    ],
    options: {
        safelist: [
            "sm:max-w-2xl",
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
