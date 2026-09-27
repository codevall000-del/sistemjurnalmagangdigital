<template>
  <div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
      <div>
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
          <span>🎛️ Dashboard Admin / Kaprog RPL</span>
        </h2>
        <p class="text-xs text-slate-500 mt-1">
          Statistik makro tata kelola Praktik Kerja Lapangan (PKL) SMK Negeri 1 Industri.
        </p>
      </div>

      <div class="flex items-center gap-2">
        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
          Tahun Ajaran: 2025/2026 • Semester Ganjil
        </span>
      </div>
    </div>

    <!-- STATISTIK LEVEL MAKRO -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
        <div class="flex items-center justify-between">
          <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Siswa Terdaftar</span>
          <span class="text-lg">👨‍🎓</span>
        </div>
        <div class="text-3xl font-extrabold text-slate-900 mt-2">128 <span class="text-sm font-normal text-slate-500">Siswa</span></div>
        <span class="text-[11px] text-emerald-700 font-semibold block mt-1">100% Terplotting Industri</span>
      </div>

      <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
        <div class="flex items-center justify-between">
          <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Mitra Industri (DUDI)</span>
          <span class="text-lg">🏢</span>
        </div>
        <div class="text-3xl font-extrabold text-slate-900 mt-2">24 <span class="text-sm font-normal text-slate-500">Perusahaan</span></div>
        <span class="text-[11px] text-indigo-700 font-semibold block mt-1">Software &amp; Creative Agency</span>
      </div>

      <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
        <div class="flex items-center justify-between">
          <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Guru Pembimbing</span>
          <span class="text-lg">👨‍🏫</span>
        </div>
        <div class="text-3xl font-extrabold text-slate-900 mt-2">12 <span class="text-sm font-normal text-slate-500">Guru</span></div>
        <span class="text-[11px] text-amber-700 font-semibold block mt-1">Rasio 1 : 10 Siswa</span>
      </div>

      <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
        <div class="flex items-center justify-between">
          <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Logbook Terverifikasi</span>
          <span class="text-lg">📑</span>
        </div>
        <div class="text-3xl font-extrabold text-emerald-700 mt-2">1,842</div>
        <span class="text-[11px] text-slate-500 font-medium block mt-1">Total Jurnal Di-ACC</span>
      </div>
    </div>

    <!-- AREA TENGAH: GRAFIK PENYEBARAN SISWA & STATUS SINKRONISASI SERVER PUSAT -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
      <!-- 1. GRAFIK PENYEBARAN SISWA DI BERBAGAI INDUSTRI (7 Cols) -->
      <div class="lg:col-span-7 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200">
          <div>
            <h3 class="text-sm font-bold text-slate-900">Grafik Penyebaran Siswa di Berbagai Industri</h3>
            <p class="text-[11px] text-slate-500">Distribusi kuota penempatan magang per mitra DUDI</p>
          </div>
          <span class="text-xs font-mono font-semibold text-indigo-700">24 Perusahaan</span>
        </div>

        <!-- Distribution Bars -->
        <div class="space-y-4 pt-2">
          <div v-for="comp in industryDistribution" :key="comp.name" class="space-y-1.5">
            <div class="flex items-center justify-between text-xs">
              <span class="font-bold text-slate-900">{{ comp.name }}</span>
              <span class="font-mono text-slate-600">{{ comp.students }} / {{ comp.quota }} Kuota ({{ Math.round((comp.students / comp.quota) * 100) }}%)</span>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden p-0.5 border border-slate-200">
              <div
                class="h-full rounded-full transition-all duration-700"
                :class="comp.color"
                :style="{ width: `${(comp.students / comp.quota) * 100}%` }"
              ></div>
            </div>
            <div class="flex items-center justify-between text-[10px] text-slate-500">
              <span>{{ comp.sector }}</span>
              <span>Pembimbing: {{ comp.mentor }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- 2. STATUS SINKRONISASI SERVER PUSAT (5 Cols) -->
      <div class="lg:col-span-5 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
        <div>
          <div class="flex items-center justify-between pb-3 border-b border-slate-200">
            <div>
              <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                <span>🛰️ Status Sinkronisasi Server Pusat</span>
              </h3>
              <p class="text-[11px] text-slate-500">Infrastruktur data &amp; sinkronisasi desktop hybrid</p>
            </div>
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
              ONLINE
            </span>
          </div>

          <!-- Server Metrics Table -->
          <div class="mt-4 space-y-3 text-xs bg-slate-50 p-4 rounded-xl border border-slate-200 text-slate-700">
            <div class="flex items-center justify-between">
              <span class="text-slate-500">Status Server REST API:</span>
              <span class="text-emerald-700 font-mono font-bold flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-600"></span> 200 OK (Optimal)
              </span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-slate-500">Sinkronisasi Terakhir:</span>
              <span class="text-slate-800 font-mono font-semibold">{{ lastServerSync }}</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-slate-500">Antrean Perubahan Lokal:</span>
              <span class="text-slate-800 font-mono">0 Pending Records</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-slate-500">Basis Data Desktop:</span>
              <span class="text-indigo-700 font-mono font-semibold">SQLite 3.42 (WAL Mode)</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-slate-500">Kapasitas Storage:</span>
              <span class="text-slate-800 font-mono">42.8 MB / 10 GB</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-slate-500">Protokol Keamanan:</span>
              <span class="text-cyan-700 font-mono font-semibold">Bearer Sanctum Token</span>
            </div>
          </div>
        </div>

        <div class="pt-4 border-t border-slate-200 mt-4">
          <button
            @click="forceSync"
            :disabled="isSyncing"
            class="w-full py-2.5 px-4 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition flex items-center justify-center gap-2 shadow-sm active:scale-95 disabled:opacity-50"
          >
            <span :class="isSyncing ? 'animate-spin inline-block' : ''">🔄</span>
            <span>Paksa Sinkronisasi Server Sekarang</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useAppStore } from '~/composables/useAppStore'

const { showToast } = useAppStore()

const isSyncing = ref(false)
const lastServerSync = ref('27 Sep 2026, 13:25:00 WIB')

const industryDistribution = ref([
  {
    name: 'PT Telkom Digital Solusi',
    sector: 'Software & Cloud Engineering',
    students: 6,
    quota: 6,
    mentor: 'Hendra Wijaya, S.Kom',
    color: 'bg-emerald-600'
  },
  {
    name: 'PT Inovasi Media Kreatif',
    sector: 'UI/UX Design & Frontend',
    students: 4,
    quota: 4,
    mentor: 'Linda Kusuma, M.Ds',
    color: 'bg-cyan-600'
  },
  {
    name: 'Bank Mandiri IT Hub Innovation',
    sector: 'Fintech & Cyber Security',
    students: 7,
    quota: 8,
    mentor: 'Ahmad Fauzi (PIC DUDI)',
    color: 'bg-indigo-600'
  },
  {
    name: 'CV Nusantara Studio Digital',
    sector: 'Game Dev & Flutter Mobile',
    students: 3,
    quota: 4,
    mentor: 'Bagus Setiawan',
    color: 'bg-amber-600'
  }
])

const forceSync = () => {
  isSyncing.value = true
  setTimeout(() => {
    isSyncing.value = false
    const now = new Date()
    lastServerSync.value = `${now.toLocaleDateString('id-ID')} ${now.toLocaleTimeString('id-ID')} WIB`
    showToast('Seluruh tabel basis data berhasil disinkronisasi ke server pusat!', 'success')
  }, 1200)
}
</script>
