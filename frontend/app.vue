<template>
  <div class="h-screen w-screen overflow-hidden bg-surface font-body text-on-surface antialiased select-none">
    <!-- HALAMAN UTAMA: LOGIN PAGE (JIKA BELUM LOGIN) -->
    <LoginPage v-if="!isLoggedIn" />

    <!-- HALAMAN DALAM: DESKTOP APPLICATION SHELL (JIKA SUDAH LOGIN) -->
    <div v-else class="flex h-screen w-screen overflow-hidden">
      <!-- 1. NAVBAR (SIDEBAR KIRI 260px) - STITCH DESIGN SYSTEM -->
      <DesktopSidebar class="no-print" />

      <!-- 2. VIEW (AREA KONTEN KANAN) - DENGAN STITCH TOP BAR -->
      <div class="pl-[260px] flex-1 flex flex-col h-screen overflow-hidden bg-surface relative">
        <!-- Stitch Desktop App Header Bar (No-print) -->
        <header class="h-16 bg-surface-container-lowest/90 backdrop-blur-xl border-b border-outline-variant z-40 px-gutter flex items-center justify-between shrink-0 no-print">
          <!-- Left: Breadcrumb Navigation & Week Progress Pill -->
          <div class="flex items-center gap-space-md">
            <div class="flex items-center gap-space-xs text-on-surface-variant font-label-md text-label-md">
              <span class="text-on-surface font-semibold">Portal Magang</span>
              <span class="material-symbols-outlined text-[16px]">chevron_right</span>
              <span class="text-primary font-bold">{{ activeMenuTitle }}</span>
            </div>

            <!-- Stitch Week Tracker Pill -->
            <div class="hidden xl:flex items-center gap-space-xs bg-surface-container-low px-space-md py-1.5 rounded-full border border-outline-variant/60">
              <span class="w-2 h-2 rounded-full bg-secondary"></span>
              <span class="font-label-sm text-label-sm text-on-surface">Minggu ke-8 dari 16 Minggu (50% Berjalan)</span>
            </div>
          </div>

          <!-- Right Header Items -->
          <div class="flex items-center gap-space-md">
            <!-- Shortcut: Tulis Jurnal Hari Ini (For Siswa) -->
            <button
              v-if="currentRole === 'siswa'"
              @click="activeMenu = 'logbook'"
              class="hidden sm:inline-flex items-center gap-space-xs bg-primary text-on-primary hover:bg-primary-container px-space-md py-2 rounded-lg font-headline-sm text-headline-sm transition-colors shadow-sm active:scale-95"
              type="button"
            >
              <span class="material-symbols-outlined text-[18px]">add</span>
              <span class="font-body-sm text-body-sm font-semibold">Tulis Jurnal Hari Ini</span>
            </button>

            <!-- Quick Offline/Online Interactive Toggle -->
            <button
              @click="toggleNetworkStatus"
              :class="isOnline ? 'bg-tertiary-fixed/40 text-tertiary border-tertiary/30 hover:bg-tertiary-fixed' : 'bg-secondary-container text-on-secondary-fixed border-secondary/30'"
              class="hidden lg:flex items-center gap-1.5 px-2.5 py-1 rounded border text-[11px] font-bold transition active:scale-95"
              title="Klik untuk simulasi mode Online / Offline"
            >
              <span class="w-2 h-2 rounded-full" :class="isOnline ? 'bg-emerald-500 animate-pulse' : 'bg-secondary'"></span>
              <span>{{ isOnline ? 'Online (Real-time)' : 'Offline (Local WAL)' }}</span>
            </button>

            <!-- Quick Action Icons -->
            <div class="flex items-center gap-2 border-l border-outline-variant pl-space-md">
              <button
                @click="openHelp"
                aria-label="Bantuan"
                class="w-8 h-8 rounded-lg border border-outline-variant flex items-center justify-center text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface transition-colors"
                type="button"
                title="Pusat Bantuan & Panduan PKL"
              >
                <span class="material-symbols-outlined text-[18px]">help_outline</span>
              </button>

              <button
                @click="openNotifications"
                aria-label="Notifikasi"
                class="relative w-8 h-8 rounded-lg border border-outline-variant flex items-center justify-center text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface transition-colors"
                type="button"
                title="Notifikasi & Peringatan Sistem"
              >
                <span class="material-symbols-outlined text-[18px]">notifications</span>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-error"></span>
              </button>

              <!-- Stitch Profile Pill -->
              <div
                @click="openSettings"
                class="flex items-center gap-space-sm pl-space-xs cursor-pointer select-none group"
                title="Profil Pengguna"
              >
                <img
                  :src="currentUser.avatar || '/images/avatar-student.png'"
                  alt="Profile"
                  class="w-8 h-8 rounded-full object-cover border border-outline-variant"
                />
                <div class="hidden sm:flex flex-col text-left">
                  <span class="font-headline-sm text-body-sm text-on-surface leading-tight font-semibold group-hover:text-primary transition-colors">
                    {{ currentUser.name }}
                  </span>
                  <span class="font-label-sm text-label-sm text-on-surface-variant">
                    {{ currentRole === 'siswa' ? 'SMKN 71 Jakarta' : currentUser.roleLabel }}
                  </span>
                </div>
                <span class="material-symbols-outlined text-[18px] text-on-surface-variant group-hover:text-primary transition-colors">
                  arrow_drop_down
                </span>
              </div>
            </div>
          </div>
        </header>

        <!-- View Area Content Scrollable -->
        <main class="flex-1 overflow-y-auto px-gutter py-space-lg bg-surface">
          <!-- 1. MODUL SISWA VIEWS -->
          <template v-if="currentRole === 'siswa'">
            <SiswaDashboard v-if="activeMenu === 'dashboard'" />
            <SiswaLogbook v-else-if="activeMenu === 'logbook'" />
            <SiswaPresensi v-else-if="activeMenu === 'presensi'" />
            <SiswaPenempatan v-else-if="activeMenu === 'penempatan'" />
          </template>

          <!-- 2. MODUL PEMBIMBING INDUSTRI (DUDI) VIEWS -->
          <template v-else-if="currentRole === 'dudi'">
            <DudiDashboard v-if="activeMenu === 'dashboard_dudi'" />
            <DudiValidasi v-else-if="activeMenu === 'validasi_jurnal'" />
            <DudiPresensi v-else-if="activeMenu === 'presensi_siswa'" />
            <DudiEvaluasi v-else-if="activeMenu === 'evaluasi'" />
          </template>

          <!-- 3. MODUL GURU PEMBIMBING VIEWS -->
          <template v-else-if="currentRole === 'guru'">
            <GuruDashboard v-if="activeMenu === 'dashboard_guru'" />
            <GuruMonitoring v-else-if="activeMenu === 'monitoring'" />
            <GuruNilai v-else-if="activeMenu === 'manajemen_nilai'" />
          </template>

          <!-- 4. MODUL ADMIN / KAPROG VIEWS -->
          <template v-else-if="currentRole === 'admin'">
            <AdminDashboard v-if="activeMenu === 'dashboard_admin'" />
            <AdminDataMaster v-else-if="['data_master_siswa', 'data_master_dudi', 'data_master_guru'].includes(activeMenu)" />
            <AdminPlotting v-else-if="activeMenu === 'plotting'" />
            <AdminLaporan v-else-if="activeMenu === 'laporan'" />
          </template>
        </main>
      </div>

      <!-- Global Account Settings Modal -->
      <SettingsModal />
    </div>

    <!-- Global Floating Toast Notification (Stitch Field Verified Tone) -->
    <div
      v-if="notificationToast.show"
      class="fixed bottom-5 right-5 z-50 flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg border text-xs font-bold transition-all"
      :class="{
        'bg-surface-container-lowest text-tertiary border-tertiary-fixed': notificationToast.type === 'success',
        'bg-surface-container-lowest text-primary border-primary-fixed': notificationToast.type === 'info',
        'bg-surface-container-lowest text-on-surface border-outline-variant': notificationToast.type === 'warning',
        'bg-error-container text-on-error-container border-error': notificationToast.type === 'error'
      }"
    >
      <span class="text-base">
        {{ notificationToast.type === 'success' ? '✅' : (notificationToast.type === 'warning' ? '⚠️' : 'ℹ️') }}
      </span>
      <span>{{ notificationToast.message }}</span>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed, ref, onMounted } from 'vue'
import { useAppStore } from '~/composables/useAppStore'

const {
  isLoggedIn,
  currentRole,
  currentUser,
  activeMenu,
  isOnline,
  isSettingsModalOpen,
  notificationToast,
  toggleNetworkStatus,
  showToast
} = useAppStore()

const openSettings = () => {
  isSettingsModalOpen.value = true
}

const currentDate = ref('')

onMounted(() => {
  const now = new Date()
  const options: Intl.DateTimeFormatOptions = {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  }
  currentDate.value = now.toLocaleDateString('id-ID', options)
})

const activeMenuTitle = computed(() => {
  const titles: Record<string, string> = {
    dashboard: 'Ringkasan & Dashboard',
    logbook: 'Catatan Harian',
    presensi: 'Lembar Kehadiran',
    penempatan: 'Bimbingan & Catatan Mentor',
    dashboard_dudi: 'Dashboard DUDI',
    validasi_jurnal: 'Validasi Jurnal Siswa',
    presensi_siswa: 'Presensi Siswa Binaan',
    evaluasi: 'Evaluasi & Nilai QR',
    dashboard_guru: 'Dashboard Monitoring Guru',
    monitoring: 'Timeline Jurnal (Read-Only)',
    manajemen_nilai: 'Manajemen Kompilasi Nilai',
    dashboard_admin: 'Dashboard Admin Makro',
    data_master_siswa: 'Data Master Siswa',
    data_master_dudi: 'Data Master DUDI',
    data_master_guru: 'Data Master Guru',
    plotting: 'Plotting & Penempatan',
    laporan: 'Laporan & Buku Jurnal Cetak'
  }
  return titles[activeMenu.value] || activeMenu.value
})

const openHelp = () => {
  showToast('Pusat Bantuan PKL: Hubungi Tim Pengembang Vokasi di ext. 104', 'info')
}

const openNotifications = () => {
  showToast('Tidak ada peringatan kritis baru saat ini.', 'info')
}
</script>
