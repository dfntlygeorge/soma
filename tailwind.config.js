import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                olive: {
                    50: "#f7f8f0",
                    100: "#eceede",
                    200: "#d9dcbd",
                    300: "#c1c692",
                    400: "#aab069",
                    500: "#94984a",
                    600: "#767a39",
                    700: "#5c5f30",
                    800: "#4c4f29",
                    900: "#424526",
                },
            },
        },
    },

    plugins: [forms, require("daisyui")],
};
