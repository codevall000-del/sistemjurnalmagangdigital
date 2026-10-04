<template>
  <div class="flex flex-col w-full max-w-[1440px] mx-auto gap-6">
    <!-- Header & Breadcrumb Context -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
      <div>
        <div class="flex items-center gap-2 mb-1">
          <span class="text-[11px] text-[#0071e3] tracking-wider uppercase font-semibold">Administrasi &amp; Logbook</span>
          <span class="text-[#86868b] text-[10px]">•</span>
          <span class="text-[11px] text-[#86868b]">Semester Ganjil 2024 • SMKN 71 Jakarta</span>
        </div>
        <h1 class="text-2xl sm:text-3xl text-[#1d1d1f] font-bold tracking-tight">Lembar Kehadiran &amp; Presensi</h1>
        <p class="text-[13px] text-[#86868b] mt-0.5 leading-relaxed">
          Pemantauan rekapitulasi jam kerja reguler, bukti lokasi presensi, dan validasi mentor.
        </p>
      </div>

      <div class="flex items-center gap-2.5 self-start md:self-auto">
        <button
          @click="downloadRekapPdf"
          class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white text-[#1d1d1f] shadow-xs hover:bg-black/[0.04] transition-all text-[12px] font-semibold border border-black/[0.08] apple-press"
          type="button"
        >
          <span class="material-symbols-outlined text-[17px] text-[#0071e3]">file_download</span>
          <span>Unduh Rekap PDF</span>
        </button>
        <button
          @click="isIzinModalOpen = true"
          class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#0071e3] text-white shadow-[0_2px_8px_rgba(0,113,227,0.25)] hover:bg-[#0077ed] transition-all text-[12px] font-semibold apple-press"
          type="button"
        >
          <span class="material-symbols-outlined text-[17px]">add_circle</span>
          <span>Ajukan Izin / Sakit</span>
        </button>
      </div>
    </div>

    <!-- Quick Presensi Today Panel (Apple Hero Split Banner) -->
    <div class="bg-white dark:bg-[#1c1c1e] rounded-2xl shadow-[0_2px_12px_rgba(0,0,0,0.03)] border border-black/[0.05] dark:border-white/[0.08] p-5 sm:p-6 relative overflow-hidden">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-stretch relative z-10">
        <!-- Left Sub-panel: Realtime Clock & Status -->
        <div class="lg:col-span-4 flex flex-col justify-between gap-4 p-5 rounded-2xl bg-[#f5f5f7]/70 dark:bg-white/[0.04] border border-black/[0.04] dark:border-white/[0.06]">
          <div class="flex flex-col gap-2">
            <div class="flex items-center gap-2 text-[#86868b] dark:text-[#a1a1a6] text-[12px] font-medium">
              <span class="w-2 h-2 rounded-full bg-[#34c759] animate-pulse"></span>
              <span>Rabu, 23 Oktober 2024</span>
              <span class="text-black/20 dark:text-white/20">•</span>
              <span class="text-[#0071e3] font-semibold">{{ currentSessionName }}</span>
            </div>

            <div class="flex items-baseline gap-2 mt-0.5">
              <span class="text-[38px] sm:text-[42px] leading-none text-[#1d1d1f] dark:text-white font-bold tracking-tight font-headline">
                {{ currentTime }}
              </span>
              <span class="text-[12px] text-[#86868b] font-medium">WIB</span>
            </div>
          </div>

          <button
            @click="isGeofenceModalOpen = true"
            type="button"
            class="flex items-center justify-between gap-2 text-[#1d1d1f] dark:text-[#f5f5f7] bg-white/90 dark:bg-black/30 hover:bg-white dark:hover:bg-black/40 px-3.5 py-2.5 rounded-xl border border-black/[0.06] dark:border-white/[0.08] shadow-xs transition-all apple-press cursor-pointer text-left group"
          >
            <div class="flex items-center gap-2 min-w-0">
              <span class="material-symbols-outlined text-[18px] text-[#0071e3] shrink-0">verified</span>
              <span class="text-[11px] font-medium truncate">Tervalidasi GPS Kantor • Lantai 4 Tech Hub</span>
            </div>
            <span class="material-symbols-outlined text-[15px] text-[#86868b] group-hover:text-[#0071e3] transition-colors shrink-0">arrow_forward_ios</span>
          </button>
        </div>

        <!-- Middle Sub-panel: Check-in Details (STATUS PRESENSI MASUK) -->
        <div class="lg:col-span-5 bg-gradient-to-br from-[#f9f9fb] via-[#f5f5f8] to-[#ededf2] dark:from-white/[0.06] dark:to-white/[0.02] rounded-2xl p-5 flex flex-col justify-between gap-4 border border-black/[0.06] dark:border-white/[0.08] shadow-[0_2px_8px_rgba(0,0,0,0.02)] relative overflow-hidden">
          <!-- Header: Category Title + Pill Badge -->
          <div class="flex items-center justify-between gap-2">
            <div class="flex items-center gap-2">
              <div class="w-6 h-6 rounded-lg bg-[#0071e3]/10 dark:bg-[#0071e3]/20 text-[#0071e3] dark:text-[#38bdf8] flex items-center justify-center">
                <span class="material-symbols-outlined text-[15px]">how_to_reg</span>
              </div>
              <span class="text-[11px] uppercase tracking-wider text-[#86868b] dark:text-[#a1a1a6] font-bold">Status Presensi Masuk</span>
            </div>

            <!-- Dynamic Status Badge -->
            <span
              v-if="attendanceState.hasCheckedOut"
              class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#0071e3]/10 text-[#0071e3] border border-[#0071e3]/20 text-[11px] font-semibold"
            >
              <span class="material-symbols-outlined text-[13px]">task_alt</span>
              <span>Selesai Sesi</span>
            </span>
            <span
              v-else-if="attendanceState.hasCheckedIn"
              class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#34c759]/12 text-[#248a3d] dark:text-emerald-400 border border-[#34c759]/25 text-[11px] font-semibold shadow-xs"
            >
              <span class="w-1.5 h-1.5 rounded-full bg-[#34c759] animate-pulse"></span>
              <span>Hadir Tepat Waktu</span>
            </span>
            <span
              v-else
              class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-500/12 text-amber-700 border border-amber-500/25 text-[11px] font-semibold"
            >
              <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
              <span>Belum Tap-In</span>
            </span>
          </div>

          <!-- Hero Metric: Large Check-in Time & Work Mode -->
          <div class="flex items-center justify-between gap-3">
            <div class="flex items-center gap-3.5">
              <div class="w-12 h-12 rounded-2xl bg-[#0071e3]/10 dark:bg-[#0071e3]/20 text-[#0071e3] dark:text-[#38bdf8] flex items-center justify-center border border-[#0071e3]/15 shadow-xs shrink-0">
                <span class="material-symbols-outlined text-[24px]">login</span>
              </div>
              <div class="flex flex-col">
                <div class="flex items-baseline gap-1.5">
                  <span class="text-[26px] sm:text-[28px] font-bold text-[#1d1d1f] dark:text-white tracking-tight leading-none font-headline">
                    {{ effectiveCheckInTime }}
                  </span>
                  <span class="text-[12px] font-semibold text-[#86868b]">WIB</span>
                </div>
                <div class="flex items-center gap-1.5 text-[12px] text-[#86868b] dark:text-[#a1a1a6] mt-1">
                  <span class="material-symbols-outlined text-[15px] text-[#34c759]">verified</span>
                  <span class="font-medium text-[#1d1d1f] dark:text-[#f5f5f7]">{{ currentWorkModeLabel }}</span>
                  <span class="text-black/20 dark:text-white/20">•</span>
                  <span>{{ currentLocationLabel }}</span>
                </div>
              </div>
            </div>

            <!-- Elapsed Duration Mini Card -->
            <div class="hidden sm:flex flex-col items-end px-3 py-1.5 rounded-xl bg-white/80 dark:bg-black/30 border border-black/[0.05] dark:border-white/[0.08] shadow-xs shrink-0">
              <span class="text-[10px] uppercase font-semibold text-[#86868b] tracking-wider">Durasi Kerja</span>
              <span class="text-[13px] font-bold text-[#0071e3] dark:text-[#38bdf8]">{{ currentDurationElapsed }}</span>
            </div>
          </div>

          <!-- Workday Progress Track & Timeline Bar -->
          <div class="flex flex-col gap-2 pt-2 border-t border-black/[0.05] dark:border-white/[0.06]">
            <div class="flex items-center justify-between text-[11px]">
              <span class="text-[#86868b] dark:text-[#a1a1a6] font-medium flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[14px] text-[#0071e3]">timelapse</span>
                <span>Progres Jam Kerja Hari Ini</span>
              </span>
              <span class="font-semibold text-[#1d1d1f] dark:text-white">
                {{ workdayProgressPercent }}% <span class="font-normal text-[#86868b]">menuju jam pulang</span>
              </span>
            </div>

            <!-- Progress Bar -->
            <div class="w-full bg-black/[0.06] dark:bg-white/[0.08] rounded-full h-2 overflow-hidden p-0.5">
              <div
                class="h-full rounded-full bg-gradient-to-r from-[#0071e3] to-[#34c759] transition-all duration-700 ease-out shadow-xs"
                :style="{ width: `${workdayProgressPercent}%` }"
              ></div>
            </div>

            <!-- Timeline Boundary Endpoints -->
            <div class="flex items-center justify-between text-[11px] text-[#86868b] dark:text-[#a1a1a6] font-medium">
              <div class="flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-[#0071e3]"></span>
                <span>Masuk: <strong class="text-[#1d1d1f] dark:text-white font-semibold">{{ effectiveCheckInTime }} WIB</strong></span>
              </div>
              <div class="flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-[#34c759]"></span>
                <span>Target Pulang: <strong class="text-[#0071e3] dark:text-[#38bdf8] font-semibold">{{ targetJamPulang }} WIB</strong></span>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Sub-panel: Quick Checkout & Secondary Actions -->
        <div class="lg:col-span-3 flex flex-col justify-between gap-3 p-5 rounded-2xl bg-[#f5f5f7]/70 dark:bg-white/[0.04] border border-black/[0.04] dark:border-white/[0.06]">
          <div class="flex flex-col gap-2">
            <span class="text-[11px] uppercase tracking-wider text-[#86868b] dark:text-[#a1a1a6] font-bold">
              Kepulangan &amp; Validasi
            </span>

            <button
              @click="handleCheckOut"
              :disabled="attendanceState.hasCheckedOut"
              :class="attendanceState.hasCheckedOut ? 'bg-black/[0.05] dark:bg-white/[0.08] text-[#86868b] cursor-default' : 'bg-[#ff9500] text-white hover:bg-[#e08500] shadow-[0_2px_8px_rgba(255,149,0,0.3)] apple-press cursor-pointer'"
              class="w-full py-3 px-4 rounded-xl flex items-center justify-center gap-2 text-[13px] font-semibold transition-all"
              type="button"
            >
              <span class="material-symbols-outlined text-[19px]">logout</span>
              <span>
                {{ attendanceState.hasCheckedOut ? 'Sudah Check-out Sore' : 'Check-out Sore' }}
              </span>
            </button>
          </div>

          <!-- Alert Callout if Checked Out but Journal is not filled -->
          <div
            v-if="attendanceState.hasCheckedOut && !isTodayLogged"
            class="p-3 rounded-xl border flex flex-col gap-1.5 transition-all text-xs"
            :class="{
              'bg-amber-500/10 border-amber-500/40 text-amber-950': journalUrgency === 'warning',
              'bg-red-500/15 border-red-500/50 text-red-950 animate-glow-danger': journalUrgency === 'danger'
            }"
          >
            <div class="flex items-center gap-1.5 font-bold">
              <span class="material-symbols-outlined text-[17px]">
                {{ journalUrgency === 'danger' ? 'crisis_alert' : 'priority_high' }}
              </span>
              <span>{{ journalUrgency === 'danger' ? '🚨 BAHAYA: Wajib Isi Jurnal!' : '⚠️ Belum Isi Jurnal Harian' }}</span>
            </div>
            <p class="text-[11px] leading-tight" :class="journalUrgency === 'danger' ? 'text-red-800 font-semibold' : 'text-amber-800'">
              {{ journalUrgency === 'danger'
                ? `Sudah ${effectiveMinutesSinceTapOut} menit sejak check-out! Segera lengkapi agar presensi tidak gugur.`
                : 'Sesi pulang tercatat. Lengkapi catatan aktivitas magang hari ini.'
              }}
            </p>
            <button
              @click="activeMenu = 'logbook'"
              type="button"
              class="mt-1 py-2 px-3 rounded-lg text-white font-bold text-center text-[11px] transition-all flex items-center justify-center gap-1.5 apple-press cursor-pointer"
              :class="{
                'bg-amber-500 hover:bg-amber-600 shadow-xs': journalUrgency === 'warning',
                'bg-red-600 hover:bg-red-700 shadow-md animate-pulse-danger ring-2 ring-red-400 font-black': journalUrgency === 'danger'
              }"
            >
              <span class="material-symbols-outlined text-[15px]">
                {{ journalUrgency === 'danger' ? 'warning' : 'priority_high' }}
              </span>
              <span>{{ journalUrgency === 'danger' ? '⚠️ SEGERA ISI JURNAL (DARURAT) !' : 'Isi Jurnal Hari Ini !' }}</span>
            </button>
          </div>

          <div v-else class="text-center text-[11px] text-[#86868b] dark:text-[#a1a1a6]">
            {{ attendanceState.hasCheckedOut ? 'Presensi &amp; jurnal hari ini tuntas' : `Aktif otomatis pada ${targetJamPulang} WIB` }}
          </div>

          <button
            @click="isGeofenceModalOpen = true"
            class="w-full py-2 px-3 rounded-xl bg-white dark:bg-black/20 text-[#0071e3] hover:bg-black/[0.03] border border-black/[0.06] dark:border-white/[0.08] text-center text-[12px] font-semibold flex items-center justify-center gap-1.5 transition-all apple-press shadow-xs cursor-pointer"
            type="button"
          >
            <span class="material-symbols-outlined text-[16px]">pin_drop</span>
            <span>Lihat Radius Geofence</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Monthly Summary Apple Metric Cards (4 Grid) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <!-- Metric 1: Total Hari Kerja -->
      <div class="bg-white rounded-2xl p-4.5 shadow-[0_2px_12px_rgba(0,0,0,0.03)] border border-black/[0.05] hover:shadow-[0_4px_20px_rgba(0,0,0,0.06)] transition-all flex flex-col justify-between apple-press">
        <div class="flex items-center justify-between">
          <span class="text-[11px] uppercase tracking-wider text-[#86868b] font-semibold">Target Periode</span>
          <div class="w-8 h-8 rounded-xl bg-[#0071e3]/10 flex items-center justify-center text-[#0071e3]">
            <span class="material-symbols-outlined text-[18px]">calendar_month</span>
          </div>
        </div>
        <div class="my-2.5">
          <div class="text-2xl text-[#1d1d1f] font-bold">22 Hari</div>
          <div class="text-[12px] text-[#86868b] mt-0.5">Total hari kerja Oktober 2024</div>
        </div>
        <div class="flex items-center gap-1 text-[11px] text-[#0071e3] font-medium">
          <span class="material-symbols-outlined text-[15px]">info</span>
          <span>17 hari telah terselesaikan</span>
        </div>
      </div>

      <!-- Metric 2: Tepat Waktu -->
      <div class="bg-white rounded-2xl p-4.5 shadow-[0_2px_12px_rgba(0,0,0,0.03)] border border-black/[0.05] hover:shadow-[0_4px_20px_rgba(0,0,0,0.06)] transition-all flex flex-col justify-between apple-press">
        <div class="flex items-center justify-between">
          <span class="text-[11px] uppercase tracking-wider text-[#86868b] font-semibold">Tepat Waktu</span>
          <div class="w-8 h-8 rounded-xl bg-[#34c759]/10 flex items-center justify-center text-[#248a3d]">
            <span class="material-symbols-outlined text-[18px]">timer</span>
          </div>
        </div>
        <div class="my-2.5">
          <div class="text-2xl text-[#1d1d1f] font-bold">21 Hari</div>
          <div class="flex items-center gap-2 mt-0.5">
            <span class="inline-flex px-2 py-0.5 rounded-full bg-[#34c759]/10 text-[#248a3d] text-[11px] font-semibold">95.5% Rasio</span>
            <span class="text-[12px] text-[#86868b]">Sangat Bagus</span>
          </div>
        </div>
        <div class="w-full bg-[#f5f5f7] rounded-full h-1.5 overflow-hidden">
          <div class="bg-[#34c759] h-1.5 rounded-full" style="width: 95.5%;"></div>
        </div>
      </div>

      <!-- Metric 3: Terlambat -->
      <div class="bg-white rounded-2xl p-4.5 shadow-[0_2px_12px_rgba(0,0,0,0.03)] border border-black/[0.05] hover:shadow-[0_4px_20px_rgba(0,0,0,0.06)] transition-all flex flex-col justify-between apple-press">
        <div class="flex items-center justify-between">
          <span class="text-[11px] uppercase tracking-wider text-[#86868b] font-semibold">Terlambat</span>
          <div class="w-8 h-8 rounded-xl bg-black/[0.04] flex items-center justify-center text-[#86868b]">
            <span class="material-symbols-outlined text-[18px]">running_with_errors</span>
          </div>
        </div>
        <div class="my-2.5">
          <div class="text-2xl text-[#1d1d1f] font-bold">0 Hari</div>
          <div class="text-[12px] text-[#86868b] mt-0.5">0 Menit akumulasi penalti</div>
        </div>
        <div class="flex items-center gap-1 text-[11px] text-[#34c759] font-medium">
          <span class="material-symbols-outlined text-[15px]">check_circle</span>
          <span>Catatan kehadiran bersih</span>
        </div>
      </div>

      <!-- Metric 4: Izin & Sakit -->
      <div class="bg-white rounded-2xl p-4.5 shadow-[0_2px_12px_rgba(0,0,0,0.03)] border border-black/[0.05] hover:shadow-[0_4px_20px_rgba(0,0,0,0.06)] transition-all flex flex-col justify-between apple-press">
        <div class="flex items-center justify-between">
          <span class="text-[11px] uppercase tracking-wider text-[#86868b] font-semibold">Izin / Sakit</span>
          <div class="w-8 h-8 rounded-xl bg-[#5e5ce6]/10 flex items-center justify-center text-[#5e5ce6]">
            <span class="material-symbols-outlined text-[18px]">medical_services</span>
          </div>
        </div>
        <div class="my-2.5">
          <div class="text-2xl text-[#1d1d1f] font-bold">1 Hari</div>
          <div class="text-[12px] text-[#86868b] mt-0.5">18 Okt 2024 (Surat Dokter)</div>
        </div>
        <div class="flex items-center gap-1 text-[11px] text-[#5e5ce6] font-medium">
          <span class="material-symbols-outlined text-[15px]">task_alt</span>
          <span>Disetujui Pembimbing</span>
        </div>
      </div>
    </div>

    <!-- Main Content: Filters & Views -->
    <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant p-space-md flex flex-col gap-space-md">
      <!-- Toolbar -->
      <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-space-sm pb-space-sm border-b border-outline-variant/60">
        <!-- Left: Month Selector & Category Pills -->
        <div class="flex flex-wrap items-center gap-space-xs">
          <div class="flex items-center bg-surface-container-low rounded-lg p-1 border border-outline-variant/60">
            <button class="p-1 hover:bg-surface-container rounded text-on-surface-variant hover:text-on-surface transition-colors" title="Bulan Sebelumnya" type="button">
              <span class="material-symbols-outlined text-[18px]">chevron_left</span>
            </button>
            <div class="px-space-sm flex items-center gap-1 font-headline-sm text-body-sm font-semibold text-primary">
              <span class="material-symbols-outlined text-[16px] text-secondary">calendar_today</span>
              <span>Oktober 2024</span>
            </div>
            <button class="p-1 hover:bg-surface-container rounded text-on-surface-variant hover:text-on-surface transition-colors" title="Bulan Berikutnya" type="button">
              <span class="material-symbols-outlined text-[18px]">chevron_right</span>
            </button>
          </div>

          <div class="apple-segmented-container">
            <button
              @click="modeFilter = 'all'"
              :class="modeFilter === 'all' ? 'active' : ''"
              class="apple-segmented-item apple-press cursor-pointer"
              type="button"
            >
              Semua Jenis ({{ records.length }})
            </button>
            <button
              @click="modeFilter = 'wfo'"
              :class="modeFilter === 'wfo' ? 'active' : ''"
              class="apple-segmented-item apple-press cursor-pointer"
              type="button"
            >
              WFO (4)
            </button>
            <button
              @click="modeFilter = 'wfh'"
              :class="modeFilter === 'wfh' ? 'active' : ''"
              class="apple-segmented-item apple-press cursor-pointer"
              type="button"
            >
              WFH (1)
            </button>
          </div>
        </div>

        <!-- Right: View Toggle (Apple Segmented Control) -->
        <div class="flex items-center gap-2 self-end md:self-auto">
          <div class="apple-segmented-container">
            <button
              @click="viewType = 'table'"
              :class="viewType === 'table' ? 'active' : ''"
              class="apple-segmented-item flex items-center gap-1.5 apple-press cursor-pointer"
              type="button"
            >
              <span class="material-symbols-outlined text-[15px]">table_rows</span>
              <span>Tabel Rekap</span>
            </button>
            <button
              @click="viewType = 'calendar'"
              :class="viewType === 'calendar' ? 'active' : ''"
              class="apple-segmented-item flex items-center gap-1.5 apple-press cursor-pointer"
              type="button"
            >
              <span class="material-symbols-outlined text-[15px]">calendar_month</span>
              <span>Kalender Presensi</span>
            </button>
          </div>
        </div>
      </div>

      <!-- VIEW 1: TABEL REKAP (STITCH DESIGN) -->
      <div v-if="viewType === 'table'" class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse text-xs">
          <thead>
            <tr class="bg-surface-container-low text-on-surface-variant font-label-sm text-[11px] uppercase tracking-wider border-b border-outline-variant">
              <th class="py-space-sm px-space-md">Tanggal &amp; Sesi</th>
              <th class="py-space-sm px-space-md">Jam Masuk</th>
              <th class="py-space-sm px-space-md">Jam Pulang</th>
              <th class="py-space-sm px-space-md">Durasi</th>
              <th class="py-space-sm px-space-md">Lokasi &amp; Moda</th>
              <th class="py-space-sm px-space-md">Status Kehadiran</th>
              <th class="py-space-sm px-space-md">Validasi Mentor</th>
              <th class="py-space-sm px-space-md text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-outline-variant/60 font-body text-xs text-on-surface">
            <tr
              v-for="rec in filteredRecords"
              :key="rec.id"
              class="hover:bg-surface-container-low/50 transition-colors"
            >
              <!-- Tanggal -->
              <td class="py-3 px-space-md whitespace-nowrap">
                <div class="font-mono font-bold text-on-surface text-xs">{{ rec.date }}</div>
                <div class="text-[11px] text-on-surface-variant">{{ rec.day }}</div>
              </td>

              <!-- Jam Masuk -->
              <td class="py-3 px-space-md whitespace-nowrap">
                <span class="font-mono font-semibold text-primary">{{ rec.checkIn || '-' }}</span>
              </td>

              <!-- Jam Pulang -->
              <td class="py-3 px-space-md whitespace-nowrap">
                <span class="font-mono font-semibold" :class="rec.checkOut ? 'text-on-surface' : 'text-on-surface-variant italic'">
                  {{ rec.checkOut || 'Berjalan' }}
                </span>
              </td>

              <!-- Durasi -->
              <td class="py-3 px-space-md whitespace-nowrap">
                <span class="font-mono font-medium">{{ rec.duration }}</span>
              </td>

              <!-- Lokasi & Moda -->
              <td class="py-3 px-space-md whitespace-nowrap">
                <div class="font-medium text-xs">{{ rec.location }}</div>
                <div class="text-[10px] text-on-surface-variant">{{ rec.mode }}</div>
              </td>

              <!-- Status Kehadiran -->
              <td class="py-3 px-space-md whitespace-nowrap">
                <span
                  class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full font-label-sm text-label-sm font-semibold border"
                  :class="{
                    'bg-emerald-50 text-emerald-800 border-emerald-200': rec.status === 'ontime',
                    'bg-amber-50 text-amber-800 border-amber-200': rec.status === 'late',
                    'bg-sky-50 text-sky-800 border-sky-200': rec.status === 'sick'
                  }"
                >
                  <span
                    class="w-1.5 h-1.5 rounded-full"
                    :class="{
                      'bg-emerald-600': rec.status === 'ontime',
                      'bg-amber-600': rec.status === 'late',
                      'bg-sky-600': rec.status === 'sick'
                    }"
                  ></span>
                  {{ rec.statusLabel }}
                </span>
              </td>

              <!-- Validasi Mentor -->
              <td class="py-3 px-space-md whitespace-nowrap">
                <div class="flex items-center gap-1.5 text-secondary">
                  <span class="material-symbols-outlined text-[16px]">verified</span>
                  <span class="font-medium text-[11px]">{{ rec.validation }}</span>
                </div>
              </td>

              <!-- Aksi -->
              <td class="py-3 px-space-md text-right whitespace-nowrap">
                <button
                  @click="viewDetail(rec)"
                  class="text-[11px] px-2.5 py-1 rounded bg-surface-container text-primary font-bold hover:bg-surface-container-high transition-colors border border-outline-variant"
                  type="button"
                >
                  Detail
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- VIEW 2: KALENDER PRESENSI -->
      <div v-else class="p-space-lg flex flex-col gap-space-md">
        <div class="grid grid-cols-7 gap-2 text-center">
          <div v-for="d in ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']" :key="d" class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-bold pb-2">
            {{ d }}
          </div>
          <!-- Sample days for October 2024 -->
          <div
            v-for="day in calendarDays"
            :key="day.dayNumber"
            class="h-20 p-2 rounded-xl border border-outline-variant/60 flex flex-col justify-between text-left transition-colors"
            :class="day.isToday ? 'bg-surface-container-low border-primary' : 'bg-surface-container-lowest hover:bg-surface-container-low/50'"
          >
            <div class="flex items-center justify-between">
              <span class="font-mono text-xs font-bold" :class="day.isToday ? 'text-primary' : 'text-on-surface'">
                {{ day.dayNumber }}
              </span>
              <span v-if="day.isToday" class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
            </div>
            <div v-if="day.status" class="flex flex-col">
              <span
                class="text-[10px] px-1 py-0.5 rounded font-semibold truncate"
                :class="day.status === 'Hadir' ? 'bg-emerald-50 text-emerald-700' : 'bg-sky-50 text-sky-700'"
              >
                {{ day.status }}
              </span>
              <span class="font-mono text-[9px] text-on-surface-variant mt-0.5">{{ day.time }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- MODAL: AJUKAN IZIN / SAKIT -->
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
          v-if="isIzinModalOpen"
          class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm select-none"
          @click.self="isIzinModalOpen = false"
        >
          <div class="modal-card-animate bg-surface-container-lowest rounded-2xl max-w-lg w-full p-6 shadow-xl border border-outline-variant flex flex-col gap-4 select-auto">
            <div class="flex items-center justify-between pb-3 border-b border-outline-variant/60">
              <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[22px] text-secondary">medical_services</span>
                <h3 class="font-headline-sm text-headline-sm text-primary font-bold">Form Pengajuan Izin / Sakit</h3>
              </div>
              <button @click="isIzinModalOpen = false" class="text-on-surface-variant hover:text-on-surface p-1 cursor-pointer">
                <span class="material-symbols-outlined text-[20px]">close</span>
              </button>
            </div>

            <form @submit.prevent="submitIzin" class="flex flex-col gap-4">
              <div class="flex flex-col gap-1.5">
                <label class="font-label-md text-label-md text-primary font-semibold">Jenis Pengajuan</label>
                <select v-model="izinForm.type" class="w-full px-3.5 py-2.5 bg-surface-container-low text-on-surface text-body-sm font-body-sm rounded-lg border border-outline-variant/60 outline-none">
                  <option value="sakit">Sakit (Dengan Surat Keterangan Dokter)</option>
                  <option value="izin">Izin Kepentingan Akademik / Khusus</option>
                </select>
              </div>

              <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1.5">
                  <label class="font-label-md text-label-md text-primary font-semibold">Tanggal Mulai</label>
                  <input v-model="izinForm.startDate" type="date" class="w-full px-3.5 py-2.5 bg-surface-container-low text-on-surface text-body-sm font-body-sm rounded-lg border border-outline-variant/60 outline-none" required />
                </div>
                <div class="flex flex-col gap-1.5">
                  <label class="font-label-md text-label-md text-primary font-semibold">Tanggal Selesai</label>
                  <input v-model="izinForm.endDate" type="date" class="w-full px-3.5 py-2.5 bg-surface-container-low text-on-surface text-body-sm font-body-sm rounded-lg border border-outline-variant/60 outline-none" required />
                </div>
              </div>

              <div class="flex flex-col gap-1.5">
                <label class="font-label-md text-label-md text-primary font-semibold">Keterangan / Alasan Lengkap</label>
                <textarea v-model="izinForm.reason" rows="3" class="w-full px-3.5 py-2.5 bg-surface-container-low text-on-surface text-body-sm font-body-sm rounded-lg border border-outline-variant/60 outline-none" placeholder="Uraikan kondisi sakit atau alasan perizinan..." required></textarea>
              </div>

              <div class="flex flex-col gap-1.5">
                <label class="font-label-md text-label-md text-primary font-semibold">Upload Berkas Pendukung (Surat Dokter / Dokumen)</label>
                <input type="file" class="w-full text-xs text-on-surface-variant file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border file:border-outline-variant file:text-xs file:font-semibold file:bg-surface-container-lowest file:text-primary hover:file:bg-surface-container" />
              </div>

              <div class="flex items-center justify-end gap-2 pt-3 border-t border-outline-variant/60">
                <button @click="isIzinModalOpen = false" type="button" class="px-4 py-2 rounded-lg bg-surface-container-low text-on-surface-variant text-body-sm font-body-sm font-semibold hover:bg-surface-container cursor-pointer">
                  Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-on-primary text-body-sm font-body-sm font-semibold hover:bg-primary-container shadow-sm cursor-pointer">
                  Kirim Pengajuan
                </button>
              </div>
            </form>
          </div>
        </div>
      </Transition>
    </Teleport>

    <!-- MODAL: RADIUS GEOFENCE -->
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
          v-if="isGeofenceModalOpen"
          class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm select-none"
          @click.self="isGeofenceModalOpen = false"
        >
          <div class="modal-card-animate bg-surface-container-lowest rounded-2xl max-w-md w-full p-6 shadow-xl border border-outline-variant flex flex-col gap-4 select-auto">
            <div class="flex items-center justify-between pb-3 border-b border-outline-variant/60">
              <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[22px] text-secondary">pin_drop</span>
                <h3 class="font-headline-sm text-headline-sm text-primary font-bold">Radius Geofence Kantor</h3>
              </div>
              <button @click="isGeofenceModalOpen = false" class="text-on-surface-variant hover:text-on-surface p-1 cursor-pointer">
                <span class="material-symbols-outlined text-[20px]">close</span>
              </button>
            </div>

            <div class="flex flex-col gap-3">
              <div class="h-40 bg-surface-container-low rounded-xl border border-outline-variant flex items-center justify-center relative overflow-hidden">
                <div class="w-24 h-24 rounded-full border-2 border-secondary bg-secondary/10 flex items-center justify-center animate-pulse">
                  <span class="material-symbols-outlined text-[28px] text-primary">domain</span>
                </div>
                <div class="absolute bottom-2 right-2 px-2 py-0.5 rounded bg-surface-container-lowest text-[10px] font-mono text-on-surface-variant border border-outline-variant">
                  Radius: 50 Meter
                </div>
              </div>

              <div class="p-3 rounded-lg bg-surface-container-low border border-outline-variant/60 flex flex-col gap-1 text-xs">
                <div class="flex justify-between">
                  <span class="text-on-surface-variant">Lokasi Kantor:</span>
                  <span class="font-semibold text-primary">PT Solusi Digital Pratama</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-on-surface-variant">Koordinat Titik:</span>
                  <span class="font-mono text-on-surface">-6.2088° S, 106.8456° E</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-on-surface-variant">Jarak Posisi Anda:</span>
                  <span class="font-semibold text-emerald-700">12 meter (Di dalam radius)</span>
                </div>
              </div>
            </div>

            <div class="flex justify-end pt-2">
              <button @click="isGeofenceModalOpen = false" class="px-4 py-2 rounded-lg bg-primary text-on-primary text-body-sm font-semibold cursor-pointer">
                Tutup
              </button>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useAppStore } from '~/composables/useAppStore'

const {
  activeMenu,
  showToast,
  attendanceState,
  isTodayLogged,
  journalUrgency,
  effectiveMinutesSinceTapOut,
  recordCheckOut,
  authToken
} = useAppStore()

const currentTime = ref('09:14:02')
const modeFilter = ref('all')
const viewType = ref<'table' | 'calendar'>('table')

const isIzinModalOpen = ref(false)
const isGeofenceModalOpen = ref(false)

const izinForm = ref({
  type: 'sakit',
  startDate: '',
  endDate: '',
  reason: ''
})

const targetJamPulang = ref('16:00')
const targetJamMasuk = ref('07:30')
const isHolidayToday = ref(false)
const holidayNameToday = ref('')

const effectiveCheckInTime = computed(() => {
  return attendanceState.checkInTime || '08:24'
})

const currentWorkModeLabel = computed(() => {
  if (attendanceState.workMode === 'wfh') return 'WFH Mandiri'
  if (attendanceState.workMode === 'wfa') return 'WFA Fleksibel'
  return 'WFO Kantor Pusat'
})

const currentLocationLabel = computed(() => 'Tech Hub Lt. 4')

const currentSessionName = computed(() => {
  try {
    const hour = parseInt(currentTime.value.split(':')[0], 10)
    if (hour < 11) return 'Sesi Pagi'
    if (hour < 15) return 'Sesi Siang'
    return 'Sesi Sore'
  } catch (e) {
    return 'Sesi Siang'
  }
})

const currentDurationElapsed = computed(() => {
  if (attendanceState.hasCheckedOut && attendanceState.checkOutTime) {
    const [inH, inM] = effectiveCheckInTime.value.split(':').map(Number)
    const [outH, outM] = attendanceState.checkOutTime.split(':').map(Number)
    const diffMin = Math.max(0, (outH * 60 + outM) - (inH * 60 + inM))
    const h = Math.floor(diffMin / 60)
    const m = diffMin % 60
    return `${h} Jam${m > 0 ? ` ${m} Mnt` : ''}`
  }
  try {
    const [inH, inM] = effectiveCheckInTime.value.split(':').map(Number)
    const [nowH, nowM] = currentTime.value.split(':').map(Number)
    const diffMin = (nowH * 60 + nowM) - (inH * 60 + inM)
    if (diffMin <= 0 || isNaN(diffMin)) {
      return '5.5 Jam'
    }
    const h = Math.floor(diffMin / 60)
    const m = diffMin % 60
    return `${h} Jam${m > 0 ? ` ${m} Mnt` : ''}`
  } catch (e) {
    return '5.5 Jam'
  }
})

const workdayProgressPercent = computed(() => {
  if (attendanceState.hasCheckedOut) return 100
  try {
    const [inH, inM] = effectiveCheckInTime.value.split(':').map(Number)
    const [targetH, targetM] = targetJamPulang.value.split(':').map(Number)
    const [nowH, nowM] = currentTime.value.split(':').map(Number)
    const totalTargetMin = (targetH * 60 + targetM) - (inH * 60 + inM)
    const elapsedMin = (nowH * 60 + nowM) - (inH * 60 + inM)
    if (totalTargetMin <= 0) return 65
    if (elapsedMin <= 0) return 25
    return Math.min(100, Math.max(15, Math.round((elapsedMin / totalTargetMin) * 100)))
  } catch (e) {
    return 65
  }
})

let timer: any = null

const fetchScheduleInfo = async () => {
  try {
    const res = await fetch('http://127.0.0.1:8000/api/siswa/dashboard', {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${authToken.value}`
      }
    })
    if (res.ok) {
      const data = await res.json()
      if (data.scheduled_check_out_time) {
        targetJamPulang.value = data.scheduled_check_out_time
      }
      if (data.scheduled_check_in_time) {
        targetJamMasuk.value = data.scheduled_check_in_time
      }
      if (typeof data.is_today_holiday === 'boolean') {
        isHolidayToday.value = data.is_today_holiday
      }
      if (data.holiday_reason) {
        holidayNameToday.value = data.holiday_reason
      }
    }
  } catch (err) {
    // fallback default
  }
}

onMounted(() => {
  const updateClock = () => {
    const now = new Date()
    currentTime.value = now.toTimeString().split(' ')[0]
  }
  updateClock()
  timer = setInterval(updateClock, 1000)
  fetchScheduleInfo()
})

onUnmounted(() => {
  if (timer) clearInterval(timer)
})

const records = ref([
  {
    id: 1,
    date: '23 Okt 2024',
    day: 'Rabu',
    checkIn: '08:24',
    checkOut: '',
    duration: '5.5 Jam',
    location: 'Tech Hub Lt. 4',
    mode: 'WFO Kantor Pusat',
    status: 'ontime',
    statusLabel: 'Hadir Tepat Waktu',
    validation: 'Menunggu Checkout'
  },
  {
    id: 2,
    date: '22 Okt 2024',
    day: 'Selasa',
    checkIn: '08:28',
    checkOut: '17:32',
    duration: '8 Jam',
    location: 'Tech Hub Lt. 4',
    mode: 'WFO Kantor Pusat',
    status: 'ontime',
    statusLabel: 'Hadir Tepat Waktu',
    validation: 'Disetujui Mentor'
  },
  {
    id: 3,
    date: '21 Okt 2024',
    day: 'Senin',
    checkIn: '08:35',
    checkOut: '17:40',
    duration: '8 Jam',
    location: 'Tech Hub Lt. 4',
    mode: 'WFO Kantor Pusat',
    status: 'ontime',
    statusLabel: 'Hadir Tepat Waktu',
    validation: 'Disetujui Mentor'
  },
  {
    id: 4,
    date: '18 Okt 2024',
    day: 'Jumat',
    checkIn: '',
    checkOut: '',
    duration: '-',
    location: 'Klinik Pratama',
    mode: 'Surat Keterangan Dokter',
    status: 'sick',
    statusLabel: 'Izin Sakit',
    validation: 'Disetujui Mentor'
  },
  {
    id: 5,
    date: '17 Okt 2024',
    day: 'Kamis',
    checkIn: '08:40',
    checkOut: '17:35',
    duration: '8 Jam',
    location: 'Rumah (Remote)',
    mode: 'WFH Mandiri',
    status: 'ontime',
    statusLabel: 'Hadir Tepat Waktu',
    validation: 'Disetujui Mentor'
  }
])

const filteredRecords = computed(() => {
  if (modeFilter.value === 'wfo') {
    return records.value.filter(r => r.mode.includes('WFO'))
  }
  if (modeFilter.value === 'wfh') {
    return records.value.filter(r => r.mode.includes('WFH'))
  }
  return records.value
})

const calendarDays = [
  { dayNumber: 14, status: 'Hadir', time: '08:25 - 17:30' },
  { dayNumber: 15, status: 'Hadir', time: '08:20 - 17:30' },
  { dayNumber: 16, status: 'Hadir', time: '08:30 - 17:30' },
  { dayNumber: 17, status: 'Hadir', time: '08:40 - 17:35' },
  { dayNumber: 18, status: 'Sakit', time: 'Surat Dokter' },
  { dayNumber: 19, status: '', time: '' },
  { dayNumber: 20, status: '', time: '' },
  { dayNumber: 21, status: 'Hadir', time: '08:35 - 17:40' },
  { dayNumber: 22, status: 'Hadir', time: '08:28 - 17:32' },
  { dayNumber: 23, status: 'Hadir', time: '08:24 - Aktif', isToday: true }
]

const handleCheckOut = () => {
  recordCheckOut(currentTime.value.substring(0, 5))
  const first = records.value[0]
  if (first) {
    first.checkOut = currentTime.value.substring(0, 5)
    first.validation = 'Disetujui Mentor'
  }
}

const submitIzin = () => {
  isIzinModalOpen.value = false
  showToast('Pengajuan izin/sakit berhasil dikirim ke Pembimbing & Guru!', 'success')
}

const downloadRekapPdf = () => {
  showToast('Mengunduh Lembar Rekapitulasi Presensi Kehadiran SMKN 71...', 'success')
}

const viewDetail = (rec: typeof records.value[0]) => {
  showToast(`Detail presensi ${rec.date}: ${rec.statusLabel} (${rec.mode})`, 'info')
}
</script>
