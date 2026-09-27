<template>
  <div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header with Toggle View (Kalender vs List) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
      <div>
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
          <span>🕒 Riwayat Presensi Kehadiran</span>
        </h2>
        <p class="text-xs text-slate-500 mt-1">
          Rekam jejak jam Check-In dan Check-Out harian selama periode praktik kerja lapangan.
        </p>
      </div>

      <!-- View Switcher (Kalender / List) -->
      <div class="flex items-center p-1 bg-slate-100 border border-slate-200 rounded-xl text-xs font-semibold">
        <button
          @click="viewMode = 'calendar'"
          :class="viewMode === 'calendar' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900'"
          class="px-3.5 py-1.5 rounded-lg transition flex items-center gap-1.5"
        >
          <span>🗓️</span>
          <span>Tampilan Kalender</span>
        </button>
        <button
          @click="viewMode = 'list'"
          :class="viewMode === 'list' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900'"
          class="px-3.5 py-1.5 rounded-lg transition flex items-center gap-1.5"
        >
          <span>📋</span>
          <span>Daftar Rinci (List)</span>
        </button>
      </div>
    </div>

    <!-- Monthly Summary Bar (Clean White Cards) -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <div class="p-4 bg-white border border-slate-200 rounded-xl shadow-sm">
        <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Total Hadir Tepat Waktu</div>
        <div class="text-2xl font-bold text-emerald-600 mt-1">26 Hari</div>
      </div>
      <div class="p-4 bg-white border border-slate-200 rounded-xl shadow-sm">
        <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Terlambat Toleransi</div>
        <div class="text-2xl font-bold text-amber-600 mt-1">1 Hari</div>
      </div>
      <div class="p-4 bg-white border border-slate-200 rounded-xl shadow-sm">
        <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Izin / Sakit Resmi</div>
        <div class="text-2xl font-bold text-blue-600 mt-1">1 Hari</div>
      </div>
      <div class="p-4 bg-white border border-slate-200 rounded-xl shadow-sm">
        <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Rata-rata Jam Pulang</div>
        <div class="text-2xl font-bold text-indigo-600 mt-1">17:08 WIB</div>
      </div>
    </div>

    <!-- VIEW 1: KALENDER VIEW (LIGHT FLAT DESIGN) -->
    <div v-if="viewMode === 'calendar'" class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
      <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-200">
        <h3 class="text-sm font-bold text-slate-900">September 2026</h3>
        <div class="flex items-center gap-4 text-[11px] font-semibold">
          <span class="flex items-center gap-1 text-slate-600">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Hadir Lengkap
          </span>
          <span class="flex items-center gap-1 text-slate-600">
            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Terlambat
          </span>
          <span class="flex items-center gap-1 text-slate-600">
            <span class="w-2.5 h-2.5 rounded-full bg-slate-300"></span> Libur Akhir Pekan
          </span>
        </div>
      </div>

      <!-- Calendar Grid -->
      <div class="grid grid-cols-7 gap-2.5 text-center text-xs">
        <div class="py-2 text-[11px] font-bold text-slate-500">SEN</div>
        <div class="py-2 text-[11px] font-bold text-slate-500">SEL</div>
        <div class="py-2 text-[11px] font-bold text-slate-500">RAB</div>
        <div class="py-2 text-[11px] font-bold text-slate-500">KAM</div>
        <div class="py-2 text-[11px] font-bold text-slate-500">JUM</div>
        <div class="py-2 text-[11px] font-bold text-rose-500">SAB</div>
        <div class="py-2 text-[11px] font-bold text-rose-500">MIN</div>

        <!-- Days -->
        <div
          v-for="day in calendarDays"
          :key="day.date"
          :class="[
            day.isWeekend ? 'bg-slate-100/70 text-slate-400 border-slate-200' : 'bg-slate-50 border-slate-200 text-slate-800 hover:border-indigo-400 hover:bg-white',
            day.isToday ? 'ring-2 ring-indigo-600 bg-indigo-50/40' : ''
          ]"
          class="p-2.5 min-h-[85px] rounded-xl border flex flex-col justify-between text-left transition"
        >
          <div class="flex items-center justify-between">
            <span class="font-bold text-xs" :class="day.isToday ? 'text-indigo-700' : ''">{{ day.dayNum }}</span>
            <span v-if="day.isToday" class="text-[9px] px-1.5 py-0.2 bg-indigo-100 text-indigo-700 rounded font-bold">Hari Ini</span>
          </div>

          <div v-if="day.attendance" class="mt-1 space-y-0.5">
            <div class="text-[10px] font-mono text-emerald-700 font-bold">
              IN: {{ day.attendance.in }}
            </div>
            <div class="text-[10px] font-mono text-indigo-700 font-bold">
              OUT: {{ day.attendance.out || '—' }}
            </div>
          </div>
          <div v-else-if="day.isWeekend" class="text-[10px] text-slate-400 italic">
            Libur
          </div>
          <div v-else class="text-[10px] text-slate-400">
            —
          </div>
        </div>
      </div>
    </div>

    <!-- VIEW 2: DAFTAR RINCI (LIST) VIEW (LIGHT FLAT TABLE) -->
    <div v-else class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
      <div class="pb-4 mb-4 border-b border-slate-200 flex items-center justify-between">
        <h3 class="text-sm font-bold text-slate-900">Log Presensi Kronologis</h3>
        <span class="text-xs text-slate-500 font-medium">Total 28 Catatan Rekam Jejak</span>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-slate-700">
          <thead class="bg-slate-50 text-slate-600 uppercase text-[10px] tracking-wider border-b border-slate-200 font-bold">
            <tr>
              <th class="py-3 px-4">Tanggal Presensi</th>
              <th class="py-3 px-4">Jam Check-In</th>
              <th class="py-3 px-4">Jam Check-Out</th>
              <th class="py-3 px-4 text-center">Status</th>
              <th class="py-3 px-4">Lokasi &amp; Keterangan</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            <tr v-for="item in attendanceList" :key="item.dateFormatted" class="hover:bg-slate-50 transition">
              <td class="py-3.5 px-4 font-mono font-bold text-slate-900 whitespace-nowrap">
                {{ item.dateFormatted }}
              </td>
              <td class="py-3.5 px-4 font-mono text-emerald-700 font-bold whitespace-nowrap">
                {{ item.check_in }} WIB
              </td>
              <td class="py-3.5 px-4 font-mono text-indigo-700 font-bold whitespace-nowrap">
                {{ item.check_out ? `${item.check_out} WIB` : 'Belum Check-Out' }}
              </td>
              <td class="py-3.5 px-4 text-center whitespace-nowrap">
                <span
                  :class="item.status === 'Hadir' ? 'bg-emerald-50 text-emerald-800 border-emerald-300' : 'bg-amber-50 text-amber-800 border-amber-300'"
                  class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border"
                >
                  {{ item.status }}
                </span>
              </td>
              <td class="py-3.5 px-4 text-slate-600 text-[11px]">
                {{ item.notes }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const viewMode = ref<'calendar' | 'list'>('calendar')

const calendarDays = ref([
  { date: '2026-09-01', dayNum: 1, isWeekend: false, isToday: false, attendance: { in: '07:40', out: '17:02' } },
  { date: '2026-09-02', dayNum: 2, isWeekend: false, isToday: false, attendance: { in: '07:45', out: '17:00' } },
  { date: '2026-09-03', dayNum: 3, isWeekend: false, isToday: false, attendance: { in: '07:42', out: '17:15' } },
  { date: '2026-09-04', dayNum: 4, isWeekend: false, isToday: false, attendance: { in: '07:38', out: '17:05' } },
  { date: '2026-09-05', dayNum: 5, isWeekend: true, isToday: false, attendance: null },
  { date: '2026-09-06', dayNum: 6, isWeekend: true, isToday: false, attendance: null },
  { date: '2026-09-07', dayNum: 7, isWeekend: false, isToday: false, attendance: { in: '07:44', out: '17:00' } },
  { date: '2026-09-08', dayNum: 8, isWeekend: false, isToday: false, attendance: { in: '07:35', out: '17:04' } },
  { date: '2026-09-09', dayNum: 9, isWeekend: false, isToday: false, attendance: { in: '07:50', out: '17:00' } },
  { date: '2026-09-10', dayNum: 10, isWeekend: false, isToday: false, attendance: { in: '07:41', out: '17:10' } },
  { date: '2026-09-11', dayNum: 11, isWeekend: false, isToday: false, attendance: { in: '07:39', out: '17:02' } },
  { date: '2026-09-12', dayNum: 12, isWeekend: true, isToday: false, attendance: null },
  { date: '2026-09-13', dayNum: 13, isWeekend: true, isToday: false, attendance: null },
  { date: '2026-09-14', dayNum: 14, isWeekend: false, isToday: false, attendance: { in: '07:45', out: '17:01' } },
  { date: '2026-09-15', dayNum: 15, isWeekend: false, isToday: false, attendance: { in: '07:40', out: '17:05' } },
  { date: '2026-09-16', dayNum: 16, isWeekend: false, isToday: false, attendance: { in: '07:42', out: '17:00' } },
  { date: '2026-09-17', dayNum: 17, isWeekend: false, isToday: false, attendance: { in: '07:47', out: '17:10' } },
  { date: '2026-09-18', dayNum: 18, isWeekend: false, isToday: false, attendance: { in: '07:36', out: '17:00' } },
  { date: '2026-09-19', dayNum: 19, isWeekend: true, isToday: false, attendance: null },
  { date: '2026-09-20', dayNum: 20, isWeekend: true, isToday: false, attendance: null },
  { date: '2026-09-21', dayNum: 21, isWeekend: false, isToday: false, attendance: { in: '07:41', out: '17:04' } },
  { date: '2026-09-22', dayNum: 22, isWeekend: false, isToday: false, attendance: { in: '07:43', out: '17:00' } },
  { date: '2026-09-23', dayNum: 23, isWeekend: false, isToday: false, attendance: { in: '07:38', out: '17:08' } },
  { date: '2026-09-24', dayNum: 24, isWeekend: false, isToday: false, attendance: { in: '07:45', out: '17:00' } },
  { date: '2026-09-25', dayNum: 25, isWeekend: false, isToday: false, attendance: { in: '07:58', out: '17:00' } },
  { date: '2026-09-26', dayNum: 26, isWeekend: true, isToday: false, attendance: null },
  { date: '2026-09-27', dayNum: 27, isWeekend: false, isToday: true, attendance: { in: '07:35', out: null } },
])

const attendanceList = ref([
  { dateFormatted: '27 Sep 2026 (Hari ini)', check_in: '07:35:12', check_out: null, status: 'Hadir', notes: 'Presensi pagi berhasil melalui desktop app' },
  { dateFormatted: '25 Sep 2026', check_in: '07:58:10', check_out: '17:02:15', status: 'Hadir', notes: 'Tepat waktu di kantor Telkom Landmark' },
  { dateFormatted: '24 Sep 2026', check_in: '07:45:00', check_out: '17:00:22', status: 'Hadir', notes: 'Presensi presisi lokasi geotag' },
  { dateFormatted: '23 Sep 2026', check_in: '07:38:40', check_out: '17:08:45', status: 'Hadir', notes: 'Tepat waktu di ruangan tech lead' },
  { dateFormatted: '22 Sep 2026', check_in: '07:43:11', check_out: '17:01:00', status: 'Hadir', notes: 'Hadir tepat waktu' },
])
</script>
