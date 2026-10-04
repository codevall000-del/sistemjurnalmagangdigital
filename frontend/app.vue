<template>
  <div class="h-screen w-screen overflow-hidden bg-[#f5f5f7] dark:bg-[#121214] font-body text-[#1d1d1f] dark:text-[#f5f5f7] antialiased select-none transition-colors duration-500 ease-[cubic-bezier(0.2,0.8,0.2,1)]">
    <!-- HALAMAN UTAMA: LOGIN PAGE (JIKA BELUM LOGIN) -->
    <LoginPage v-if="!isLoggedIn" />

    <!-- HALAMAN DALAM: DESKTOP APPLICATION SHELL (JIKA SUDAH LOGIN) -->
    <div v-else class="flex h-screen w-screen overflow-hidden">
      <!-- 1. NAVBAR (SIDEBAR KIRI 260px) - macOS VIBRANCY STYLE -->
      <DesktopSidebar class="no-print" />

      <!-- 2. VIEW (AREA KONTEN KANAN) - DENGAN macOS FROSTED TOP BAR -->
      <div
        :class="isSidebarCollapsed ? 'pl-0' : 'pl-[260px]'"
        class="flex-1 flex flex-col h-screen overflow-hidden bg-[#f5f5f7] dark:bg-[#121214] relative transition-all duration-300 ease-[cubic-bezier(0.2,0.8,0.2,1)]"
      >
        <!-- Apple macOS Desktop Top Bar (Disembunyikan pada Kanvas Penuh Diagram Relasi) -->
        <header
          v-if="activeMenu !== 'diagram_relasi'"
          class="h-14 bg-white/80 dark:bg-[#18181b]/85 backdrop-blur-2xl border-b border-black/[0.06] dark:border-white/[0.08] z-40 px-6 flex items-center justify-between shrink-0 no-print"
        >
          <!-- Left: Breadcrumb Navigation & Progress Pill -->
          <div class="flex items-center gap-4">
            <div class="flex items-center gap-1.5 text-[#86868b] dark:text-[#98989f] text-[13px] font-medium">
              <span class="text-[#86868b] dark:text-[#98989f]">EduAccess</span>
              <span class="material-symbols-outlined text-[15px] text-[#86868b]/70 dark:text-[#98989f]/70">chevron_right</span>
              <span class="text-[#1d1d1f] dark:text-[#f5f5f7] font-semibold">{{ activeMenuTitle }}</span>
            </div>

            <!-- Apple Style Week Tracker Capsule -->
            <div class="hidden xl:flex items-center gap-2 bg-black/[0.04] dark:bg-white/[0.08] px-3 py-1 rounded-full border border-black/[0.04] dark:border-white/[0.08]">
              <span class="w-1.5 h-1.5 rounded-full bg-[#0071e3]"></span>
              <span class="text-[11px] font-medium text-[#1d1d1f] dark:text-[#f5f5f7]">Minggu ke-8 dari 16 Minggu (50%)</span>
            </div>
          </div>

          <!-- Right Header Items -->
          <div class="flex items-center gap-3">
            <!-- Cloud Online Realtime Indicator -->
            <div
              class="hidden lg:flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-[#34c759]/10 text-[#248a3d] border border-[#34c759]/20 text-[11px] font-semibold"
              title="Sistem Terhubung Penuh Online ke Server SMKN 71 Jakarta"
            >
              <span class="w-1.5 h-1.5 rounded-full bg-[#34c759] animate-pulse"></span>
              <span>Cloud Sync Live</span>
            </div>

            <!-- Quick Action Icons -->
            <div class="flex items-center gap-2 border-l border-black/[0.08] dark:border-white/[0.08] pl-3">
              <button
                @click="openHelp"
                aria-label="Bantuan"
                class="w-7 h-7 rounded-full bg-black/[0.04] hover:bg-black/[0.08] dark:bg-white/[0.08] dark:hover:bg-white/[0.14] flex items-center justify-center text-[#86868b] hover:text-[#1d1d1f] dark:text-[#98989f] dark:hover:text-white transition-all apple-press cursor-pointer"
                type="button"
                title="Pusat Bantuan & Panduan PKL"
              >
                <span class="material-symbols-outlined text-[16px]">help_outline</span>
              </button>

              <button
                @click="openNotifications"
                aria-label="Notifikasi"
                class="relative w-7 h-7 rounded-full bg-black/[0.04] hover:bg-black/[0.08] dark:bg-white/[0.08] dark:hover:bg-white/[0.14] flex items-center justify-center text-[#86868b] hover:text-[#1d1d1f] dark:text-[#98989f] dark:hover:text-white transition-all apple-press cursor-pointer"
                :class="{
                  'ring-2 ring-red-400 bg-red-50 text-red-600 dark:bg-red-950/40 dark:text-red-400': hasActiveNotification && journalUrgency === 'danger',
                  'ring-1 ring-amber-400 bg-amber-50 text-amber-600 dark:bg-amber-950/40 dark:text-amber-400': hasActiveNotification && journalUrgency === 'warning'
                }"
                type="button"
                title="Notifikasi & Peringatan Sistem"
              >
                <span class="material-symbols-outlined text-[16px]">notifications</span>
                <!-- Indikator dot notifikasi hanya tampil jika benar-benar ada notifikasi/urgensi aktif -->
                <template v-if="hasActiveNotification">
                  <span
                    v-if="journalUrgency === 'danger'"
                    class="absolute top-1 right-1 w-2 h-2 rounded-full bg-[#ff3b30] animate-ping"
                  ></span>
                  <span
                    class="absolute top-1 right-1 w-1.5 h-1.5 rounded-full"
                    :class="journalUrgency === 'warning' ? 'bg-[#ff9500]' : 'bg-[#ff3b30]'"
                  ></span>
                </template>
              </button>

              <!-- Apple User Profile Pill -->
              <div
                @click="openSettings"
                class="flex items-center gap-2 pl-1 cursor-pointer select-none group apple-press"
                title="Profil Pengguna"
              >
                <img
                  :src="currentUser.avatar || '/images/avatar-student.png'"
                  alt="Profile"
                  class="w-7 h-7 rounded-full object-cover border border-black/[0.08] shadow-xs"
                />
                <div class="hidden sm:flex flex-col text-left">
                  <span class="text-[12px] text-[#1d1d1f] dark:text-[#f5f5f7] leading-tight font-semibold group-hover:text-[#0071e3] transition-colors">
                    {{ currentUser.name }}
                  </span>
                  <span class="text-[10px] text-[#86868b] dark:text-[#98989f]">
                    {{ currentRole === 'siswa' ? 'SMKN 71' : currentUser.roleLabel }}
                  </span>
                </div>
                <span class="material-symbols-outlined text-[16px] text-[#86868b] dark:text-[#98989f] group-hover:text-[#0071e3] transition-colors">
                  arrow_drop_down
                </span>
              </div>
            </div>
          </div>
        </header>

        <!-- View Area Content Scrollable -->
        <main
          :class="activeMenu === 'diagram_relasi' ? 'p-0 overflow-hidden' : 'px-7 py-6 overflow-y-auto'"
          class="flex-1 bg-[#f5f5f7] dark:bg-[#121214] text-[#1d1d1f] dark:text-[#f5f5f7] transition-colors duration-500 ease-[cubic-bezier(0.2,0.8,0.2,1)]"
        >
          <!-- 1. MODUL SISWA VIEWS -->
          <template v-if="currentRole === 'siswa'">
            <SiswaDashboard v-if="activeMenu === 'dashboard'" />
            <SiswaLogbook v-else-if="activeMenu === 'logbook'" />
            <SiswaPresensi v-else-if="activeMenu === 'presensi'" />
            <SiswaPenempatan v-else-if="activeMenu === 'penempatan'" />
          </template>

          <!-- 2. MODUL PEMBIMBING LAPANGAN (INSTANSI / PERUSAHAAN) VIEWS -->
          <template v-else-if="currentRole === 'mentor' || currentRole === 'dudi'">
            <DudiDashboard v-if="activeMenu === 'dashboard_mentor' || activeMenu === 'dashboard_dudi'" />
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
            <AdminDataMaster v-else-if="['data_master_siswa', 'data_master_dudi', 'data_master_mentor', 'data_master_instansi', 'data_master_guru'].includes(activeMenu)" />
            <AdminPlotting v-else-if="activeMenu === 'plotting'" />
            <AdminDiagramRelasi v-else-if="activeMenu === 'diagram_relasi'" />
            <AdminLaporan v-else-if="activeMenu === 'laporan'" />
          </template>
        </main>
      </div>

      <!-- Global Account Settings Modal -->
      <SettingsModal />

      <!-- Official Digital ID Card / Student Pass Modal -->
      <DigitalIdCardModal />
    </div>

    <!-- Apple Dynamic Island / iOS Floating Banner Toast Notification -->
    <Transition
      enter-active-class="transition duration-300 ease-out"
      enter-from-class="opacity-0 -translate-y-4 scale-95"
      enter-to-class="opacity-100 translate-y-0 scale-100"
      leave-active-class="transition duration-200 ease-in"
      leave-from-class="opacity-100 translate-y-0 scale-100"
      leave-to-class="opacity-0 -translate-y-4 scale-95"
    >
      <div
        v-if="notificationToast.show"
        class="fixed top-5 left-1/2 -translate-x-1/2 z-[1000] flex items-center gap-3 px-5 py-2.5 rounded-full shadow-[0_12px_36px_rgba(0,0,0,0.24)] text-xs font-semibold backdrop-blur-2xl border"
        :class="{
          'bg-[#1d1d1f]/90 text-white border-white/10': notificationToast.type === 'info',
          'bg-[#1d1d1f]/90 text-[#34c759] border-[#34c759]/30': notificationToast.type === 'success',
          'bg-[#1d1d1f]/90 text-[#ff9500] border-[#ff9500]/30': notificationToast.type === 'warning',
          'bg-[#1d1d1f]/90 text-[#ff3b30] border-[#ff3b30]/30': notificationToast.type === 'error'
        }"
      >
        <span class="text-sm">
          {{ notificationToast.type === 'success' ? '✓' : (notificationToast.type === 'warning' ? '!' : 'ℹ') }}
        </span>
        <span class="text-white">{{ notificationToast.message }}</span>
      </div>
    </Transition>
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
  openSettings,
  notificationToast,
  showToast,
  journalUrgency,
  effectiveMinutesSinceTapOut,
  isSidebarCollapsed
} = useAppStore()

const currentDate = ref('')

const hasActiveNotification = computed(() => {
  return currentRole.value === 'siswa' && journalUrgency.value !== 'none'
})

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
    dashboard_mentor: 'Dashboard Pembimbing Lapangan',
    dashboard_dudi: 'Dashboard Pembimbing Lapangan',
    validasi_jurnal: 'Validasi Jurnal Siswa',
    presensi_siswa: 'Presensi Siswa Binaan',
    evaluasi: 'Evaluasi & Nilai QR',
    dashboard_guru: 'Dashboard Monitoring Guru',
    monitoring: 'Timeline Jurnal (Read-Only)',
    manajemen_nilai: 'Manajemen Kompilasi Nilai',
    dashboard_admin: 'Dashboard Admin Makro',
    data_master_siswa: 'Data Master Siswa',
    data_master_mentor: 'Data Master Tempat Magang & Pembimbing',
    data_master_dudi: 'Data Master Tempat Magang & Pembimbing',
    data_master_instansi: 'Data Master Tempat Magang & Pembimbing',
    data_master_guru: 'Data Master Guru',
    plotting: 'Plotting & Penempatan',
    diagram_relasi: 'Diagram Relasi & Alur PKL',
    laporan: 'Laporan & Buku Jurnal Cetak'
  }
  return titles[activeMenu.value] || activeMenu.value
})

const openHelp = () => {
  showToast('Pusat Bantuan PKL: Hubungi Tim Pengembang Vokasi di ext. 104', 'info')
}

const openNotifications = () => {
  if (currentRole.value === 'siswa' && journalUrgency.value === 'danger') {
    showToast(`🚨 PERINGATAN DARURAT: Anda telah Tap-Out lebih dari ${effectiveMinutesSinceTapOut.value} menit lalu dan belum mengisi jurnal!`, 'error')
  } else if (currentRole.value === 'siswa' && journalUrgency.value === 'warning') {
    showToast('⚠️ Perhatian: Anda sudah Tap-Out kepulangan. Mohon segera lengkapi jurnal harian hari ini!', 'warning')
  } else {
    showToast('Tidak ada peringatan kritis baru saat ini.', 'info')
  }
}
</script>
