module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['var(--font-sans)'],
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}