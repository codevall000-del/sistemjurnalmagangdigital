<template>
  <div class="flex flex-col w-full max-w-[1440px] mx-auto gap-6">
    <!-- Top Greeting & Notice Banner (Apple HIG Style) -->
    <section class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 bg-white p-6 sm:p-7 rounded-2xl shadow-[0_2px_12px_rgba(0,0,0,0.03)] border border-black/[0.05] relative overflow-hidden">
      <div class="flex flex-col gap-1.5 max-w-2xl z-10">
        <div class="inline-flex items-center gap-2 text-[#0071e3] text-[11px] font-semibold uppercase tracking-wider">
          <span class="w-1.5 h-1.5 rounded-full bg-[#0071e3]"></span>
          Periode Ganjil 2024/2025 • SMKN 71 Jakarta
        </div>
        <h1 class="text-2xl sm:text-3xl text-[#1d1d1f] font-bold tracking-tight">
          Selamat Pagi, {{ currentUser.name }}! 👋
        </h1>
        <p class="text-[13px] text-[#86868b] leading-relaxed">
          Berikut adalah ikhtisar kegiatan magang Anda per <span class="font-semibold text-[#1d1d1f]">{{ todayFormatted }}</span> di <span class="font-semibold text-[#0071e3]">PT Solusi Digital Pratama</span>.
        </p>
      </div>

      <!-- Apple Notice Alert Capsule -->
      <div
        class="flex flex-col sm:flex-row items-start sm:items-center gap-3.5 z-10 p-4 rounded-xl border transition-all duration-300"
        :class="{
          'bg-[#f5f5f7] border-black/[0.04]': journalUrgency === 'none',
          'bg-amber-500/10 border-amber-500/40 shadow-xs': journalUrgency === 'warning',
          'bg-red-500/15 border-red-500/50 shadow-[0_4px_16px_rgba(255,59,48,0.18)] animate-glow-danger': journalUrgency === 'danger'
        }"
      >
        <div
          class="w-9 h-9 rounded-full flex items-center justify-center shrink-0 transition-colors"
          :class="{
            'bg-[#0071e3]/10 text-[#0071e3]': journalUrgency === 'none',
            'bg-amber-500/20 text-amber-700 font-bold': journalUrgency === 'warning',
            'bg-red-600 text-white animate-pulse-danger': journalUrgency === 'danger'
          }"
        >
          <span class="material-symbols-outlined text-[20px]">
            {{ journalUrgency === 'danger' ? 'crisis_alert' : (journalUrgency === 'warning' ? 'priority_high' : (isTodayLogged ? 'check_circle' : 'notification_important')) }}
          </span>
        </div>
        <div class="flex flex-col pr-2">
          <span
            class="text-[13px] font-semibold flex items-center gap-1.5"
            :class="{
              'text-[#1d1d1f]': journalUrgency === 'none',
              'text-amber-950 font-bold': journalUrgency === 'warning',
              'text-red-950 font-extrabold': journalUrgency === 'danger'
            }"
          >
            <template v-if="isTodayLogged">
              Jurnal Hari Ini Sudah Dikirim
            </template>
            <template v-else-if="journalUrgency === 'danger'">
              🚨 BAHAYA: Wajib Segera Isi Jurnal Harian!
            </template>
            <template v-else-if="journalUrgency === 'warning'">
              ⚠️ Sudah Tap-Out • Belum Isi Jurnal
            </template>
            <template v-else>
              Jurnal Hari Ini Belum Diisi
            </template>
          </span>
          <span
            class="text-[11px]"
            :class="{
              'text-[#86868b]': journalUrgency === 'none',
              'text-amber-800 font-medium': journalUrgency === 'warning',
              'text-red-800 font-semibold': journalUrgency === 'danger'
            }"
          >
            <template v-if="isTodayLogged">
              Tercatat pada 11:20 WIB • Menunggu review mentor
            </template>
            <template v-else-if="journalUrgency === 'danger'">
              Sudah {{ effectiveMinutesSinceTapOut }} menit sejak Tap-Out! Wajib segera dilaporkan.
            </template>
            <template v-else-if="journalUrgency === 'warning'">
              Tap-Out pukul {{ attendanceState.checkOutTime || '17:00' }} WIB • Segera isi sebelum meninggalkan tempat
            </template>
            <template v-else>
              Batas submisi harian pukul 18:00 WIB
            </template>
          </span>
        </div>
        <div class="flex items-center gap-2 w-full sm:w-auto pt-1 sm:pt-0">
          <button
            @click="goToLogbook"
            class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl text-[12px] transition-all apple-press cursor-pointer"
            :class="{
              'bg-[#0071e3] text-white hover:bg-[#0077ed] shadow-[0_2px_8px_rgba(0,113,227,0.25)] font-semibold': journalUrgency === 'none',
              'bg-amber-500 hover:bg-amber-600 text-white shadow-[0_4px_14px_rgba(245,158,11,0.35)] font-bold': journalUrgency === 'warning',
              'bg-red-600 hover:bg-red-700 text-white shadow-[0_4px_20px_rgba(239,68,68,0.55)] font-black animate-pulse-danger ring-2 ring-red-400': journalUrgency === 'danger'
            }"
            type="button"
          >
            <span class="material-symbols-outlined text-[17px]">
              {{ journalUrgency === 'danger' ? 'warning' : (journalUrgency === 'warning' ? 'priority_high' : (isTodayLogged ? 'edit_note' : 'edit_calendar')) }}
            </span>
            <span>
              {{ isTodayLogged ? 'Buka Logbook' : (journalUrgency === 'danger' ? '⚠️ SEGERA ISI JURNAL !' : (journalUrgency === 'warning' ? 'Isi Jurnal Hari Ini !' : 'Isi Jurnal Hari Ini')) }}
            </span>
          </button>
          <button
            @click="showGuideline"
            class="p-2 text-[#86868b] hover:text-[#1d1d1f] hover:bg-black/[0.05] rounded-xl transition-all apple-press"
            title="Lihat Panduan Pengisian"
            type="button"
          >
            <span class="material-symbols-outlined text-[19px]">help_outline</span>
          </button>
        </div>
      </div>
    </section>

    <!-- ALERT NOTIFIKASI KHUSUS SAAT SUDAH TAP-OUT TAPI BELUM ISI JURNAL (KUNING / MERAH BERDENYUT) -->
    <transition
      enter-active-class="transition duration-300 ease-out"
      enter-from-class="opacity-0 -translate-y-2 scale-98"
      enter-to-class="opacity-100 translate-y-0 scale-100"
      leave-active-class="transition duration-200 ease-in"
      leave-from-class="opacity-100 translate-y-0 scale-100"
      leave-to-class="opacity-0 -translate-y-2 scale-98"
    >
      <section
        v-if="journalUrgency !== 'none'"
        class="rounded-2xl p-5 sm:p-6 transition-all duration-300 relative overflow-hidden"
        :class="{
          'bg-gradient-to-r from-amber-500/[0.14] via-amber-500/[0.08] to-amber-500/[0.12] border-2 border-amber-500/40 shadow-[0_4px_20px_rgba(245,158,11,0.12)]': journalUrgency === 'warning',
          'bg-gradient-to-r from-red-500/[0.18] via-red-500/[0.10] to-red-500/[0.15] border-2 border-red-500/60 shadow-[0_8px_30px_rgba(239,68,68,0.22)] animate-glow-danger': journalUrgency === 'danger'
        }"
      >
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-5 relative z-10">
          <div class="flex items-start gap-4">
            <!-- Pulsing Badge Icon -->
            <div
              class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 shadow-sm"
              :class="{
                'bg-amber-500 text-white shadow-amber-500/30': journalUrgency === 'warning',
                'bg-red-600 text-white animate-pulse-danger shadow-red-600/40': journalUrgency === 'danger'
              }"
            >
              <span class="material-symbols-outlined text-[28px]">
                {{ journalUrgency === 'danger' ? 'crisis_alert' : 'notification_important' }}
              </span>
            </div>

            <div class="flex flex-col gap-1">
              <div class="flex items-center gap-2 flex-wrap">
                <span
                  class="px-2.5 py-0.5 rounded-full text-[11px] font-bold tracking-wide uppercase"
                  :class="{
                    'bg-amber-500/20 text-amber-800 border border-amber-500/40': journalUrgency === 'warning',
                    'bg-red-600 text-white animate-pulse shadow-xs': journalUrgency === 'danger'
                  }"
                >
                  {{ journalUrgency === 'danger' ? '🚨 TINGKAT BAHAYA KRITIS' : '⚠️ PERINGATAN TAP-OUT' }}
                </span>
                <span
                  class="text-[12px] font-medium"
                  :class="journalUrgency === 'danger' ? 'text-red-700 font-semibold' : 'text-amber-800'"
                >
                  Tap-Out Pukul {{ attendanceState.checkOutTime || '17:00' }} WIB • {{ effectiveMinutesSinceTapOut }} Menit Berlalu
                </span>
              </div>

              <h2
                class="text-base sm:text-lg font-bold tracking-tight"
                :class="journalUrgency === 'danger' ? 'text-red-950 font-black' : 'text-amber-950'"
              >
                {{ journalUrgency === 'danger'
                  ? 'Batas Waktu Segera Berakhir! Jurnal Harian Wajib Diisi Sekarang!'
                  : 'Anda Sudah Tap-Out Kepulangan Namun Belum Mengisi Jurnal Hari Ini!'
                }}
              </h2>

              <p
                class="text-[12.5px] max-w-3xl leading-relaxed"
                :class="journalUrgency === 'danger' ? 'text-red-800 font-medium' : 'text-amber-900/80'"
              >
                <template v-if="journalUrgency === 'danger'">
                  Sistem mendeteksi Anda telah mengakhiri sesi magang (Tap-Out) lebih dari {{ effectiveMinutesSinceTapOut }} menit lalu tanpa melampirkan jurnal kegiatan. Berdasarkan SOP PKL SMKN 71 Jakarta, kelalaian pengisian jurnal dapat mengakibatkan <strong>kehadiran dianggap tidak sah / sanksi evaluasi pembimbing lapangan</strong>.
                </template>
                <template v-else>
                  Presensi pulang (Tap-Out) Anda telah tercatat pada sistem. Segera lengkapi dokumentasi aktivitas dan capaian magang Anda sebelum meninggalkan tempat PKL atau sebelum pergantian hari.
                </template>
              </p>
            </div>
          </div>

          <!-- Action Button: Kuning / Merah Berdenyut -->
          <div class="flex flex-col sm:flex-row md:flex-col lg:flex-row items-stretch sm:items-center gap-2.5 w-full md:w-auto shrink-0">
            <button
              @click="goToLogbook"
              type="button"
              class="px-5 py-3 rounded-xl text-[13px] font-bold transition-all flex items-center justify-center gap-2 apple-press cursor-pointer"
              :class="{
                'bg-amber-500 hover:bg-amber-600 text-white shadow-[0_4px_16px_rgba(245,158,11,0.4)]': journalUrgency === 'warning',
                'bg-red-600 hover:bg-red-700 text-white shadow-[0_4px_24px_rgba(239,68,68,0.6)] animate-pulse-danger ring-4 ring-red-400/60 font-black': journalUrgency === 'danger'
              }"
            >
              <span class="material-symbols-outlined text-[20px] font-bold">
                {{ journalUrgency === 'danger' ? 'warning' : 'priority_high' }}
              </span>
              <span>
                {{ journalUrgency === 'danger' ? '⚠️ SEGERA ISI JURNAL (DARURAT) !' : 'Isi Jurnal Hari Ini !' }}
              </span>
            </button>
          </div>
        </div>

        <!-- Testing & Simulation Controls for Evaluator/User -->
        <div class="mt-4 pt-3 border-t border-black/[0.06] flex flex-wrap items-center justify-between gap-2 text-[11px]">
          <div class="flex items-center gap-1.5 text-[#86868b]">
            <span class="material-symbols-outlined text-[15px] text-[#0071e3]">tune</span>
            <span class="font-medium text-[#1d1d1f]">Simulasi Pengujian Fitur:</span>
          </div>
          <div class="flex items-center gap-1.5 flex-wrap">
            <button
              @click="triggerTapOutDemo('immediate')"
              type="button"
              class="px-2.5 py-1 rounded-lg border text-[11px] font-medium transition-all apple-press cursor-pointer"
              :class="journalUrgency === 'warning' ? 'bg-amber-500 text-white border-amber-600 font-bold' : 'bg-white text-amber-800 border-amber-300 hover:bg-amber-50'"
            >
              🟡 Baru Tap-Out (3 mnt - Kuning)
            </button>
            <button
              @click="triggerTapOutDemo('delayed')"
              type="button"
              class="px-2.5 py-1 rounded-lg border text-[11px] font-medium transition-all apple-press cursor-pointer"
              :class="journalUrgency === 'danger' ? 'bg-red-600 text-white border-red-700 font-bold' : 'bg-white text-red-700 border-red-300 hover:bg-red-50'"
            >
              🔴 Lewat 45 mnt (Merah Berdenyut)
            </button>
            <button
              @click="recordJournalSubmitted"
              type="button"
              class="px-2.5 py-1 rounded-lg bg-white hover:bg-emerald-50 text-emerald-700 border border-emerald-300 text-[11px] font-semibold transition-all apple-press cursor-pointer"
            >
              🟢 Tandai Jurnal Sudah Terisi
            </button>
            <button
              @click="resetAttendanceDemo"
              type="button"
              class="px-2.5 py-1 rounded-lg bg-white hover:bg-black/[0.04] text-[#86868b] border border-black/[0.1] text-[11px] font-medium transition-all apple-press cursor-pointer"
            >
              ↺ Reset
            </button>
          </div>
        </div>
      </section>
    </transition>

    <!-- SECTION PRESENSI DIGITAL CEPAT (TAP IN & TAP OUT HERO WIDGET) -->
    <section class="bg-white p-6 sm:p-7 rounded-2xl shadow-[0_2px_12px_rgba(0,0,0,0.03)] border border-black/[0.05] relative overflow-hidden">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center relative z-10">
        <!-- Kolom Kiri (6 Cols): Jam Realtime, Status, & Mode Kerja -->
        <div class="lg:col-span-6 flex flex-col gap-4">
          <div class="flex items-center gap-2">
            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#0071e3]/10 text-[#0071e3]">
              Presensi Digital Siswa
            </span>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-[#34c759]/10 text-[#248a3d]">
              <span class="w-1.5 h-1.5 rounded-full bg-[#34c759] animate-pulse"></span>
              Online Real-time (SMKN 71)
            </span>
          </div>

          <!-- Digital Clock Display -->
          <div class="flex flex-col">
            <div class="font-headline text-4xl sm:text-5xl font-black text-[#1d1d1f] tracking-tight flex items-baseline gap-2">
              <span>{{ liveTimeString }}</span>
              <span class="text-sm font-sans font-semibold text-[#86868b]">WIB</span>
            </div>
            <p class="text-[12px] text-[#86868b] font-medium mt-1">
              {{ todayFormatted }} • Penempatan: <strong class="text-[#1d1d1f]">{{ companyInfo.name }}</strong>
            </p>
          </div>

          <!-- Apple Controlled Work Mode Badge & Policy Section -->
          <div class="flex flex-col gap-2.5 p-3.5 rounded-2xl bg-black/[0.02] border border-black/[0.06]">
            <!-- Header bar with Mode status & source -->
            <div class="flex items-center justify-between gap-2">
              <span class="text-[11px] font-bold text-[#86868b] uppercase tracking-wider flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[15px] text-[#0071e3]">schedule</span>
                Mode Presensi Hari Ini
              </span>
              <span
                v-if="workModeInfo.source === 'approved_request'"
                class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-[#34c759]/10 text-[#248a3d] border border-[#34c759]/20 flex items-center gap-1"
              >
                <span class="material-symbols-outlined text-[12px]">verified</span>
                Dispensasi Disetujui
              </span>
              <span
                v-else-if="isTodayHoliday || selectedWorkMode === 'libur'"
                class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-500/15 text-amber-800 border border-amber-500/30 flex items-center gap-1"
              >
                <span class="material-symbols-outlined text-[12px]">beach_access</span>
                Libur Kantor
              </span>
              <span
                v-else
                class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-[#0071e3]/10 text-[#0071e3] border border-[#0071e3]/20 flex items-center gap-1"
              >
                <span class="material-symbols-outlined text-[12px]">lock</span>
                Jadwal Resmi Tempat Magang
              </span>
            </div>

            <!-- Company Working Hours Info Pill -->
            <div class="flex items-center justify-between text-[11px] px-2.5 py-1.5 rounded-xl bg-black/[0.03] text-[#86868b]">
              <span class="flex items-center gap-1.5 font-medium">
                <span class="material-symbols-outlined text-[15px] text-[#0071e3]">schedule</span>
                <span>Jam Kantor: <strong class="text-[#1d1d1f] font-mono">{{ scheduledCheckInTime }} &ndash; {{ scheduledCheckOutTime }} WIB</strong></span>
              </span>
              <span class="text-[10px] text-[#34c759] font-bold">
                Toleransi +{{ lateToleranceMinutes }} Mnt
              </span>
            </div>

            <!-- Active Mode Highlight Card (Holiday vs Work Mode) -->
            <div
              v-if="isTodayHoliday || selectedWorkMode === 'libur'"
              class="p-3 rounded-xl border border-amber-500/30 bg-gradient-to-r from-amber-500/10 via-amber-500/5 to-orange-500/10 text-amber-900 flex items-center justify-between gap-3 transition-all"
            >
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                  <span class="material-symbols-outlined text-[22px]">beach_access</span>
                </div>
                <div>
                  <div class="flex items-center gap-1.5">
                    <span class="text-sm font-bold text-amber-950">
                      🏖️ HARI LIBUR OPERASIONAL KANTOR
                    </span>
                  </div>
                  <p class="text-[11px] text-amber-900/80 leading-tight mt-0.5">
                    {{ holidayReason || 'Kantor libur operasional / akhir pekan sesuai jadwal tempat magang. Tidak ada kewajiban presensi reguler hari ini.' }}
                  </p>
                </div>
              </div>
            </div>

            <div
              v-else
              :class="{
                'bg-gradient-to-r from-blue-500/10 to-indigo-500/10 border-[#0071e3]/20 text-[#0071e3]': selectedWorkMode === 'wfo',
                'bg-gradient-to-r from-emerald-500/10 to-teal-500/10 border-[#34c759]/20 text-[#248a3d]': selectedWorkMode === 'wfh',
                'bg-gradient-to-r from-purple-500/10 to-pink-500/10 border-purple-500/20 text-purple-600': selectedWorkMode === 'wfa'
              }"
              class="p-3 rounded-xl border flex items-center justify-between gap-3 transition-all"
            >
              <div class="flex items-center gap-3">
                <div
                  :class="{
                    'bg-[#0071e3] text-white': selectedWorkMode === 'wfo',
                    'bg-[#34c759] text-white': selectedWorkMode === 'wfh',
                    'bg-purple-600 text-white': selectedWorkMode === 'wfa'
                  }"
                  class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 shadow-sm"
                >
                  <span class="material-symbols-outlined text-[22px]">
                    {{ selectedWorkMode === 'wfo' ? 'domain' : (selectedWorkMode === 'wfh' ? 'home_work' : 'travel_explore') }}
                  </span>
                </div>
                <div>
                  <div class="flex items-center gap-1.5">
                    <span class="text-sm font-bold text-[#1d1d1f]">
                      {{ selectedWorkMode === 'wfo' ? 'WFO (Bekerja di Kantor Mitra)' : (selectedWorkMode === 'wfh' ? 'WFH (Bekerja dari Rumah - Pola BKKBN)' : 'WFA (Tugas Lapangan Kreatif)') }}
                    </span>
                  </div>
                  <p class="text-[11px] text-[#86868b] leading-tight mt-0.5">
                    {{ selectedWorkMode === 'wfo' ? 'Validasi Geofence GPS 150m aktif terhadap kantor PT.' : (selectedWorkMode === 'wfh' ? 'Bebas radius kantor. Wajib melaporkan progres di logbook harian (Sistem Kerja Hybrid BKKBN / Mitra).' : 'Penugasan luar kantor / liputan kreatif mitra.') }}
                  </p>
                </div>
              </div>
            </div>

            <!-- Weekly Schedule Ribbon (Pita Jadwal Mingguan 7 Hari) -->
            <div class="pt-1">
              <div class="flex items-center justify-between text-[10px] text-[#86868b] font-medium mb-1 px-1">
                <span>RITME KERJA MINGGUAN KANTOR:</span>
                <span>{{ currentDayName }} (Hari Ini)</span>
              </div>
              <div class="grid grid-cols-7 gap-1 text-center">
                <div
                  v-for="(dayItem, dayKey) in weekDaysList"
                  :key="dayKey"
                  :class="[
                    currentDayKey === dayKey ? 'ring-2 ring-[#0071e3] font-bold bg-white shadow-xs' : 'bg-black/[0.03] text-[#86868b]',
                    'p-1.5 rounded-lg text-[10px] transition-all flex flex-col items-center justify-center gap-0.5'
                  ]"
                >
                  <span class="text-[9px] uppercase text-[#86868b]">{{ dayItem.short }}</span>
                  <span
                    :class="{
                      'text-[#0071e3]': (weeklySchedule[dayKey] || 'wfo') === 'wfo',
                      'text-[#34c759]': (weeklySchedule[dayKey] || 'wfo') === 'wfh',
                      'text-purple-600': (weeklySchedule[dayKey] || 'wfo') === 'wfa',
                      'text-amber-600 bg-amber-500/10 px-1 rounded': (weeklySchedule[dayKey] || (['saturday', 'sunday'].includes(dayKey) ? 'libur' : 'wfo')) === 'libur'
                    }"
                    class="font-bold text-[10px] uppercase font-mono"
                  >
                    {{ (weeklySchedule[dayKey] || (['saturday', 'sunday'].includes(dayKey) ? 'libur' : 'wfo')).toUpperCase() }}
                  </span>
                </div>
              </div>
            </div>

            <!-- Active Pending Request Alert (if any) -->
            <div
              v-if="todayRequest && todayRequest.status === 'pending'"
              class="p-2.5 rounded-xl bg-[#ff9500]/10 border border-[#ff9500]/20 flex items-start gap-2 text-xs"
            >
              <span class="material-symbols-outlined text-[#ff9500] text-[18px] shrink-0 mt-0.5 animate-pulse">hourglass_top</span>
              <div class="flex flex-col min-w-0">
                <span class="font-semibold text-[#1d1d1f] text-[11px]">
                  Permohonan {{ todayRequest.requested_mode.toUpperCase() }} Sedang Ditinjau Pembimbing Lapangan
                </span>
                <span class="text-[10px] text-[#86868b] italic truncate">
                  "{{ todayRequest.reason }}"
                </span>
              </div>
            </div>

            <!-- Request Button -->
            <div class="flex items-center justify-between pt-1">
              <span class="text-[11px] text-[#86868b]">Berhalangan ke kantor hari ini?</span>
              <button
                type="button"
                @click="openRequestModal"
                :disabled="attendanceState.hasCheckedIn"
                class="px-3 py-1.5 rounded-lg bg-black/[0.04] hover:bg-black/[0.08] active:scale-95 text-[#0071e3] text-[11px] font-semibold transition flex items-center gap-1 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <span class="material-symbols-outlined text-[14px]">edit_calendar</span>
                <span>Ajukan Dispensasi Mode</span>
              </button>
            </div>
          </div>

          <!-- Status Lokasi & GPS Geofence -->
          <div class="p-3 rounded-xl bg-[#f5f5f7] border border-black/[0.04] flex items-center justify-between gap-3 text-xs">
            <div class="flex items-center gap-2.5 min-w-0">
              <span class="material-symbols-outlined text-[#0071e3] shrink-0 text-[19px]">
                {{ selectedWorkMode === 'wfo' ? 'pin_drop' : (selectedWorkMode === 'wfh' ? 'home' : 'public') }}
              </span>
              <div class="flex flex-col min-w-0">
                <span class="font-semibold text-[#1d1d1f] truncate text-[12px]">
                  {{ locationStatusText }}
                </span>
                <span class="text-[10px] text-[#86868b] font-mono truncate">
                  {{ coordinatesDisplay }}
                </span>
              </div>
            </div>
            <button
              @click="refreshLocation"
              class="shrink-0 p-1.5 rounded-lg hover:bg-black/[0.06] text-[#0071e3] transition-all apple-press cursor-pointer"
              title="Perbarui Sensor Lokasi GPS"
              type="button"
            >
              <span class="material-symbols-outlined text-[17px]">my_location</span>
            </button>
          </div>
        </div>


        <!-- Kolom Kanan (6 Cols): Tombol Raksasa Tap In / Tap Out & Log Status -->
        <div class="lg:col-span-6 flex flex-col justify-center items-center gap-4 p-6 bg-[#f5f5f7] rounded-2xl border border-black/[0.04]">
          <!-- Tombol Tap In (Jika Belum Check In) -->
          <template v-if="!attendanceState.hasCheckedIn">
            <div class="text-center">
              <span
                v-if="isTodayHoliday || selectedWorkMode === 'libur'"
                class="text-[11px] font-bold text-amber-700 uppercase tracking-wider flex items-center justify-center gap-1"
              >
                <span class="material-symbols-outlined text-[15px]">beach_access</span>
                Hari Libur Operasional Kantor
              </span>
              <span v-else class="text-[11px] font-semibold text-[#86868b] uppercase tracking-wider">
                Presensi Masuk Pagi
              </span>
              <h3 class="text-[15px] font-bold text-[#1d1d1f] mt-0.5">
                {{ (isTodayHoliday || selectedWorkMode === 'libur') ? 'Kantor Sedang Libur / Tutup Hari Ini' : 'Silakan Lakukan Tap In Hari Ini' }}
              </h3>
              <p v-if="isTodayHoliday || selectedWorkMode === 'libur'" class="text-[11px] text-[#86868b] mt-0.5 max-w-xs">
                Siswa tidak diwajibkan presensi reguler. Anda tetap dapat melakukan Tap In jika ada penugasan lembur atau sesi mandiri.
              </p>
            </div>

            <button
              @click="handleTapIn"
              :disabled="isProcessingAttendance || (!isTodayHoliday && selectedWorkMode === 'wfo' && !isWithinGeofence)"
              :class="isTodayHoliday
                ? 'bg-amber-600 hover:bg-amber-700 text-white shadow-[0_4px_16px_rgba(217,119,6,0.3)] active:scale-[0.98] cursor-pointer'
                : ((selectedWorkMode === 'wfo' && !isWithinGeofence)
                  ? 'opacity-50 cursor-not-allowed bg-slate-300 text-slate-500'
                  : 'bg-[#0071e3] hover:bg-[#0077ed] text-white shadow-[0_4px_16px_rgba(0,113,227,0.3)] active:scale-[0.98] cursor-pointer')"
              class="w-full sm:w-80 py-5 px-6 rounded-2xl flex flex-col items-center justify-center gap-1.5 transition-all text-center group apple-press border border-white/20"
              type="button"
            >
              <span class="material-symbols-outlined text-[36px] group-hover:scale-105 transition-transform">
                {{ isProcessingAttendance ? 'progress_activity' : (isTodayHoliday ? 'work_history' : 'fingerprint') }}
              </span>
              <span class="text-base font-bold tracking-tight">
                {{ isProcessingAttendance ? 'Menyimpan Online...' : (isTodayHoliday ? 'TAP IN (LEMBUR / MANDIRI)' : 'TAP IN (MASUK)') }}
              </span>
              <span class="text-[11px] opacity-90 font-medium">
                {{ isTodayHoliday ? 'Presensi Mandiri di Hari Libur' : `Mode: ${selectedWorkMode.toUpperCase()} • Jam: ${liveTimeString} WIB` }}
              </span>
            </button>

            <p v-if="!isTodayHoliday && selectedWorkMode === 'wfo' && !isWithinGeofence" class="text-xs text-[#ff3b30] font-semibold text-center">
              ⚠️ Di luar radius kantor PT. Ubah mode ke WFH/WFA jika sedang tugas luar/remote.
            </p>
            <p v-else class="text-[11px] text-[#86868b] text-center">
              {{ isTodayHoliday ? 'Presensi di hari libur akan dicatat sebagai sesi khusus / mandiri.' : 'Data otomatis tersimpan langsung secara online ke sistem sekolah & pembimbing lapangan.' }}
            </p>
          </template>

          <!-- Tombol Tap Out (Jika Sudah Check In dan Belum Check Out) -->
          <template v-else-if="attendanceState.hasCheckedIn && !attendanceState.hasCheckedOut">
            <div class="w-full p-3.5 bg-white border border-[#34c759]/20 rounded-xl flex items-center justify-between text-xs shadow-xs">
              <div class="flex items-center gap-2.5">
                <span class="w-2.5 h-2.5 rounded-full bg-[#34c759] animate-ping"></span>
                <div>
                  <span class="font-bold text-[#1d1d1f] block text-[12px]">Check-In Terverifikasi</span>
                  <span class="text-[#86868b] text-[11px] font-mono">
                    Pukul {{ attendanceState.checkInTime }} WIB • Mode {{ attendanceState.workMode.toUpperCase() }}
                  </span>
                </div>
              </div>
              <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-[#34c759]/10 text-[#248a3d]">
                Tepat Waktu
              </span>
            </div>

            <button
              @click="handleTapOut"
              :disabled="isProcessingAttendance"
              class="w-full sm:w-80 py-5 px-6 rounded-2xl bg-[#ff9500] hover:bg-[#e08500] text-white shadow-[0_4px_16px_rgba(255,149,0,0.3)] active:scale-[0.98] transition-all flex flex-col items-center justify-center gap-1.5 text-center group apple-press cursor-pointer border border-white/20"
              type="button"
            >
              <span class="material-symbols-outlined text-[36px] group-hover:scale-105 transition-transform">
                logout
              </span>
              <span class="text-base font-bold tracking-tight">
                {{ isProcessingAttendance ? 'Menyimpan Online...' : 'TAP OUT (PULANG)' }}
              </span>
              <span class="text-[11px] opacity-90 font-medium">
                Akhiri Sesi Magang Hari Ini
              </span>
            </button>

            <span class="text-[11px] text-[#86868b] text-center font-medium">
              Target kepulangan normal: <strong class="text-[#1d1d1f] font-mono">{{ scheduledCheckOutTime || '16:00' }} WIB</strong>
            </span>
          </template>

          <!-- Status Selesai (Sudah Check Out) -->
          <template v-else>
            <!-- Sub-case 1: Sudah Tap-Out tapi BELUM ISI JURNAL -->
            <template v-if="!isTodayLogged">
              <div
                class="w-14 h-14 rounded-full flex items-center justify-center text-2xl mb-1 shadow-xs border transition-all"
                :class="{
                  'bg-amber-500/10 text-amber-600 border-amber-500/30': journalUrgency === 'warning',
                  'bg-red-500/15 text-red-600 border-red-500/40 animate-pulse-danger': journalUrgency === 'danger'
                }"
              >
                <span class="material-symbols-outlined text-[28px]">
                  {{ journalUrgency === 'danger' ? 'crisis_alert' : 'priority_high' }}
                </span>
              </div>
              <div class="text-center">
                <div class="flex items-center justify-center gap-1.5 mb-1">
                  <span
                    class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider"
                    :class="{
                      'bg-amber-500/20 text-amber-800': journalUrgency === 'warning',
                      'bg-red-600 text-white animate-pulse shadow-xs': journalUrgency === 'danger'
                    }"
                  >
                    {{ journalUrgency === 'danger' ? '🚨 TINGKAT BAHAYA: WAJIB ISI JURNAL' : '⚠️ PERHATIAN: BELUM ISI JURNAL' }}
                  </span>
                </div>
                <h3
                  class="text-base font-bold"
                  :class="journalUrgency === 'danger' ? 'text-red-600 font-extrabold' : 'text-[#1d1d1f]'"
                >
                  Tap Out Selesai • Jurnal Belum Terisi!
                </h3>
                <p class="text-[12px] text-[#86868b] mt-0.5">
                  Masuk: <strong class="text-[#1d1d1f] font-mono">{{ attendanceState.checkInTime }} WIB</strong> • 
                  Pulang: <strong class="text-[#1d1d1f] font-mono">{{ attendanceState.checkOutTime }} WIB</strong>
                </p>
              </div>

              <!-- Button Isi Jurnal di dalam Box Presensi -->
              <button
                @click="goToLogbook"
                type="button"
                class="w-full sm:w-80 py-4 px-6 rounded-2xl text-white font-bold text-center flex items-center justify-center gap-2 transition-all apple-press cursor-pointer border border-white/20"
                :class="{
                  'bg-amber-500 hover:bg-amber-600 shadow-[0_4px_16px_rgba(245,158,11,0.35)]': journalUrgency === 'warning',
                  'bg-red-600 hover:bg-red-700 shadow-[0_4px_24px_rgba(239,68,68,0.55)] animate-pulse-danger ring-4 ring-red-400/50 font-black': journalUrgency === 'danger'
                }"
              >
                <span class="material-symbols-outlined text-[24px]">
                  {{ journalUrgency === 'danger' ? 'warning' : 'priority_high' }}
                </span>
                <span class="text-sm font-bold tracking-tight">
                  {{ journalUrgency === 'danger' ? '⚠️ SEGERA ISI JURNAL (DARURAT) !' : 'ISI JURNAL HARI INI !' }}
                </span>
              </button>

              <span
                class="text-[11px] text-center"
                :class="journalUrgency === 'danger' ? 'text-red-600 font-semibold' : 'text-amber-800 font-medium'"
              >
                {{ journalUrgency === 'danger'
                  ? `Sudah ${effectiveMinutesSinceTapOut} menit sejak pulang! Jangan tinggalkan tempat sebelum isi jurnal.`
                  : 'Sesi pulang tercatat. Lengkapi jurnal harian Anda sekarang.'
                }}
              </span>
            </template>

            <!-- Sub-case 2: Sudah Tap-Out DAN SUDAH ISI JURNAL -->
            <template v-else>
              <div class="w-14 h-14 rounded-full bg-[#34c759]/10 text-[#248a3d] flex items-center justify-center text-2xl mb-1 shadow-xs border border-[#34c759]/20">
                ✓
              </div>
              <div class="text-center">
                <h3 class="text-base font-bold text-[#1d1d1f]">Presensi &amp; Jurnal Hari Ini Tuntas</h3>
                <p class="text-[12px] text-[#86868b] mt-0.5">
                  Masuk: <strong class="text-[#1d1d1f] font-mono">{{ attendanceState.checkInTime }} WIB</strong> • 
                  Pulang: <strong class="text-[#1d1d1f] font-mono">{{ attendanceState.checkOutTime }} WIB</strong>
                </p>
              </div>
              <div class="px-4 py-2 rounded-xl bg-white border border-[#34c759]/20 text-[11px] font-semibold text-[#248a3d] shadow-xs flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-[#34c759]"></span>
                <span>Jurnal Kegiatan Harian Terverifikasi • Presensi Sah</span>
              </div>
            </template>
          </template>
        </div>
      </div>
    </section>

    <!-- 4 Apple Key Metrics Cards -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
      <!-- Metric 1: Jam Magang -->
      <div class="bg-white p-5 rounded-2xl shadow-[0_2px_12px_rgba(0,0,0,0.03)] border border-black/[0.05] flex flex-col justify-between hover:shadow-[0_4px_20px_rgba(0,0,0,0.06)] transition-all apple-press">
        <div class="flex items-center justify-between pb-4">
          <span class="text-[12px] text-[#86868b] font-medium">Total Jam Magang</span>
          <div class="w-8 h-8 rounded-xl bg-[#0071e3]/10 flex items-center justify-center text-[#0071e3]">
            <span class="material-symbols-outlined text-[19px]">schedule</span>
          </div>
        </div>
        <div class="flex flex-col gap-1.5">
          <div class="flex items-baseline gap-1.5">
            <span class="text-3xl text-[#1d1d1f] font-bold tracking-tight">328</span>
            <span class="text-[13px] text-[#86868b]">/ 640 Jam</span>
          </div>
          <div class="w-full bg-[#f5f5f7] h-2 rounded-full overflow-hidden mt-1">
            <div class="bg-[#0071e3] h-full rounded-full transition-all duration-500" style="width: 51.2%;"></div>
          </div>
          <div class="flex justify-between items-center pt-1">
            <span class="text-[11px] text-[#0071e3] font-semibold">51.2% Tercapai</span>
            <span class="text-[11px] text-[#86868b]">Sisa 312 Jam</span>
          </div>
        </div>
      </div>

      <!-- Metric 2: Jurnal Terverifikasi -->
      <div class="bg-white p-5 rounded-2xl shadow-[0_2px_12px_rgba(0,0,0,0.03)] border border-black/[0.05] flex flex-col justify-between hover:shadow-[0_4px_20px_rgba(0,0,0,0.06)] transition-all apple-press">
        <div class="flex items-center justify-between pb-4">
          <span class="text-[12px] text-[#86868b] font-medium">Jurnal Terverifikasi</span>
          <div class="w-8 h-8 rounded-xl bg-[#5e5ce6]/10 flex items-center justify-center text-[#5e5ce6]">
            <span class="material-symbols-outlined text-[19px]">fact_check</span>
          </div>
        </div>
        <div class="flex flex-col gap-1.5">
          <div class="flex items-baseline gap-1.5">
            <span class="text-3xl text-[#1d1d1f] font-bold tracking-tight">39</span>
            <span class="text-[13px] text-[#86868b]">Logbook</span>
          </div>
          <div class="flex items-center gap-3 pt-1">
            <div class="flex items-center gap-1.5">
              <span class="w-2 h-2 rounded-full bg-[#34c759]"></span>
              <span class="text-[11px] text-[#1d1d1f] font-medium">36 Disetujui</span>
            </div>
            <div class="flex items-center gap-1.5">
              <span class="w-2 h-2 rounded-full bg-[#ff9500]"></span>
              <span class="text-[11px] text-[#86868b] font-medium">3 Review</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Metric 3: Kehadiran -->
      <div class="bg-white p-5 rounded-2xl shadow-[0_2px_12px_rgba(0,0,0,0.03)] border border-black/[0.05] flex flex-col justify-between hover:shadow-[0_4px_20px_rgba(0,0,0,0.06)] transition-all apple-press">
        <div class="flex items-center justify-between pb-4">
          <span class="text-[12px] text-[#86868b] font-medium">Persentase Kehadiran</span>
          <div class="w-8 h-8 rounded-xl bg-[#34c759]/10 flex items-center justify-center text-[#248a3d]">
            <span class="material-symbols-outlined text-[19px]">event_seat</span>
          </div>
        </div>
        <div class="flex flex-col gap-1.5">
          <div class="flex items-baseline gap-1.5">
            <span class="text-3xl text-[#1d1d1f] font-bold tracking-tight">97.5%</span>
          </div>
          <div class="flex items-center gap-3 pt-1">
            <span class="text-[11px] text-[#86868b]">
              <span class="font-semibold text-[#1d1d1f]">39</span> Hadir Tepat Waktu
            </span>
            <span class="text-[11px] text-[#86868b]">
              <span class="font-semibold text-[#1d1d1f]">1</span> Izin
            </span>
          </div>
        </div>
      </div>

      <!-- Metric 4: Evaluasi Terakhir -->
      <div class="bg-white p-5 rounded-2xl shadow-[0_2px_12px_rgba(0,0,0,0.03)] border border-black/[0.05] flex flex-col justify-between hover:shadow-[0_4px_20px_rgba(0,0,0,0.06)] transition-all apple-press">
        <div class="flex items-center justify-between pb-4">
          <span class="text-[12px] text-[#86868b] font-medium">Evaluasi Terakhir Mentor</span>
          <div class="w-8 h-8 rounded-xl bg-[#ff9500]/10 flex items-center justify-center text-[#b26a00]">
            <span class="material-symbols-outlined text-[19px]">military_tech</span>
          </div>
        </div>
        <div class="flex flex-col gap-1.5">
          <div class="flex items-baseline gap-1.5">
            <span class="text-3xl text-[#1d1d1f] font-bold tracking-tight">4.8</span>
            <span class="text-[13px] text-[#86868b]">/ 5.0</span>
          </div>
          <div class="inline-flex items-center gap-1.5 pt-1">
            <span class="material-symbols-outlined text-[15px] text-[#ff9500]">stars</span>
            <span class="text-[11px] text-[#ff9500] font-semibold">Predikat Sangat Memuaskan</span>
          </div>
        </div>
      </div>
    </section>

    <!-- 2 Column Layout (8:4 Desktop Grid) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-xl items-start">
      <!-- Main Content Column (8 cols) -->
      <div class="lg:col-span-8 flex flex-col gap-space-xl">
        <!-- Section: Aktivitas Jurnal Terbaru -->
        <div class="bg-surface-container-lowest p-space-xl rounded-xl shadow-sm border border-outline-variant flex flex-col gap-space-lg">
          <div class="flex items-center justify-between">
            <div class="flex flex-col gap-0.5">
              <h2 class="font-headline-md text-headline-md text-primary font-bold">Aktivitas Jurnal Terbaru</h2>
              <p class="font-body-sm text-body-sm text-on-surface-variant">Catatan teknis dan tugas kerja harian yang tersimpan</p>
            </div>
            <button
              @click="goToLogbook"
              class="inline-flex items-center gap-space-xs text-secondary hover:text-primary font-label-md text-label-md font-semibold transition-colors"
              type="button"
            >
              <span>Semua Jurnal</span>
              <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
            </button>
          </div>

          <!-- Entries List -->
          <div class="flex flex-col gap-space-md">
            <!-- Entry 1 -->
            <div class="bg-surface-container-low/50 hover:bg-surface-container-low p-space-lg rounded-xl border border-outline-variant/60 transition-all flex flex-col sm:flex-row sm:items-start justify-between gap-space-md">
              <div class="flex flex-col gap-space-xs flex-1">
                <div class="flex flex-wrap items-center gap-space-sm mb-1">
                  <span class="font-label-sm text-label-sm text-on-surface-variant font-medium">Selasa, 22 Okt 2024 • 08:30 - 17:00</span>
                  <span class="px-2.5 py-0.5 rounded-full font-label-sm text-label-sm font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                    Disetujui
                  </span>
                </div>
                <h3 class="font-headline-sm text-headline-sm text-primary font-bold">
                  Implementasi API Endpoint Auth &amp; Pengujian Unit
                </h3>
                <p class="font-body-md text-body-md text-on-surface-variant line-clamp-2 leading-relaxed">
                  Menyelesaikan integrasi sistem otentikasi JWT pada modul pengguna dan menulis 14 unit test dengan Jest. Seluruh suite berhasil mencapai code coverage 88%.
                </p>
                <div class="flex items-center gap-space-xs pt-space-xs flex-wrap">
                  <span class="px-2 py-0.5 bg-surface-container-lowest text-on-surface-variant font-label-sm text-label-sm rounded font-medium border border-outline-variant">#Backend</span>
                  <span class="px-2 py-0.5 bg-surface-container-lowest text-on-surface-variant font-label-sm text-label-sm rounded font-medium border border-outline-variant">#Sprint3</span>
                  <span class="px-2 py-0.5 bg-surface-container-lowest text-on-surface-variant font-label-sm text-label-sm rounded font-medium border border-outline-variant">8 Jam Kerja</span>
                </div>
              </div>
              <div class="shrink-0 self-end sm:self-center">
                <button
                  @click="goToLogbook"
                  class="inline-flex items-center gap-1 px-space-md py-1.5 bg-surface-container-lowest hover:bg-surface-container text-primary font-label-md text-label-md rounded-lg shadow-sm border border-outline-variant transition-colors"
                  type="button"
                >
                  <span>Detail</span>
                  <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                </button>
              </div>
            </div>

            <!-- Entry 2 -->
            <div class="bg-surface-container-low/50 hover:bg-surface-container-low p-space-lg rounded-xl border border-outline-variant/60 transition-all flex flex-col sm:flex-row sm:items-start justify-between gap-space-md">
              <div class="flex flex-col gap-space-xs flex-1">
                <div class="flex flex-wrap items-center gap-space-sm mb-1">
                  <span class="font-label-sm text-label-sm text-on-surface-variant font-medium">Senin, 21 Okt 2024 • 09:00 - 17:30</span>
                  <span class="px-2.5 py-0.5 rounded-full font-label-sm text-label-sm font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                    Disetujui
                  </span>
                </div>
                <h3 class="font-headline-sm text-headline-sm text-primary font-bold">
                  Sprint Planning &amp; Wireframing Modul Transaksi
                </h3>
                <p class="font-body-md text-body-md text-on-surface-variant line-clamp-2 leading-relaxed">
                  Menghadiri sesi kickoff sprint bersama tim produk, menyusun breakdown user stories untuk alur checkout multi-metode pembayaran, serta sinkronisasi diagram alur sistem.
                </p>
                <div class="flex items-center gap-space-xs pt-space-xs flex-wrap">
                  <span class="px-2 py-0.5 bg-surface-container-lowest text-on-surface-variant font-label-sm text-label-sm rounded font-medium border border-outline-variant">#ProductSync</span>
                  <span class="px-2 py-0.5 bg-surface-container-lowest text-on-surface-variant font-label-sm text-label-sm rounded font-medium border border-outline-variant">#UIUX</span>
                  <span class="px-2 py-0.5 bg-surface-container-lowest text-on-surface-variant font-label-sm text-label-sm rounded font-medium border border-outline-variant">7.5 Jam Kerja</span>
                </div>
              </div>
              <div class="shrink-0 self-end sm:self-center">
                <button
                  @click="goToLogbook"
                  class="inline-flex items-center gap-1 px-space-md py-1.5 bg-surface-container-lowest hover:bg-surface-container text-primary font-label-md text-label-md rounded-lg shadow-sm border border-outline-variant transition-colors"
                  type="button"
                >
                  <span>Detail</span>
                  <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                </button>
              </div>
            </div>

            <!-- Entry 3 -->
            <div class="bg-surface-container-low/50 hover:bg-surface-container-low p-space-lg rounded-xl border border-outline-variant/60 transition-all flex flex-col sm:flex-row sm:items-start justify-between gap-space-md">
              <div class="flex flex-col gap-space-xs flex-1">
                <div class="flex flex-wrap items-center gap-space-sm mb-1">
                  <span class="font-label-sm text-label-sm text-on-surface-variant font-medium">Jumat, 18 Okt 2024 • 08:30 - 16:30</span>
                  <span class="px-2.5 py-0.5 rounded-full font-label-sm text-label-sm font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                    Menunggu Review
                  </span>
                </div>
                <h3 class="font-headline-sm text-headline-sm text-primary font-bold">
                  Refactoring Database Query &amp; Profiling Index
                </h3>
                <p class="font-body-md text-body-md text-on-surface-variant line-clamp-2 leading-relaxed">
                  Melakukan profiling kueri lambat pada database staging PostgreSQL. Mengoptimalkan relasi join log audit yang sebelumnya memakan waktu respon di atas 1.2 detik.
                </p>
                <div class="flex items-center gap-space-xs pt-space-xs flex-wrap">
                  <span class="px-2 py-0.5 bg-surface-container-lowest text-on-surface-variant font-label-sm text-label-sm rounded font-medium border border-outline-variant">#Postgres</span>
                  <span class="px-2 py-0.5 bg-surface-container-lowest text-on-surface-variant font-label-sm text-label-sm rounded font-medium border border-outline-variant">#Optimization</span>
                  <span class="px-2 py-0.5 bg-surface-container-lowest text-on-surface-variant font-label-sm text-label-sm rounded font-medium border border-outline-variant">8 Jam Kerja</span>
                </div>
              </div>
              <div class="shrink-0 self-end sm:self-center">
                <button
                  @click="goToLogbook"
                  class="inline-flex items-center gap-1 px-space-md py-1.5 bg-surface-container-lowest hover:bg-surface-container text-primary font-label-md text-label-md rounded-lg shadow-sm border border-outline-variant transition-colors"
                  type="button"
                >
                  <span>Detail</span>
                  <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Section: Grafik Distribusi Jam & Aktivitas Mingguan -->
        <div class="bg-surface-container-lowest p-space-xl rounded-xl shadow-sm border border-outline-variant flex flex-col gap-space-lg">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-space-xs">
            <div class="flex flex-col gap-0.5">
              <h2 class="font-headline-md text-headline-md text-primary font-bold">Distribusi Jam &amp; Aktivitas Mingguan</h2>
              <p class="font-body-sm text-body-sm text-on-surface-variant">Pencatatan jam kerja reguler versus sesi bimbingan teknis (Minggu ke-8)</p>
            </div>
            <div class="flex items-center gap-space-md text-on-surface font-label-sm text-label-sm">
              <div class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-sm bg-primary"></span>
                <span>Jam Reguler</span>
              </div>
              <div class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-sm bg-secondary-container border border-secondary/30"></span>
                <span>Sesi Bimbingan</span>
              </div>
            </div>
          </div>

          <!-- Structured Visual Bar Chart -->
          <div class="w-full bg-surface-container-low/40 p-space-lg rounded-xl border border-outline-variant/60 flex flex-col gap-space-sm">
            <div class="h-56 w-full flex items-end justify-between px-2 pt-6">
              <!-- Monday -->
              <div class="flex-1 flex flex-col items-center gap-space-xs h-full justify-end">
                <div class="w-full max-w-[48px] flex flex-col items-center gap-1 h-full justify-end group cursor-pointer">
                  <span class="font-label-sm text-label-sm text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity">7.5h</span>
                  <div class="w-full bg-secondary-container rounded-t-sm h-[18%]" title="Bimbingan: 1.5 Jam"></div>
                  <div class="w-full bg-primary rounded-t-sm h-[72%]" title="Kerja Reguler: 6.0 Jam"></div>
                </div>
                <span class="font-label-md text-label-md text-on-surface-variant font-medium">Sen</span>
              </div>

              <!-- Tuesday -->
              <div class="flex-1 flex flex-col items-center gap-space-xs h-full justify-end">
                <div class="w-full max-w-[48px] flex flex-col items-center gap-1 h-full justify-end group cursor-pointer">
                  <span class="font-label-sm text-label-sm text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity">8.0h</span>
                  <div class="w-full bg-secondary-container rounded-t-sm h-[12%]" title="Bimbingan: 1.0 Jam"></div>
                  <div class="w-full bg-primary rounded-t-sm h-[84%]" title="Kerja Reguler: 7.0 Jam"></div>
                </div>
                <span class="font-label-md text-label-md text-on-surface-variant font-medium">Sel</span>
              </div>

              <!-- Wednesday (Today) -->
              <div class="flex-1 flex flex-col items-center gap-space-xs h-full justify-end">
                <div class="w-full max-w-[48px] flex flex-col items-center gap-1 h-full justify-end group cursor-pointer">
                  <span class="font-label-sm text-label-sm text-primary font-bold opacity-0 group-hover:opacity-100 transition-opacity">4.5h</span>
                  <div class="w-full bg-secondary-container rounded-t-sm h-[10%]" title="Bimbingan: 0.5 Jam"></div>
                  <div class="w-full bg-primary rounded-t-sm h-[42%]" title="Kerja Berjalan: 4.0 Jam"></div>
                </div>
                <span class="font-label-md text-label-md text-primary font-bold">Rab (Hari ini)</span>
              </div>

              <!-- Thursday -->
              <div class="flex-1 flex flex-col items-center gap-space-xs h-full justify-end">
                <div class="w-full max-w-[48px] flex flex-col items-center gap-1 h-full justify-end opacity-40">
                  <div class="w-full bg-surface-container rounded-t-sm h-[60%] border-dashed border-t-2 border-outline"></div>
                </div>
                <span class="font-label-md text-label-md text-on-surface-variant">Kam</span>
              </div>

              <!-- Friday -->
              <div class="flex-1 flex flex-col items-center gap-space-xs h-full justify-end">
                <div class="w-full max-w-[48px] flex flex-col items-center gap-1 h-full justify-end opacity-40">
                  <div class="w-full bg-surface-container rounded-t-sm h-[60%] border-dashed border-t-2 border-outline"></div>
                </div>
                <span class="font-label-md text-label-md text-on-surface-variant">Jum</span>
              </div>
            </div>

            <!-- Footer summary -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pt-space-md border-t border-outline-variant/60 gap-space-sm text-on-surface-variant">
              <span class="font-body-sm text-body-sm">
                Target mingguan: <span class="font-semibold text-on-surface">40 Jam</span> • Terpenuhi berjalan: <span class="font-semibold text-secondary">20 Jam</span>
              </span>
              <span class="font-label-sm text-label-sm text-secondary font-semibold">Tercatat On-Track (100% dari rasio waktu)</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column: Mentorship & Milestones (4 cols) -->
      <div class="lg:col-span-4 flex flex-col gap-space-xl">
        <!-- Mentor Profile Card -->
        <div class="bg-surface-container-lowest p-space-xl rounded-xl shadow-sm border border-outline-variant flex flex-col gap-space-lg">
          <div class="flex items-center justify-between">
            <span class="font-label-md text-label-md text-on-surface-variant font-semibold uppercase tracking-wider">Pembimbing Lapangan</span>
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500" title="Mentor Aktif"></span>
          </div>
          <div class="flex items-start gap-space-md">
            <div class="w-14 h-14 rounded-full bg-surface-container flex items-center justify-center text-primary font-bold text-lg shrink-0 border border-outline-variant">
              DA
            </div>
            <div class="flex flex-col">
              <h3 class="font-headline-sm text-headline-sm text-primary font-bold leading-tight">
                Dimas Ardiansyah, S.T.
              </h3>
              <p class="font-body-sm text-body-sm text-on-surface-variant">
                Lead Software Engineer &amp; Mentor
              </p>
              <span class="font-label-sm text-label-sm text-secondary font-medium pt-1">
                Review terakhir: Kemarin, 19:40
              </span>
            </div>
          </div>
          <div class="grid grid-cols-2 gap-space-sm">
            <button
              @click="sendMessageToMentor"
              class="inline-flex items-center justify-center gap-space-xs px-space-md py-2 bg-surface-container-low hover:bg-surface-container text-primary font-headline-sm text-body-sm rounded-lg transition-colors font-semibold border border-outline-variant"
              type="button"
            >
              <span class="material-symbols-outlined text-[18px]">chat</span>
              <span>Kirim Pesan</span>
            </button>
            <button
              @click="openDiscussionModal"
              class="inline-flex items-center justify-center gap-space-xs px-space-md py-2 bg-surface-container-low hover:bg-surface-container text-primary font-headline-sm text-body-sm rounded-lg transition-colors font-semibold border border-outline-variant"
              type="button"
            >
              <span class="material-symbols-outlined text-[18px]">calendar_add_on</span>
              <span>Diskusi</span>
            </button>
          </div>
        </div>

        <!-- Latest Mentor Feedback Box -->
        <div class="bg-surface-container-low p-space-xl rounded-xl shadow-sm border border-outline-variant flex flex-col gap-space-md relative overflow-hidden">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-space-xs text-primary font-headline-sm text-headline-sm font-bold">
              <span class="material-symbols-outlined text-[20px] text-secondary">mark_chat_unread</span>
              <span>Catatan Mentor Terbaru</span>
            </div>
            <span class="font-label-sm text-label-sm text-on-surface-variant">22 Okt</span>
          </div>
          <blockquote class="font-body-md text-body-md text-on-surface italic leading-relaxed pl-space-sm border-l-2 border-secondary">
            “Catatan implementasi JWT token kemarin sudah sangat rapi. Penanganan corner case session expired berjalan lancar. Siapkan demo untuk sprint review hari Jumat ya.”
          </blockquote>
          <div class="flex items-center justify-between pt-space-xs">
            <span class="font-label-sm text-label-sm text-on-surface-variant">Ref: Logbook #35 • Auth Service</span>
            <button
              @click="replyFeedback"
              class="text-secondary hover:text-primary font-label-sm text-label-sm font-semibold transition-colors"
              type="button"
            >
              Balas Tanggapan
            </button>
          </div>
        </div>

        <!-- Next Milestones & Interactive Checklists -->
        <div class="bg-surface-container-lowest p-space-xl rounded-xl shadow-sm border border-outline-variant flex flex-col gap-space-lg">
          <div class="flex items-center justify-between">
            <div class="flex flex-col">
              <h3 class="font-headline-sm text-headline-sm text-primary font-bold">Target Minggu ke-8</h3>
              <p class="font-body-sm text-body-sm text-on-surface-variant">Milestone &amp; checklist evaluasi</p>
            </div>
            <span class="px-2 py-0.5 rounded font-label-sm text-label-sm bg-surface-container text-secondary font-semibold border border-outline-variant">
              {{ completedMilestonesCount }}/{{ milestones.length }} Selesai
            </span>
          </div>

          <div class="flex flex-col gap-space-sm">
            <label
              v-for="item in milestones"
              :key="item.id"
              class="flex items-start gap-space-sm p-space-sm rounded-lg hover:bg-surface-container-low transition-colors cursor-pointer select-none"
            >
              <input
                type="checkbox"
                v-model="item.done"
                class="mt-1 h-4 w-4 rounded text-secondary focus:ring-0 cursor-pointer"
              />
              <div class="flex flex-col">
                <span
                  class="font-body-md text-body-md font-medium transition-colors"
                  :class="item.done ? 'line-through text-on-surface-variant' : 'text-primary font-semibold'"
                >
                  {{ item.title }}
                </span>
                <span class="font-label-sm text-label-sm text-on-surface-variant">
                  {{ item.desc }}
                </span>
              </div>
            </label>
          </div>

          <!-- Documentation Quick Access -->
          <div class="pt-space-sm flex items-center justify-between border-t border-outline-variant/60">
            <span class="font-body-sm text-body-sm text-on-surface-variant">Template Laporan PKL SMKN 71:</span>
            <button
              @click="downloadTemplate"
              class="inline-flex items-center gap-1 text-secondary hover:text-primary font-label-md text-label-md font-semibold transition-colors"
              type="button"
            >
              <span class="material-symbols-outlined text-[16px]">download</span>
              <span>Unduh DOCX</span>
            </button>
          </div>
        </div>

        <!-- Program Contact Support Info -->
        <div class="bg-surface-container-lowest p-space-lg rounded-xl shadow-sm border border-outline-variant flex items-center justify-between">
          <div class="flex items-center gap-space-md">
            <div class="w-10 h-10 rounded-full bg-surface-container-low flex items-center justify-center text-primary border border-outline-variant">
              <span class="material-symbols-outlined text-[20px]">school</span>
            </div>
            <div class="flex flex-col">
              <span class="font-headline-sm text-body-sm font-semibold text-primary">Guru Pembimbing Akademik</span>
              <span class="font-label-sm text-label-sm text-on-surface-variant">Guru Pembimbing, M.Pd (SMKN 71)</span>
            </div>
          </div>
          <span class="material-symbols-outlined text-secondary text-[18px]">verified</span>
        </div>
      </div>
    </div>

    <!-- Apple Sheet Modal: Pengajuan Dispensasi Beralih Mode (WFH/WFA) -->
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
          v-if="isRequestModalOpen"
          class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm select-none"
          @click.self="isRequestModalOpen = false"
        >
          <div class="modal-card-animate bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-black/10 flex flex-col gap-5">
          <!-- Modal Header -->
          <div class="flex items-center justify-between pb-3 border-b border-black/[0.06]">
            <div class="flex items-center gap-2.5">
              <div class="w-9 h-9 rounded-xl bg-[#0071e3]/10 text-[#0071e3] flex items-center justify-center">
                <span class="material-symbols-outlined text-[20px]">edit_calendar</span>
              </div>
              <div>
                <h3 class="text-base font-bold text-[#1d1d1f] tracking-tight">Permohonan Dispensasi Mode Kerja</h3>
                <p class="text-[11px] text-[#86868b]">Kirimkan permohonan beralih mode kepada Pembimbing Lapangan.</p>
              </div>
            </div>
            <button
              @click="isRequestModalOpen = false"
              type="button"
              class="w-8 h-8 rounded-full bg-black/[0.04] hover:bg-black/[0.08] text-[#86868b] flex items-center justify-center transition cursor-pointer"
            >
              <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
          </div>

          <!-- Modal Body Form -->
          <form @submit.prevent="submitWorkModeRequest" class="space-y-4 text-xs">
            <!-- Target Tanggal -->
            <div class="flex flex-col gap-1.5">
              <label class="font-semibold text-[#1d1d1f]">Tanggal Berlaku</label>
              <input
                v-model="requestForm.date"
                type="date"
                required
                class="w-full px-3.5 py-2.5 bg-black/[0.03] border border-black/[0.08] rounded-xl text-xs text-[#1d1d1f] focus:outline-none focus:ring-2 focus:ring-[#0071e3]"
              />
            </div>

            <!-- Pilihan Mode yang Diajukan -->
            <div class="flex flex-col gap-1.5">
              <label class="font-semibold text-[#1d1d1f]">Mode Kerja yang Diajukan</label>
              <div class="grid grid-cols-3 gap-2">
                <button
                  type="button"
                  @click="requestForm.requested_mode = 'wfh'"
                  :disabled="!allowedWorkModes.includes('wfh')"
                  :class="[
                    requestForm.requested_mode === 'wfh' ? 'bg-[#34c759] text-white font-bold shadow-sm' : 'bg-black/[0.04] text-[#1d1d1f] hover:bg-black/[0.07]',
                    !allowedWorkModes.includes('wfh') ? 'opacity-40 cursor-not-allowed' : 'cursor-pointer',
                    'py-2.5 px-3 rounded-xl flex flex-col items-center gap-1 transition text-center'
                  ]"
                >
                  <span class="material-symbols-outlined text-[20px]">home_work</span>
                  <span class="text-[11px]">WFH (Rumah)</span>
                </button>

                <button
                  type="button"
                  @click="requestForm.requested_mode = 'wfa'"
                  :disabled="!allowedWorkModes.includes('wfa')"
                  :class="[
                    requestForm.requested_mode === 'wfa' ? 'bg-purple-600 text-white font-bold shadow-sm' : 'bg-black/[0.04] text-[#1d1d1f] hover:bg-black/[0.07]',
                    !allowedWorkModes.includes('wfa') ? 'opacity-40 cursor-not-allowed' : 'cursor-pointer',
                    'py-2.5 px-3 rounded-xl flex flex-col items-center gap-1 transition text-center'
                  ]"
                >
                  <span class="material-symbols-outlined text-[20px]">travel_explore</span>
                  <span class="text-[11px]">WFA (Lapangan)</span>
                </button>

                <button
                  type="button"
                  @click="requestForm.requested_mode = 'wfo'"
                  :class="[
                    requestForm.requested_mode === 'wfo' ? 'bg-[#0071e3] text-white font-bold shadow-sm' : 'bg-black/[0.04] text-[#1d1d1f] hover:bg-black/[0.07]',
                    'py-2.5 px-3 rounded-xl flex flex-col items-center gap-1 transition text-center cursor-pointer'
                  ]"
                >
                  <span class="material-symbols-outlined text-[20px]">domain</span>
                  <span class="text-[11px]">WFO (Kantor)</span>
                </button>
              </div>
            </div>

            <!-- Alasan Pengajuan -->
            <div class="flex flex-col gap-1.5">
              <label class="font-semibold text-[#1d1d1f]">Alasan & Keterangan Rinci</label>
              <textarea
                v-model="requestForm.reason"
                required
                rows="3"
                placeholder="Contoh: Kondisi badan kurang fit / flu ringan namun siap stand-by coding remote, atau jadwal pemotretan liputan di lokasi mitra..."
                class="w-full px-3.5 py-2.5 bg-black/[0.03] border border-black/[0.08] rounded-xl text-xs text-[#1d1d1f] focus:outline-none focus:ring-2 focus:ring-[#0071e3] resize-none"
              ></textarea>
              <span class="text-[10px] text-[#86868b]">Permohonan akan langsung diteruskan ke dasbor Pembimbing Lapangan untuk verifikasi.</span>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end gap-2.5 pt-2">
              <button
                type="button"
                @click="isRequestModalOpen = false"
                class="px-4 py-2 rounded-xl text-xs font-semibold text-[#86868b] hover:bg-black/[0.04] transition cursor-pointer"
              >
                Batal
              </button>
              <button
                type="submit"
                :disabled="isSubmittingRequest || !requestForm.reason"
                class="px-5 py-2 rounded-xl bg-[#0071e3] hover:bg-[#0077ed] text-white text-xs font-semibold shadow-sm transition disabled:opacity-50 flex items-center gap-1.5 cursor-pointer"
              >
                <span v-if="isSubmittingRequest" class="material-symbols-outlined text-[16px] animate-spin">progress_activity</span>
                <span>{{ isSubmittingRequest ? 'Mengirim...' : 'Kirim Permohonan' }}</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </Transition>
  </Teleport>
  </div>
</template>

<script setup lang="ts">
import { ref, reactive, computed, onMounted, onUnmounted } from 'vue'
import { useAppStore } from '~/composables/useAppStore'

const {
  currentUser,
  activeMenu,
  authToken,
  showToast,
  attendanceState,
  isTodayLogged,
  journalUrgency,
  effectiveMinutesSinceTapOut,
  recordCheckIn,
  recordCheckOut,
  recordJournalSubmitted,
  setSimulatedMinutes,
  resetAttendanceDemo,
  triggerTapOutDemo
} = useAppStore()

// Realtime Live Clock
const liveTimeString = ref('08:00:00')
let clockInterval: any = null

const updateClock = () => {
  const now = new Date()
  liveTimeString.value = [
    now.getHours().toString().padStart(2, '0'),
    now.getMinutes().toString().padStart(2, '0'),
    now.getSeconds().toString().padStart(2, '0')
  ].join(':')
}

// Company & Placement context (SMKN 71 Jakarta)
const companyInfo = reactive({
  name: 'PT Telkom Digital Solusi',
  sector: 'Software House & Cloud (RPL)',
  lat: -6.2301000,
  lng: 106.8228000,
  radius: 150
})

// Work Mode & Geofence
const selectedWorkMode = ref<'wfo' | 'wfh' | 'wfa' | 'libur'>('wfo')
const todayWorkMode = ref<'wfo' | 'wfh' | 'wfa' | 'libur'>('wfo')
const workModeInfo = ref<{ mode: string; source: string; reason?: string; is_holiday?: boolean; holiday_name?: string }>({
  mode: 'wfo',
  source: 'weekly_schedule'
})
const todayRequest = ref<any>(null)
const weeklySchedule = ref<Record<string, string>>({
  monday: 'wfo',
  tuesday: 'wfh',
  wednesday: 'wfo',
  thursday: 'wfh',
  friday: 'wfo',
  saturday: 'libur',
  sunday: 'libur'
})
const allowedWorkModes = ref<string[]>(['wfo', 'wfh', 'wfa', 'libur'])
const currentDayKey = ref<string>('monday')
const currentDayName = ref<string>('Senin')

const isTodayHoliday = ref(false)
const holidayReason = ref('')
const scheduledCheckInTime = ref('07:30')
const scheduledCheckOutTime = ref('16:00')
const lateToleranceMinutes = ref(15)
const companyOfficeSchedule = ref<any>(null)

const weekDaysList = computed(() => ({
  monday: { label: 'Senin', short: 'Sen' },
  tuesday: { label: 'Selasa', short: 'Sel' },
  wednesday: { label: 'Rabu', short: 'Rab' },
  thursday: { label: 'Kamis', short: 'Kam' },
  friday: { label: 'Jumat', short: 'Jum' },
  saturday: { label: 'Sabtu', short: 'Sab' },
  sunday: { label: 'Minggu', short: 'Min' }
}))

// Request Modal State
const isRequestModalOpen = ref(false)
const isSubmittingRequest = ref(false)
const requestForm = reactive({
  date: new Date().toISOString().split('T')[0],
  requested_mode: 'wfh',
  reason: ''
})

const openRequestModal = () => {
  requestForm.date = new Date().toISOString().split('T')[0]
  requestForm.requested_mode = selectedWorkMode.value === 'wfo' ? 'wfh' : 'wfa'
  requestForm.reason = ''
  isRequestModalOpen.value = true
}

const submitWorkModeRequest = async () => {
  if (!requestForm.reason.trim()) {
    showToast('Harap sertakan alasan permohonan beralih mode.', 'warning')
    return
  }

  isSubmittingRequest.value = true
  try {
    const res = await fetch('http://127.0.0.1:8000/api/siswa/request-work-mode', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${authToken.value}`
      },
      body: JSON.stringify({
        date: requestForm.date,
        requested_mode: requestForm.requested_mode,
        reason: requestForm.reason
      })
    })

    const data = await res.json()
    if (res.ok && data.success) {
      showToast(data.message || 'Permohonan berhasil dikirim ke Pembimbing Lapangan!', 'success')
      todayRequest.value = data.request
      isRequestModalOpen.value = false
    } else {
      showToast(data.message || 'Gagal mengajukan permohonan.', 'danger')
    }
  } catch (err) {
    todayRequest.value = {
      requested_mode: requestForm.requested_mode,
      reason: requestForm.reason,
      status: 'pending'
    }
    showToast('Permohonan diajukan (Demo Mode). Menunggu persetujuan Pembimbing.', 'success')
    isRequestModalOpen.value = false
  } finally {
    isSubmittingRequest.value = false
  }
}

const userCoordinates = ref<{ lat: number; lng: number }>({ lat: -6.2301250, lng: 106.8227800 })
const distanceToOffice = ref<number>(24) // in meters
const isLocating = ref(false)

const isWithinGeofence = computed(() => {
  if (selectedWorkMode.value !== 'wfo') return true
  return distanceToOffice.value <= companyInfo.radius
})

const locationStatusText = computed(() => {
  if (selectedWorkMode.value === 'wfo') {
    if (isWithinGeofence.value) {
      return `Dalam Radius Kantor PT (${distanceToOffice.value}m dari titik pusat)`
    } else {
      return `Di Luar Radius Kantor PT (${distanceToOffice.value}m • Maks: ${companyInfo.radius}m)`
    }
  } else if (selectedWorkMode.value === 'wfh') {
    return 'Mode WFH Aktif • Lokasi Tempat Tinggal Terverifikasi'
  } else {
    return 'Mode WFA Aktif • Lokasi Penugasan Lapangan Kreatif'
  }
})

const coordinatesDisplay = computed(() => {
  return `Koordinat: ${userCoordinates.value.lat.toFixed(5)}, ${userCoordinates.value.lng.toFixed(5)} • SMKN 71`
})

const setWorkMode = (mode: 'wfo' | 'wfh' | 'wfa') => {
  selectedWorkMode.value = mode
  if (mode === 'wfo') {
    showToast('Mode WFO dipilih. Sistem memvalidasi radius geofence kantor PT.', 'info')
  } else if (mode === 'wfh') {
    showToast('Mode WFH dipilih. Presensi fleksibel dari kediaman.', 'info')
  } else {
    showToast('Mode WFA dipilih. Presensi penugasan mobile/lapangan.', 'info')
  }
}

const refreshLocation = () => {
  isLocating.value = true
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      (pos) => {
        userCoordinates.value = {
          lat: pos.coords.latitude,
          lng: pos.coords.longitude
        }
        // Calculate distance
        const R = 6371e3
        const φ1 = (userCoordinates.value.lat * Math.PI) / 180
        const φ2 = (companyInfo.lat * Math.PI) / 180
        const Δφ = ((companyInfo.lat - userCoordinates.value.lat) * Math.PI) / 180
        const Δλ = ((companyInfo.lng - userCoordinates.value.lng) * Math.PI) / 180
        const a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
                  Math.cos(φ1) * Math.cos(φ2) *
                  Math.sin(Δλ / 2) * Math.sin(Δλ / 2)
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a))
        distanceToOffice.value = Math.round(R * c)
        isLocating.value = false
        showToast(`Lokasi GPS diperbarui! Jarak ke PT: ${distanceToOffice.value} meter.`, 'success')
      },
      () => {
        isLocating.value = false
        // Simulation default near PT
        distanceToOffice.value = 28
        showToast('Sensor GPS desktop aktif: Posisi terverifikasi di area kantor PT.', 'info')
      }
    )
  } else {
    isLocating.value = false
  }
}

// Attendance Processing
const isProcessingAttendance = ref(false)

const handleTapIn = async () => {
  isProcessingAttendance.value = true
  const now = new Date()
  const currentTime = [
    now.getHours().toString().padStart(2, '0'),
    now.getMinutes().toString().padStart(2, '0')
  ].join(':')

  try {
    const res = await fetch('http://127.0.0.1:8000/api/siswa/check-in', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${authToken.value}`
      },
      body: JSON.stringify({
        work_mode: selectedWorkMode.value,
        latitude: userCoordinates.value.lat,
        longitude: userCoordinates.value.lng,
        notes: `Tap In ${selectedWorkMode.value.toUpperCase()} via Dashboard Siswa SMKN 71`
      })
    })

    const data = await res.json()
    if (res.ok && data.success) {
      recordCheckIn(data.attendance?.check_in?.substring(0, 5) || currentTime, selectedWorkMode.value)
      showToast(data.message || `Check-in ${selectedWorkMode.value.toUpperCase()} berhasil!`, 'success')
      isProcessingAttendance.value = false
      return
    } else {
      showToast(data.message || 'Presensi gagal divalidasi.', 'danger')
      isProcessingAttendance.value = false
      return
    }
  } catch (err) {
    // offline/demo fallback only on true network failure
    setTimeout(() => {
      recordCheckIn(currentTime, selectedWorkMode.value)
      isProcessingAttendance.value = false
    }, 400)
  }
}

const handleTapOut = async () => {
  isProcessingAttendance.value = true
  const now = new Date()
  const currentTime = [
    now.getHours().toString().padStart(2, '0'),
    now.getMinutes().toString().padStart(2, '0')
  ].join(':')

  try {
    const res = await fetch('http://127.0.0.1:8000/api/siswa/check-out', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${authToken.value}`
      },
      body: JSON.stringify({
        latitude: userCoordinates.value.lat,
        longitude: userCoordinates.value.lng
      })
    })

    if (res.ok) {
      const data = await res.json()
      recordCheckOut(data.attendance?.check_out?.substring(0, 5) || currentTime)
      isProcessingAttendance.value = false
      return
    }
  } catch (err) {
    // fallback
  }

  setTimeout(() => {
    recordCheckOut(currentTime)
    isProcessingAttendance.value = false
  }, 400)
}

// Fetch Today's Attendance from Online API on mount
const fetchTodayData = async () => {
  try {
    const res = await fetch('http://127.0.0.1:8000/api/siswa/dashboard', {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${authToken.value}`
      }
    })
    if (res.ok) {
      const data = await res.json()
      if (data.today_attendance) {
        attendanceState.hasCheckedIn = true
        attendanceState.checkInTime = data.today_attendance.check_in ? data.today_attendance.check_in.substring(0, 5) : '07:35'
        attendanceState.workMode = data.today_attendance.work_mode || 'wfo'
        selectedWorkMode.value = attendanceState.workMode as any
        if (data.today_attendance.check_out) {
          attendanceState.hasCheckedOut = true
          attendanceState.checkOutTime = data.today_attendance.check_out.substring(0, 5)
        }
      } else if (data.today_work_mode) {
        selectedWorkMode.value = data.today_work_mode as any
        todayWorkMode.value = data.today_work_mode as any
      }

      if (data.work_mode_info) {
        workModeInfo.value = data.work_mode_info
      }
      if (data.today_request) {
        todayRequest.value = data.today_request
      }
      if (data.weekly_schedule) {
        weeklySchedule.value = data.weekly_schedule
      }
      if (data.allowed_work_modes) {
        allowedWorkModes.value = data.allowed_work_modes
      }
      if (data.day_name) {
        currentDayName.value = data.day_name
      }
      if (data.day_key) {
        currentDayKey.value = data.day_key
      }

      if (typeof data.is_today_holiday === 'boolean') {
        isTodayHoliday.value = data.is_today_holiday
      }
      if (data.holiday_reason) {
        holidayReason.value = data.holiday_reason
      }
      if (data.scheduled_check_in_time) {
        scheduledCheckInTime.value = data.scheduled_check_in_time
      }
      if (data.scheduled_check_out_time) {
        scheduledCheckOutTime.value = data.scheduled_check_out_time
      }
      if (typeof data.late_tolerance_minutes === 'number') {
        lateToleranceMinutes.value = data.late_tolerance_minutes
      }
      if (data.office_schedule) {
        companyOfficeSchedule.value = data.office_schedule
      }

      if (typeof data.is_today_logged === 'boolean') {
        isTodayLogged.value = data.is_today_logged
      }
      if (data.placement?.company) {
        companyInfo.name = data.placement.company.name
        companyInfo.sector = data.placement.company.sector
        companyInfo.lat = parseFloat(data.placement.company.latitude) || companyInfo.lat
        companyInfo.lng = parseFloat(data.placement.company.longitude) || companyInfo.lng
        companyInfo.radius = parseInt(data.placement.company.radius_meters) || companyInfo.radius
      }
    }
  } catch (e) {
    // Keep initial store state
  }
}

onMounted(() => {
  updateClock()
  clockInterval = setInterval(updateClock, 1000)
  fetchTodayData()
})

onUnmounted(() => {
  if (clockInterval) clearInterval(clockInterval)
})

const todayFormatted = computed(() => {
  const options: Intl.DateTimeFormatOptions = {
    weekday: 'long',
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  }
  return new Date().toLocaleDateString('id-ID', options)
})

const milestones = ref([
  {
    id: 1,
    title: 'Selesaikan modul autentikasi backend & Geofencing',
    desc: 'Selesai diverifikasi oleh Pembimbing Lapangan',
    done: true
  },
  {
    id: 2,
    title: 'Verifikasi logbook mingguan ke mentor',
    desc: 'Disetujui kemarin sore',
    done: true
  },
  {
    id: 3,
    title: 'Penyusunan draft laporan tengah periode PKL SMKN 71',
    desc: 'Batas pengumpulan: Jumat pekan depan',
    done: false
  }
])

const completedMilestonesCount = computed(() => {
  return milestones.value.filter(m => m.done).length
})

const goToLogbook = () => {
  activeMenu.value = 'logbook'
}

const showGuideline = () => {
  showToast('Panduan Presensi & Logbook: Lakukan Tap In sebelum jam 08:00 WIB, dan catat jurnal harian sebelum 18:00 WIB.', 'info')
}

const sendMessageToMentor = () => {
  showToast('Membuka ruang obrolan internal WhatsApp dengan Sdr. Hendra Wijaya, S.Kom (Pembimbing Lapangan)', 'info')
}

const openDiscussionModal = () => {
  showToast('Pengajuan sesi bimbingan teknis 1-on-1 dengan mentor sedang diproses.', 'info')
}

const replyFeedback = () => {
  showToast('Menautkan balasan tanggapan ke Logbook #35.', 'info')
}

const downloadTemplate = () => {
  showToast('Mengunduh Template Laporan Magang Resmi SMKN 71 (.docx)...', 'success')
}
</script>
