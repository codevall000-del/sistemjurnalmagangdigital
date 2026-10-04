// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2024-11-01',
  devtools: { enabled: false },
  ssr: false, // SPA Mode optimal for desktop application UI
  experimental: {
    appManifest: false
  },

  modules: [
    '@nuxtjs/tailwindcss'
  ],

  tailwindcss: {
    config: {
      darkMode: 'class'
    }
  },

  css: [
    '~/assets/css/main.css'
  ],

  app: {
    head: {
      title: 'EduAccess — SMKN 71 Jakarta',
      meta: [
        { charset: 'utf-8' },
        { name: 'viewport', content: 'width=device-width, initial-scale=1' },
        { name: 'description', content: 'EduAccess - Portal Jurnal & Presensi Praktik Kerja Lapangan SMKN 71 Jakarta' }
      ],
      link: [
        { rel: 'preconnect', href: 'https://fonts.googleapis.com' },
        { rel: 'preconnect', href: 'https://fonts.gstatic.com', crossorigin: '' },
        { rel: 'icon', type: 'image/png', href: '/images/logo-smkn71.png' },
        { rel: 'stylesheet', href: 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Geist:wght@100..900&family=Space+Grotesk:wght@300..700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap' },
        { rel: 'stylesheet', href: 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200' }
      ]
    }
  },

  runtimeConfig: {
    public: {
      apiBase: process.env.NUXT_PUBLIC_API_BASE || 'http://localhost:8000/api'
    }
  }
})
