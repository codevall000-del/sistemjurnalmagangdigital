/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
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
        // Apple Design System Palette (SF Pro / macOS & iOS Inspired)
        "surface": "#f5f5f7",                  // Apple System Canvas / Gray 6 background
        "surface-dim": "#e5e5ea",              // Apple System Gray 5
        "surface-bright": "#ffffff",           // Pure White
        "surface-container-lowest": "#ffffff", // Crisp elevated card surface
        "surface-container-low": "#fbfbfd",    // Subtle light elevation
        "surface-container": "#f0f0f5",        // Grouping background
        "surface-container-high": "#e8e8ed",   // Apple System Gray 5 high
        "surface-container-highest": "#d1d1d6",// Apple System Gray 4
        "surface-variant": "#f2f2f7",          // Apple Secondary System Grouped Background
        "surface-tint": "#0071e3",
        "on-surface": "#1d1d1f",               // Apple Primary Label (near-black, high contrast)
        "on-surface-variant": "#86868b",       // Apple Secondary Label
        "inverse-surface": "#1d1d1f",
        "inverse-on-surface": "#f5f5f7",
        "outline": "#d2d2d7",                  // Apple System Hairline separator
        "outline-variant": "#e5e5ea",          // Apple System Ultra-fine border

        // Primary: Apple System Blue (Vibrant & Trusted)
        "primary": "#0071e3",                  // Apple Official Blue
        "on-primary": "#ffffff",
        "primary-container": "#0077ed",        // Apple Interactive Blue Hover
        "on-primary-container": "#ffffff",
        "primary-fixed": "#e8f2ff",            // Apple Blue Tint Background
        "primary-fixed-dim": "#b9d8ff",
        "on-primary-fixed": "#004085",
        "on-primary-fixed-variant": "#002d5e",
        "inverse-primary": "#409cff",

        // Secondary: Apple System Indigo / Purple
        "secondary": "#5e5ce6",                // Apple Indigo
        "on-secondary": "#ffffff",
        "secondary-container": "#f2f2fe",
        "on-secondary-container": "#3634a3",
        "secondary-fixed": "#e8e8fc",
        "secondary-fixed-dim": "#d0d0f9",
        "on-secondary-fixed": "#1e1d70",
        "on-secondary-fixed-variant": "#3634a3",

        // Tertiary: Apple System Mint / Green
        "tertiary": "#34c759",                 // Apple System Green
        "on-tertiary": "#ffffff",
        "tertiary-container": "#28cd41",
        "on-tertiary-container": "#ffffff",
        "tertiary-fixed": "#e8f9ed",
        "tertiary-fixed-dim": "#c7f3d2",
        "on-tertiary-fixed": "#08541c",
        "on-tertiary-fixed-variant": "#147a32",

        // Status Colors (Apple Human Interface Guidelines)
        "apple-blue": "#0071e3",
        "apple-purple": "#af52de",
        "apple-pink": "#ff2d55",
        "apple-red": "#ff3b30",
        "apple-orange": "#ff9500",
        "apple-yellow": "#ffcc00",
        "apple-green": "#34c759",
        "apple-teal": "#30b0c7",
        "apple-indigo": "#5856d6",
        "apple-canvas": "#f5f5f7",
        "apple-card": "#ffffff",
        "apple-text": "#1d1d1f",
        "apple-subtext": "#86868b",
        "apple-border": "#e5e5ea",

        "error": "#ff3b30",
        "on-error": "#ffffff",
        "error-container": "#ffe5e5",
        "on-error-container": "#d70015",

        "background": "#f5f5f7",
        "on-background": "#1d1d1f"
      },
      fontFamily: {
        serif: ['-apple-system', 'BlinkMacSystemFont', '"SF Pro Display"', '"Plus Jakarta Sans"', 'sans-serif'],
        headline: ['-apple-system', 'BlinkMacSystemFont', '"SF Pro Display"', '"SF Pro Text"', 'Inter', 'sans-serif'],
        body: ['-apple-system', 'BlinkMacSystemFont', '"SF Pro Text"', '"SF Pro"', 'Inter', 'sans-serif'],
        mono: ['"SF Mono"', 'SFMono-Regular', 'Menlo', 'Monaco', 'Consolas', 'monospace'],
        "headline-xl": ['-apple-system', 'BlinkMacSystemFont', '"SF Pro Display"', 'sans-serif'],
        "headline-lg": ['-apple-system', 'BlinkMacSystemFont', '"SF Pro Display"', 'sans-serif'],
        "headline-md": ['-apple-system', 'BlinkMacSystemFont', '"SF Pro Display"', 'sans-serif'],
        "headline-sm": ['-apple-system', 'BlinkMacSystemFont', '"SF Pro Text"', 'sans-serif'],
        "body-lg": ['-apple-system', 'BlinkMacSystemFont', '"SF Pro Text"', 'sans-serif'],
        "body-md": ['-apple-system', 'BlinkMacSystemFont', '"SF Pro Text"', 'sans-serif'],
        "body-sm": ['-apple-system', 'BlinkMacSystemFont', '"SF Pro Text"', 'sans-serif'],
        "label-md": ['-apple-system', 'BlinkMacSystemFont', '"SF Pro Text"', 'sans-serif'],
        "label-sm": ['-apple-system', 'BlinkMacSystemFont', '"SF Pro Text"', 'sans-serif'],
        "code-sm": ['"SF Mono"', 'Menlo', 'monospace']
      },
      fontSize: {
        "label-sm": ["11px", { lineHeight: "14px", letterSpacing: "0.02em", fontWeight: "500" }],
        "label-md": ["12px", { lineHeight: "16px", letterSpacing: "0.01em", fontWeight: "600" }],
        "body-sm": ["13px", { lineHeight: "18px", letterSpacing: "-0.005em", fontWeight: "400" }],
        "body-md": ["14px", { lineHeight: "21px", letterSpacing: "-0.01em", fontWeight: "400" }],
        "body-lg": ["16px", { lineHeight: "24px", letterSpacing: "-0.015em", fontWeight: "400" }],
        "headline-sm": ["16px", { lineHeight: "22px", letterSpacing: "-0.015em", fontWeight: "600" }],
        "headline-md": ["20px", { lineHeight: "26px", letterSpacing: "-0.02em", fontWeight: "600" }],
        "headline-lg": ["24px", { lineHeight: "30px", letterSpacing: "-0.025em", fontWeight: "700" }],
        "headline-xl": ["32px", { lineHeight: "38px", letterSpacing: "-0.03em", fontWeight: "700" }]
      },
      borderRadius: {
        "apple": "14px",
        "apple-lg": "18px",
        "apple-xl": "22px",
        "apple-2xl": "28px"
      },
      boxShadow: {
        "apple-subtle": "0 2px 8px -1px rgba(0, 0, 0, 0.04), 0 1px 3px -1px rgba(0, 0, 0, 0.02)",
        "apple-card": "0 4px 20px -2px rgba(0, 0, 0, 0.05), 0 2px 6px -1px rgba(0, 0, 0, 0.02)",
        "apple-elevated": "0 12px 36px -4px rgba(0, 0, 0, 0.08), 0 4px 12px -2px rgba(0, 0, 0, 0.03)",
        "apple-modal": "0 24px 60px -8px rgba(0, 0, 0, 0.16), 0 8px 20px -4px rgba(0, 0, 0, 0.06)",
        "apple-float": "0 8px 24px rgba(0, 113, 227, 0.18)"
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
