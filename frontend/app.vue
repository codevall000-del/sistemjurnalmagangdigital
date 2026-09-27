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
        <header class="h-16 bg-surface-container-lowest border-b border-outline-variant z-40 px-gutter flex items-center justify-between shrink-0 no-print">
          <!-- Breadcrumb Navigation -->
          <div class="flex items-center gap-space-sm font-label-md text-label-md text-on-surface-variant">
            <span class="hover:text-on-surface cursor-pointer">Portal Vokasi &amp; PKL Digital</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-on-surface font-semibold capitalize">{{ currentRole }}</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold capitalize">{{ activeMenuTitle }}</span>
          </div>

          <!-- Right Header Items -->
          <div class="flex items-center gap-space-md">
            <!-- Quick Offline/Online Interactive Toggle -->
            <button
              @click="toggleNetworkStatus"
              :class="isOnline ? 'bg-tertiary-fixed/40 text-tertiary border-tertiary/30 hover:bg-tertiary-fixed' : 'bg-secondary-container text-on-secondary-fixed border-secondary/30'"
              class="hidden sm:flex items-center gap-1.5 px-2.5 py-1 rounded border text-[11px] font-bold transition active:scale-95"
              title="Klik untuk simulasi mode Online / Offline"
            >
              <span class="w-2 h-2 rounded-full" :class="isOnline ? 'bg-tertiary-container animate-pulse' : 'bg-secondary'"></span>
              <span>{{ isOnline ? 'Online (Real-time)' : 'Offline (Local WAL)' }}</span>
            </button>

            <!-- Live Date Pill -->
            <div class="hidden md:flex items-center gap-1.5 px-3 py-1 rounded bg-surface-container-low border border-outline-variant font-label-sm text-label-sm text-on-surface font-medium">
              <span class="material-symbols-outlined text-[16px] text-primary">calendar_today</span>
              <span>{{ currentDate }}</span>
            </div>

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

              <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-on-primary">
                <span class="material-symbols-outlined text-[18px]">person</span>
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
  activeMenu,
  isOnline,
  notificationToast,
  toggleNetworkStatus,
  showToast
} = useAppStore()

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
    dashboard: 'Dashboard Ringkasan',
    logbook: 'Logbook Harian',
    presensi: 'Presensi & Kehadiran',
    penempatan: 'Info Tempat PKL',
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
