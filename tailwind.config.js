/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        // Build directly from package source views/assets.
        "./src/Resources/**/*.blade.php",
        "./src/Resources/**/*.js",

        // Keep published views as fallback during transition.
        "../../../resources/themes/beanspa/**/*.blade.php",
    ],

    theme: {
        container: {
            center: true,

            screens: {
                "2xl": "1440px",
            },

            padding: {
                DEFAULT: "90px",
            },
        },

        screens: {
            sm: "525px",
            md: "768px",
            lg: "1024px",
            xl: "1240px",
            "2xl": "1440px",
            1180: "1180px",
            1060: "1060px",
            991: "991px",
            868: "868px",
        },

        extend: {
            colors: {
                // Legacy aliases kept to avoid breaking existing templates.
                navyBlue: "#060C3B",
                lightOrange: "#F6F2EB",
                darkGreen: '#40994A',
                darkBlue: '#0044F2',
                darkPink: '#F85156',

                // Beanspa design tokens mapped from the original static theme.
                beanspa: {
                    primary: "#1B6060",
                    accent: "#F0A793",
                    text: "#000000",
                    surface: "#F6F3ED",
                    hover: "#F0A793",
                    support: "#1B6060",
                    price: "#FC0000",
                    footer: "#F6F3ED",
                },

                // Semantic aliases for reusable component styling.
                brand: {
                    primary: "#1B6060",
                    accent: "#F0A793",
                },
                surface: {
                    base: "#F6F3ED",
                    footer: "#F6F3ED",
                },
                content: {
                    primary: "#000000",
                },
            },

            fontFamily: {
                poppins: ["Poppins", "sans-serif"],
                dmserif: ["DM Serif Display", "serif"],
                bitter: ["Bitter", "serif"],

                // Semantic font tokens.
                body: ["Poppins", "sans-serif"],
                heading: ["Bitter", "DM Serif Display", "serif"],
            },

            spacing: {
                // Layout rhythm tokens.
                "section-y": "5rem",
                "section-y-lg": "7rem",
                "block-gap": "2rem",
                "card-pad": "1.25rem",
                "inline-gap": "0.875rem",
            },

            borderRadius: {
                // Corner tokens from original design language.
                "beanspa": "20px",
                "beanspa-sm": "12px",
                "beanspa-lg": "28px",
                "beanspa-pill": "9999px",
            },
        }
    },

    plugins: [],


};
