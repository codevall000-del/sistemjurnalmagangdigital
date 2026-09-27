<template>
  <div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
      <div>
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
          <span>🏬 Dashboard Pembimbing Industri</span>
        </h2>
        <p class="text-xs text-slate-500 mt-1">
          Monitoring aktivitas siswa magang aktif di PT Telkom Digital Solusi.
        </p>
      </div>

      <div class="flex items-center gap-2">
        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-300">
          🏢 PT Telkom Digital Solusi • Unit Core Platform
        </span>
      </div>
    </div>

    <!-- Quick Stat Cards (Flat White) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
      <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm flex items-center justify-between">
        <div>
          <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Siswa Aktif Binaan</span>
          <div class="text-3xl font-extrabold text-slate-900 mt-1">4 <span class="text-sm font-normal text-slate-500">Siswa</span></div>
          <p class="text-xs text-emerald-700 font-semibold mt-1">Semua terdaftar aktif</p>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-indigo-50 border border-indigo-200 text-indigo-700 flex items-center justify-center text-2xl font-bold">
          👥
        </div>
      </div>

      <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm flex items-center justify-between">
        <div>
          <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Jurnal Menunggu Validasi</span>
          <div class="text-3xl font-extrabold text-amber-600 mt-1">3 <span class="text-sm font-normal text-slate-500">Jurnal</span></div>
          <p class="text-xs text-amber-700 font-semibold mt-1">Memerlukan persetujuan DUDI</p>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-amber-50 border border-amber-200 text-amber-700 flex items-center justify-center text-2xl font-bold">
          ✍️
        </div>
      </div>

      <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm flex items-center justify-between">
        <div>
          <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Rata-rata Kedisiplinan</span>
          <div class="text-3xl font-extrabold text-emerald-600 mt-1">94.8%</div>
          <p class="text-xs text-emerald-700 font-semibold mt-1">Kehadiran minggu ini</p>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center text-2xl font-bold">
          🎯
        </div>
      </div>
    </div>

    <!-- DAFTAR KARTU (CARD) SISWA YANG SEDANG AKTIF MAGANG -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
      <div class="flex items-center justify-between pb-4 mb-5 border-b border-slate-200">
        <div>
          <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
            <span>📋 Daftar Siswa Magang Aktif &amp; Indikator Validasi Jurnal</span>
          </h3>
          <p class="text-xs text-slate-500">Pilih siswa untuk meninjau logbook harian atau periksa rekapitulasi presensi</p>
        </div>
      </div>

      <!-- Cards Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div
          v-for="student in students"
          :key="student.id"
          class="p-5 rounded-2xl bg-slate-50 border border-slate-200 hover:border-emerald-500 transition-all flex flex-col justify-between group shadow-sm hover:bg-white"
        >
          <div>
            <!-- Top Card Header -->
            <div class="flex items-start justify-between gap-4">
              <div class="flex items-center gap-3.5">
                <img
                  :src="student.avatar"
                  alt="Student Avatar"
                  class="w-14 h-14 rounded-2xl object-cover border border-slate-300"
                />
                <div>
                  <h4 class="text-base font-bold text-slate-900 group-hover:text-emerald-700 transition-colors">
                    {{ student.name }}
                  </h4>
                  <div class="text-xs text-slate-500 font-mono">NISN: {{ student.nisn }}</div>
                  <div class="text-[11px] text-indigo-700 font-semibold">SMKN 1 Industri • RPL</div>
                </div>
              </div>

              <!-- Indikator Jumlah Jurnal yang Menunggu Divalidasi -->
              <div>
                <span
                  v-if="student.pendingJournals > 0"
                  class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-300"
                >
                  <span>⏳</span> {{ student.pendingJournals }} Menunggu Validasi
                </span>
                <span
                  v-else
                  class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300"
                >
                  ✓ Jurnal Up-to-date
                </span>
              </div>
            </div>

            <!-- Stats Bar Siswa -->
            <div class="grid grid-cols-2 gap-3 mt-5 pt-4 border-t border-slate-200 text-xs">
              <div class="p-2.5 rounded-xl bg-white border border-slate-200">
                <span class="text-slate-500 text-[11px] block font-medium">Tingkat Kehadiran:</span>
                <span class="font-extrabold text-slate-900 text-sm">{{ student.attendanceRate }}%</span>
                <span class="text-[10px] text-emerald-700 block font-bold">Sangat Disiplin</span>
              </div>

              <div class="p-2.5 rounded-xl bg-white border border-slate-200">
                <span class="text-slate-500 text-[11px] block font-medium">Jurnal Terakhir:</span>
                <span class="font-extrabold text-slate-900 text-sm">{{ student.lastJournalDate }}</span>
                <span class="text-[10px] text-slate-500 block truncate">{{ student.lastJournalTitle }}</span>
              </div>
            </div>
          </div>

          <!-- Bottom Card Action -->
          <div class="mt-5 pt-3 flex items-center justify-between gap-3">
            <span class="text-[11px] text-slate-500 font-medium">Angkatan 32 • Periode 2026</span>
            <button
              @click="goToValidation(student.id)"
              class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm active:scale-95"
            >
              <span>Validasi Jurnal</span>
              <span>&rarr;</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useAppStore } from '~/composables/useAppStore'

const { activeMenu } = useAppStore()

const students = ref([
  {
    id: 1,
    name: 'Budi Santoso',
    nisn: '0061234567',
    avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150',
    pendingJournals: 1,
    attendanceRate: 96.4,
    lastJournalDate: '26 Sep 2026',
    lastJournalTitle: 'Split-Screen UX Validasi'
  },
  {
    id: 2,
    name: 'Siti Rahma',
    nisn: '0061234568',
    avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150',
    pendingJournals: 2,
    attendanceRate: 92.8,
    lastJournalDate: '25 Sep 2026',
    lastJournalTitle: 'Slicing Dashboard Siswa'
  },
  {
    id: 3,
    name: 'Rizky Pratama',
    nisn: '0061234569',
    avatar: 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=150',
    pendingJournals: 0,
    attendanceRate: 85.0,
    lastJournalDate: '21 Sep 2026',
    lastJournalTitle: 'Riset Desain UI Figma'
  },
  {
    id: 4,
    name: 'Dewi Anggraeni',
    nisn: '0061234570',
    avatar: 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150',
    pendingJournals: 0,
    attendanceRate: 98.0,
    lastJournalDate: '26 Sep 2026',
    lastJournalTitle: 'Unit Testing Vue Components'
  }
])

const goToValidation = (studentId: number) => {
  activeMenu.value = 'validasi_jurnal'
}
</script>
