module.exports = {
  content: [
    "./*.js",
    "./templates/**/*.html.twig"
  ],
  theme: {
    extend: {},
  },
  plugins: [require('@tailwindcss/forms')],
}
