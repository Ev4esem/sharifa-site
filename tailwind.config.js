/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./*.html"],
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        "primary": "#324c69",
        "background-light": "#f5fcfe",
        "background-dark": "#111821",
        "accent-blue": "#cedbea",
        "accent-muted": "#8696ad",
        "text-main": "#0e131b",
        "text-muted": "#506d95"
      },
      fontFamily: { "display": ["Manrope", "sans-serif"] },
      borderRadius: { "DEFAULT": "0.75rem", "lg": "0.75rem", "xl": "0.75rem", "full": "9999px" }
    }
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/container-queries')
  ]
}
