module.exports = {
  plugins: [
    require('tailwindcss/nesting'),
    require('tailwindcss'),
    require('autoprefixer'),
    require('postcss-preset-env')({
        browsers: 'last 2 versions',
    }),
  ]
}
