<template>
  <div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
      <div>
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
          <span>👥 Presensi &amp; Kontrol Kedisiplinan Siswa</span>
        </h2>
        <p class="text-xs text-slate-500 mt-1">
          Rekapitulasi catatan absensi seluruh siswa magang aktif di PT Telkom Digital Solusi.
        </p>
      </div>

      <div class="flex items-center gap-2">
        <button
          @click="exportCsv"
          class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold border border-slate-300 transition flex items-center gap-1.5 shadow-sm active:scale-95"
        >
          <span>📥</span> Export Rekap Presensi (CSV)
        </button>
      </div>
    </div>

    <!-- Discipline Indicator Cards (Clean White Cards) -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
      <div class="p-4 rounded-xl bg-white border border-slate-200 shadow-sm">
        <span class="text-[11px] font-bold text-slate-500 block uppercase tracking-wider">Total Kehadiran Bulan Ini</span>
        <span class="text-2xl font-extrabold text-slate-900 mt-1 block">94.8%</span>
        <span class="text-[10px] text-emerald-700 mt-0.5 block font-bold">Sangat Baik</span>
      </div>
      <div class="p-4 rounded-xl bg-white border border-slate-200 shadow-sm">
        <span class="text-[11px] font-bold text-slate-500 block uppercase tracking-wider">Hadir Tepat Waktu</span>
        <span class="text-2xl font-extrabold text-emerald-600 mt-1 block">78 Sesi</span>
        <span class="text-[10px] text-slate-500 mt-0.5 block font-medium">&le; 08:00 WIB</span>
      </div>
      <div class="p-4 rounded-xl bg-white border border-slate-200 shadow-sm">
        <span class="text-[11px] font-bold text-slate-500 block uppercase tracking-wider">Keterlambatan</span>
        <span class="text-2xl font-extrabold text-amber-600 mt-1 block">3 Sesi</span>
        <span class="text-[10px] text-slate-500 mt-0.5 block font-medium">Toleransi 15 Menit</span>
      </div>
      <div class="p-4 rounded-xl bg-white border border-slate-200 shadow-sm">
        <span class="text-[11px] font-bold text-slate-500 block uppercase tracking-wider">Tanpa Keterangan (Alpha)</span>
        <span class="text-2xl font-extrabold text-rose-600 mt-1 block">0 Sesi</span>
        <span class="text-[10px] text-slate-500 mt-0.5 block font-medium">Nol Pelanggaran</span>
      </div>
    </div>

    <!-- TABEL REKAPITULASI KEHADIRAN SELURUH SISWA (FLAT LIGHT TABLE) -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 mb-4 border-b border-slate-200">
        <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
          <span>📊 Rekapitulasi Presensi Harian Siswa Magang</span>
        </h3>

        <!-- Filter Search & Date -->
        <div class="flex items-center gap-2">
          <input
            v-model="search"
            type="text"
            placeholder="Cari nama siswa..."
            class="px-3 py-1.5 bg-white border border-slate-300 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-600 transition"
          />
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-slate-700">
          <thead class="bg-slate-50 text-slate-600 uppercase text-[10px] tracking-wider border-b border-slate-200 font-bold">
            <tr>
              <th class="py-3 px-4">Nama Siswa</th>
              <th class="py-3 px-4">Tanggal</th>
              <th class="py-3 px-4">Jam Masuk (Check-In)</th>
              <th class="py-3 px-4">Jam Pulang (Check-Out)</th>
              <th class="py-3 px-4 text-center">Durasi Kerja</th>
              <th class="py-3 px-4 text-center">Status Kehadiran</th>
              <th class="py-3 px-4">Geotagging &amp; Lokasi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            <tr v-for="att in filteredAttendances" :key="att.id" class="hover:bg-slate-50 transition">
              <!-- Student -->
              <td class="py-3.5 px-4 whitespace-nowrap">
                <div class="flex items-center gap-3">
                  <img :src="att.avatar" class="w-8 h-8 rounded-lg object-cover border border-slate-300" />
                  <div>
                    <div class="font-bold text-slate-900">{{ att.name }}</div>
                    <div class="text-[10px] text-slate-500 font-mono">NISN: {{ att.nisn }}</div>
                  </div>
                </div>
              </td>

              <!-- Date -->
              <td class="py-3.5 px-4 font-mono text-slate-700 whitespace-nowrap font-medium">
                {{ att.date }}
              </td>

              <!-- Check-In -->
              <td class="py-3.5 px-4 font-mono font-bold text-emerald-700 whitespace-nowrap">
                {{ att.in }} WIB
              </td>

              <!-- Check-Out -->
              <td class="py-3.5 px-4 font-mono font-bold text-[#1e3a5f] whitespace-nowrap">
                {{ att.out ? `${att.out} WIB` : 'Sedang Bekerja' }}
              </td>

              <!-- Durasi -->
              <td class="py-3.5 px-4 text-center font-mono text-slate-600 whitespace-nowrap font-medium">
                {{ att.duration }}
              </td>

              <!-- Status -->
              <td class="py-3.5 px-4 text-center whitespace-nowrap">
                <span
                  :class="att.status === 'Hadir Tepat Waktu' ? 'bg-emerald-50 text-emerald-800 border-emerald-300' : 'bg-amber-50 text-amber-800 border-amber-300'"
                  class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border"
                >
                  {{ att.status }}
                </span>
              </td>

              <!-- Lokasi -->
              <td class="py-3.5 px-4 text-[11px] text-slate-600 whitespace-nowrap">
                <span class="text-slate-800 font-semibold">📍 Telkom Landmark Lt. 14</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useAppStore } from '~/composables/useAppStore'

const { showToast } = useAppStore()

const search = ref('')

const attendances = ref([
  { id: 1, name: 'Budi Santoso', nisn: '0061234567', avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150', date: '27 Sep 2026', in: '07:35:12', out: null, duration: '4j 45m', status: 'Hadir Tepat Waktu' },
  { id: 2, name: 'Siti Rahma', nisn: '0061234568', avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150', date: '27 Sep 2026', in: '07:42:00', out: null, duration: '4j 38m', status: 'Hadir Tepat Waktu' },
  { id: 3, name: 'Dewi Anggraeni', nisn: '0061234570', avatar: 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150', date: '27 Sep 2026', in: '07:30:15', out: null, duration: '4j 50m', status: 'Hadir Tepat Waktu' },
  { id: 4, name: 'Budi Santoso', nisn: '0061234567', avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150', date: '25 Sep 2026', in: '07:58:10', out: '17:02:15', duration: '9j 04m', status: 'Hadir Tepat Waktu' },
  { id: 5, name: 'Siti Rahma', nisn: '0061234568', avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150', date: '25 Sep 2026', in: '08:08:22', out: '17:15:00', duration: '9j 06m', status: 'Terlambat (Toleransi)' },
  { id: 6, name: 'Dewi Anggraeni', nisn: '0061234570', avatar: 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150', date: '25 Sep 2026', in: '07:35:00', out: '17:00:10', duration: '9j 25m', status: 'Hadir Tepat Waktu' },
])

const filteredAttendances = computed(() => {
  if (!search.value) return attendances.value
  const q = search.value.toLowerCase()
  return attendances.value.filter(a => a.name.toLowerCase().includes(q) || a.nisn.includes(q))
})

const exportCsv = () => {
  showToast('File rekap_presensi_dudi_september.csv berhasil diunduh.', 'success')
}
</script>
