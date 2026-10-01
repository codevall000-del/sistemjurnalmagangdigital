<template>
  <div class="h-screen w-screen overflow-hidden bg-[#f8fafc] flex flex-col md:flex-row select-none font-body text-on-surface">
    <!-- 1. LEFT PANEL: FOTO GEDUNG SEKOLAH (GAMBAR DI KIRI FULL-HEIGHT) -->
    <div class="hidden md:block w-full md:w-[50%] lg:w-[55%] h-full relative overflow-hidden bg-slate-900">
      <!-- Foto Gedung Sekolah -->
      <img
        src="/images/gedung-sekolah.jpg"
        alt="Foto Gedung SMKN 71 Jakarta"
        class="w-full h-full object-cover object-center transform scale-[1.01] transition-transform duration-700 ease-out"
      />

      <!-- Soft Right-Edge Fade Transition (Bleeds seamlessly into right panel canvas) -->
      <div class="absolute inset-y-0 right-0 w-32 lg:w-44 bg-gradient-to-l from-[#f8fafc] via-[#f8fafc]/50 to-transparent pointer-events-none z-10"></div>

      <!-- Institutional watermark badge on top-left of artwork -->
      <div class="absolute top-6 left-8 z-15 flex items-center gap-2 bg-white/90 backdrop-blur-md px-3.5 py-1.5 rounded-full border border-white/60 shadow-sm">
        <img src="/images/logo-smkn71.png" alt="Logo SMKN 71" class="w-5 h-5 object-contain" />
        <span class="text-[11px] font-bold text-slate-900 tracking-wider font-headline uppercase">
          LOGPKL DIGITAL
        </span>
        <span class="text-slate-300">|</span>
        <span class="text-[10px] text-slate-600 font-medium">
          SMKN 71 Jakarta
        </span>
      </div>

      <!-- Bottom watermark on artwork -->
      <div class="absolute bottom-5 left-8 z-10 text-[10px] font-mono text-slate-700/80 tracking-widest uppercase pointer-events-none bg-white/70 backdrop-blur-xs px-2.5 py-1 rounded-md">
        Field Verified Enterprise PKL • SMKN 71 Jakarta
      </div>
    </div>

    <!-- 2. RIGHT PANEL: CLEAN AREA DENGAN SECTION / DIV PUTIH BERSIH MENGURUNG LOGIN -->
    <div class="w-full md:w-[50%] lg:w-[45%] h-full flex flex-col justify-between items-center p-6 sm:p-8 lg:p-12 overflow-y-auto bg-[#f8fafc] z-20">
      <!-- Mobile Top Brand Header -->
      <div class="flex md:hidden items-center justify-between w-full max-w-[420px] pb-4">
        <div class="flex items-center gap-2">
          <img src="/images/logo-smkn71.png" alt="Logo SMKN 71" class="w-6 h-6 object-contain" />
          <span class="text-xs font-bold text-slate-900 tracking-widest font-headline uppercase">
            LOGPKL DIGITAL
          </span>
        </div>
        <span class="text-[11px] font-mono text-slate-500">
          SMKN 71 Jakarta
        </span>
      </div>

      <!-- SECTION / DIV DEDIKASI MENGURUNG FORM & TOMBOL LOGIN (TONE PUTIH BERSIH CLEAR) -->
      <section class="my-auto w-full max-w-[420px] bg-white rounded-2xl border border-slate-200/90 p-7 sm:p-9 shadow-[0_15px_35px_-5px_rgba(15,35,65,0.08)] relative">
        <!-- Top Badge inside Box -->
        <div class="flex items-center justify-between pb-4 mb-5 border-b border-slate-100">
          <div class="flex items-center gap-2.5">
            <img src="/images/logo-smkn71.png" alt="Logo SMKN 71" class="w-8 h-8 object-contain" />
            <div>
              <span class="block text-xs font-bold text-slate-900 tracking-tight font-headline">Portal Autentikasi</span>
              <span class="block text-[10px] text-slate-400 font-mono">SMKN 71 Jakarta</span>
            </div>
          </div>
          <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 font-mono">
            ● ONLINE
          </span>
        </div>

        <!-- Headline & Subtitle -->
        <div class="mb-6">
          <h1 class="font-serif text-3xl sm:text-[34px] font-normal text-slate-900 tracking-tight leading-tight">
            Welcome back!
          </h1>
          <p class="font-serif italic text-xs text-slate-500 mt-1 tracking-wide">
            Where learning meets industrial excellence.
          </p>
        </div>

        <!-- Form Inputs & Button Area (Enclosed inside White Container) -->
        <form @submit.prevent="handleManualLogin" class="space-y-4 text-xs">
          <!-- Email Field -->
          <div>
            <label class="block font-semibold text-slate-700 mb-1.5">Email</label>
            <div class="relative">
              <input
                v-model="emailInput"
                type="email"
                required
                placeholder="Enter your email"
                class="w-full py-2.5 px-3.5 bg-white border border-slate-300 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition shadow-xs"
              />
            </div>
          </div>

          <!-- Password Field -->
          <div>
            <label class="block font-semibold text-slate-700 mb-1.5">Password</label>
            <div class="relative">
              <input
                v-model="passwordInput"
                :type="showPassword ? 'text' : 'password'"
                required
                placeholder="••••••••"
                class="w-full py-2.5 px-3.5 pr-10 bg-white border border-slate-300 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition shadow-xs"
              />
              <button
                type="button"
                @click="showPassword = !showPassword"
                class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-700 transition"
                title="Lihat password"
              >
                <span class="material-symbols-outlined text-[17px]">
                  {{ showPassword ? 'visibility_off' : 'visibility' }}
                </span>
              </button>
            </div>
          </div>

          <!-- Remember Me & Forgot Password Row -->
          <div class="flex items-center justify-between pt-0.5 text-[11px]">
            <label class="flex items-center gap-1.5 text-slate-600 cursor-pointer select-none">
              <input
                type="checkbox"
                v-model="rememberMe"
                class="w-3.5 h-3.5 rounded border-slate-300 text-slate-900 accent-slate-900 focus:ring-0 cursor-pointer"
              />
              <span>Remember me</span>
            </label>

            <button
              type="button"
              @click="showForgotPassword"
              class="text-slate-500 hover:text-slate-900 underline transition font-medium"
            >
              Forgot password?
            </button>
          </div>

          <!-- SECTION MENGURUNG TOMBOL LOGIN -->
          <div class="pt-2">
            <button
              type="submit"
              :disabled="isLoading"
              class="w-full py-3 px-4 bg-[#1e3a5f] hover:bg-[#152a45] text-white rounded-xl text-xs font-semibold tracking-wide shadow-sm transition active:scale-[0.99] disabled:opacity-50 flex items-center justify-center gap-2"
            >
              <span v-if="isLoading" class="animate-spin inline-block text-xs">⏳</span>
              <span class="material-symbols-outlined text-[16px]">login</span>
              <span>Log in</span>
            </button>
          </div>
        </form>

        <!-- 1-Click Quick Demo Role Switcher inside Box -->
        <div class="mt-6 pt-4 border-t border-slate-100">
          <div class="flex items-center justify-between text-[11px] text-slate-500 mb-2">
            <span class="font-medium">Quick Demo Role:</span>
            <span class="font-mono text-[10px] text-slate-400 font-bold uppercase">1-CLICK LOGIN</span>
          </div>
          <div class="grid grid-cols-4 gap-1.5 text-xs">
            <button
              @click="quickLogin('siswa')"
              class="py-1 px-1.5 rounded-lg bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-medium transition text-center shadow-xs active:scale-95"
              title="Masuk sebagai Siswa (Budi Santoso)"
            >
              Siswa
            </button>
            <button
              @click="quickLogin('dudi')"
              class="py-1 px-1.5 rounded-lg bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-medium transition text-center shadow-xs active:scale-95"
              title="Masuk sebagai Pembimbing DUDI (Hendra Wijaya)"
            >
              DUDI
            </button>
            <button
              @click="quickLogin('guru')"
              class="py-1 px-1.5 rounded-lg bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-medium transition text-center shadow-xs active:scale-95"
              title="Masuk sebagai Guru Pembimbing (Nurul Hidayah)"
            >
              Guru
            </button>
            <button
              @click="quickLogin('admin')"
              class="py-1 px-1.5 rounded-lg bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-medium transition text-center shadow-xs active:scale-95"
              title="Masuk sebagai Admin Kaprog (Bambang Hermanto)"
            >
              Admin
            </button>
          </div>
        </div>

        <!-- Footer link inside Box -->
        <div class="mt-4 pt-3 text-center text-[11px] text-slate-500 border-t border-slate-100">
          <span>Don't have an account? </span>
          <button @click="contactAdmin" class="text-slate-900 underline font-semibold hover:text-black">
            Sign up
          </button>
        </div>
      </section>

      <!-- Bottom Outer Footer -->
      <footer class="w-full max-w-[420px] text-center text-[11px] text-slate-400 py-2">
        <span>&copy; 2026 SMK Negeri 1 Industri Digital • Laravel 11 &amp; Nuxt 3</span>
      </footer>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useAppStore } from '~/composables/useAppStore'

const { login, loginAs, showToast } = useAppStore()

const emailInput = ref('siswa@magang.id')
const passwordInput = ref('password123')
const showPassword = ref(false)
const rememberMe = ref(true)
const isLoading = ref(false)

const handleManualLogin = async () => {
  isLoading.value = true
  await login(emailInput.value, passwordInput.value)
  isLoading.value = false
}

const quickLogin = (role: 'siswa' | 'dudi' | 'guru' | 'admin') => {
  loginAs(role)
}

const showForgotPassword = () => {
  showToast('Silakan hubungi Administrator Sekolah (Kaprog RPL) untuk mereset kata sandi Anda.', 'info')
}

const contactAdmin = () => {
  showToast('Pendaftaran akun siswa & DUDI dilakukan oleh Admin Sekolah melalui menu Plotting.', 'info')
}
</script>
