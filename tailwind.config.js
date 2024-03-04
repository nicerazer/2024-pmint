import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class", // This specifies that Tailwind should look at Class elements to determine dark mode

    content: [
        // "./vendor/ramonrietdijk/livewire-tables/resources/**/*.blade.php",
        "./resources/specialclasses.html",
        "./vendor/rappasoft/laravel-livewire-tables/resources/views/**/*.blade.php",
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    daisyui: {
        themes: ["emerald"],
    },

    plugins: [require("daisyui")],
    // plugins: [forms, require("daisyui")],
};
