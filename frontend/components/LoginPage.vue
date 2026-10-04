<template>
  <div class="h-screen w-screen overflow-hidden bg-[#f5f5f7] dark:bg-[#121214] flex flex-col md:flex-row select-none font-body text-[#1d1d1f] dark:text-[#f5f5f7] transition-colors duration-350">
    <!-- 1. LEFT PANEL: FOTO GEDUNG SEKOLAH (ARTWORK DENGAN FADE TRANSISI HALUS) -->
    <div class="hidden md:block w-full md:w-[50%] lg:w-[54%] h-full relative overflow-hidden bg-[#f5f5f7] dark:bg-[#121214] transition-colors duration-350">
      <!-- Masked Wrapper: Foto & Vignette menyatu halus 100% sempurna ke panel kanan dari atas sampai bawah -->
      <div
        class="w-full h-full relative overflow-hidden"
        style="-webkit-mask-image: linear-gradient(to right, black 0%, black 50%, rgba(0,0,0,0.85) 68%, rgba(0,0,0,0.45) 82%, rgba(0,0,0,0.12) 93%, transparent 100%); mask-image: linear-gradient(to right, black 0%, black 50%, rgba(0,0,0,0.85) 68%, rgba(0,0,0,0.45) 82%, rgba(0,0,0,0.12) 93%, transparent 100%);"
      >
        <!-- Foto Gedung Sekolah Asli -->
        <img
          src="/images/gedung-sekolah.jpg"
          alt="Foto Gedung SMKN 71 Jakarta"
          class="w-full h-full object-cover object-center transform scale-[1.01]"
        />

        <!-- Subtle Dark Bottom Vignette (Hanya di area kiri bawah teks caption, otomatis memudar halus ke kanan) -->
        <div class="absolute bottom-0 left-0 w-full h-80 bg-gradient-to-t from-black/90 via-black/40 to-transparent pointer-events-none"></div>
      </div>

      <!-- Top-Left Institutional Watermark Pill -->
      <div class="absolute top-6 left-6 z-20 flex items-center gap-2.5 px-3.5 py-1.5 rounded-full bg-black/40 backdrop-blur-xl border border-white/20 text-white shadow-lg">
        <img src="/images/logo-smkn71.png" alt="Logo SMKN 71" class="w-5 h-5 object-contain" />
        <span class="text-[12px] font-semibold tracking-wide">SMK Negeri 71 Jakarta</span>
      </div>

      <!-- Bottom Inspiring Caption Badge -->
      <div class="absolute bottom-8 left-8 right-8 z-20 flex flex-col gap-2 pointer-events-auto max-w-md">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/25 text-white text-[11px] font-semibold w-fit">
          <span class="w-2 h-2 rounded-full bg-[#34c759] shadow-[0_0_8px_rgba(52,199,89,0.8)] animate-pulse"></span>
          <span>Sistem Informasi Prakerin &amp; Vokasi Industri</span>
        </div>
        <h2 class="text-white text-xl lg:text-2xl font-bold font-headline tracking-tight drop-shadow-md">
          Portal Jurnal &amp; Presensi PKL Digital
        </h2>
        <p class="text-white/80 text-[12.5px] max-w-md leading-relaxed drop-shadow">
          Platform kolaborasi terpadu antara Siswa, Guru Pembimbing, dan Tempat Magang (Instansi Pemerintahan, BUMN, &amp; Perusahaan).
        </p>
      </div>
    </div>

    <!-- 2. RIGHT PANEL: CLEAN LOGIN CARD -->
    <div class="w-full md:w-[50%] lg:w-[46%] h-full flex flex-col justify-between items-center p-6 sm:p-8 lg:p-12 overflow-y-auto bg-[#f5f5f7] dark:bg-[#121214] z-20 relative transition-colors duration-350">
      <!-- Top Row with Apple Segmented Theme Switcher -->
      <div class="w-full max-w-[400px] flex items-center justify-between pb-2">
        <span class="text-[11px] font-semibold text-[#86868b] dark:text-[#98989f]">
          EduAccess v2.4
        </span>

        <!-- Segmented 2-Pill Switch (☀️ Terang | 🌙 Gelap) -->
        <div class="p-0.5 rounded-full bg-black/[0.05] dark:bg-white/[0.1] border-0 dark:border dark:border-white/[0.08] flex items-center gap-0.5">
          <button
            type="button"
            @click="applyTheme('light')"
            class="flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] transition-all apple-press cursor-pointer"
            :class="!isDarkMode ? 'bg-white text-[#1d1d1f] shadow-xs font-bold' : 'text-[#86868b] hover:text-[#1d1d1f] dark:hover:text-white font-medium'"
            title="Aktifkan Mode Terang (Light Canvas)"
          >
            <span class="material-symbols-outlined text-[14px] text-[#ff9500]">light_mode</span>
            <span>Terang</span>
          </button>
          <button
            type="button"
            @click="applyTheme('dark')"
            class="flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] transition-all apple-press cursor-pointer"
            :class="isDarkMode ? 'bg-[#2c2c2e] text-white shadow-xs font-bold' : 'text-[#86868b] hover:text-[#1d1d1f] dark:hover:text-white font-medium'"
            title="Aktifkan Mode Gelap (Apple Obsidian)"
          >
            <span class="material-symbols-outlined text-[14px] text-[#0a84ff]">dark_mode</span>
            <span>Gelap</span>
          </button>
        </div>
      </div>

      <!-- MAIN CARD LOGIN -->
      <section class="my-auto w-full max-w-[400px] bg-white dark:bg-[#1c1c1e] rounded-3xl border-0 dark:border dark:border-white/[0.1] p-7 sm:p-8 shadow-[0_10px_35px_rgba(0,0,0,0.05)] dark:shadow-[0_20px_60px_rgba(0,0,0,0.6)] relative transition-all duration-350">
        <!-- Brand Header (Bersih, Fokus & Profesional) -->
        <div class="flex flex-col items-center text-center mb-6">
          <div class="w-14 h-14 rounded-2xl bg-[#0071e3]/10 dark:bg-[#0071e3]/20 border-0 dark:border dark:border-[#0071e3]/30 flex items-center justify-center p-2 mb-3 shadow-xs">
            <img src="/images/logo-smkn71.png" alt="Logo SMKN 71" class="w-full h-full object-contain" />
          </div>
          <h1 class="text-2xl font-bold text-[#1d1d1f] dark:text-[#f5f5f7] tracking-tight font-headline">
            EduAccess
          </h1>
          <p class="text-[13px] text-[#86868b] dark:text-[#98989f] mt-1 font-normal">
            Portal Jurnal &amp; Presensi PKL SMKN 71 Jakarta
          </p>
        </div>

        <!-- Form Inputs & Button Area -->
        <form @submit.prevent="handleManualLogin" class="space-y-4 text-xs">
          <!-- Email Field -->
          <div>
            <label class="block font-semibold text-[#1d1d1f] dark:text-[#f5f5f7] mb-1.5 text-[12px]">Email</label>
            <div class="relative">
              <input
                v-model="emailInput"
                type="email"
                autocomplete="username"
                required
                placeholder="nama@smkn71.sch.id"
                class="w-full py-2.5 px-3.5 bg-[#f5f5f7] dark:bg-[#26262a] border-0 dark:border dark:border-white/[0.12] rounded-xl text-[13px] text-[#1d1d1f] dark:text-[#f5f5f7] placeholder-[#86868b] dark:placeholder-[#71717a] focus:outline-none focus:bg-white dark:focus:bg-[#2c2c30] focus:ring-2 focus:ring-[#0071e3]/25 transition-all shadow-none"
              />
            </div>
          </div>

          <!-- Password Field -->
          <div>
            <div class="flex items-center justify-between mb-1.5">
              <label class="block font-semibold text-[#1d1d1f] dark:text-[#f5f5f7] text-[12px]">Kata Sandi</label>
              <button
                type="button"
                @click="showForgotPassword"
                class="text-[#0071e3] dark:text-[#0a84ff] hover:underline transition font-medium text-[11px] cursor-pointer"
              >
                Lupa kata sandi?
              </button>
            </div>
            <div class="relative">
              <input
                v-model="passwordInput"
                :type="showPassword ? 'text' : 'password'"
                autocomplete="current-password"
                required
                placeholder="••••••••"
                class="w-full py-2.5 px-3.5 pr-10 bg-[#f5f5f7] dark:bg-[#26262a] border-0 dark:border dark:border-white/[0.12] rounded-xl text-[13px] text-[#1d1d1f] dark:text-[#f5f5f7] placeholder-[#86868b] dark:placeholder-[#71717a] focus:outline-none focus:bg-white dark:focus:bg-[#2c2c30] focus:ring-2 focus:ring-[#0071e3]/25 transition-all shadow-none"
              />
              <button
                type="button"
                @click="showPassword = !showPassword"
                class="absolute right-3 top-2.5 text-[#86868b] hover:text-[#1d1d1f] dark:text-[#98989f] dark:hover:text-white transition-colors cursor-pointer"
                title="Lihat kata sandi"
              >
                <span class="material-symbols-outlined text-[17px]">
                  {{ showPassword ? 'visibility_off' : 'visibility' }}
                </span>
              </button>
            </div>
          </div>

          <!-- Apple Blue Primary Button -->
          <div class="pt-2">
            <button
              type="submit"
              :disabled="isLoading"
              class="w-full py-3 px-4 bg-[#0071e3] hover:bg-[#0077ed] text-white rounded-xl text-[13px] font-semibold tracking-wide shadow-[0_2px_8px_rgba(0,113,227,0.3)] transition-all apple-press disabled:opacity-50 flex items-center justify-center gap-2 cursor-pointer"
            >
              <span v-if="isLoading" class="animate-spin inline-block text-xs">⏳</span>
              <span class="material-symbols-outlined text-[16px]">login</span>
              <span>Masuk ke Akun</span>
            </button>
          </div>
        </form>

        <!-- 1-Click Quick Access Role Selector (Demo Mode) -->
        <div class="mt-5 pt-4 border-t border-black/[0.06] dark:border-white/[0.08]">
          <div class="flex items-center justify-between text-[11px] text-[#86868b] dark:text-[#98989f] mb-2 font-medium">
            <span class="flex items-center gap-1 font-semibold text-[#1d1d1f] dark:text-[#f5f5f7]">
              <span class="material-symbols-outlined text-[14px] text-[#0071e3]">bolt</span>
              <span>Akses Cepat (Demo):</span>
            </span>
            <span class="text-[9px] px-1.5 py-0.5 rounded bg-black/[0.04] dark:bg-white/[0.08] text-[#86868b] dark:text-[#98989f] font-mono font-semibold uppercase tracking-wider">
              1-Klik Masuk
            </span>
          </div>
          <div class="grid grid-cols-4 gap-1.5 text-xs">
            <button
              type="button"
              @click="quickLogin('siswa')"
              class="py-2 px-1 rounded-xl bg-black/[0.03] hover:bg-black/[0.06] dark:bg-white/[0.06] dark:hover:bg-white/[0.1] border-0 dark:border dark:border-white/[0.08] text-[#1d1d1f] dark:text-[#f5f5f7] font-medium transition-all text-center apple-press cursor-pointer flex flex-col items-center gap-0.5"
              title="Masuk sebagai Siswa (Budi Santoso - siswa@gmail.com)"
            >
              <span class="text-[14px]">🎓</span>
              <span class="text-[10px] font-semibold">Siswa</span>
            </button>
            <button
              type="button"
              @click="quickLogin('mentor')"
              class="py-2 px-1 rounded-xl bg-black/[0.03] hover:bg-black/[0.06] dark:bg-white/[0.06] dark:hover:bg-white/[0.1] border-0 dark:border dark:border-white/[0.08] text-[#1d1d1f] dark:text-[#f5f5f7] font-medium transition-all text-center apple-press cursor-pointer flex flex-col items-center gap-0.5"
              title="Masuk sebagai Pembimbing Lapangan (Hendra Wijaya - mentor@gmail.com)"
            >
              <span class="text-[14px]">🏢</span>
              <span class="text-[10px] font-semibold">Mentor</span>
            </button>
            <button
              type="button"
              @click="quickLogin('guru')"
              class="py-2 px-1 rounded-xl bg-black/[0.03] hover:bg-black/[0.06] dark:bg-white/[0.06] dark:hover:bg-white/[0.1] border-0 dark:border dark:border-white/[0.08] text-[#1d1d1f] dark:text-[#f5f5f7] font-medium transition-all text-center apple-press cursor-pointer flex flex-col items-center gap-0.5"
              title="Masuk sebagai Guru Pembimbing (Dra. Nurul Hidayah - guru@gmail.com)"
            >
              <span class="text-[14px]">👩‍🏫</span>
              <span class="text-[10px] font-semibold">Guru</span>
            </button>
            <button
              type="button"
              @click="quickLogin('admin')"
              class="py-2 px-1 rounded-xl bg-black/[0.03] hover:bg-black/[0.06] dark:bg-white/[0.06] dark:hover:bg-white/[0.1] border-0 dark:border dark:border-white/[0.08] text-[#1d1d1f] dark:text-[#f5f5f7] font-medium transition-all text-center apple-press cursor-pointer flex flex-col items-center gap-0.5"
              title="Masuk sebagai Admin Kaprog (Ir. Bambang Hermanto - admin@gmail.com)"
            >
              <span class="text-[14px]">⚡</span>
              <span class="text-[10px] font-semibold">Admin</span>
            </button>
          </div>
        </div>

        <!-- Footer link inside Box -->
        <div class="mt-4 pt-3 text-center text-[12px] text-[#86868b] dark:text-[#98989f] border-t border-black/[0.05] dark:border-white/[0.08]">
          <span>Belum memiliki akun? </span>
          <button @click="contactAdmin" class="text-[#0071e3] dark:text-[#0a84ff] font-semibold hover:underline cursor-pointer">
            Hubungi Admin
          </button>
        </div>
      </section>

      <!-- Bottom Outer Footer -->
      <footer class="w-full max-w-[400px] text-center text-[11px] text-[#86868b] dark:text-[#98989f] py-2">
        <span>&copy; 2026 SMKN 71 Jakarta • EduAccess</span>
      </footer>
    </div>

    <!-- Modal Bantuan Hubungi Admin (Apple HIG Modal) -->
    <Teleport to="body">
      <Transition
        enter-active-class="transition-opacity duration-200 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition-opacity duration-150 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <div
          v-if="isContactModalOpen"
          class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm select-none"
          @click.self="isContactModalOpen = false"
        >
          <div
            class="modal-card-animate bg-white dark:bg-[#1c1c1e] text-[#1d1d1f] dark:text-[#f5f5f7] rounded-3xl max-w-sm w-full p-6 shadow-[0_20px_50px_rgba(0,0,0,0.25)] border border-black/[0.08] dark:border-white/[0.12] flex flex-col gap-4 text-center items-center"
          >
            <div class="w-12 h-12 rounded-2xl bg-[#0071e3]/10 dark:bg-[#0071e3]/20 text-[#0071e3] flex items-center justify-center">
              <span class="material-symbols-outlined text-[28px]">support_agent</span>
            </div>

            <div class="flex flex-col gap-1">
              <h3 class="text-base font-bold text-[#1d1d1f] dark:text-[#f5f5f7]">Informasi Pendaftaran Akun</h3>
              <p class="text-[12.5px] text-[#86868b] dark:text-[#98989f] leading-relaxed">
                Bagi siswa atau pembimbing tempat magang yang belum memiliki akun atau mengalami kendala login, silakan hubungi:
              </p>
            </div>

            <div class="w-full bg-[#f5f5f7] dark:bg-[#26262a] rounded-2xl p-3.5 border border-black/[0.04] dark:border-white/[0.08] text-left flex flex-col gap-2 text-[12px]">
              <div class="flex items-center gap-2.5 text-[#1d1d1f] dark:text-[#f5f5f7] font-semibold">
                <span class="w-2 h-2 rounded-full bg-[#0071e3]"></span>
                <span>1. Guru Pembimbing PKL</span>
              </div>
              <div class="flex items-center gap-2.5 text-[#1d1d1f] dark:text-[#f5f5f7] font-semibold">
                <span class="w-2 h-2 rounded-full bg-[#5e5ce6]"></span>
                <span>2. Kepala Jurusan / Kaprog</span>
              </div>
              <div class="flex items-center gap-2.5 text-[#1d1d1f] dark:text-[#f5f5f7] font-semibold">
                <span class="w-2 h-2 rounded-full bg-[#34c759]"></span>
                <span>3. Tata Usaha (TU) SMKN 71</span>
              </div>
            </div>

            <p class="text-[11px] text-[#86868b] dark:text-[#98989f] leading-tight">
              Pendaftaran akun dan plotting data magang divalidasi langsung oleh pihak sekolah.
            </p>

            <button
              @click="isContactModalOpen = false"
              class="w-full py-2.5 px-4 bg-[#0071e3] hover:bg-[#0077ed] text-white rounded-xl text-[13px] font-semibold transition-all apple-press cursor-pointer shadow-xs"
              type="button"
            >
              Mengerti
            </button>
          </div>
        </div>
      </Transition>
    </Teleport>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useAppStore } from '~/composables/useAppStore'

const { login, loginAs, showToast, isDarkMode, toggleTheme, applyTheme } = useAppStore()

const emailInput = ref('')
const passwordInput = ref('')
const showPassword = ref(false)
const isLoading = ref(false)

const handleManualLogin = async () => {
  isLoading.value = true
  await login(emailInput.value, passwordInput.value)
  isLoading.value = false
}

const quickLogin = async (role: 'siswa' | 'mentor' | 'dudi' | 'guru' | 'admin') => {
  const credentials: Record<string, { email: string; pass: string }> = {
    siswa: { email: 'siswa@gmail.com', pass: '12345678' },
    mentor: { email: 'mentor@gmail.com', pass: '12345678' },
    dudi: { email: 'mentor@gmail.com', pass: '12345678' },
    guru: { email: 'guru@gmail.com', pass: '12345678' },
    admin: { email: 'admin@gmail.com', pass: '12345678' }
  }
  const cred = credentials[role]
  emailInput.value = cred.email
  passwordInput.value = cred.pass
  isLoading.value = true
  const success = await login(cred.email, cred.pass)
  if (!success) {
    loginAs(role)
  }
  isLoading.value = false
}

const isContactModalOpen = ref(false)

const showForgotPassword = () => {
  isContactModalOpen.value = true
  showToast('Lupa kata sandi? Silakan hubungi Guru Pembimbing, Kepala Jurusan, atau TU.', 'info')
}

const contactAdmin = () => {
  isContactModalOpen.value = true
  showToast('Silakan hubungi Guru Pembimbing, Kepala Jurusan, atau Tata Usaha (TU).', 'info')
}
</script>
