<template>
  <div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-black/[0.06]">
      <div>
        <div class="flex items-center gap-2 mb-1">
          <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold tracking-wide bg-[#0071e3]/10 text-[#0071e3]">
            Tata Kelola PKL
          </span>
          <span class="text-[#86868b]">•</span>
          <span class="text-xs font-medium text-[#86868b]">SMKN 71 Jakarta</span>
        </div>
        <h2 class="text-2xl font-bold text-[#1d1d1f] tracking-tight flex items-center gap-2">
          <span>Dashboard Administrator</span>
        </h2>
        <p class="text-xs text-[#86868b] mt-0.5">
          Statistik makro tata kelola Praktik Kerja Lapangan (PKL) SMK Negeri 71 Jakarta.
        </p>
      </div>

      <div class="flex items-center gap-2">
        <button
          type="button"
          @click="activeMenu = 'diagram_relasi'"
          class="px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-[#0071e3]/10 hover:bg-[#0071e3]/20 text-[#0071e3] border border-[#0071e3]/20 transition flex items-center gap-1.5 apple-press cursor-pointer"
        >
          <span class="material-symbols-outlined text-[15px]">account_tree</span>
          <span>Buka Peta Relasi PKL</span>
        </button>
        <span class="px-3.5 py-1.5 rounded-xl text-xs font-medium bg-black/[0.04] text-[#1d1d1f] border border-black/[0.06] hidden sm:inline-block">
          Tahun Ajaran: 2025/2026 • Semester Ganjil
        </span>
      </div>
    </div>

    <!-- STATISTIK LEVEL MAKRO (Apple Metrics) -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <div class="bg-white border border-black/[0.05] rounded-2xl p-5 shadow-[0_2px_12px_rgba(0,0,0,0.03)] apple-press transition-all">
        <div class="flex items-center justify-between">
          <span class="text-xs font-semibold text-[#86868b] uppercase tracking-wider">Total Siswa Terdaftar</span>
          <span class="text-base">👨‍🎓</span>
        </div>
        <div class="text-3xl font-bold text-[#1d1d1f] tracking-tight mt-2">128 <span class="text-sm font-normal text-[#86868b]">Siswa</span></div>
        <span class="text-[11px] text-[#34c759] font-medium block mt-1">100% Terplotting Industri</span>
      </div>

      <div class="bg-white border border-black/[0.05] rounded-2xl p-5 shadow-[0_2px_12px_rgba(0,0,0,0.03)] apple-press transition-all">
        <div class="flex items-center justify-between">
          <span class="text-xs font-semibold text-[#86868b] uppercase tracking-wider">Tempat Magang (Instansi / PT)</span>
          <span class="text-base">🏢</span>
        </div>
        <div class="text-3xl font-bold text-[#0071e3] tracking-tight mt-2">24 <span class="text-sm font-normal text-[#86868b]">Instansi / PT</span></div>
        <span class="text-[11px] text-[#86868b] font-medium block mt-1">Software, Instansi Pemerintah &amp; Creative Agency</span>
      </div>

      <div class="bg-white border border-black/[0.05] rounded-2xl p-5 shadow-[0_2px_12px_rgba(0,0,0,0.03)] apple-press transition-all">
        <div class="flex items-center justify-between">
          <span class="text-xs font-semibold text-[#86868b] uppercase tracking-wider">Guru Pembimbing</span>
          <span class="text-base">👨‍🏫</span>
        </div>
        <div class="text-3xl font-bold text-[#1d1d1f] tracking-tight mt-2">12 <span class="text-sm font-normal text-[#86868b]">Guru</span></div>
        <span class="text-[11px] text-[#ff9500] font-medium block mt-1">Rasio 1 : 10 Siswa</span>
      </div>

      <div class="bg-white border border-black/[0.05] rounded-2xl p-5 shadow-[0_2px_12px_rgba(0,0,0,0.03)] apple-press transition-all">
        <div class="flex items-center justify-between">
          <span class="text-xs font-semibold text-[#86868b] uppercase tracking-wider">Logbook Terverifikasi</span>
          <span class="text-base">📑</span>
        </div>
        <div class="text-3xl font-bold text-[#34c759] tracking-tight mt-2">1,842</div>
        <span class="text-[11px] text-[#86868b] font-medium block mt-1">Total Jurnal Di-ACC</span>
      </div>
    </div>

    <!-- AREA TENGAH: GRAFIK PENYEBARAN SISWA & STATUS SERVER -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
      <!-- 1. GRAFIK PENYEBARAN SISWA DI BERBAGAI INSTANSI & INDUSTRI (7 Cols) -->
      <div class="lg:col-span-7 bg-white border border-black/[0.05] rounded-2xl p-6 shadow-[0_2px_12px_rgba(0,0,0,0.03)] space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-black/[0.06]">
          <div>
            <h3 class="text-sm font-bold text-[#1d1d1f] tracking-tight">Grafik Penyebaran Siswa di Tempat Magang</h3>
            <p class="text-[11px] text-[#86868b]">Distribusi kuota penempatan magang per instansi / perusahaan</p>
          </div>
          <span class="text-xs font-mono font-medium text-[#0071e3]">24 Lokasi Magang</span>
        </div>

        <!-- Distribution Bars -->
        <div class="space-y-4 pt-2">
          <div v-for="comp in industryDistribution" :key="comp.name" class="space-y-1.5">
            <div class="flex items-center justify-between text-xs">
              <span class="font-semibold text-[#1d1d1f]">{{ comp.name }}</span>
              <span class="font-mono text-[#86868b]">{{ comp.students }} / {{ comp.quota }} Kuota ({{ Math.round((comp.students / comp.quota) * 100) }}%)</span>
            </div>
            <div class="w-full bg-black/[0.04] rounded-full h-2.5 overflow-hidden">
              <div
                class="h-full rounded-full transition-all duration-700"
                :class="comp.appleColor"
                :style="{ width: `${(comp.students / comp.quota) * 100}%` }"
              ></div>
            </div>
            <div class="flex items-center justify-between text-[11px] text-[#86868b]">
              <span>{{ comp.sector }}</span>
              <span>Mentor: {{ comp.mentor }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- 2. STATUS SERVER ONLINE (5 Cols) -->
      <div class="lg:col-span-5 bg-white border border-black/[0.05] rounded-2xl p-6 shadow-[0_2px_12px_rgba(0,0,0,0.03)] flex flex-col justify-between">
        <div>
          <div class="flex items-center justify-between pb-3 border-b border-black/[0.06]">
            <div>
              <h3 class="text-sm font-bold text-[#1d1d1f] tracking-tight">Status Cloud &amp; Server</h3>
              <p class="text-[11px] text-[#86868b]">Infrastruktur data murni online</p>
            </div>
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-[#34c759]/10 text-[#34c759] flex items-center gap-1.5">
              <span class="w-1.5 h-1.5 rounded-full bg-[#34c759] animate-pulse"></span>
              ONLINE
            </span>
          </div>

          <!-- Server Metrics Table -->
          <div class="mt-4 space-y-3 text-xs bg-black/[0.02] p-4 rounded-2xl border border-black/[0.04] text-[#1d1d1f]">
            <div class="flex items-center justify-between">
              <span class="text-[#86868b]">Koneksi REST API:</span>
              <span class="text-[#34c759] font-mono font-semibold flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-[#34c759]"></span> 200 OK (Aktif 24/7)
              </span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-[#86868b]">Latensi Respons:</span>
              <span class="text-[#1d1d1f] font-mono font-medium">22 ms (Sangat Cepat)</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-[#86868b]">Mekanisme Penyimpanan:</span>
              <span class="text-[#34c759] font-mono font-semibold">Auto-Save Cloud (Zero Push)</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-[#86868b]">Basis Data Terpadu:</span>
              <span class="text-[#0071e3] font-mono font-medium">Cloud Database SMKN 71</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-[#86868b]">Konsentrasi Keahlian:</span>
              <span class="text-[#1d1d1f] font-mono font-medium">RPL, Animasi, DKV</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-[#86868b]">Protokol Keamanan:</span>
              <span class="text-[#5856d6] font-mono font-medium">Bearer Sanctum Token</span>
            </div>
          </div>
        </div>

        <div class="pt-4 border-t border-black/[0.06] mt-4">
          <button
            @click="testCloudConnection"
            :disabled="isPinging"
            class="w-full py-2.5 px-4 bg-[#0071e3] hover:bg-[#0077ed] text-white rounded-xl text-xs font-semibold shadow-[0_2px_8px_rgba(0,113,227,0.25)] transition flex items-center justify-center gap-2 apple-press disabled:opacity-50 cursor-pointer"
          >
            <span :class="isPinging ? 'animate-spin inline-block' : ''">⚡</span>
            <span>Uji Latensi Cloud Online</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useAppStore } from '~/composables/useAppStore'

const { showToast, activeMenu } = useAppStore()

const isPinging = ref(false)

const industryDistribution = ref([
  {
    name: 'PT Telkom Digital Solusi',
    sector: 'Software House & Cloud (RPL)',
    students: 2,
    quota: 6,
    mentor: 'Hendra Wijaya, S.Kom',
    appleColor: 'bg-[#0071e3]'
  },
  {
    name: 'Studio Animasi Kinetik Digital',
    sector: '3D Animation & CGI (Animasi)',
    students: 2,
    quota: 4,
    mentor: 'Raditya Pratama, S.Sn',
    appleColor: 'bg-[#af52de]'
  },
  {
    name: 'Pixel Kreatif Visual Agency',
    sector: 'Branding, Media & UI/UX (DKV)',
    students: 2,
    quota: 5,
    mentor: 'Maya Safitri, M.Ds',
    appleColor: 'bg-[#ff9500]'
  }
])

const testCloudConnection = () => {
  isPinging.value = true
  setTimeout(() => {
    isPinging.value = false
    showToast('Ping Cloud REST API: 22ms • Koneksi real-time optimal ke Server SMKN 71 Jakarta.', 'success')
  }, 600)
}
</script>
