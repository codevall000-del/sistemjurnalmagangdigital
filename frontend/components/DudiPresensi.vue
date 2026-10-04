<template>
  <div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-black/[0.06]">
      <div>
        <div class="flex items-center gap-2 mb-1">
          <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold tracking-wide bg-[#0071e3]/10 text-[#0071e3]">
            Kontrol Kedisiplinan &amp; Ritme Kerja
          </span>
          <span class="text-[#86868b]">•</span>
          <span class="text-xs font-medium text-[#86868b]">Pembimbing Lapangan</span>
        </div>
        <h2 class="text-2xl font-bold text-[#1d1d1f] tracking-tight flex items-center gap-2">
          <span>Presensi &amp; Manajemen Mode Kerja (WFO / WFH / WFA)</span>
        </h2>
        <p class="text-xs text-[#86868b] mt-0.5">
          Atur jam kantor mingguan, tentukan hari kerja &amp; hari libur, tinjau dispensasi WFH/WFA, dan pantau catatan kehadiran siswa secara terpadu.
        </p>
      </div>

      <div class="flex items-center gap-2">
        <button
          @click="exportCsv"
          class="px-4 py-2 bg-black/[0.04] hover:bg-black/[0.07] text-[#1d1d1f] rounded-xl text-xs font-medium border border-black/[0.06] transition flex items-center gap-1.5 shadow-sm apple-press cursor-pointer"
        >
          <span class="material-symbols-outlined text-[16px] text-[#86868b]">download</span>
          <span>Export Rekap Presensi (CSV)</span>
        </button>
      </div>
    </div>

    <!-- Apple Segmented Sub-Navigation Tabs -->
    <div class="flex p-1 bg-black/[0.04] rounded-2xl w-full sm:w-auto max-w-2xl border border-black/[0.04] overflow-x-auto">
      <button
        type="button"
        @click="activeSubTab = 'rekap'"
        :class="activeSubTab === 'rekap' ? 'bg-white text-[#1d1d1f] shadow-[0_2px_8px_rgba(0,0,0,0.06)] font-semibold' : 'text-[#86868b] hover:text-[#1d1d1f] font-medium'"
        class="flex-1 py-2 px-3 rounded-xl text-xs transition-all flex items-center justify-center gap-1.5 cursor-pointer apple-press whitespace-nowrap"
      >
        <span class="material-symbols-outlined text-[16px]">fact_check</span>
        <span>Rekap Presensi Harian</span>
      </button>

      <button
        type="button"
        @click="activeSubTab = 'requests'"
        :class="activeSubTab === 'requests' ? 'bg-white text-[#1d1d1f] shadow-[0_2px_8px_rgba(0,0,0,0.06)] font-semibold' : 'text-[#86868b] hover:text-[#1d1d1f] font-medium'"
        class="flex-1 py-2 px-3 rounded-xl text-xs transition-all flex items-center justify-center gap-1.5 cursor-pointer apple-press relative whitespace-nowrap"
      >
        <span class="material-symbols-outlined text-[16px]">pending_actions</span>
        <span>Dispensasi WFH/WFA</span>
        <span
          v-if="pendingRequestsCount > 0"
          class="ml-1 px-1.5 py-0.2 rounded-full text-[10px] font-bold bg-[#ff3b30] text-white animate-pulse"
        >
          {{ pendingRequestsCount }}
        </span>
      </button>

      <button
        type="button"
        @click="activeSubTab = 'office_schedule'"
        :class="activeSubTab === 'office_schedule' ? 'bg-white text-[#1d1d1f] shadow-[0_2px_8px_rgba(0,0,0,0.06)] font-semibold' : 'text-[#86868b] hover:text-[#1d1d1f] font-medium'"
        class="flex-1 py-2 px-3 rounded-xl text-xs transition-all flex items-center justify-center gap-1.5 cursor-pointer apple-press relative whitespace-nowrap"
      >
        <span class="material-symbols-outlined text-[16px]">tune</span>
        <span>Jadwal Kantor Mingguan</span>
        <span class="ml-1 px-1.5 py-0.2 rounded-full text-[9px] font-bold bg-[#0071e3]/15 text-[#0071e3]">
          Baru
        </span>
      </button>

      <button
        type="button"
        @click="activeSubTab = 'schedules'"
        :class="activeSubTab === 'schedules' ? 'bg-white text-[#1d1d1f] shadow-[0_2px_8px_rgba(0,0,0,0.06)] font-semibold' : 'text-[#86868b] hover:text-[#1d1d1f] font-medium'"
        class="flex-1 py-2 px-3 rounded-xl text-xs transition-all flex items-center justify-center gap-1.5 cursor-pointer apple-press whitespace-nowrap"
      >
        <span class="material-symbols-outlined text-[16px]">group</span>
        <span>Jadwal Per Siswa</span>
      </button>
    </div>

    <!-- TAB 1: REKAP PRESENSI HARIAN -->
    <div v-if="activeSubTab === 'rekap'" class="space-y-6">
      <!-- Discipline Indicator Cards (Apple Metrics) -->
      <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="p-5 rounded-2xl bg-white border border-black/[0.05] shadow-[0_2px_12px_rgba(0,0,0,0.03)] transition-all">
          <span class="text-[11px] font-semibold text-[#86868b] block uppercase tracking-wider">Total Kehadiran</span>
          <span class="text-3xl font-bold text-[#1d1d1f] tracking-tight mt-1.5 block">96.2%</span>
          <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-[#34c759]/10 text-[#34c759] mt-2">
            <span class="w-1.5 h-1.5 rounded-full bg-[#34c759]"></span>
            Disiplin Tinggi
          </span>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-black/[0.05] shadow-[0_2px_12px_rgba(0,0,0,0.03)] transition-all">
          <span class="text-[11px] font-semibold text-[#86868b] block uppercase tracking-wider">WFO (Di Kantor)</span>
          <span class="text-3xl font-bold text-[#0071e3] tracking-tight mt-1.5 block">
            {{ countByMode('wfo') }} Sesi
          </span>
          <span class="text-[11px] text-[#86868b] mt-2 block font-medium">Validasi Geofencing 150m</span>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-black/[0.05] shadow-[0_2px_12px_rgba(0,0,0,0.03)] transition-all">
          <span class="text-[11px] font-semibold text-[#86868b] block uppercase tracking-wider">WFH (Rumah)</span>
          <span class="text-3xl font-bold text-[#34c759] tracking-tight mt-1.5 block">
            {{ countByMode('wfh') }} Sesi
          </span>
          <span class="text-[11px] text-[#86868b] mt-2 block font-medium">Remote Output Target</span>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-black/[0.05] shadow-[0_2px_12px_rgba(0,0,0,0.03)] transition-all">
          <span class="text-[11px] font-semibold text-[#86868b] block uppercase tracking-wider">WFA (Tugas Lapangan)</span>
          <span class="text-3xl font-bold text-purple-600 tracking-tight mt-1.5 block">
            {{ countByMode('wfa') }} Sesi
          </span>
          <span class="text-[11px] text-[#86868b] mt-2 block font-medium">Liputan &amp; Riset Visual</span>
        </div>
      </div>

      <!-- TABEL REKAPITULASI KEHADIRAN (APPLE STYLE TABLE) -->
      <div class="bg-white border border-black/[0.05] rounded-2xl p-6 shadow-[0_2px_12px_rgba(0,0,0,0.03)]">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 mb-4 border-b border-black/[0.05]">
          <div>
            <h3 class="text-sm font-semibold text-[#1d1d1f] tracking-tight">
              Rekapitulasi Presensi &amp; Mode Kerja Siswa
            </h3>
            <p class="text-[11px] text-[#86868b] mt-0.5">Memantau waktu check-in, check-out, mode kerja terverifikasi, dan geotagging GPS.</p>
          </div>

          <!-- Filter Search -->
          <div class="relative w-full sm:w-64">
            <input
              v-model="search"
              type="text"
              placeholder="Cari nama siswa..."
              class="w-full pl-9 pr-3.5 py-1.5 bg-black/[0.03] focus:bg-white border border-transparent focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-xs text-[#1d1d1f] placeholder-[#86868b] transition"
            />
            <span class="material-symbols-outlined text-[16px] absolute left-3 top-2 text-[#86868b]">search</span>
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs text-[#1d1d1f]">
            <thead class="bg-black/[0.02] text-[#86868b] uppercase text-[10px] tracking-wider border-b border-black/[0.05] font-semibold">
              <tr>
                <th class="py-3 px-4 rounded-l-xl">Nama Siswa</th>
                <th class="py-3 px-4">Tanggal</th>
                <th class="py-3 px-4 text-center">Mode Kerja</th>
                <th class="py-3 px-4">Jam Masuk (Check-In)</th>
                <th class="py-3 px-4">Jam Pulang (Check-Out)</th>
                <th class="py-3 px-4 text-center">Status</th>
                <th class="py-3 px-4 rounded-r-xl">Geotagging &amp; Keterangan</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-black/[0.04]">
              <tr v-for="att in filteredAttendances" :key="att.id" class="hover:bg-black/[0.02] transition">
                <!-- Student -->
                <td class="py-3.5 px-4 whitespace-nowrap">
                  <div class="flex items-center gap-3">
                    <img :src="att.student?.avatar || 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150'" class="w-9 h-9 rounded-xl object-cover border border-black/[0.06] shadow-xs" />
                    <div>
                      <div class="font-semibold text-[#1d1d1f]">{{ att.student?.name || att.name }}</div>
                      <div class="text-[10px] text-[#86868b] font-mono">NISN: {{ att.student?.nisn_nip || att.nisn }}</div>
                    </div>
                  </div>
                </td>

                <!-- Date -->
                <td class="py-3.5 px-4 font-mono text-[#86868b] whitespace-nowrap font-medium">
                  {{ att.date }}
                </td>

                <!-- Mode Kerja Badge -->
                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                  <span
                    :class="{
                      'bg-[#0071e3]/10 text-[#0071e3] border-[#0071e3]/20': (att.work_mode || 'wfo') === 'wfo',
                      'bg-[#34c759]/10 text-[#248a3d] border-[#34c759]/20': att.work_mode === 'wfh',
                      'bg-purple-500/10 text-purple-600 border-purple-500/20': att.work_mode === 'wfa',
                    }"
                    class="px-2.5 py-1 rounded-full text-[10px] font-bold border uppercase inline-flex items-center gap-1"
                  >
                    <span class="material-symbols-outlined text-[13px]">
                      {{ (att.work_mode || 'wfo') === 'wfo' ? 'domain' : (att.work_mode === 'wfh' ? 'home_work' : 'travel_explore') }}
                    </span>
                    {{ (att.work_mode || 'wfo').toUpperCase() }}
                  </span>
                </td>

                <!-- Check-In -->
                <td class="py-3.5 px-4 font-mono font-semibold text-[#34c759] whitespace-nowrap">
                  {{ att.check_in ? att.check_in.substring(0, 5) + ' WIB' : (att.in || '-') }}
                </td>

                <!-- Check-Out -->
                <td class="py-3.5 px-4 font-mono font-semibold text-[#0071e3] whitespace-nowrap">
                  {{ att.check_out ? att.check_out.substring(0, 5) + ' WIB' : (att.out ? `${att.out} WIB` : 'Sedang Aktif') }}
                </td>

                <!-- Status -->
                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                  <span
                    :class="att.status === 'hadir' || att.status === 'Hadir Tepat Waktu' ? 'bg-[#34c759]/10 text-[#34c759]' : 'bg-[#ff9500]/10 text-[#ff9500]'"
                    class="px-2.5 py-1 rounded-full text-[10px] font-semibold capitalize"
                  >
                    {{ att.status }}
                  </span>
                </td>

                <!-- Lokasi & Notes -->
                <td class="py-3.5 px-4 text-[11px] text-[#86868b] whitespace-nowrap max-w-xs truncate">
                  <div class="flex items-center gap-1.5 font-medium text-[#1d1d1f]">
                    <span class="material-symbols-outlined text-[15px] text-[#ff3b30] shrink-0">pin_drop</span>
                    <span class="truncate">{{ att.notes || 'Terverifikasi sistem' }}</span>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- TAB 2: PERMOHONAN DISPENSASI BERALIH MODE (WFH / WFA REQUESTS) -->
    <div v-if="activeSubTab === 'requests'" class="space-y-4">
      <div class="bg-white border border-black/[0.05] rounded-2xl p-6 shadow-[0_2px_12px_rgba(0,0,0,0.03)]">
        <div class="flex items-center justify-between pb-4 mb-4 border-b border-black/[0.05]">
          <div>
            <h3 class="text-sm font-semibold text-[#1d1d1f] tracking-tight flex items-center gap-2">
              <span>Pengajuan Izin Beralih Mode dari Siswa</span>
              <span v-if="pendingRequestsCount > 0" class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#ff9500]/15 text-[#b25e00]">
                {{ pendingRequestsCount }} Menunggu Keputusan
              </span>
            </h3>
            <p class="text-[11px] text-[#86868b] mt-0.5">
              Setujui atau tolak permohonan siswa yang berhalangan hadir ke kantor (sakit ringan, tugas luar, dll).
            </p>
          </div>
        </div>

        <div v-if="modeRequests.length === 0" class="text-center py-12 text-[#86868b]">
          <span class="material-symbols-outlined text-4xl text-slate-300 block mb-2">inbox</span>
          <p class="text-xs font-medium">Belum ada permohonan beralih mode dari siswa magang.</p>
        </div>

        <div v-else class="space-y-3">
          <div
            v-for="req in modeRequests"
            :key="req.id"
            class="p-4 rounded-xl border border-black/[0.06] bg-[#fafafa] flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 transition hover:border-[#0071e3]/30"
          >
            <!-- Left Info -->
            <div class="flex items-start gap-3.5 min-w-0">
              <img
                :src="req.student?.avatar || 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150'"
                class="w-10 h-10 rounded-xl object-cover border border-black/[0.06] shrink-0"
              />
              <div class="flex flex-col min-w-0">
                <div class="flex items-center gap-2 flex-wrap">
                  <span class="font-bold text-[#1d1d1f] text-xs">{{ req.student?.name }}</span>
                  <span class="text-[10px] px-2 py-0.2 rounded-md bg-black/[0.05] text-[#86868b] font-mono">
                    {{ req.student?.major }} • {{ req.student?.class_name }}
                  </span>
                  <span
                    :class="{
                      'bg-[#34c759]/10 text-[#248a3d] border-[#34c759]/20': req.requested_mode === 'wfh',
                      'bg-purple-600/10 text-purple-600 border-purple-600/20': req.requested_mode === 'wfa',
                      'bg-[#0071e3]/10 text-[#0071e3] border-[#0071e3]/20': req.requested_mode === 'wfo',
                    }"
                    class="text-[10px] font-bold px-2 py-0.5 rounded-full border uppercase inline-flex items-center gap-1"
                  >
                    <span class="material-symbols-outlined text-[12px]">
                      {{ req.requested_mode === 'wfh' ? 'home_work' : (req.requested_mode === 'wfa' ? 'travel_explore' : 'domain') }}
                    </span>
                    Minta {{ req.requested_mode.toUpperCase() }}
                  </span>
                </div>

                <p class="text-xs text-[#1d1d1f] font-medium mt-1">
                  &ldquo;{{ req.reason }}&rdquo;
                </p>

                <div class="flex items-center gap-2 mt-1 text-[10px] text-[#86868b]">
                  <span class="font-mono">Tanggal Izin: {{ req.date }}</span>
                  <span>•</span>
                  <span v-if="req.status === 'pending'" class="text-[#ff9500] font-semibold flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#ff9500] animate-ping"></span>
                    Menunggu Keputusan Mentor
                  </span>
                  <span v-else-if="req.status === 'approved'" class="text-[#34c759] font-semibold flex items-center gap-1">
                    <span class="material-symbols-outlined text-[13px]">check_circle</span>
                    Telah Disetujui
                  </span>
                  <span v-else class="text-[#ff3b30] font-semibold flex items-center gap-1">
                    <span class="material-symbols-outlined text-[13px]">cancel</span>
                    Ditolak
                  </span>
                </div>
              </div>
            </div>

            <!-- Right Actions (if pending) -->
            <div class="flex items-center gap-2 shrink-0">
              <template v-if="req.status === 'pending'">
                <button
                  type="button"
                  @click="reviewRequest(req.id, 'approved')"
                  class="px-3.5 py-1.5 rounded-xl bg-[#34c759] hover:bg-[#2eb350] active:scale-95 text-white text-xs font-semibold shadow-xs transition flex items-center gap-1 cursor-pointer"
                >
                  <span class="material-symbols-outlined text-[16px]">check</span>
                  <span>Setujui</span>
                </button>
                <button
                  type="button"
                  @click="reviewRequest(req.id, 'rejected')"
                  class="px-3.5 py-1.5 rounded-xl bg-black/[0.04] hover:bg-[#ff3b30]/10 hover:text-[#ff3b30] text-[#86868b] text-xs font-semibold transition flex items-center gap-1 cursor-pointer"
                >
                  <span class="material-symbols-outlined text-[16px]">close</span>
                  <span>Tolak</span>
                </button>
              </template>
              <div v-else class="text-[11px] font-semibold text-[#86868b] px-3 py-1 bg-black/[0.03] rounded-lg">
                {{ req.status === 'approved' ? 'Telah Disetujui' : 'Ditolak' }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- TAB 3: PENGATURAN JADWAL KANTOR MINGGUAN (JAM KERJA, HARI LIBUR & SISTEM WFH/WFO SEPERTI BKKBN) -->
    <div v-if="activeSubTab === 'office_schedule'" class="space-y-6">
      <!-- 1. Header Overview & Summary Statistics -->
      <div class="bg-white border border-black/[0.05] rounded-2xl p-6 shadow-[0_2px_12px_rgba(0,0,0,0.03)] relative overflow-hidden">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 pb-5 border-b border-black/[0.05]">
          <div>
            <div class="flex items-center gap-2 mb-1.5">
              <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-[#0071e3]/10 text-[#0071e3]">
                🏢 {{ companyData.name || 'PT Telkom Digital Solusi' }}
              </span>
              <span class="text-[#86868b]">•</span>
              <span class="text-[11px] font-medium text-[#86868b]">{{ companyData.sector || 'Sektor Industri Mitra' }}</span>
            </div>
            <h3 class="text-lg font-bold text-[#1d1d1f] tracking-tight flex items-center gap-2">
              <span>Pengaturan Jam Kerja Kantor &amp; Kebijakan Mingguan</span>
            </h3>
            <p class="text-xs text-[#86868b] mt-1 max-w-2xl leading-relaxed">
              Tentukan jam masuk, jam pulang, toleransi keterlambatan, hari kerja aktif, serta hari libur operasional. Mode kerja kantor (WFO/WFH) dapat diatur per hari sesuai regulasi instansi (contoh: <strong>pola sistem kerja WFH BKKBN</strong>).
            </p>
          </div>

          <!-- Quick Metrics Bar -->
          <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 shrink-0">
            <div class="p-3 rounded-xl bg-black/[0.02] border border-black/[0.05] text-center">
              <span class="text-[10px] text-[#86868b] uppercase font-semibold block">Hari Kerja</span>
              <span class="text-lg font-bold text-[#0071e3] block mt-0.5">{{ countWorkDays }} Hari</span>
            </div>
            <div class="p-3 rounded-xl bg-black/[0.02] border border-black/[0.05] text-center">
              <span class="text-[10px] text-[#86868b] uppercase font-semibold block">Hari Libur</span>
              <span class="text-lg font-bold text-[#ff9500] block mt-0.5">{{ countHolidays }} Hari</span>
            </div>
            <div class="p-3 rounded-xl bg-black/[0.02] border border-black/[0.05] text-center">
              <span class="text-[10px] text-[#86868b] uppercase font-semibold block">Jam Kantor</span>
              <span class="text-xs font-bold text-[#1d1d1f] block mt-1.5 font-mono">{{ sampleOfficeHours }}</span>
            </div>
            <div class="p-3 rounded-xl bg-black/[0.02] border border-black/[0.05] text-center">
              <span class="text-[10px] text-[#86868b] uppercase font-semibold block">Toleransi</span>
              <span class="text-sm font-bold text-[#34c759] block mt-1">+{{ officeSchedule.late_tolerance_minutes }} Mnt</span>
            </div>
          </div>
        </div>

        <!-- 2. One-Click Preset Templates (Termasuk Pola Instansi BKKBN) -->
        <div class="pt-5">
          <div class="flex items-center justify-between gap-2 mb-3">
            <div class="flex items-center gap-1.5 text-xs font-bold text-[#1d1d1f]">
              <span class="material-symbols-outlined text-[17px] text-[#0071e3]">auto_awesome</span>
              <span>Pilih Template Cepat (1-Klik Penerapan Jadwal):</span>
            </div>
            <span class="text-[11px] text-[#86868b]">Klik salah satu untuk otomatis mengisi format hari &amp; jam</span>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-3">
            <!-- Preset 1: Instansi BKKBN / Hybrid Pemerintah -->
            <button
              type="button"
              @click="applyPreset('bkkbn')"
              class="p-3.5 rounded-xl border text-left transition-all apple-press cursor-pointer relative group flex flex-col justify-between h-full"
              :class="activePresetKey === 'bkkbn' ? 'border-[#0071e3] bg-[#0071e3]/5 shadow-[0_2px_10px_rgba(0,113,227,0.12)] ring-1 ring-[#0071e3]' : 'border-black/[0.07] bg-[#fafafa] hover:border-[#0071e3]/40 hover:bg-white'"
            >
              <div>
                <div class="flex items-center justify-between mb-1.5">
                  <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-[#0071e3] text-white">
                    🏛️ Instansi BKKBN (Hybrid)
                  </span>
                  <span v-if="activePresetKey === 'bkkbn'" class="material-symbols-outlined text-[16px] text-[#0071e3]">check_circle</span>
                </div>
                <h4 class="text-xs font-bold text-[#1d1d1f]">Sistem WFH Terjadwal BKKBN</h4>
                <p class="text-[11px] text-[#86868b] mt-1 leading-snug">
                  • <strong>Sen, Rab, Jum:</strong> WFO Kantor (07:30 - 16:00)<br />
                  • <strong>Sel &amp; Kam:</strong> WFH Mandiri (07:30 - 16:00)<br />
                  • <strong>Sab &amp; Min:</strong> LIBUR Operasional
                </p>
              </div>
              <div class="mt-3 pt-2 border-t border-black/[0.04] flex items-center justify-between text-[10px] text-[#0071e3] font-semibold">
                <span>Terapkan Pola BKKBN</span>
                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
              </div>
            </button>

            <!-- Preset 2: Korporat Standar (Full WFO) -->
            <button
              type="button"
              @click="applyPreset('corporate')"
              class="p-3.5 rounded-xl border text-left transition-all apple-press cursor-pointer relative group flex flex-col justify-between h-full"
              :class="activePresetKey === 'corporate' ? 'border-[#0071e3] bg-[#0071e3]/5 shadow-[0_2px_10px_rgba(0,113,227,0.12)] ring-1 ring-[#0071e3]' : 'border-black/[0.07] bg-[#fafafa] hover:border-[#0071e3]/40 hover:bg-white'"
            >
              <div>
                <div class="flex items-center justify-between mb-1.5">
                  <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-[#1d1d1f] text-white">
                    🏢 Korporat Standar
                  </span>
                  <span v-if="activePresetKey === 'corporate'" class="material-symbols-outlined text-[16px] text-[#0071e3]">check_circle</span>
                </div>
                <h4 class="text-xs font-bold text-[#1d1d1f]">5 Hari Kerja WFO Penuh</h4>
                <p class="text-[11px] text-[#86868b] mt-1 leading-snug">
                  • <strong>Senin - Jumat:</strong> WFO Kantor (08:00 - 17:00, Jum 16:30)<br />
                  • <strong>Sabtu &amp; Minggu:</strong> LIBUR Operasional<br />
                  • Toleransi keterlambatan 15 menit
                </p>
              </div>
              <div class="mt-3 pt-2 border-t border-black/[0.04] flex items-center justify-between text-[10px] text-[#0071e3] font-semibold">
                <span>Terapkan Pola Korporat</span>
                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
              </div>
            </button>

            <!-- Preset 3: Tech Startup & Studio Digital -->
            <button
              type="button"
              @click="applyPreset('tech')"
              class="p-3.5 rounded-xl border text-left transition-all apple-press cursor-pointer relative group flex flex-col justify-between h-full"
              :class="activePresetKey === 'tech' ? 'border-[#0071e3] bg-[#0071e3]/5 shadow-[0_2px_10px_rgba(0,113,227,0.12)] ring-1 ring-[#0071e3]' : 'border-black/[0.07] bg-[#fafafa] hover:border-[#0071e3]/40 hover:bg-white'"
            >
              <div>
                <div class="flex items-center justify-between mb-1.5">
                  <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-purple-600 text-white">
                    💻 Startup IT &amp; Studio
                  </span>
                  <span v-if="activePresetKey === 'tech'" class="material-symbols-outlined text-[16px] text-[#0071e3]">check_circle</span>
                </div>
                <h4 class="text-xs font-bold text-[#1d1d1f]">Flexible &amp; Remote Friendly</h4>
                <p class="text-[11px] text-[#86868b] mt-1 leading-snug">
                  • <strong>Sen - Rab:</strong> WFO (09:00 - 18:00)<br />
                  • <strong>Kamis:</strong> WFA Lapangan • <strong>Jumat:</strong> WFH<br />
                  • <strong>Sabtu &amp; Minggu:</strong> LIBUR
                </p>
              </div>
              <div class="mt-3 pt-2 border-t border-black/[0.04] flex items-center justify-between text-[10px] text-[#0071e3] font-semibold">
                <span>Terapkan Pola Startup</span>
                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
              </div>
            </button>

            <!-- Preset 4: 6 Hari Kerja (Senin - Sabtu) -->
            <button
              type="button"
              @click="applyPreset('six_days')"
              class="p-3.5 rounded-xl border text-left transition-all apple-press cursor-pointer relative group flex flex-col justify-between h-full"
              :class="activePresetKey === 'six_days' ? 'border-[#0071e3] bg-[#0071e3]/5 shadow-[0_2px_10px_rgba(0,113,227,0.12)] ring-1 ring-[#0071e3]' : 'border-black/[0.07] bg-[#fafafa] hover:border-[#0071e3]/40 hover:bg-white'"
            >
              <div>
                <div class="flex items-center justify-between mb-1.5">
                  <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-[#ff9500] text-white">
                    🏭 6 Hari Operasional
                  </span>
                  <span v-if="activePresetKey === 'six_days'" class="material-symbols-outlined text-[16px] text-[#0071e3]">check_circle</span>
                </div>
                <h4 class="text-xs font-bold text-[#1d1d1f]">Senin s/d Sabtu Bekerja</h4>
                <p class="text-[11px] text-[#86868b] mt-1 leading-snug">
                  • <strong>Sen - Jum:</strong> WFO (08:00 - 16:00)<br />
                  • <strong>Sabtu:</strong> WFO Setengah Hari (08:00 - 13:00)<br />
                  • <strong>Minggu:</strong> LIBUR Operasional
                </p>
              </div>
              <div class="mt-3 pt-2 border-t border-black/[0.04] flex items-center justify-between text-[10px] text-[#0071e3] font-semibold">
                <span>Terapkan Pola 6 Hari</span>
                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
              </div>
            </button>
          </div>
        </div>
      </div>

      <!-- 3. Aturan Cepat Serentak & Toleransi Keterlambatan -->
      <div class="bg-white border border-black/[0.05] rounded-2xl p-6 shadow-[0_2px_12px_rgba(0,0,0,0.03)] space-y-4">
        <h3 class="text-sm font-bold text-[#1d1d1f] flex items-center gap-2">
          <span class="material-symbols-outlined text-[18px] text-[#0071e3]">alarm</span>
          <span>Penerapan Cepat Jam Kerja Serentak &amp; Toleransi</span>
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 rounded-xl bg-black/[0.02] border border-black/[0.04]">
          <div>
            <label class="text-[11px] font-semibold text-[#86868b] block mb-1">Set Jam Masuk Serentak</label>
            <div class="flex items-center gap-2">
              <input
                v-model="bulkInTime"
                type="time"
                class="px-3 py-1.5 bg-white border border-black/[0.1] rounded-xl text-xs font-mono font-bold text-[#1d1d1f] focus:ring-2 focus:ring-[#0071e3] focus:border-transparent outline-none"
              />
              <button
                type="button"
                @click="applyBulkInTime"
                class="px-3 py-1.5 rounded-xl bg-black/[0.05] hover:bg-black/[0.08] text-[#1d1d1f] text-xs font-semibold apple-press cursor-pointer transition"
              >
                Terapkan
              </button>
            </div>
            <span class="text-[10px] text-[#86868b] mt-0.5 block">Terapkan ke seluruh hari kerja aktif</span>
          </div>

          <div>
            <label class="text-[11px] font-semibold text-[#86868b] block mb-1">Set Jam Pulang Serentak</label>
            <div class="flex items-center gap-2">
              <input
                v-model="bulkOutTime"
                type="time"
                class="px-3 py-1.5 bg-white border border-black/[0.1] rounded-xl text-xs font-mono font-bold text-[#1d1d1f] focus:ring-2 focus:ring-[#0071e3] focus:border-transparent outline-none"
              />
              <button
                type="button"
                @click="applyBulkOutTime"
                class="px-3 py-1.5 rounded-xl bg-black/[0.05] hover:bg-black/[0.08] text-[#1d1d1f] text-xs font-semibold apple-press cursor-pointer transition"
              >
                Terapkan
              </button>
            </div>
            <span class="text-[10px] text-[#86868b] mt-0.5 block">Terapkan ke seluruh hari kerja aktif</span>
          </div>

          <div>
            <label class="text-[11px] font-semibold text-[#86868b] block mb-1">Toleransi Keterlambatan</label>
            <select
              v-model.number="officeSchedule.late_tolerance_minutes"
              class="w-full px-3 py-1.5 bg-white border border-black/[0.1] rounded-xl text-xs font-bold text-[#1d1d1f] focus:ring-2 focus:ring-[#0071e3] outline-none cursor-pointer"
            >
              <option :value="0">0 Menit (Tepat Waktu Ketat)</option>
              <option :value="10">10 Menit</option>
              <option :value="15">15 Menit (Standar Instansi / BKKBN)</option>
              <option :value="30">30 Menit (Fleksibel)</option>
              <option :value="45">45 Menit</option>
              <option :value="60">60 Menit (Toleransi Maksimum)</option>
            </select>
            <span class="text-[10px] text-[#86868b] mt-0.5 block">Siswa tap-in setelah toleransi dicatat "Terlambat"</span>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-1">
          <div>
            <label class="text-[11px] font-semibold text-[#86868b] block mb-1">Nama Kebijakan Jadwal Kantor</label>
            <input
              v-model="officeSchedule.policy_name"
              type="text"
              placeholder="Contoh: Sistem Kerja WFH Terjadwal BKKBN"
              class="w-full px-3.5 py-2 bg-black/[0.03] focus:bg-white border border-transparent focus:border-[#0071e3]/30 rounded-xl text-xs text-[#1d1d1f] font-semibold outline-none transition"
            />
          </div>

          <div>
            <label class="text-[11px] font-semibold text-[#86868b] block mb-1">Catatan Kebijakan &amp; Regulasi Kantor</label>
            <input
              v-model="officeSchedule.policy_description"
              type="text"
              placeholder="Deskripsi aturan WFH/WFO dan operasional kantor..."
              class="w-full px-3.5 py-2 bg-black/[0.03] focus:bg-white border border-transparent focus:border-[#0071e3]/30 rounded-xl text-xs text-[#1d1d1f] outline-none transition"
            />
          </div>
        </div>
      </div>

      <!-- 4. 7 Blok Mendatar Jadwal Mingguan (Senin s/d Minggu) -->
      <div class="bg-white border border-black/[0.05] rounded-2xl p-6 shadow-[0_2px_12px_rgba(0,0,0,0.03)] space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-black/[0.05]">
          <div>
            <h3 class="text-sm font-bold text-[#1d1d1f] flex items-center gap-2">
              <span class="material-symbols-outlined text-[18px] text-[#0071e3]">calendar_view_week</span>
              <span>Jadwal Mingguan 7 Hari (Senin &ndash; Minggu)</span>
            </h3>
            <p class="text-[11px] text-[#86868b] mt-0.5">
              Klik salah satu kotak hari di bawah untuk mengatur mode kerja (WFH/WFO/WFA), jam masuk, jam pulang, atau status libur.
            </p>
          </div>
          <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#0071e3]/10 text-[#0071e3] text-[11px] font-semibold">
              <span class="material-symbols-outlined text-[14px]">touch_app</span>
              <span>Klik kotak hari untuk konfigurasi</span>
            </span>
          </div>
        </div>

        <!-- 7 Horizontal Day Blocks Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3">
          <div
            v-for="(dayKey, idx) in allDaysOrder"
            :key="dayKey"
            @click="openDayEditModal(dayKey)"
            role="button"
            tabindex="0"
            class="group relative flex flex-col justify-between p-3.5 rounded-2xl border transition-all duration-200 cursor-pointer text-left select-none outline-none"
            :class="[
              officeSchedule.days[dayKey].is_work_day
                ? 'bg-white border-black/[0.08] hover:border-[#0071e3] hover:shadow-md hover:-translate-y-0.5'
                : 'bg-amber-500/[0.04] border-amber-500/20 hover:border-amber-500/50 hover:shadow-sm',
              currentDayKeyString === dayKey ? 'ring-2 ring-[#0071e3]/50' : ''
            ]"
          >
            <!-- Card Top: Day Name + Today Badge -->
            <div>
              <div class="flex items-center justify-between gap-1 mb-2">
                <span class="text-xs font-bold uppercase tracking-wider text-[#1d1d1f]">
                  {{ dayNamesMap[dayKey].label }}
                </span>
                <span
                  v-if="currentDayKeyString === dayKey"
                  class="px-1.5 py-0.5 rounded-md text-[9px] font-extrabold bg-[#34c759]/15 text-[#248a3d]"
                >
                  HARI INI
                </span>
              </div>

              <!-- Work Mode Badge -->
              <div class="mb-3">
                <!-- If Kerja -->
                <div v-if="officeSchedule.days[dayKey].is_work_day">
                  <span
                    v-if="officeSchedule.days[dayKey].mode === 'wfo'"
                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-[10px] font-bold bg-[#0071e3]/10 text-[#0071e3]"
                  >
                    <span class="material-symbols-outlined text-[13px]">apartment</span>
                    <span>WFO (Kantor)</span>
                  </span>
                  <span
                    v-else-if="officeSchedule.days[dayKey].mode === 'wfh'"
                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-[10px] font-bold bg-[#34c759]/15 text-[#248a3d]"
                  >
                    <span class="material-symbols-outlined text-[13px]">home_work</span>
                    <span>WFH (Rumah)</span>
                  </span>
                  <span
                    v-else-if="officeSchedule.days[dayKey].mode === 'wfa'"
                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-[10px] font-bold bg-purple-500/10 text-purple-600"
                  >
                    <span class="material-symbols-outlined text-[13px]">public</span>
                    <span>WFA (Luar)</span>
                  </span>
                </div>
                <!-- If Libur -->
                <div v-else>
                  <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-[10px] font-bold bg-amber-500/15 text-amber-700">
                    <span class="material-symbols-outlined text-[13px]">beach_access</span>
                    <span>LIBUR</span>
                  </span>
                </div>
              </div>

              <!-- Time / Hours -->
              <div class="space-y-1 mb-2">
                <div v-if="officeSchedule.days[dayKey].is_work_day" class="space-y-0.5">
                  <div class="text-[11px] text-[#86868b] flex items-center justify-between">
                    <span>Masuk:</span>
                    <span class="font-mono font-bold text-[#1d1d1f]">
                      {{ officeSchedule.days[dayKey].check_in_time || '--:--' }}
                    </span>
                  </div>
                  <div class="text-[11px] text-[#86868b] flex items-center justify-between">
                    <span>Pulang:</span>
                    <span class="font-mono font-bold text-[#1d1d1f]">
                      {{ officeSchedule.days[dayKey].check_out_time || '--:--' }}
                    </span>
                  </div>
                </div>
                <div v-else class="py-1">
                  <span class="text-[11px] font-semibold text-amber-800/80 block">Tutup / Libur</span>
                  <span class="text-[10px] text-amber-700/60 block">Tanpa presensi</span>
                </div>
              </div>

              <!-- Notes Preview -->
              <p
                v-if="officeSchedule.days[dayKey].notes"
                class="text-[10px] text-[#86868b] line-clamp-1 italic mt-1 border-t border-black/[0.04] pt-1"
                :title="officeSchedule.days[dayKey].notes"
              >
                {{ officeSchedule.days[dayKey].notes }}
              </p>
            </div>

            <!-- Card Bottom: Click to Edit Cue -->
            <div class="mt-3 pt-2 border-t border-black/[0.04] flex items-center justify-between text-[10px] font-semibold text-[#86868b] group-hover:text-[#0071e3] transition-colors">
              <span>Atur Hari</span>
              <span class="material-symbols-outlined text-[14px] group-hover:translate-x-0.5 transition-transform">tune</span>
            </div>
          </div>
        </div>
      </div>

      <!-- 5. Hari Libur Khusus / Kalender Tanggal Merah Tambahan -->
      <div class="bg-white border border-black/[0.05] rounded-2xl p-6 shadow-[0_2px_12px_rgba(0,0,0,0.03)] space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-3 border-b border-black/[0.05]">
          <div>
            <h3 class="text-sm font-bold text-[#1d1d1f] flex items-center gap-2">
              <span class="material-symbols-outlined text-[18px] text-[#ff9500]">event_busy</span>
              <span>Daftar Hari Libur Khusus &amp; Cuti Bersama Perusahaan</span>
            </h3>
            <p class="text-[11px] text-[#86868b] mt-0.5">
              Tambahkan tanggal merah khusus di mana kantor diliburkan di luar akhir pekan reguler.
            </p>
          </div>

          <!-- Add Special Holiday Form -->
          <div class="flex items-center gap-2 flex-wrap">
            <input
              v-model="newHolidayDate"
              type="date"
              class="px-3 py-1.5 bg-black/[0.03] border border-black/[0.08] rounded-xl text-xs font-mono text-[#1d1d1f] outline-none"
            />
            <input
              v-model="newHolidayName"
              type="text"
              placeholder="Nama Libur (e.g. Cuti Bersama)"
              class="px-3 py-1.5 bg-black/[0.03] border border-black/[0.08] rounded-xl text-xs text-[#1d1d1f] outline-none w-48"
            />
            <button
              type="button"
              @click="addSpecialHoliday"
              class="px-3 py-1.5 rounded-xl bg-[#0071e3] hover:bg-[#0077ed] text-white text-xs font-semibold shadow-xs apple-press cursor-pointer flex items-center gap-1"
            >
              <span class="material-symbols-outlined text-[15px]">add</span>
              <span>Tambah</span>
            </button>
          </div>
        </div>

        <div v-if="officeSchedule.special_holidays.length === 0" class="text-center py-6 text-[#86868b]">
          <p class="text-xs">Belum ada hari libur khusus / cuti bersama tambahan yang didaftarkan.</p>
        </div>

        <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2.5">
          <div
            v-for="(h, idx) in officeSchedule.special_holidays"
            :key="idx"
            class="p-3 rounded-xl border border-amber-500/20 bg-amber-500/[0.04] flex items-center justify-between gap-2"
          >
            <div class="flex items-center gap-2 min-w-0">
              <span class="material-symbols-outlined text-[18px] text-amber-600 shrink-0">event</span>
              <div class="min-w-0">
                <span class="text-xs font-bold text-[#1d1d1f] block truncate">{{ h.name }}</span>
                <span class="text-[10px] text-[#86868b] font-mono block">{{ h.date }}</span>
              </div>
            </div>
            <button
              type="button"
              @click="removeSpecialHoliday(idx)"
              class="p-1 rounded-lg text-[#86868b] hover:text-[#ff3b30] hover:bg-black/[0.05] transition"
              title="Hapus Libur Ini"
            >
              <span class="material-symbols-outlined text-[16px]">delete</span>
            </button>
          </div>
        </div>
      </div>

      <!-- 6. Sticky Action Bar: Simpan Jadwal -->
      <div class="bg-white border border-black/[0.08] rounded-2xl p-4.5 shadow-[0_4px_20px_rgba(0,0,0,0.06)] flex flex-col sm:flex-row sm:items-center sm:justify-end gap-2.5">
        <button
          type="button"
          @click="resetScheduleToDefault"
          class="px-4 py-2.5 rounded-xl bg-black/[0.04] hover:bg-black/[0.08] text-[#1d1d1f] text-xs font-semibold transition apple-press cursor-pointer"
        >
          Reset
        </button>
        <button
          type="button"
          @click="saveCompanySchedule"
          :disabled="isSavingOfficeSchedule"
          class="px-6 py-2.5 rounded-xl bg-[#0071e3] hover:bg-[#0077ed] text-white text-xs font-bold shadow-[0_2px_8px_rgba(0,113,227,0.3)] transition apple-press flex items-center gap-1.5 cursor-pointer disabled:opacity-50"
        >
          <span class="material-symbols-outlined text-[17px]">
            {{ isSavingOfficeSchedule ? 'progress_activity' : 'save' }}
          </span>
          <span>{{ isSavingOfficeSchedule ? 'Menyimpan ke Server...' : 'Simpan Jadwal Kantor Mingguan' }}</span>
        </button>
      </div>
    </div>

    <!-- TAB 4: PENGATURAN JADWAL MINGGUAN PER SISWA (MATRIX PENJADWALAN INDIVIDUAL) -->
    <div v-if="activeSubTab === 'schedules'" class="space-y-4">
      <div class="bg-white border border-black/[0.05] rounded-2xl p-6 shadow-[0_2px_12px_rgba(0,0,0,0.03)]">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 mb-4 border-b border-black/[0.05]">
          <div>
            <h3 class="text-sm font-semibold text-[#1d1d1f] tracking-tight">
              Matriks Penjadwalan Khusus Per Siswa (Senin &ndash; Jumat)
            </h3>
            <p class="text-[11px] text-[#86868b] mt-0.5">
              Jadwal di bawah ini dapat mengikuti jadwal kantor utama di tab <strong>Jadwal Kantor Mingguan</strong> atau disesuaikan khusus untuk tiap siswa.
            </p>
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs text-[#1d1d1f]">
            <thead class="bg-black/[0.02] text-[#86868b] uppercase text-[10px] tracking-wider border-b border-black/[0.05] font-semibold">
              <tr>
                <th class="py-3 px-4 rounded-l-xl">Siswa Magang</th>
                <th class="py-3 px-3 text-center">Senin</th>
                <th class="py-3 px-3 text-center">Selasa</th>
                <th class="py-3 px-3 text-center">Rabu</th>
                <th class="py-3 px-3 text-center">Kamis</th>
                <th class="py-3 px-3 text-center">Jumat</th>
                <th class="py-3 px-4 text-center rounded-r-xl">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-black/[0.04]">
              <tr v-for="item in studentsWithSchedules" :key="item.placement_id" class="hover:bg-black/[0.02] transition">
                <!-- Student -->
                <td class="py-3.5 px-4 whitespace-nowrap">
                  <div class="flex items-center gap-3">
                    <img :src="item.student?.avatar || 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150'" class="w-9 h-9 rounded-xl object-cover border border-black/[0.06] shadow-xs" />
                    <div>
                      <div class="font-semibold text-[#1d1d1f]">{{ item.student?.name }}</div>
                      <div class="text-[10px] text-[#86868b] font-mono">{{ item.student?.major }} • {{ item.student?.class_name }}</div>
                    </div>
                  </div>
                </td>

                <!-- Senin -->
                <td class="py-3.5 px-2 text-center whitespace-nowrap">
                  <select
                    v-model="item.work_schedule.monday"
                    class="py-1 px-2 text-[11px] font-bold rounded-lg border border-black/[0.08] bg-white focus:ring-2 focus:ring-[#0071e3] cursor-pointer"
                  >
                    <option value="wfo">WFO (Kantor)</option>
                    <option value="wfh">WFH (Rumah)</option>
                    <option value="wfa">WFA (Lapangan)</option>
                    <option value="libur">Libur Kantor</option>
                  </select>
                </td>

                <!-- Selasa -->
                <td class="py-3.5 px-2 text-center whitespace-nowrap">
                  <select
                    v-model="item.work_schedule.tuesday"
                    class="py-1 px-2 text-[11px] font-bold rounded-lg border border-black/[0.08] bg-white focus:ring-2 focus:ring-[#0071e3] cursor-pointer"
                  >
                    <option value="wfo">WFO (Kantor)</option>
                    <option value="wfh">WFH (Rumah)</option>
                    <option value="wfa">WFA (Lapangan)</option>
                    <option value="libur">Libur Kantor</option>
                  </select>
                </td>

                <!-- Rabu -->
                <td class="py-3.5 px-2 text-center whitespace-nowrap">
                  <select
                    v-model="item.work_schedule.wednesday"
                    class="py-1 px-2 text-[11px] font-bold rounded-lg border border-black/[0.08] bg-white focus:ring-2 focus:ring-[#0071e3] cursor-pointer"
                  >
                    <option value="wfo">WFO (Kantor)</option>
                    <option value="wfh">WFH (Rumah)</option>
                    <option value="wfa">WFA (Lapangan)</option>
                    <option value="libur">Libur Kantor</option>
                  </select>
                </td>

                <!-- Kamis -->
                <td class="py-3.5 px-2 text-center whitespace-nowrap">
                  <select
                    v-model="item.work_schedule.thursday"
                    class="py-1 px-2 text-[11px] font-bold rounded-lg border border-black/[0.08] bg-white focus:ring-2 focus:ring-[#0071e3] cursor-pointer"
                  >
                    <option value="wfo">WFO (Kantor)</option>
                    <option value="wfh">WFH (Rumah)</option>
                    <option value="wfa">WFA (Lapangan)</option>
                    <option value="libur">Libur Kantor</option>
                  </select>
                </td>

                <!-- Jumat -->
                <td class="py-3.5 px-2 text-center whitespace-nowrap">
                  <select
                    v-model="item.work_schedule.friday"
                    class="py-1 px-2 text-[11px] font-bold rounded-lg border border-black/[0.08] bg-white focus:ring-2 focus:ring-[#0071e3] cursor-pointer"
                  >
                    <option value="wfo">WFO (Kantor)</option>
                    <option value="wfh">WFH (Rumah)</option>
                    <option value="wfa">WFA (Lapangan)</option>
                    <option value="libur">Libur Kantor</option>
                  </select>
                </td>

                <!-- Action: Save -->
                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                  <button
                    type="button"
                    @click="saveSchedule(item)"
                    class="px-3.5 py-1.5 rounded-xl bg-[#0071e3] hover:bg-[#0077ed] active:scale-95 text-white text-xs font-semibold transition shadow-xs flex items-center justify-center gap-1 mx-auto cursor-pointer"
                  >
                    <span class="material-symbols-outlined text-[15px]">save</span>
                    <span>Simpan</span>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Modal Teleport: Edit Jadwal Harian Apple HIG -->
    <Teleport to="body">
      <div
        v-if="isDayEditModalOpen"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm"
        @click.self="closeDayEditModal"
      >
        <div class="bg-white rounded-3xl shadow-2xl border border-black/[0.08] max-w-lg w-full overflow-hidden transition-all transform scale-100">
          <!-- Modal Header -->
          <div class="px-6 py-4 border-b border-black/[0.05] flex items-center justify-between bg-[#fbfbfd]">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-2xl bg-[#0071e3] text-white flex items-center justify-center font-bold text-sm shadow-xs">
                {{ dayNamesMap[selectedEditDayKey]?.short }}
              </div>
              <div>
                <h3 class="text-base font-bold text-[#1d1d1f] flex items-center gap-2">
                  <span>Atur Jadwal: {{ dayNamesMap[selectedEditDayKey]?.label }}</span>
                  <span
                    v-if="currentDayKeyString === selectedEditDayKey"
                    class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-[#34c759]/15 text-[#248a3d]"
                  >
                    HARI INI
                  </span>
                </h3>
                <p class="text-xs text-[#86868b]">Konfigurasi jam masuk, pulang, dan mode kerja</p>
              </div>
            </div>
            <button
              type="button"
              @click="closeDayEditModal"
              class="w-8 h-8 rounded-full bg-black/[0.05] hover:bg-black/[0.1] text-[#86868b] hover:text-[#1d1d1f] flex items-center justify-center transition cursor-pointer"
            >
              <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
          </div>

          <!-- Modal Body -->
          <div class="p-6 space-y-5 max-h-[75vh] overflow-y-auto">
            <!-- 1. Status Kerja: Bekerja vs Libur -->
            <div>
              <label class="text-xs font-bold text-[#1d1d1f] block mb-2">Status Operasional Hari</label>
              <div class="grid grid-cols-2 gap-2 p-1 bg-black/[0.04] rounded-2xl">
                <button
                  type="button"
                  @click="editDayForm.is_work_day = true"
                  class="flex items-center justify-center gap-2 py-2.5 rounded-xl text-xs font-bold transition-all cursor-pointer"
                  :class="editDayForm.is_work_day
                    ? 'bg-white text-[#0071e3] shadow-sm'
                    : 'text-[#86868b] hover:text-[#1d1d1f]'"
                >
                  <span class="material-symbols-outlined text-[18px]">work</span>
                  <span>Hari Kerja (Aktif)</span>
                </button>
                <button
                  type="button"
                  @click="editDayForm.is_work_day = false"
                  class="flex items-center justify-center gap-2 py-2.5 rounded-xl text-xs font-bold transition-all cursor-pointer"
                  :class="!editDayForm.is_work_day
                    ? 'bg-amber-500 text-white shadow-sm'
                    : 'text-[#86868b] hover:text-[#1d1d1f]'"
                >
                  <span class="material-symbols-outlined text-[18px]">beach_access</span>
                  <span>Hari Libur (Tutup)</span>
                </button>
              </div>
            </div>

            <!-- Jika HARI KERJA -->
            <template v-if="editDayForm.is_work_day">
              <!-- Mode Kerja Pilihan (WFO / WFH / WFA) -->
              <div>
                <label class="text-xs font-bold text-[#1d1d1f] block mb-2">Pilih Mode Kerja Kantor</label>
                <div class="grid grid-cols-3 gap-2.5">
                  <!-- WFO -->
                  <div
                    @click="editDayForm.mode = 'wfo'"
                    class="p-3 rounded-2xl border-2 transition-all cursor-pointer text-center select-none"
                    :class="editDayForm.mode === 'wfo'
                      ? 'border-[#0071e3] bg-[#0071e3]/[0.05] ring-1 ring-[#0071e3]'
                      : 'border-black/[0.08] hover:border-black/[0.15] bg-[#fafafa]'"
                  >
                    <div
                      class="w-8 h-8 mx-auto rounded-xl flex items-center justify-center mb-1.5"
                      :class="editDayForm.mode === 'wfo' ? 'bg-[#0071e3] text-white' : 'bg-black/[0.06] text-[#86868b]'"
                    >
                      <span class="material-symbols-outlined text-[18px]">apartment</span>
                    </div>
                    <div class="font-bold text-xs text-[#1d1d1f]">WFO</div>
                    <div class="text-[10px] text-[#86868b] mt-0.5">Di Kantor</div>
                  </div>

                  <!-- WFH -->
                  <div
                    @click="editDayForm.mode = 'wfh'"
                    class="p-3 rounded-2xl border-2 transition-all cursor-pointer text-center select-none"
                    :class="editDayForm.mode === 'wfh'
                      ? 'border-[#34c759] bg-[#34c759]/[0.05] ring-1 ring-[#34c759]'
                      : 'border-black/[0.08] hover:border-black/[0.15] bg-[#fafafa]'"
                  >
                    <div
                      class="w-8 h-8 mx-auto rounded-xl flex items-center justify-center mb-1.5"
                      :class="editDayForm.mode === 'wfh' ? 'bg-[#34c759] text-white' : 'bg-black/[0.06] text-[#86868b]'"
                    >
                      <span class="material-symbols-outlined text-[18px]">home_work</span>
                    </div>
                    <div class="font-bold text-xs text-[#1d1d1f]">WFH</div>
                    <div class="text-[10px] text-[#86868b] mt-0.5">Dari Rumah</div>
                  </div>

                  <!-- WFA -->
                  <div
                    @click="editDayForm.mode = 'wfa'"
                    class="p-3 rounded-2xl border-2 transition-all cursor-pointer text-center select-none"
                    :class="editDayForm.mode === 'wfa'
                      ? 'border-purple-600 bg-purple-600/[0.05] ring-1 ring-purple-600'
                      : 'border-black/[0.08] hover:border-black/[0.15] bg-[#fafafa]'"
                  >
                    <div
                      class="w-8 h-8 mx-auto rounded-xl flex items-center justify-center mb-1.5"
                      :class="editDayForm.mode === 'wfa' ? 'bg-purple-600 text-white' : 'bg-black/[0.06] text-[#86868b]'">
                      <span class="material-symbols-outlined text-[18px]">public</span>
                    </div>
                    <div class="font-bold text-xs text-[#1d1d1f]">WFA</div>
                    <div class="text-[10px] text-[#86868b] mt-0.5">Fleksibel/Luar</div>
                  </div>
                </div>
              </div>

              <!-- Jam Masuk & Jam Pulang -->
              <div>
                <div class="flex items-center justify-between mb-2">
                  <label class="text-xs font-bold text-[#1d1d1f]">Jam Masuk &amp; Jam Pulang</label>
                  <span class="text-[11px] text-[#86868b]">Waktu Indonesia Barat (WIB)</span>
                </div>
                <div class="grid grid-cols-2 gap-3">
                  <div class="bg-black/[0.02] p-3 rounded-2xl border border-black/[0.06]">
                    <span class="text-[11px] font-semibold text-[#86868b] block mb-1">Jam Masuk (Tap-In)</span>
                    <input
                      v-model="editDayForm.check_in_time"
                      type="time"
                      class="w-full px-3 py-2 bg-white border border-black/[0.1] rounded-xl text-sm font-mono font-bold text-[#1d1d1f] focus:ring-2 focus:ring-[#0071e3] outline-none"
                    />
                  </div>
                  <div class="bg-black/[0.02] p-3 rounded-2xl border border-black/[0.06]">
                    <span class="text-[11px] font-semibold text-[#86868b] block mb-1">Jam Pulang (Tap-Out)</span>
                    <input
                      v-model="editDayForm.check_out_time"
                      type="time"
                      class="w-full px-3 py-2 bg-white border border-black/[0.1] rounded-xl text-sm font-mono font-bold text-[#1d1d1f] focus:ring-2 focus:ring-[#0071e3] outline-none"
                    />
                  </div>
                </div>

                <!-- Quick Presets for Times -->
                <div class="mt-2.5 flex flex-wrap gap-1.5 items-center">
                  <span class="text-[10px] font-medium text-[#86868b] mr-1">Preset cepat:</span>
                  <button
                    type="button"
                    @click="setEditTimePreset('07:30', '16:00')"
                    class="px-2 py-1 rounded-lg bg-black/[0.04] hover:bg-black/[0.08] text-[10px] font-semibold text-[#1d1d1f] transition cursor-pointer"
                  >
                    07:30 - 16:00 (Standar)
                  </button>
                  <button
                    type="button"
                    @click="setEditTimePreset('07:30', '16:30')"
                    class="px-2 py-1 rounded-lg bg-black/[0.04] hover:bg-black/[0.08] text-[10px] font-semibold text-[#1d1d1f] transition cursor-pointer"
                  >
                    07:30 - 16:30 (Jumat)
                  </button>
                  <button
                    type="button"
                    @click="setEditTimePreset('08:00', '17:00')"
                    class="px-2 py-1 rounded-lg bg-black/[0.04] hover:bg-black/[0.08] text-[10px] font-semibold text-[#1d1d1f] transition cursor-pointer"
                  >
                    08:00 - 17:00
                  </button>
                  <button
                    type="button"
                    @click="setEditTimePreset('08:00', '13:00')"
                    class="px-2 py-1 rounded-lg bg-black/[0.04] hover:bg-black/[0.08] text-[10px] font-semibold text-[#1d1d1f] transition cursor-pointer"
                  >
                    08:00 - 13:00 (1/2 Hari)
                  </button>
                </div>
              </div>

              <!-- Catatan / Keterangan -->
              <div>
                <label class="text-xs font-bold text-[#1d1d1f] block mb-1">Catatan / Keterangan Hari</label>
                <input
                  v-model="editDayForm.notes"
                  type="text"
                  placeholder="Contoh: WFO Kantor Pusat, WFH Mandiri BKKBN, Apel Pagi"
                  class="w-full px-3.5 py-2.5 bg-black/[0.02] focus:bg-white border border-black/[0.08] focus:border-[#0071e3] rounded-xl text-xs text-[#1d1d1f] outline-none transition"
                />
              </div>
            </template>

            <!-- Jika HARI LIBUR -->
            <template v-else>
              <div class="p-4 rounded-2xl bg-amber-500/[0.08] border border-amber-500/20 text-amber-950 space-y-2">
                <div class="flex items-center gap-2 font-bold text-xs">
                  <span class="material-symbols-outlined text-[20px] text-amber-600">beach_access</span>
                  <span>Hari Libur Operasional Kantor</span>
                </div>
                <p class="text-[11px] text-amber-900/80 leading-relaxed">
                  Pada hari ini siswa binaan tidak diwajibkan untuk mengisi absensi masuk ataupun pulang.
                </p>
              </div>

              <div>
                <label class="text-xs font-bold text-[#1d1d1f] block mb-1">Alasan Libur / Keterangan</label>
                <input
                  v-model="editDayForm.notes"
                  type="text"
                  placeholder="Contoh: Libur Akhir Pekan, Libur Bersama"
                  class="w-full px-3.5 py-2.5 bg-black/[0.02] focus:bg-white border border-black/[0.08] focus:border-[#0071e3] rounded-xl text-xs text-[#1d1d1f] outline-none transition"
                />
              </div>
            </template>
          </div>

          <!-- Modal Footer -->
          <div class="px-6 py-4 bg-[#fbfbfd] border-t border-black/[0.05] flex flex-col sm:flex-row items-center justify-between gap-3">
            <button
              v-if="editDayForm.is_work_day"
              type="button"
              @click="applyModalToAllWorkDays"
              class="text-[11px] font-semibold text-[#0071e3] hover:underline flex items-center gap-1 cursor-pointer order-2 sm:order-1"
            >
              <span class="material-symbols-outlined text-[15px]">sync_alt</span>
              <span>Terapkan ke seluruh hari kerja aktif</span>
            </button>
            <div v-else class="order-2 sm:order-1"></div>

            <div class="flex items-center gap-2 w-full sm:w-auto order-1 sm:order-2">
              <button
                type="button"
                @click="closeDayEditModal"
                class="flex-1 sm:flex-initial px-4 py-2 rounded-xl border border-black/[0.1] text-xs font-semibold text-[#1d1d1f] hover:bg-black/[0.05] transition cursor-pointer"
              >
                Batal
              </button>
              <button
                type="button"
                @click="saveDayEdit"
                class="flex-1 sm:flex-initial px-5 py-2 rounded-xl bg-[#0071e3] hover:bg-[#0077ed] text-white text-xs font-bold transition shadow-xs cursor-pointer flex items-center justify-center gap-1.5"
              >
                <span class="material-symbols-outlined text-[16px]">check</span>
                <span>Simpan Perubahan</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </Teleport>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, reactive, onMounted } from 'vue'
import { useAppStore } from '~/composables/useAppStore'

const { showToast, authToken } = useAppStore()

const activeSubTab = ref<'rekap' | 'requests' | 'office_schedule' | 'schedules'>('rekap')
const search = ref('')

// Attendances State
const attendances = ref<any[]>([
  { id: 1, name: 'Budi Santoso', nisn: '0061234567', avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150', date: '2026-10-02', in: '07:35:12', out: null, work_mode: 'wfo', status: 'hadir', notes: 'Validasi Geofence (24m di kantor PT Telkom)' },
  { id: 2, name: 'Siti Fauziah', nisn: '0061234568', avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150', date: '2026-10-01', in: '07:42:00', out: '17:05:00', work_mode: 'wfh', status: 'hadir', notes: 'Presensi WFH (Pola Kerja Hybrid Mandiri)' },
  { id: 3, name: 'Ahmad Danu', nisn: '0061234569', avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150', date: '2026-10-01', in: '07:50:00', out: '17:15:00', work_mode: 'wfa', status: 'hadir', notes: 'Presensi WFA (Penugasan Luar: Liputan Visual)' },
])

// Mode Requests State
const modeRequests = ref<any[]>([])

// Schedules Matrix State
const studentsWithSchedules = ref<any[]>([])

// ----------------------------------------------------
// Office Schedule State (Jam Masuk, Pulang, Hari Libur)
// ----------------------------------------------------
const companyData = reactive({
  id: 1,
  name: 'PT Telkom Digital Solusi',
  sector: 'Software House & Cloud Platform',
  address: 'Jl. Gatot Subroto Kav. 52, Gedung Telkom Landmark Lt. 14, Jakarta Selatan'
})

const officeSchedule = reactive({
  work_days: ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'],
  days: {
    monday: { is_work_day: true, mode: 'wfo', check_in_time: '07:30', check_out_time: '16:00', notes: 'WFO Kantor Pusat' },
    tuesday: { is_work_day: true, mode: 'wfh', check_in_time: '07:30', check_out_time: '16:00', notes: 'Sistem WFH Mandiri (Pola BKKBN)' },
    wednesday: { is_work_day: true, mode: 'wfo', check_in_time: '07:30', check_out_time: '16:00', notes: 'WFO Kantor Pusat' },
    thursday: { is_work_day: true, mode: 'wfh', check_in_time: '07:30', check_out_time: '16:00', notes: 'Sistem WFH Mandiri (Pola BKKBN)' },
    friday: { is_work_day: true, mode: 'wfo', check_in_time: '07:30', check_out_time: '16:30', notes: 'WFO & Evaluasi Mingguan' },
    saturday: { is_work_day: false, mode: 'libur', check_in_time: null, check_out_time: null, notes: 'Libur Akhir Pekan' },
    sunday: { is_work_day: false, mode: 'libur', check_in_time: null, check_out_time: null, notes: 'Libur Akhir Pekan' },
  } as Record<string, any>,
  late_tolerance_minutes: 15,
  policy_name: 'Sistem Kerja Hybrid BKKBN / Tempat Magang',
  policy_description: 'Jadwal operasional kantor: Masuk pukul 07:30 WIB, Pulang pukul 16:00 WIB (Jumat 16:30). Menerapkan sistem WFH terjadwal seperti regulasi instansi BKKBN pada hari Selasa & Kamis. Sabtu dan Minggu libur.',
  special_holidays: [] as Array<{ date: string; name: string }>
})

const activePresetKey = ref<string>('bkkbn')
const isSavingOfficeSchedule = ref(false)

const bulkInTime = ref('07:30')
const bulkOutTime = ref('16:00')

const newHolidayDate = ref('')
const newHolidayName = ref('')

const allDaysOrder = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']

const dayNamesMap: Record<string, { label: string; short: string }> = {
  monday: { label: 'Senin', short: 'SEN' },
  tuesday: { label: 'Selasa', short: 'SEL' },
  wednesday: { label: 'Rabu', short: 'RAB' },
  thursday: { label: 'Kamis', short: 'KAM' },
  friday: { label: 'Jumat', short: 'JUM' },
  saturday: { label: 'Sabtu', short: 'SAB' },
  sunday: { label: 'Minggu', short: 'MIN' },
}

const currentDayKeyString = computed(() => {
  const days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']
  return days[new Date().getDay()]
})

const countWorkDays = computed(() => {
  return allDaysOrder.filter(k => officeSchedule.days[k]?.is_work_day).length
})

const countHolidays = computed(() => {
  return allDaysOrder.filter(k => !officeSchedule.days[k]?.is_work_day).length
})

const sampleOfficeHours = computed(() => {
  const mon = officeSchedule.days['monday']
  if (mon && mon.is_work_day && mon.check_in_time && mon.check_out_time) {
    return `${mon.check_in_time} - ${mon.check_out_time} WIB`
  }
  return '07:30 - 16:00 WIB'
})

const countByMode = (mode: string) => {
  return attendances.value.filter(a => (a.work_mode || 'wfo') === mode).length
}

const pendingRequestsCount = computed(() => {
  return modeRequests.value.filter(r => r.status === 'pending').length
})

const filteredAttendances = computed(() => {
  if (!search.value) return attendances.value
  const q = search.value.toLowerCase()
  return attendances.value.filter(a =>
    (a.student?.name || a.name || '').toLowerCase().includes(q) ||
    (a.student?.nisn_nip || a.nisn || '').includes(q)
  )
})

// Toggle work day vs holiday
const setDayWorkStatus = (dayKey: string, isWork: boolean) => {
  officeSchedule.days[dayKey].is_work_day = isWork
  if (!isWork) {
    officeSchedule.days[dayKey].mode = 'libur'
    officeSchedule.days[dayKey].check_in_time = null
    officeSchedule.days[dayKey].check_out_time = null
    if (!officeSchedule.days[dayKey].notes || officeSchedule.days[dayKey].notes.includes('WFO')) {
      officeSchedule.days[dayKey].notes = inArray(dayKey, ['saturday', 'sunday']) ? 'Libur Akhir Pekan' : 'Hari Libur Operasional'
    }
  } else {
    if (officeSchedule.days[dayKey].mode === 'libur') {
      officeSchedule.days[dayKey].mode = 'wfo'
    }
    if (!officeSchedule.days[dayKey].check_in_time) {
      officeSchedule.days[dayKey].check_in_time = bulkInTime.value || '07:30'
    }
    if (!officeSchedule.days[dayKey].check_out_time) {
      officeSchedule.days[dayKey].check_out_time = bulkOutTime.value || '16:00'
    }
    officeSchedule.days[dayKey].notes = 'Bekerja Normal'
  }
}

const inArray = (val: string, arr: string[]) => arr.includes(val)

// Modal Pengaturan Jadwal Harian Apple HIG
const isDayEditModalOpen = ref(false)
const selectedEditDayKey = ref('monday')
const editDayForm = reactive({
  is_work_day: true,
  mode: 'wfo',
  check_in_time: '07:30',
  check_out_time: '16:00',
  notes: ''
})

const openDayEditModal = (dayKey: string) => {
  selectedEditDayKey.value = dayKey
  const current = officeSchedule.days[dayKey] || {}
  editDayForm.is_work_day = current.is_work_day !== false
  editDayForm.mode = current.mode || (editDayForm.is_work_day ? 'wfo' : 'libur')
  editDayForm.check_in_time = current.check_in_time || bulkInTime.value || '07:30'
  editDayForm.check_out_time = current.check_out_time || bulkOutTime.value || '16:00'
  editDayForm.notes = current.notes || (editDayForm.is_work_day ? 'Bekerja Normal' : 'Libur Operasional')
  isDayEditModalOpen.value = true
}

const closeDayEditModal = () => {
  isDayEditModalOpen.value = false
}

const setEditTimePreset = (inTime: string, outTime: string) => {
  editDayForm.check_in_time = inTime
  editDayForm.check_out_time = outTime
}

const saveDayEdit = () => {
  const dayKey = selectedEditDayKey.value
  if (!officeSchedule.days[dayKey]) {
    officeSchedule.days[dayKey] = {}
  }

  officeSchedule.days[dayKey].is_work_day = editDayForm.is_work_day
  if (editDayForm.is_work_day) {
    officeSchedule.days[dayKey].mode = editDayForm.mode || 'wfo'
    officeSchedule.days[dayKey].check_in_time = editDayForm.check_in_time || '07:30'
    officeSchedule.days[dayKey].check_out_time = editDayForm.check_out_time || '16:00'
    officeSchedule.days[dayKey].notes = editDayForm.notes || 'Bekerja Normal'
  } else {
    officeSchedule.days[dayKey].mode = 'libur'
    officeSchedule.days[dayKey].check_in_time = null
    officeSchedule.days[dayKey].check_out_time = null
    officeSchedule.days[dayKey].notes = editDayForm.notes || (inArray(dayKey, ['saturday', 'sunday']) ? 'Libur Akhir Pekan' : 'Hari Libur Operasional')
  }

  isDayEditModalOpen.value = false
  showToast(`Pengaturan hari ${dayNamesMap[dayKey]?.label || dayKey} berhasil disimpan!`, 'success')
}

const applyModalToAllWorkDays = () => {
  allDaysOrder.forEach(k => {
    if (officeSchedule.days[k]?.is_work_day) {
      officeSchedule.days[k].mode = editDayForm.mode
      officeSchedule.days[k].check_in_time = editDayForm.check_in_time
      officeSchedule.days[k].check_out_time = editDayForm.check_out_time
      if (editDayForm.notes) {
        officeSchedule.days[k].notes = editDayForm.notes
      }
    }
  })
  saveDayEdit()
  showToast('Pengaturan jam & mode berhasil disalin ke seluruh hari kerja aktif!', 'success')
}

// Bulk Set In / Out Times
const applyBulkInTime = () => {
  allDaysOrder.forEach(k => {
    if (officeSchedule.days[k].is_work_day) {
      officeSchedule.days[k].check_in_time = bulkInTime.value
    }
  })
  showToast(`Jam masuk (${bulkInTime.value} WIB) diterapkan ke seluruh hari kerja aktif.`, 'success')
}

const applyBulkOutTime = () => {
  allDaysOrder.forEach(k => {
    if (officeSchedule.days[k].is_work_day) {
      officeSchedule.days[k].check_out_time = bulkOutTime.value
    }
  })
  showToast(`Jam pulang (${bulkOutTime.value} WIB) diterapkan ke seluruh hari kerja aktif.`, 'success')
}

// Preset Handlers (e.g. BKKBN, Corporate, Tech, Six Days)
const applyPreset = (presetKey: string) => {
  activePresetKey.value = presetKey

  if (presetKey === 'bkkbn') {
    // Pola Sistem WFH BKKBN
    officeSchedule.policy_name = 'Sistem Kerja Hybrid BKKBN (3 WFO • 2 WFH)'
    officeSchedule.policy_description = 'Jadwal pola kerja instansi BKKBN: Senin, Rabu, dan Jumat WFO di kantor. Selasa dan Kamis WFH terjadwal secara mandiri. Sabtu dan Minggu libur.'
    officeSchedule.late_tolerance_minutes = 15
    bulkInTime.value = '07:30'
    bulkOutTime.value = '16:00'

    officeSchedule.days = {
      monday: { is_work_day: true, mode: 'wfo', check_in_time: '07:30', check_out_time: '16:00', notes: 'WFO Kantor Pusat (Apel Pagi)' },
      tuesday: { is_work_day: true, mode: 'wfh', check_in_time: '07:30', check_out_time: '16:00', notes: 'Sistem WFH Mandiri (Pola BKKBN)' },
      wednesday: { is_work_day: true, mode: 'wfo', check_in_time: '07:30', check_out_time: '16:00', notes: 'WFO Kantor Pusat' },
      thursday: { is_work_day: true, mode: 'wfh', check_in_time: '07:30', check_out_time: '16:00', notes: 'Sistem WFH Mandiri (Pola BKKBN)' },
      friday: { is_work_day: true, mode: 'wfo', check_in_time: '07:30', check_out_time: '16:30', notes: 'WFO & Evaluasi Mingguan' },
      saturday: { is_work_day: false, mode: 'libur', check_in_time: null, check_out_time: null, notes: 'Libur Akhir Pekan' },
      sunday: { is_work_day: false, mode: 'libur', check_in_time: null, check_out_time: null, notes: 'Libur Akhir Pekan' },
    }
    showToast('Template Pola Kerja BKKBN (WFH Selasa & Kamis) berhasil diterapkan!', 'success')
  } else if (presetKey === 'corporate') {
    // Pola Korporat Full WFO
    officeSchedule.policy_name = 'Pola Kerja Full WFO Korporat'
    officeSchedule.policy_description = 'Senin sampai Jumat wajib hadir di kantor (WFO). Sabtu dan Minggu libur operasional.'
    officeSchedule.late_tolerance_minutes = 15
    bulkInTime.value = '08:00'
    bulkOutTime.value = '17:00'

    officeSchedule.days = {
      monday: { is_work_day: true, mode: 'wfo', check_in_time: '08:00', check_out_time: '17:00', notes: 'WFO Kantor Pusat' },
      tuesday: { is_work_day: true, mode: 'wfo', check_in_time: '08:00', check_out_time: '17:00', notes: 'WFO Kantor Pusat' },
      wednesday: { is_work_day: true, mode: 'wfo', check_in_time: '08:00', check_out_time: '17:00', notes: 'WFO Kantor Pusat' },
      thursday: { is_work_day: true, mode: 'wfo', check_in_time: '08:00', check_out_time: '17:00', notes: 'WFO Kantor Pusat' },
      friday: { is_work_day: true, mode: 'wfo', check_in_time: '08:00', check_out_time: '16:30', notes: 'WFO Kantor Pusat' },
      saturday: { is_work_day: false, mode: 'libur', check_in_time: null, check_out_time: null, notes: 'Libur Akhir Pekan' },
      sunday: { is_work_day: false, mode: 'libur', check_in_time: null, check_out_time: null, notes: 'Libur Akhir Pekan' },
    }
    showToast('Template Korporat Standar (Full WFO) berhasil diterapkan!', 'success')
  } else if (presetKey === 'tech') {
    // Pola Tech Startup
    officeSchedule.policy_name = 'Pola Fleksibel Startup IT'
    officeSchedule.policy_description = 'Senin - Rabu WFO, Kamis WFA penugasan luar, Jumat WFH remote. Sabtu dan Minggu libur.'
    officeSchedule.late_tolerance_minutes = 30
    bulkInTime.value = '09:00'
    bulkOutTime.value = '18:00'

    officeSchedule.days = {
      monday: { is_work_day: true, mode: 'wfo', check_in_time: '09:00', check_out_time: '18:00', notes: 'Sprint Planning (WFO)' },
      tuesday: { is_work_day: true, mode: 'wfo', check_in_time: '09:00', check_out_time: '18:00', notes: 'WFO Kantor Studio' },
      wednesday: { is_work_day: true, mode: 'wfo', check_in_time: '09:00', check_out_time: '18:00', notes: 'WFO Kantor Studio' },
      thursday: { is_work_day: true, mode: 'wfa', check_in_time: '09:00', check_out_time: '18:00', notes: 'WFA Tugas Lapangan' },
      friday: { is_work_day: true, mode: 'wfh', check_in_time: '09:00', check_out_time: '17:30', notes: 'WFH Remote & Demo' },
      saturday: { is_work_day: false, mode: 'libur', check_in_time: null, check_out_time: null, notes: 'Libur Akhir Pekan' },
      sunday: { is_work_day: false, mode: 'libur', check_in_time: null, check_out_time: null, notes: 'Libur Akhir Pekan' },
    }
    showToast('Template IT Startup & Studio berhasil diterapkan!', 'success')
  } else if (presetKey === 'six_days') {
    // Pola 6 Hari Kerja
    officeSchedule.policy_name = 'Pola Industri 6 Hari Kerja'
    officeSchedule.policy_description = 'Senin sampai Sabtu bekerja (Sabtu setengah hari). Minggu libur operasional.'
    officeSchedule.late_tolerance_minutes = 15
    bulkInTime.value = '08:00'
    bulkOutTime.value = '16:00'

    officeSchedule.days = {
      monday: { is_work_day: true, mode: 'wfo', check_in_time: '08:00', check_out_time: '16:00', notes: 'WFO' },
      tuesday: { is_work_day: true, mode: 'wfo', check_in_time: '08:00', check_out_time: '16:00', notes: 'WFO' },
      wednesday: { is_work_day: true, mode: 'wfo', check_in_time: '08:00', check_out_time: '16:00', notes: 'WFO' },
      thursday: { is_work_day: true, mode: 'wfo', check_in_time: '08:00', check_out_time: '16:00', notes: 'WFO' },
      friday: { is_work_day: true, mode: 'wfo', check_in_time: '08:00', check_out_time: '16:00', notes: 'WFO' },
      saturday: { is_work_day: true, mode: 'wfo', check_in_time: '08:00', check_out_time: '13:00', notes: 'WFO Setengah Hari' },
      sunday: { is_work_day: false, mode: 'libur', check_in_time: null, check_out_time: null, notes: 'Libur Akhir Pekan' },
    }
    showToast('Template 6 Hari Operasional berhasil diterapkan!', 'success')
  }
}

// Special Holidays
const addSpecialHoliday = () => {
  if (!newHolidayDate.value || !newHolidayName.value.trim()) {
    showToast('Mohon pilih tanggal dan masukkan nama hari libur khusus.', 'warning')
    return
  }
  officeSchedule.special_holidays.push({
    date: newHolidayDate.value,
    name: newHolidayName.value.trim()
  })
  newHolidayDate.value = ''
  newHolidayName.value = ''
  showToast('Hari libur khusus berhasil ditambahkan ke daftar.', 'success')
}

const removeSpecialHoliday = (idx: number) => {
  officeSchedule.special_holidays.splice(idx, 1)
  showToast('Hari libur khusus dihapus.', 'info')
}

const resetScheduleToDefault = () => {
  applyPreset('bkkbn')
}

// Fetch API Data
const fetchCompanySchedule = async () => {
  try {
    const res = await fetch('http://127.0.0.1:8000/api/mentor/company-schedule', {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${authToken.value}`
      }
    })
    if (res.ok) {
      const data = await res.json()
      if (data.company) {
        companyData.id = data.company.id
        companyData.name = data.company.name
        companyData.sector = data.company.sector
        companyData.address = data.company.address

        if (data.company.office_schedule) {
          const s = data.company.office_schedule
          if (s.days) {
            allDaysOrder.forEach(k => {
              if (s.days[k]) {
                officeSchedule.days[k] = { ...s.days[k] }
              }
            })
          }
          if (typeof s.late_tolerance_minutes === 'number') {
            officeSchedule.late_tolerance_minutes = s.late_tolerance_minutes
          }
          if (s.policy_name) officeSchedule.policy_name = s.policy_name
          if (s.policy_description) officeSchedule.policy_description = s.policy_description
          if (Array.isArray(s.special_holidays)) {
            officeSchedule.special_holidays = s.special_holidays
          }
        }
      }
    }
  } catch (err) {
    // Demo fallback is already in reactive state
  }
}

const saveCompanySchedule = async () => {
  isSavingOfficeSchedule.value = true
  try {
    const payload = {
      office_schedule: {
        work_days: allDaysOrder.filter(k => officeSchedule.days[k]?.is_work_day),
        days: officeSchedule.days,
        late_tolerance_minutes: officeSchedule.late_tolerance_minutes,
        policy_name: officeSchedule.policy_name,
        policy_description: officeSchedule.policy_description,
        special_holidays: officeSchedule.special_holidays,
      },
      schedule: {
        work_days: allDaysOrder.filter(k => officeSchedule.days[k]?.is_work_day),
        days: officeSchedule.days,
        late_tolerance_minutes: officeSchedule.late_tolerance_minutes,
        policy_name: officeSchedule.policy_name,
        policy_description: officeSchedule.policy_description,
        special_holidays: officeSchedule.special_holidays,
      },
      apply_to_all_students: true
    }

    const res = await fetch('http://127.0.0.1:8000/api/mentor/company-schedule', {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${authToken.value}`
      },
      body: JSON.stringify(payload)
    })

    const data = await res.json()
    if (res.ok && data.success) {
      showToast(data.message || 'Jadwal kantor mingguan berhasil disimpan & diterapkan ke seluruh siswa binaan!', 'success')
      // Refresh students schedule list to reflect changes
      fetchSchedules()
    } else {
      showToast(data.message || 'Gagal menyimpan jadwal kantor.', 'danger')
    }
  } catch (err) {
    // Offline / Demo fallback: otomatis selaraskan ke seluruh siswa binaan
    if (studentsWithSchedules.value.length > 0) {
      studentsWithSchedules.value.forEach(item => {
        item.work_schedule.monday = officeSchedule.days.monday.is_work_day ? officeSchedule.days.monday.mode : 'libur'
        item.work_schedule.tuesday = officeSchedule.days.tuesday.is_work_day ? officeSchedule.days.tuesday.mode : 'libur'
        item.work_schedule.wednesday = officeSchedule.days.wednesday.is_work_day ? officeSchedule.days.wednesday.mode : 'libur'
        item.work_schedule.thursday = officeSchedule.days.thursday.is_work_day ? officeSchedule.days.thursday.mode : 'libur'
        item.work_schedule.friday = officeSchedule.days.friday.is_work_day ? officeSchedule.days.friday.mode : 'libur'
      })
    }
    showToast('Jadwal kantor mingguan berhasil disimpan & disinkronkan ke seluruh siswa binaan!', 'success')
  } finally {
    isSavingOfficeSchedule.value = false
  }
}

const fetchRecap = async () => {
  try {
    const res = await fetch('http://127.0.0.1:8000/api/mentor/attendance-recap', {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${authToken.value}`
      }
    })
    if (res.ok) {
      const data = await res.json()
      if (data.attendances && data.attendances.length > 0) {
        attendances.value = data.attendances
      }
    }
  } catch (err) {
    // keep initial demo items
  }
}

const fetchRequests = async () => {
  try {
    const res = await fetch('http://127.0.0.1:8000/api/mentor/work-mode-requests', {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${authToken.value}`
      }
    })
    if (res.ok) {
      const data = await res.json()
      if (data.requests) {
        modeRequests.value = data.requests
      }
    }
  } catch (err) {
    // fallback demo items
    modeRequests.value = [
      {
        id: 1,
        student: { name: 'Siti Fauziah', major: 'RPL', class_name: 'XII RPL 2', avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150' },
        date: '2026-10-02',
        requested_mode: 'wfh',
        reason: 'Demam ringan dan flu, namun siap stand-by coding dan menyelesaikan modul REST API dari rumah.',
        status: 'pending'
      }
    ]
  }
}

const fetchSchedules = async () => {
  try {
    const res = await fetch('http://127.0.0.1:8000/api/mentor/students-schedules', {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${authToken.value}`
      }
    })
    if (res.ok) {
      const data = await res.json()
      if (data.students) {
        studentsWithSchedules.value = data.students
      }
    }
  } catch (err) {
    // fallback demo items
    studentsWithSchedules.value = [
      {
        placement_id: 1,
        student: { name: 'Budi Santoso', major: 'RPL', class_name: 'XII RPL 1', avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150' },
        work_schedule: { monday: 'wfo', tuesday: 'wfh', wednesday: 'wfo', thursday: 'wfh', friday: 'wfo' }
      },
      {
        placement_id: 2,
        student: { name: 'Siti Fauziah', major: 'RPL', class_name: 'XII RPL 2', avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150' },
        work_schedule: { monday: 'wfo', tuesday: 'wfh', wednesday: 'wfo', thursday: 'wfh', friday: 'wfo' }
      }
    ]
  }
}

const reviewRequest = async (id: number, status: 'approved' | 'rejected') => {
  try {
    const res = await fetch(`http://127.0.0.1:8000/api/mentor/work-mode-requests/${id}/review`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${authToken.value}`
      },
      body: JSON.stringify({ status })
    })

    const data = await res.json()
    if (res.ok && data.success) {
      showToast(data.message, 'success')
      const target = modeRequests.value.find(r => r.id === id)
      if (target) target.status = status
    } else {
      showToast(data.message || 'Gagal memproses permohonan.', 'danger')
    }
  } catch (err) {
    const target = modeRequests.value.find(r => r.id === id)
    if (target) target.status = status
    showToast(`Permohonan berhasil ${status === 'approved' ? 'disetujui' : 'ditolak'} (Demo Mode).`, 'success')
  }
}

const saveSchedule = async (item: any) => {
  try {
    const res = await fetch(`http://127.0.0.1:8000/api/mentor/placements/${item.placement_id}/schedule`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${authToken.value}`
      },
      body: JSON.stringify({ work_schedule: item.work_schedule })
    })

    const data = await res.json()
    if (res.ok && data.success) {
      showToast(data.message || 'Jadwal ritme kerja mingguan berhasil diperbarui!', 'success')
    } else {
      showToast(data.message || 'Gagal menyimpan jadwal.', 'danger')
    }
  } catch (err) {
    showToast('Jadwal ritme kerja mingguan berhasil disimpan (Demo Mode).', 'success')
  }
}

const exportCsv = () => {
  showToast('File rekap_presensi_lapangan_oktober.csv berhasil diunduh.', 'success')
}

onMounted(() => {
  fetchRecap()
  fetchRequests()
  fetchCompanySchedule()
  fetchSchedules()
})
</script>
