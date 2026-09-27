<template>
  <aside class="fixed left-0 top-0 h-full w-[260px] bg-surface-container-lowest border-r border-outline-variant z-50 flex flex-col justify-between select-none shadow-sm">
    <!-- Top Brand & Header -->
    <div class="flex flex-col">
      <!-- Stitch PKL Digital Brand -->
      <div class="p-space-md border-b border-outline-variant bg-surface-container-lowest">
        <div class="flex items-center gap-space-sm">
          <div class="w-9 h-9 rounded bg-primary flex items-center justify-center text-on-primary font-headline font-bold text-sm tracking-wider">
            PKL
          </div>
          <div class="flex flex-col min-w-0">
            <span class="font-headline text-[15px] font-bold text-on-surface tracking-tight truncate">
              LogPKL Digital
            </span>
            <span class="font-label-sm text-[10px] px-1.5 py-0.5 rounded bg-surface-container text-primary font-semibold mt-0.5 inline-block w-fit truncate">
              SMK / Vokasi &amp; Merdeka
            </span>
          </div>
        </div>

        <!-- Role Simulator Quick Switcher -->
        <div class="mt-3 pt-2.5 border-t border-outline-variant/60">
          <div class="flex items-center justify-between text-[11px] text-on-surface-variant mb-1.5 font-medium">
            <span>Aktor Aktif:</span>
            <span class="text-[10px] px-1.5 py-0.5 rounded bg-surface-container text-primary font-mono font-bold uppercase">
              {{ currentRole }}
            </span>
          </div>
          <div class="grid grid-cols-4 gap-1 p-0.5 bg-surface-container-low rounded-lg border border-outline-variant text-[10px] font-semibold text-center">
            <button
              @click="switchRole('siswa')"
              :class="currentRole === 'siswa' ? 'bg-primary-container text-on-primary font-bold shadow-sm' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container-lowest'"
              class="py-1 px-1 rounded transition-colors"
            >
              Siswa
            </button>
            <button
              @click="switchRole('dudi')"
              :class="currentRole === 'dudi' ? 'bg-primary-container text-on-primary font-bold shadow-sm' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container-lowest'"
              class="py-1 px-1 rounded transition-colors"
            >
              DUDI
            </button>
            <button
              @click="switchRole('guru')"
              :class="currentRole === 'guru' ? 'bg-primary-container text-on-primary font-bold shadow-sm' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container-lowest'"
              class="py-1 px-1 rounded transition-colors"
            >
              Guru
            </button>
            <button
              @click="switchRole('admin')"
              :class="currentRole === 'admin' ? 'bg-primary-container text-on-primary font-bold shadow-sm' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container-lowest'"
              class="py-1 px-1 rounded transition-colors"
            >
              Admin
            </button>
          </div>
        </div>
      </div>

      <!-- Navigation Menu with Stitch Styling -->
      <nav class="flex flex-col gap-1 p-space-sm mt-1 overflow-y-auto max-h-[calc(100vh-270px)]">
        <!-- 1. MODUL SISWA -->
        <template v-if="currentRole === 'siswa'">
          <a
            href="#"
            @click.prevent="activeMenu = 'dashboard'"
            :class="activeMenu === 'dashboard' ? 'bg-primary-container text-on-primary font-bold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface font-label-md'"
            class="flex items-center gap-space-sm px-3 py-2 rounded-lg transition-colors text-xs"
          >
            <span class="material-symbols-outlined text-[18px]">dashboard</span>
            <span>Dashboard Ringkasan</span>
          </a>

          <a
            href="#"
            @click.prevent="activeMenu = 'logbook'"
            :class="activeMenu === 'logbook' ? 'bg-primary-container text-on-primary font-bold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface font-label-md'"
            class="flex items-center gap-space-sm px-3 py-2 rounded-lg transition-colors text-xs"
          >
            <span class="material-symbols-outlined text-[18px]">menu_book</span>
            <span>Logbook Harian</span>
          </a>

          <a
            href="#"
            @click.prevent="activeMenu = 'presensi'"
            :class="activeMenu === 'presensi' ? 'bg-primary-container text-on-primary font-bold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface font-label-md'"
            class="flex items-center gap-space-sm px-3 py-2 rounded-lg transition-colors text-xs"
          >
            <span class="material-symbols-outlined text-[18px]">event_available</span>
            <span>Presensi &amp; Kehadiran</span>
          </a>

          <a
            href="#"
            @click.prevent="activeMenu = 'penempatan'"
            :class="activeMenu === 'penempatan' ? 'bg-primary-container text-on-primary font-bold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface font-label-md'"
            class="flex items-center gap-space-sm px-3 py-2 rounded-lg transition-colors text-xs"
          >
            <span class="material-symbols-outlined text-[18px]">domain</span>
            <span>Info Tempat PKL</span>
          </a>
        </template>

        <!-- 2. MODUL PEMBIMBING INDUSTRI (DUDI) -->
        <template v-else-if="currentRole === 'dudi'">
          <a
            href="#"
            @click.prevent="activeMenu = 'dashboard_dudi'"
            :class="activeMenu === 'dashboard_dudi' ? 'bg-primary-container text-on-primary font-bold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface font-label-md'"
            class="flex items-center gap-space-sm px-3 py-2 rounded-lg transition-colors text-xs"
          >
            <span class="material-symbols-outlined text-[18px]">storefront</span>
            <span>Dashboard DUDI</span>
          </a>

          <a
            href="#"
            @click.prevent="activeMenu = 'validasi_jurnal'"
            :class="activeMenu === 'validasi_jurnal' ? 'bg-primary-container text-on-primary font-bold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface font-label-md'"
            class="flex items-center justify-between px-3 py-2 rounded-lg transition-colors text-xs"
          >
            <div class="flex items-center gap-space-sm">
              <span class="material-symbols-outlined text-[18px]">rate_review</span>
              <span>Validasi Jurnal</span>
            </div>
            <span class="font-label-sm text-[10px] px-1.5 py-0.5 rounded bg-secondary-container text-on-secondary-fixed font-bold">2 Baru</span>
          </a>

          <a
            href="#"
            @click.prevent="activeMenu = 'presensi_siswa'"
            :class="activeMenu === 'presensi_siswa' ? 'bg-primary-container text-on-primary font-bold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface font-label-md'"
            class="flex items-center gap-space-sm px-3 py-2 rounded-lg transition-colors text-xs"
          >
            <span class="material-symbols-outlined text-[18px]">group</span>
            <span>Presensi Siswa</span>
          </a>

          <a
            href="#"
            @click.prevent="activeMenu = 'evaluasi'"
            :class="activeMenu === 'evaluasi' ? 'bg-primary-container text-on-primary font-bold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface font-label-md'"
            class="flex items-center gap-space-sm px-3 py-2 rounded-lg transition-colors text-xs"
          >
            <span class="material-symbols-outlined text-[18px]">workspace_premium</span>
            <span>Evaluasi &amp; Nilai QR</span>
          </a>
        </template>

        <!-- 3. MODUL GURU PEMBIMBING -->
        <template v-else-if="currentRole === 'guru'">
          <a
            href="#"
            @click.prevent="activeMenu = 'dashboard_guru'"
            :class="activeMenu === 'dashboard_guru' ? 'bg-primary-container text-on-primary font-bold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface font-label-md'"
            class="flex items-center gap-space-sm px-3 py-2 rounded-lg transition-colors text-xs"
          >
            <span class="material-symbols-outlined text-[18px]">insights</span>
            <span>Dashboard Guru</span>
          </a>

          <a
            href="#"
            @click.prevent="activeMenu = 'monitoring'"
            :class="activeMenu === 'monitoring' ? 'bg-primary-container text-on-primary font-bold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface font-label-md'"
            class="flex items-center gap-space-sm px-3 py-2 rounded-lg transition-colors text-xs"
          >
            <span class="material-symbols-outlined text-[18px]">history_edu</span>
            <span>Monitoring Jurnal</span>
          </a>

          <a
            href="#"
            @click.prevent="activeMenu = 'manajemen_nilai'"
            :class="activeMenu === 'manajemen_nilai' ? 'bg-primary-container text-on-primary font-bold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface font-label-md'"
            class="flex items-center gap-space-sm px-3 py-2 rounded-lg transition-colors text-xs"
          >
            <span class="material-symbols-outlined text-[18px]">calculate</span>
            <span>Manajemen Nilai</span>
          </a>
        </template>

        <!-- 4. MODUL ADMIN / KAPROG -->
        <template v-else-if="currentRole === 'admin'">
          <a
            href="#"
            @click.prevent="activeMenu = 'dashboard_admin'"
            :class="activeMenu === 'dashboard_admin' ? 'bg-primary-container text-on-primary font-bold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface font-label-md'"
            class="flex items-center gap-space-sm px-3 py-2 rounded-lg transition-colors text-xs"
          >
            <span class="material-symbols-outlined text-[18px]">tune</span>
            <span>Dashboard Admin</span>
          </a>

          <a
            href="#"
            @click.prevent="activeMenu = 'data_master_siswa'"
            :class="['data_master_siswa', 'data_master_dudi', 'data_master_guru'].includes(activeMenu) ? 'bg-primary-container text-on-primary font-bold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface font-label-md'"
            class="flex items-center gap-space-sm px-3 py-2 rounded-lg transition-colors text-xs"
          >
            <span class="material-symbols-outlined text-[18px]">folder_shared</span>
            <span>Data Master PKL</span>
          </a>

          <a
            href="#"
            @click.prevent="activeMenu = 'plotting'"
            :class="activeMenu === 'plotting' ? 'bg-primary-container text-on-primary font-bold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface font-label-md'"
            class="flex items-center gap-space-sm px-3 py-2 rounded-lg transition-colors text-xs"
          >
            <span class="material-symbols-outlined text-[18px]">hub</span>
            <span>Plotting Penempatan</span>
          </a>

          <a
            href="#"
            @click.prevent="activeMenu = 'laporan'"
            :class="activeMenu === 'laporan' ? 'bg-primary-container text-on-primary font-bold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface font-label-md'"
            class="flex items-center gap-space-sm px-3 py-2 rounded-lg transition-colors text-xs"
          >
            <span class="material-symbols-outlined text-[18px]">print</span>
            <span>Laporan &amp; Arsip</span>
          </a>
        </template>
      </nav>
    </div>

    <!-- Stitch Bottom Static Section (Profile, Network, Settings, Logout) -->
    <div class="flex flex-col p-space-sm border-t border-outline-variant bg-surface-container-lowest gap-space-sm">
      <!-- Mini Profile Card -->
      <div class="p-2.5 rounded-lg bg-surface border border-outline-variant flex items-center justify-between">
        <div class="flex items-center gap-2 min-w-0">
          <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center shrink-0 text-on-primary">
            <span class="material-symbols-outlined text-[18px]">person</span>
          </div>
          <div class="flex flex-col min-w-0">
            <span class="font-label-md text-label-md font-bold text-on-surface truncate">
              {{ currentUser.name }}
            </span>
            <span class="font-code-sm text-[10px] text-on-surface-variant truncate font-mono">
              {{ currentRole === 'siswa' ? 'NISN. 0061234567' : (currentRole === 'dudi' ? 'ID. TELKOM-8821' : 'NIP. 19800512001') }}
            </span>
          </div>
        </div>
        <span class="font-label-sm text-[10px] px-1.5 py-0.5 rounded bg-tertiary-fixed text-tertiary font-bold shrink-0">
          {{ currentRole === 'siswa' ? 'Magang Aktif' : (currentRole === 'dudi' ? 'Mentor DUDI' : (currentRole === 'guru' ? 'Guru Pembimbing' : 'Kaprog RPL')) }}
        </span>
      </div>

      <!-- Desktop Network Indicator & Sync -->
      <div class="flex items-center justify-between px-1">
        <div class="flex items-center gap-1.5">
          <span
            class="w-2 h-2 rounded-full"
            :class="isOnline ? 'bg-tertiary-container animate-pulse' : 'bg-secondary'"
          ></span>
          <span class="font-label-sm text-[11px] text-on-surface-variant">
            {{ isOnline ? 'Sistem Online' : 'Mode Offline (Lokal)' }}
          </span>
        </div>
        <button
          @click="handleSyncNow"
          :disabled="isSyncing"
          class="font-label-sm text-[11px] px-2 py-1 rounded bg-surface-container text-on-surface hover:bg-surface-container-high transition-colors font-medium border border-outline-variant flex items-center gap-1 active:scale-95 disabled:opacity-50"
          type="button"
        >
          <span class="material-symbols-outlined text-[14px]" :class="isSyncing ? 'animate-spin' : ''">sync</span>
          <span>Sync</span>
        </button>
      </div>

      <!-- Action Buttons: Settings & Logout -->
      <div class="flex items-center gap-1.5 pt-1 border-t border-outline-variant">
        <button
          @click="openSettings"
          class="flex-1 py-1.5 px-2 rounded-lg text-center font-label-sm text-[11px] text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface transition-colors border border-outline-variant font-medium"
        >
          Pengaturan
        </button>
        <button
          @click="handleLogout"
          aria-label="Keluar"
          class="py-1.5 px-3 rounded-lg text-center font-label-sm text-label-sm bg-error-container text-error hover:opacity-90 transition-opacity font-semibold flex items-center justify-center active:scale-95"
          title="Keluar / Logout"
        >
          <span class="material-symbols-outlined text-[16px]">logout</span>
        </button>
      </div>
    </div>
  </aside>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useAppStore } from '~/composables/useAppStore'

const {
  currentRole,
  activeMenu,
  currentUser,
  isOnline,
  isSettingsModalOpen,
  switchRole,
  showToast,
  logout
} = useAppStore()

const isSyncing = ref(false)

const openSettings = () => {
  isSettingsModalOpen.value = true
}

const handleSyncNow = () => {
  isSyncing.value = true
  setTimeout(() => {
    isSyncing.value = false
    showToast('Sinkronisasi data berhasil! Database lokal selaras dengan server pusat.', 'success')
  }, 1000)
}

const handleLogout = () => {
  logout()
}
</script>
