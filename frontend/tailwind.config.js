/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./components/**/*.{js,vue,ts}",
    "./layouts/**/*.vue",
    "./pages/**/*.vue",
    "./plugins/**/*.{js,ts}",
    "./app.vue",
    "./error.vue"
  ],
  theme: {
    extend: {
      colors: {
        // Stitch "Field Verified Enterprise PKL" Design Tokens
        "surface": "#f8f9ff",
        "surface-dim": "#cbdbf5",
        "surface-bright": "#f8f9ff",
        "surface-container-lowest": "#ffffff",
        "surface-container-low": "#eff4ff",
        "surface-container": "#e5eeff",
        "surface-container-high": "#dce9ff",
        "surface-container-highest": "#d3e4fe",
        "surface-variant": "#d3e4fe",
        "surface-tint": "#2151da",
        "on-surface": "#0b1c30",
        "on-surface-variant": "#434655",
        "inverse-surface": "#213145",
        "inverse-on-surface": "#eaf1ff",
        "outline": "#747686",
        "outline-variant": "#c4c5d7",

        "primary": "#0037b0",
        "on-primary": "#ffffff",
        "primary-container": "#1d4ed8",
        "on-primary-container": "#cad3ff",
        "primary-fixed": "#dce1ff",
        "primary-fixed-dim": "#b7c4ff",
        "on-primary-fixed": "#001551",
        "on-primary-fixed-variant": "#0039b5",
        "inverse-primary": "#b7c4ff",

        "secondary": "#565e74",
        "on-secondary": "#ffffff",
        "secondary-container": "#dae2fd",
        "on-secondary-container": "#5c647a",
        "secondary-fixed": "#dae2fd",
        "secondary-fixed-dim": "#bec6e0",
        "on-secondary-fixed": "#131b2e",
        "on-secondary-fixed-variant": "#3f465c",

        "tertiary": "#004f35",
        "on-tertiary": "#ffffff",
        "tertiary-container": "#006948",
        "on-tertiary-container": "#76eab6",
        "tertiary-fixed": "#85f8c4",
        "tertiary-fixed-dim": "#68dba9",
        "on-tertiary-fixed": "#002114",
        "on-tertiary-fixed-variant": "#005137",

        "error": "#ba1a1a",
        "on-error": "#ffffff",
        "error-container": "#ffdad6",
        "on-error-container": "#93000a",

        "background": "#f8f9ff",
        "on-background": "#0b1c30"
      },
      fontFamily: {
        serif: ['"Playfair Display"', 'Georgia', 'serif'],
        headline: ['"Space Grotesk"', 'sans-serif'],
        body: ['Geist', 'system-ui', 'sans-serif'],
        mono: ['Geist', '"JetBrains Mono"', 'monospace'],
        "headline-xl": ['"Space Grotesk"', 'sans-serif'],
        "headline-lg": ['"Space Grotesk"', 'sans-serif'],
        "headline-md": ['"Space Grotesk"', 'sans-serif'],
        "headline-sm": ['"Space Grotesk"', 'sans-serif'],
        "body-lg": ['Geist', 'sans-serif'],
        "body-md": ['Geist', 'sans-serif'],
        "body-sm": ['Geist', 'sans-serif'],
        "label-md": ['Geist', 'sans-serif'],
        "label-sm": ['Geist', 'sans-serif'],
        "code-sm": ['Geist', 'monospace']
      },
      spacing: {
        "space-xs": "0.25rem",
        "space-sm": "0.5rem",
        "space-md": "1rem",
        "space-lg": "1.5rem",
        "space-xl": "2rem",
        "margin": "2rem",
        "gutter": "1.5rem",
        "gutter-mobile": "1rem",
        "margin-mobile": "1rem"
      }
    }
  },
  plugins: []
}
