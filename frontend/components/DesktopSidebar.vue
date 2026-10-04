<template>
  <aside
    :class="isSidebarCollapsed ? '-translate-x-full' : 'translate-x-0'"
    class="fixed left-0 top-0 h-full w-[260px] bg-[#fbfbfd]/90 dark:bg-[#18181b]/95 backdrop-blur-2xl border-r border-black/[0.07] dark:border-white/[0.08] z-50 flex flex-col justify-between select-none shadow-[1px_0_12px_rgba(0,0,0,0.02)] transition-transform duration-300 ease-[cubic-bezier(0.2,0.8,0.2,1)]"
  >
    <!-- Top Section: macOS Window Controls & Header -->
    <div class="flex flex-col">
      <!-- Brand Header -->
      <div class="py-3.5 px-4 border-b border-black/[0.05] dark:border-white/[0.08]">
        <!-- App Brand -->
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-xl bg-white dark:bg-[#242427] shadow-[0_2px_8px_rgba(0,0,0,0.06)] border border-black/[0.06] dark:border-white/[0.1] flex items-center justify-center p-1 shrink-0">
            <img
              src="/images/logo-smkn71.png"
              alt="Logo SMKN 71"
              class="w-7 h-7 object-contain"
            />
          </div>
          <div class="flex flex-col min-w-0">
            <span class="text-[14px] font-bold text-[#1d1d1f] dark:text-[#f5f5f7] tracking-tight truncate font-headline">
              EduAccess
            </span>
            <div class="flex items-center gap-1.5 mt-0.5">
              <span class="text-[10px] px-2 py-0.5 rounded-full bg-[#0071e3]/10 dark:bg-[#0071e3]/20 text-[#0071e3] dark:text-[#388bfd] font-semibold inline-block truncate">
                Jurnal Magang • SMKN 71
              </span>
            </div>
          </div>
        </div>

        <!-- Quick Access Role Switcher -->
        <div class="mt-3 pt-2.5 border-t border-black/[0.06] dark:border-white/[0.08]">
          <div class="flex items-center justify-between text-[11px] text-[#86868b] dark:text-[#98989f] mb-1.5 font-medium px-0.5">
            <span class="flex items-center gap-1 font-semibold text-[#1d1d1f] dark:text-[#f5f5f7]">
              <span class="material-symbols-outlined text-[13px] text-[#0071e3] dark:text-[#388bfd]">swap_horiz</span>
              <span>Quick Access:</span>
            </span>
            <span class="text-[9px] px-1.5 py-0.5 rounded bg-[#0071e3]/10 dark:bg-[#0071e3]/20 text-[#0071e3] dark:text-[#388bfd] font-mono font-bold uppercase tracking-wider">
              {{ currentRole === 'mentor' || currentRole === 'dudi' ? 'MENTOR' : currentRole }}
            </span>
          </div>
          <div class="grid grid-cols-4 gap-1 p-0.5 bg-black/[0.03] dark:bg-white/[0.06] rounded-xl border border-black/[0.05] dark:border-white/[0.08] text-[10px] font-semibold text-center">
            <button
              @click="switchRole('siswa')"
              :class="currentRole === 'siswa' ? 'bg-[#0071e3] text-white shadow-xs font-bold' : 'text-[#48484a] dark:text-[#98989f] hover:text-[#1d1d1f] dark:hover:text-white hover:bg-black/[0.04] dark:hover:bg-white/[0.08]'"
              class="py-1 px-1 rounded-lg transition-all apple-press cursor-pointer"
              title="Akses Cepat: Siswa (Budi Santoso)"
            >
              Siswa
            </button>
            <button
              @click="switchRole('mentor')"
              :class="(currentRole === 'dudi' || currentRole === 'mentor') ? 'bg-[#0071e3] text-white shadow-xs font-bold' : 'text-[#48484a] dark:text-[#98989f] hover:text-[#1d1d1f] dark:hover:text-white hover:bg-black/[0.04] dark:hover:bg-white/[0.08]'"
              class="py-1 px-1 rounded-lg transition-all apple-press cursor-pointer"
              title="Akses Cepat: Pembimbing Lapangan (Hendra Wijaya)"
            >
              Mentor
            </button>
            <button
              @click="switchRole('guru')"
              :class="currentRole === 'guru' ? 'bg-[#0071e3] text-white shadow-xs font-bold' : 'text-[#48484a] dark:text-[#98989f] hover:text-[#1d1d1f] dark:hover:text-white hover:bg-black/[0.04] dark:hover:bg-white/[0.08]'"
              class="py-1 px-1 rounded-lg transition-all apple-press cursor-pointer"
              title="Akses Cepat: Guru (Dra. Nurul Hidayah)"
            >
              Guru
            </button>
            <button
              @click="switchRole('admin')"
              :class="currentRole === 'admin' ? 'bg-[#0071e3] text-white shadow-xs font-bold' : 'text-[#48484a] dark:text-[#98989f] hover:text-[#1d1d1f] dark:hover:text-white hover:bg-black/[0.04] dark:hover:bg-white/[0.08]'"
              class="py-1 px-1 rounded-lg transition-all apple-press cursor-pointer"
              title="Akses Cepat: Admin (Ir. Bambang Hermanto)"
            >
              Admin
            </button>
          </div>
        </div>
      </div>

      <!-- Navigation Menu with Apple HIG Styling -->
      <nav class="flex flex-col gap-1 p-2.5 mt-1 overflow-y-auto max-h-[calc(100vh-275px)]">
        <!-- 1. MODUL SISWA -->
        <template v-if="currentRole === 'siswa'">
          <div class="px-2.5 pt-2 pb-1">
            <span class="text-[10px] text-[#86868b] dark:text-[#98989f] uppercase tracking-wider font-semibold">Portal Siswa</span>
          </div>

          <a
            href="#"
            @click.prevent="activeMenu = 'dashboard'"
            :class="activeMenu === 'dashboard' ? 'bg-[#0071e3] text-white shadow-[0_2px_8px_rgba(0,113,227,0.32)] font-medium' : 'text-[#48484a] dark:text-[#a1a1a6] hover:bg-black/[0.04] dark:hover:bg-white/[0.08] hover:text-[#1d1d1f] dark:hover:text-[#f5f5f7]'"
            class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 text-[13px] apple-press"
          >
            <span class="material-symbols-outlined text-[19px]">space_dashboard</span>
            <span class="truncate">Ringkasan &amp; Dashboard</span>
          </a>

          <a
            href="#"
            @click.prevent="activeMenu = 'logbook'"
            :class="activeMenu === 'logbook' ? 'bg-[#0071e3] text-white shadow-[0_2px_8px_rgba(0,113,227,0.32)] font-medium' : 'text-[#48484a] dark:text-[#a1a1a6] hover:bg-black/[0.04] dark:hover:bg-white/[0.08] hover:text-[#1d1d1f] dark:hover:text-[#f5f5f7]'"
            class="flex items-center justify-between px-3 py-2 rounded-xl transition-all duration-150 text-[13px] apple-press"
          >
            <div class="flex items-center gap-2.5 truncate">
              <span class="material-symbols-outlined text-[19px]">edit_note</span>
              <span class="truncate">Catatan Harian</span>
            </div>

            <!-- Warning / Danger Urgency Badge in Sidebar -->
            <span
              v-if="journalUrgency === 'danger'"
              class="text-[10px] px-2 py-0.5 rounded-full bg-red-600 text-white font-bold animate-pulse shadow-xs ring-1 ring-red-300"
              title="Bahaya: Jurnal wajib segera diisi!"
            >
              ! Wajib
            </span>
            <span
              v-else-if="journalUrgency === 'warning'"
              class="text-[10px] px-1.5 py-0.5 rounded-full bg-amber-500 text-white font-bold shadow-xs"
              title="Perhatian: Belum isi jurnal harian"
            >
              !
            </span>
          </a>

          <a
            href="#"
            @click.prevent="activeMenu = 'presensi'"
            :class="activeMenu === 'presensi' ? 'bg-[#0071e3] text-white shadow-[0_2px_8px_rgba(0,113,227,0.32)] font-medium' : 'text-[#48484a] dark:text-[#a1a1a6] hover:bg-black/[0.04] dark:hover:bg-white/[0.08] hover:text-[#1d1d1f] dark:hover:text-[#f5f5f7]'"
            class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 text-[13px] apple-press"
          >
            <span class="material-symbols-outlined text-[19px]">event_available</span>
            <span class="truncate">Lembar Kehadiran</span>
          </a>

          <a
            href="#"
            @click.prevent="activeMenu = 'penempatan'"
            :class="activeMenu === 'penempatan' ? 'bg-[#0071e3] text-white shadow-[0_2px_8px_rgba(0,113,227,0.32)] font-medium' : 'text-[#48484a] dark:text-[#a1a1a6] hover:bg-black/[0.04] dark:hover:bg-white/[0.08] hover:text-[#1d1d1f] dark:hover:text-[#f5f5f7]'"
            class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 text-[13px] apple-press"
          >
            <span class="material-symbols-outlined text-[19px]">supervised_user_circle</span>
            <span class="truncate">Bimbingan &amp; Mentor</span>
          </a>
        </template>

        <!-- 2. MODUL PEMBIMBING LAPANGAN (INSTANSI / PERUSAHAAN) -->
        <template v-else-if="currentRole === 'dudi' || currentRole === 'mentor'">
          <div class="px-2.5 pt-2 pb-1">
            <span class="text-[10px] text-[#86868b] dark:text-[#98989f] uppercase tracking-wider font-semibold">Pembimbing Lapangan</span>
          </div>

          <a
            href="#"
            @click.prevent="activeMenu = 'dashboard_dudi'"
            :class="(activeMenu === 'dashboard_dudi' || activeMenu === 'dashboard_mentor') ? 'bg-[#0071e3] text-white shadow-[0_2px_8px_rgba(0,113,227,0.32)] font-medium' : 'text-[#48484a] dark:text-[#a1a1a6] hover:bg-black/[0.04] dark:hover:bg-white/[0.08] hover:text-[#1d1d1f] dark:hover:text-[#f5f5f7]'"
            class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 text-[13px] apple-press"
          >
            <span class="material-symbols-outlined text-[19px]">storefront</span>
            <span class="truncate">Dashboard Pembimbing</span>
          </a>

          <a
            href="#"
            @click.prevent="activeMenu = 'validasi_jurnal'"
            :class="activeMenu === 'validasi_jurnal' ? 'bg-[#0071e3] text-white shadow-[0_2px_8px_rgba(0,113,227,0.32)] font-medium' : 'text-[#48484a] dark:text-[#a1a1a6] hover:bg-black/[0.04] dark:hover:bg-white/[0.08] hover:text-[#1d1d1f] dark:hover:text-[#f5f5f7]'"
            class="flex items-center justify-between px-3 py-2 rounded-xl transition-all duration-150 text-[13px] apple-press"
          >
            <div class="flex items-center gap-2.5 truncate">
              <span class="material-symbols-outlined text-[19px]">rate_review</span>
              <span class="truncate">Validasi Jurnal</span>
            </div>
            <span class="text-[10px] px-2 py-0.5 rounded-full bg-[#ff3b30] text-white font-semibold shadow-xs">2</span>
          </a>

          <a
            href="#"
            @click.prevent="activeMenu = 'presensi_siswa'"
            :class="activeMenu === 'presensi_siswa' ? 'bg-[#0071e3] text-white shadow-[0_2px_8px_rgba(0,113,227,0.32)] font-medium' : 'text-[#48484a] dark:text-[#a1a1a6] hover:bg-black/[0.04] dark:hover:bg-white/[0.08] hover:text-[#1d1d1f] dark:hover:text-[#f5f5f7]'"
            class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 text-[13px] apple-press"
          >
            <span class="material-symbols-outlined text-[19px]">group</span>
            <span class="truncate">Presensi Siswa</span>
          </a>

          <a
            href="#"
            @click.prevent="activeMenu = 'evaluasi'"
            :class="activeMenu === 'evaluasi' ? 'bg-[#0071e3] text-white shadow-[0_2px_8px_rgba(0,113,227,0.32)] font-medium' : 'text-[#48484a] dark:text-[#a1a1a6] hover:bg-black/[0.04] dark:hover:bg-white/[0.08] hover:text-[#1d1d1f] dark:hover:text-[#f5f5f7]'"
            class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 text-[13px] apple-press"
          >
            <span class="material-symbols-outlined text-[19px]">workspace_premium</span>
            <span class="truncate">Evaluasi &amp; Nilai QR</span>
          </a>
        </template>

        <!-- 3. MODUL GURU PEMBIMBING -->
        <template v-else-if="currentRole === 'guru'">
          <div class="px-2.5 pt-2 pb-1">
            <span class="text-[10px] text-[#86868b] dark:text-[#98989f] uppercase tracking-wider font-semibold">Guru Pembimbing</span>
          </div>

          <a
            href="#"
            @click.prevent="activeMenu = 'dashboard_guru'"
            :class="activeMenu === 'dashboard_guru' ? 'bg-[#0071e3] text-white shadow-[0_2px_8px_rgba(0,113,227,0.32)] font-medium' : 'text-[#48484a] dark:text-[#a1a1a6] hover:bg-black/[0.04] dark:hover:bg-white/[0.08] hover:text-[#1d1d1f] dark:hover:text-[#f5f5f7]'"
            class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 text-[13px] apple-press"
          >
            <span class="material-symbols-outlined text-[19px]">insights</span>
            <span class="truncate">Dashboard Guru</span>
          </a>

          <a
            href="#"
            @click.prevent="activeMenu = 'monitoring'"
            :class="activeMenu === 'monitoring' ? 'bg-[#0071e3] text-white shadow-[0_2px_8px_rgba(0,113,227,0.32)] font-medium' : 'text-[#48484a] dark:text-[#a1a1a6] hover:bg-black/[0.04] dark:hover:bg-white/[0.08] hover:text-[#1d1d1f] dark:hover:text-[#f5f5f7]'"
            class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 text-[13px] apple-press"
          >
            <span class="material-symbols-outlined text-[19px]">history_edu</span>
            <span class="truncate">Monitoring Jurnal</span>
          </a>

          <a
            href="#"
            @click.prevent="activeMenu = 'manajemen_nilai'"
            :class="activeMenu === 'manajemen_nilai' ? 'bg-[#0071e3] text-white shadow-[0_2px_8px_rgba(0,113,227,0.32)] font-medium' : 'text-[#48484a] dark:text-[#a1a1a6] hover:bg-black/[0.04] dark:hover:bg-white/[0.08] hover:text-[#1d1d1f] dark:hover:text-[#f5f5f7]'"
            class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 text-[13px] apple-press"
          >
            <span class="material-symbols-outlined text-[19px]">calculate</span>
            <span class="truncate">Manajemen Nilai</span>
          </a>
        </template>

        <!-- 4. MODUL ADMIN / KAPROG -->
        <template v-else-if="currentRole === 'admin'">
          <div class="px-2.5 pt-2 pb-1">
            <span class="text-[10px] text-[#86868b] dark:text-[#98989f] uppercase tracking-wider font-semibold">Administrasi PKL</span>
          </div>

          <a
            href="#"
            @click.prevent="activeMenu = 'dashboard_admin'"
            :class="activeMenu === 'dashboard_admin' ? 'bg-[#0071e3] text-white shadow-[0_2px_8px_rgba(0,113,227,0.32)] font-medium' : 'text-[#48484a] dark:text-[#a1a1a6] hover:bg-black/[0.04] dark:hover:bg-white/[0.08] hover:text-[#1d1d1f] dark:hover:text-[#f5f5f7]'"
            class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 text-[13px] apple-press"
          >
            <span class="material-symbols-outlined text-[19px]">tune</span>
            <span class="truncate">Dashboard Admin</span>
          </a>

          <a
            href="#"
            @click.prevent="activeMenu = 'data_master_siswa'"
            :class="['data_master_siswa', 'data_master_dudi', 'data_master_guru'].includes(activeMenu) ? 'bg-[#0071e3] text-white shadow-[0_2px_8px_rgba(0,113,227,0.32)] font-medium' : 'text-[#48484a] dark:text-[#a1a1a6] hover:bg-black/[0.04] dark:hover:bg-white/[0.08] hover:text-[#1d1d1f] dark:hover:text-[#f5f5f7]'"
            class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 text-[13px] apple-press"
          >
            <span class="material-symbols-outlined text-[19px]">folder_shared</span>
            <span class="truncate">Data Master PKL</span>
          </a>

          <a
            href="#"
            @click.prevent="activeMenu = 'plotting'"
            :class="activeMenu === 'plotting' ? 'bg-[#0071e3] text-white shadow-[0_2px_8px_rgba(0,113,227,0.32)] font-medium' : 'text-[#48484a] dark:text-[#a1a1a6] hover:bg-black/[0.04] dark:hover:bg-white/[0.08] hover:text-[#1d1d1f] dark:hover:text-[#f5f5f7]'"
            class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 text-[13px] apple-press"
          >
            <span class="material-symbols-outlined text-[19px]">hub</span>
            <span class="truncate">Plotting Penempatan</span>
          </a>

          <a
            href="#"
            @click.prevent="activeMenu = 'diagram_relasi'"
            :class="activeMenu === 'diagram_relasi' ? 'bg-[#0071e3] text-white shadow-[0_2px_8px_rgba(0,113,227,0.32)] font-medium' : 'text-[#48484a] dark:text-[#a1a1a6] hover:bg-black/[0.04] dark:hover:bg-white/[0.08] hover:text-[#1d1d1f] dark:hover:text-[#f5f5f7]'"
            class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 text-[13px] apple-press"
          >
            <span class="material-symbols-outlined text-[19px]">account_tree</span>
            <span class="truncate">Diagram Relasi PKL</span>
          </a>

          <a
            href="#"
            @click.prevent="activeMenu = 'laporan'"
            :class="activeMenu === 'laporan' ? 'bg-[#0071e3] text-white shadow-[0_2px_8px_rgba(0,113,227,0.32)] font-medium' : 'text-[#48484a] dark:text-[#a1a1a6] hover:bg-black/[0.04] dark:hover:bg-white/[0.08] hover:text-[#1d1d1f] dark:hover:text-[#f5f5f7]'"
            class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 text-[13px] apple-press"
          >
            <span class="material-symbols-outlined text-[19px]">print</span>
            <span class="truncate">Laporan &amp; Arsip</span>
          </a>
        </template>
      </nav>
    </div>

    <!-- Apple macOS Bottom Section: Profile & System Info -->
    <div class="flex flex-col p-3 border-t border-black/[0.05] dark:border-white/[0.08] bg-white/50 dark:bg-[#18181b]/95 backdrop-blur-md gap-2">
      <!-- Affiliation Card for Siswa -->
      <div
        v-if="currentRole === 'siswa'"
        @click="openIdCard"
        class="bg-white/80 dark:bg-[#242427] rounded-xl p-2.5 border border-black/[0.05] dark:border-white/[0.08] shadow-[0_1px_3px_rgba(0,0,0,0.03)] cursor-pointer apple-press hover:border-[#0071e3]/30 dark:hover:border-[#0071e3]/50 transition-all group"
        title="Klik untuk membuka Kartu Tanda Peserta PKL Digital"
      >
        <div class="flex items-center justify-between text-[#0071e3] dark:text-[#388bfd] mb-0.5">
          <div class="flex items-center gap-1.5 min-w-0">
            <span class="material-symbols-outlined text-[16px]">domain</span>
            <span class="text-[12px] font-semibold truncate">{{ currentUser.company_name || 'PT Telkom Digital Solusi' }}</span>
          </div>
          <span class="text-[9px] font-mono px-1.5 py-0.5 rounded bg-[#0071e3]/10 dark:bg-[#0071e3]/20 text-[#0071e3] dark:text-[#388bfd] font-bold">NISN</span>
        </div>
        <div class="flex items-center justify-between text-[11px] text-[#86868b] dark:text-[#98989f]">
          <span class="font-mono">NISN: {{ currentUser.nisn_nip || '0061234567' }}</span>
          <span class="text-[10px] font-medium text-[#1d1d1f] dark:text-[#f5f5f7] flex items-center gap-1">
            <span>{{ currentUser.class_name || 'XII RPL 1' }}</span>
            <span class="material-symbols-outlined text-[13px] text-[#86868b] dark:text-[#98989f] group-hover:text-[#0071e3] dark:group-hover:text-[#388bfd] transition-colors" title="Kartu Tanda Siswa PKL">badge</span>
          </span>
        </div>
      </div>

      <!-- Mini Profile Card for Other Roles -->
      <div
        v-else
        @click="openIdCard"
        class="p-2 rounded-xl bg-white/80 dark:bg-[#242427] border border-black/[0.05] dark:border-white/[0.08] flex items-center justify-between shadow-[0_1px_3px_rgba(0,0,0,0.03)] cursor-pointer apple-press hover:border-[#0071e3]/30 dark:hover:border-[#0071e3]/50 transition-all group"
        title="Klik untuk membuka Kartu Identitas Digital"
      >
        <div class="flex items-center gap-2 min-w-0">
          <div class="w-7 h-7 rounded-full bg-[#0071e3] flex items-center justify-center shrink-0 text-white shadow-xs">
            <span class="material-symbols-outlined text-[16px]">person</span>
          </div>
          <div class="flex flex-col min-w-0">
            <span class="text-[12px] font-semibold text-[#1d1d1f] dark:text-[#f5f5f7] truncate group-hover:text-[#0071e3] dark:group-hover:text-[#388bfd] transition-colors">
              {{ currentUser.name }}
            </span>
            <span class="text-[10px] text-[#86868b] dark:text-[#98989f] truncate font-mono">
              {{ ((currentRole === 'dudi' || currentRole === 'mentor') ? 'ID: ' : 'NIP: ') + (currentUser.nisn_nip || '-') }}
            </span>
          </div>
        </div>
        <span class="material-symbols-outlined text-[16px] text-[#86868b] dark:text-[#98989f] group-hover:text-[#0071e3] dark:group-hover:text-[#388bfd] transition-colors">badge</span>
      </div>

      <!-- macOS Quick Links: Pengaturan, Bantuan -->
      <div class="flex flex-col space-y-0.5">
        <button
          @click="openSettings"
          class="flex items-center gap-2.5 px-2.5 py-1.5 rounded-lg text-[#86868b] dark:text-[#98989f] hover:bg-black/[0.04] dark:hover:bg-white/[0.06] hover:text-[#1d1d1f] dark:hover:text-[#f5f5f7] transition-all text-left apple-press cursor-pointer"
          type="button"
        >
          <span class="material-symbols-outlined text-[17px]">settings</span>
          <span class="text-[12px] font-medium">Pengaturan Akun</span>
        </button>

        <button
          @click="openHelp"
          class="flex items-center gap-2.5 px-2.5 py-1.5 rounded-lg text-[#86868b] dark:text-[#98989f] hover:bg-black/[0.04] dark:hover:bg-white/[0.06] hover:text-[#1d1d1f] dark:hover:text-[#f5f5f7] transition-all text-left apple-press cursor-pointer"
          type="button"
        >
          <span class="material-symbols-outlined text-[17px]">help_outline</span>
          <span class="text-[12px] font-medium">Bantuan &amp; Panduan</span>
        </button>
      </div>

      <!-- Live Sync Cloud Online Indicator & Logout -->
      <div class="flex items-center justify-between pt-2 border-t border-black/[0.05] dark:border-white/[0.08]">
        <div class="flex items-center gap-1.5 pl-1" title="Sistem terhubung online realtime ke backend API SMKN 71">
          <span class="w-2 h-2 rounded-full bg-[#34c759] shadow-[0_0_8px_rgba(52,199,89,0.5)]"></span>
          <span class="text-[11px] text-[#86868b] dark:text-[#98989f] font-medium">
            Live Sync
          </span>
        </div>
        <button
          @click="handleLogout"
          aria-label="Keluar"
          class="px-2.5 py-1 rounded-lg bg-[#ff3b30]/10 dark:bg-[#ff3b30]/15 text-[#ff3b30] hover:bg-[#ff3b30]/15 dark:hover:bg-[#ff3b30]/25 transition-all font-medium flex items-center justify-center gap-1 text-[11px] apple-press cursor-pointer"
          title="Keluar / Logout"
          type="button"
        >
          <span class="material-symbols-outlined text-[15px]">logout</span>
          <span>Keluar</span>
        </button>
      </div>
    </div>

    <!-- Modal Konfirmasi Logout macOS Style -->
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
          v-if="showLogoutConfirm"
          class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm select-none"
          @click.self="showLogoutConfirm = false"
        >
          <div
            class="modal-card-animate w-full max-w-[360px] bg-white dark:bg-[#1c1c1e] rounded-2xl border border-black/[0.08] dark:border-white/[0.12] shadow-[0_20px_50px_rgba(0,0,0,0.3)] p-6 text-center transform transition-all text-[#1d1d1f] dark:text-[#f5f5f7]"
          >
            <!-- Icon Alert -->
            <div class="w-12 h-12 rounded-full bg-[#ff3b30]/10 text-[#ff3b30] flex items-center justify-center mx-auto mb-3.5 border border-[#ff3b30]/20">
              <span class="material-symbols-outlined text-[24px]">logout</span>
            </div>

            <!-- Title & Description -->
            <h3 class="text-[16px] font-bold text-[#1d1d1f] dark:text-[#f5f5f7] tracking-tight">
              Konfirmasi Keluar
            </h3>
            <p class="text-[13px] text-[#86868b] dark:text-[#98989f] mt-1.5 leading-relaxed">
              Apakah Anda yakin ingin keluar dari akun EduAccess? Sesi aktif Anda saat ini akan diakhiri.
            </p>

            <!-- Action Buttons -->
            <div class="mt-6 grid grid-cols-2 gap-2.5">
              <button
                type="button"
                @click="showLogoutConfirm = false"
                class="py-2.5 px-4 rounded-xl bg-black/[0.05] hover:bg-black/[0.08] dark:bg-white/[0.08] dark:hover:bg-white/[0.12] text-[#1d1d1f] dark:text-[#f5f5f7] text-[13px] font-semibold transition-all apple-press cursor-pointer"
              >
                Batal
              </button>
              <button
                type="button"
                @click="confirmLogout"
                class="py-2.5 px-4 rounded-xl bg-[#ff3b30] hover:bg-[#e0342a] text-white text-[13px] font-semibold shadow-[0_2px_8px_rgba(255,59,48,0.3)] transition-all apple-press cursor-pointer flex items-center justify-center gap-1.5"
              >
                <span>Ya, Keluar</span>
              </button>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>
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
  openSettings,
  isIdCardModalOpen,
  switchRole,
  showToast,
  logout,
  journalUrgency,
  isSidebarCollapsed
} = useAppStore()

const showLogoutConfirm = ref(false)

const openIdCard = () => {
  isIdCardModalOpen.value = true
}

const copyNisnDirect = () => {
  const text = currentUser.value.nisn_nip || '0061234567'
  if (navigator.clipboard) {
    navigator.clipboard.writeText(text)
  }
  showToast(`✓ NISN (${text}) disalin ke clipboard!`, 'success')
}

const openHelp = () => {
  showToast('Pusat Bantuan PKL: Hubungi Tim Pengembang Vokasi SMKN 71 di ext. 104', 'info')
}

const handleLogout = () => {
  showLogoutConfirm.value = true
}

const confirmLogout = () => {
  showLogoutConfirm.value = false
  logout()
  showToast('Berhasil keluar dari akun.', 'info')
}
</script>

<style scoped>
@keyframes modalPop {
  0% {
    opacity: 0;
    transform: scale(0.95);
  }
  100% {
    opacity: 1;
    transform: scale(1);
  }
}

.modal-card-animate {
  animation: modalPop 200ms cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
</style>
