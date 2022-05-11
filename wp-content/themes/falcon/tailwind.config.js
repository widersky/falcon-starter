module.exports = {
    mode: 'jit',
    content: ["./**/*.php"],
    theme: {
        extend: {
            colors: {
                'primary': ''
            }
        },
    },
    plugins: [
        require('@tailwindcss/typography')
    ],
};
