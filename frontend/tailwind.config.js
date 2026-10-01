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
        // Serene Academic Desk Palette (Calm Slate-Navy & Azure)
        "surface": "#f8f9ff",                  // Serene low-fatigue slate canvas
        "surface-dim": "#ccdbf3",
        "surface-bright": "#ffffff",           // Pure white
        "surface-container-lowest": "#ffffff", // Pure white for cards & sidebars
        "surface-container-low": "#eff4ff",    // Soft azure tint elevation
        "surface-container": "#e6eeff",        // Muted academic surface
        "surface-container-high": "#dce9ff",   // Subtle grouping
        "surface-container-highest": "#d5e3fc",// Soft border elevation
        "surface-variant": "#d5e3fc",
        "surface-tint": "#455f87",
        "on-surface": "#0d1c2e",               // Deep legible contrast
        "on-surface-variant": "#43474e",       // Balanced body text slate
        "inverse-surface": "#233144",
        "inverse-on-surface": "#eaf1ff",
        "outline": "#74777f",
        "outline-variant": "#c4c6cf",          // Refined micro-border

        // Primary: Deep Academic Navy
        "primary": "#022448",                  // Deep academic navy
        "on-primary": "#ffffff",
        "primary-container": "#1e3a5f",        // Poised slate navy
        "on-primary-container": "#8aa4cf",
        "primary-fixed": "#d5e3ff",
        "primary-fixed-dim": "#adc8f5",
        "on-primary-fixed": "#001c3b",
        "on-primary-fixed-variant": "#2d486d",
        "inverse-primary": "#adc8f5",

        // Secondary: Calm Desaturated Azure
        "secondary": "#126588",                // Soft calm azure
        "on-secondary": "#ffffff",
        "secondary-container": "#94d7ff",
        "on-secondary-container": "#015f81",
        "secondary-fixed": "#c4e7ff",
        "secondary-fixed-dim": "#8ccff6",
        "on-secondary-fixed": "#001e2c",
        "on-secondary-fixed-variant": "#004c69",

        // Tertiary: Refined Emerald / Forest (Clean status indicator)
        "tertiary": "#047857",                 // Emerald-700
        "on-tertiary": "#ffffff",
        "tertiary-container": "#059669",       // Emerald-600
        "on-tertiary-container": "#d1fae5",
        "tertiary-fixed": "#d1fae5",           // Soft mint chip
        "tertiary-fixed-dim": "#a7f3d0",
        "on-tertiary-fixed": "#064e3b",
        "on-tertiary-fixed-variant": "#065f46",

        "error": "#ba1a1a",
        "on-error": "#ffffff",
        "error-container": "#ffdad6",
        "on-error-container": "#93000a",

        "background": "#f8f9ff",
        "on-background": "#0d1c2e"
      },
      fontFamily: {
        serif: ['"Playfair Display"', 'Georgia', 'serif'],
        headline: ['"Plus Jakarta Sans"', '"Space Grotesk"', 'sans-serif'],
        body: ['Inter', 'Geist', 'sans-serif'],
        mono: ['Geist', '"JetBrains Mono"', 'monospace'],
        "headline-xl": ['"Plus Jakarta Sans"', 'sans-serif'],
        "headline-lg": ['"Plus Jakarta Sans"', 'sans-serif'],
        "headline-md": ['"Plus Jakarta Sans"', 'sans-serif'],
        "headline-sm": ['"Plus Jakarta Sans"', 'sans-serif'],
        "body-lg": ['Inter', 'sans-serif'],
        "body-md": ['Inter', 'sans-serif'],
        "body-sm": ['Inter', 'sans-serif'],
        "label-md": ['Inter', 'sans-serif'],
        "label-sm": ['Inter', 'sans-serif'],
        "code-sm": ['Geist', 'monospace']
      },
      fontSize: {
        "label-sm": ["11px", { lineHeight: "14px", letterSpacing: "0.03em", fontWeight: "500" }],
        "label-md": ["12px", { lineHeight: "16px", letterSpacing: "0.02em", fontWeight: "600" }],
        "body-sm": ["13px", { lineHeight: "18px", letterSpacing: "0.005em", fontWeight: "400" }],
        "body-md": ["14px", { lineHeight: "22px", letterSpacing: "0em", fontWeight: "400" }],
        "body-lg": ["16px", { lineHeight: "26px", letterSpacing: "0em", fontWeight: "400" }],
        "headline-sm": ["16px", { lineHeight: "24px", letterSpacing: "-0.005em", fontWeight: "600" }],
        "headline-md": ["20px", { lineHeight: "28px", letterSpacing: "-0.01em", fontWeight: "600" }],
        "headline-lg": ["24px", { lineHeight: "32px", letterSpacing: "-0.015em", fontWeight: "600" }],
        "headline-xl": ["32px", { lineHeight: "40px", letterSpacing: "-0.02em", fontWeight: "700" }]
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
