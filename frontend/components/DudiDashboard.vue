<template>
  <div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-black/[0.06]">
      <div>
        <div class="flex items-center gap-2 mb-1">
          <span class="text-[11px] uppercase tracking-wider text-[#0071e3] font-semibold">Portal Pembimbing Lapangan</span>
          <span class="text-black/20">•</span>
          <span class="text-[11px] text-[#86868b]">SMKN 71 Jakarta</span>
        </div>
        <h2 class="text-2xl sm:text-3xl font-bold text-[#1d1d1f] tracking-tight">
          Dashboard Pembimbing Lapangan
        </h2>
        <p class="text-[13px] text-[#86868b] mt-0.5">
          Monitoring aktivitas siswa magang aktif di PT Telkom Digital Solusi.
        </p>
      </div>

      <div class="flex items-center gap-2">
        <span class="px-3.5 py-1.5 rounded-full text-[12px] font-semibold bg-[#0071e3]/10 text-[#0071e3] border border-[#0071e3]/20 flex items-center gap-1.5">
          <span class="material-symbols-outlined text-[16px]">domain</span>
          <span>PT Telkom Digital Solusi • Unit Core Platform</span>
        </span>
      </div>
    </div>

    <!-- Quick Stat Cards (Apple HIG Design) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
      <div class="bg-white border border-black/[0.05] rounded-2xl p-5 shadow-[0_2px_12px_rgba(0,0,0,0.03)] hover:shadow-[0_4px_20px_rgba(0,0,0,0.06)] transition-all flex items-center justify-between apple-press">
        <div>
          <span class="text-[11px] font-semibold text-[#86868b] uppercase tracking-wider">Siswa Aktif Binaan</span>
          <div class="text-3xl font-bold text-[#1d1d1f] mt-1 tracking-tight">4 <span class="text-sm font-normal text-[#86868b]">Siswa</span></div>
          <p class="text-[11px] text-[#34c759] font-semibold mt-1">Semua terdaftar aktif</p>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-[#0071e3]/10 text-[#0071e3] flex items-center justify-center">
          <span class="material-symbols-outlined text-[24px]">group</span>
        </div>
      </div>

      <div class="bg-white border border-black/[0.05] rounded-2xl p-5 shadow-[0_2px_12px_rgba(0,0,0,0.03)] hover:shadow-[0_4px_20px_rgba(0,0,0,0.06)] transition-all flex items-center justify-between apple-press">
        <div>
          <span class="text-[11px] font-semibold text-[#86868b] uppercase tracking-wider">Menunggu Validasi</span>
          <div class="text-3xl font-bold text-[#ff9500] mt-1 tracking-tight">3 <span class="text-sm font-normal text-[#86868b]">Jurnal</span></div>
          <p class="text-[11px] text-[#ff9500] font-semibold mt-1">Memerlukan persetujuan pembimbing</p>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-[#ff9500]/10 text-[#b26a00] flex items-center justify-center">
          <span class="material-symbols-outlined text-[24px]">edit_note</span>
        </div>
      </div>

      <div class="bg-white border border-black/[0.05] rounded-2xl p-5 shadow-[0_2px_12px_rgba(0,0,0,0.03)] hover:shadow-[0_4px_20px_rgba(0,0,0,0.06)] transition-all flex items-center justify-between apple-press">
        <div>
          <span class="text-[11px] font-semibold text-[#86868b] uppercase tracking-wider">Rata-rata Disiplin</span>
          <div class="text-3xl font-bold text-[#34c759] mt-1 tracking-tight">94.8%</div>
          <p class="text-[11px] text-[#248a3d] font-semibold mt-1">Kehadiran minggu ini</p>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-[#34c759]/10 text-[#248a3d] flex items-center justify-center">
          <span class="material-symbols-outlined text-[24px]">verified</span>
        </div>
      </div>
    </div>

    <!-- DAFTAR KARTU SISWA YANG SEDANG AKTIF MAGANG -->
    <div class="bg-white border border-black/[0.05] rounded-2xl p-6 shadow-[0_2px_12px_rgba(0,0,0,0.03)]">
      <div class="flex items-center justify-between pb-4 mb-5 border-b border-black/[0.05]">
        <div>
          <h3 class="text-base font-bold text-[#1d1d1f] tracking-tight">
            Daftar Siswa Binaan &amp; Validasi
          </h3>
          <p class="text-[12px] text-[#86868b] mt-0.5">Tinjau logbook harian atau periksa lembar kehadiran siswa</p>
        </div>
      </div>

      <!-- Cards Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div
          v-for="student in students"
          :key="student.id"
          class="p-5 rounded-2xl bg-[#f5f5f7] border border-black/[0.04] hover:bg-white hover:border-[#0071e3]/30 transition-all flex flex-col justify-between group shadow-xs apple-press"
        >
          <div>
            <!-- Top Card Header -->
            <div class="flex items-start justify-between gap-4">
              <div class="flex items-center gap-3.5">
                <img
                  :src="student.avatar"
                  alt="Student Avatar"
                  class="w-12 h-12 rounded-2xl object-cover border border-black/[0.08] shadow-xs"
                />
                <div>
                  <h4 class="text-[14px] font-bold text-[#1d1d1f] group-hover:text-[#0071e3] transition-colors">
                    {{ student.name }}
                  </h4>
                  <div class="text-[11px] text-[#86868b] font-mono">NISN: {{ student.nisn }}</div>
                  <div class="text-[10px] text-[#0071e3] font-semibold mt-0.5">SMKN 71 Jakarta • RPL</div>
                </div>
              </div>

              <!-- Indikator Jurnal -->
              <div>
                <span
                  v-if="student.pendingJournals > 0"
                  class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-[#ff9500]/10 text-[#b26a00]"
                >
                  <span class="w-1.5 h-1.5 rounded-full bg-[#ff9500]"></span> {{ student.pendingJournals }} Menunggu Validasi
                </span>
                <span
                  v-else
                  class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-[#34c759]/10 text-[#248a3d]"
                >
                  ✓ Jurnal Up-to-date
                </span>
              </div>
            </div>

            <!-- Stats Bar Siswa -->
            <div class="grid grid-cols-2 gap-3 mt-4 pt-3 border-t border-black/[0.05] text-xs">
              <div class="p-3 rounded-xl bg-white border border-black/[0.04] shadow-xs">
                <span class="text-[#86868b] text-[10px] block font-medium">Tingkat Kehadiran:</span>
                <span class="font-bold text-[#1d1d1f] text-sm">{{ student.attendanceRate }}%</span>
                <span class="text-[10px] text-[#34c759] block font-semibold">Sangat Disiplin</span>
              </div>

              <div class="p-3 rounded-xl bg-white border border-black/[0.04] shadow-xs">
                <span class="text-[#86868b] text-[10px] block font-medium">Jurnal Terakhir:</span>
                <span class="font-bold text-[#1d1d1f] text-sm">{{ student.lastJournalDate }}</span>
                <span class="text-[10px] text-[#86868b] block truncate">{{ student.lastJournalTitle }}</span>
              </div>
            </div>
          </div>

          <!-- Bottom Card Action -->
          <div class="mt-4 pt-3 flex items-center justify-between gap-3 border-t border-black/[0.04]">
            <span class="text-[11px] text-[#86868b] font-medium">Angkatan 32 • Periode 2026</span>
            <button
              @click="goToValidation(student.id)"
              class="px-4 py-2 bg-[#0071e3] hover:bg-[#0077ed] text-white rounded-xl text-[12px] font-semibold transition-all flex items-center gap-1.5 shadow-[0_2px_8px_rgba(0,113,227,0.25)] apple-press cursor-pointer"
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
    id: 4,
    name: 'Siswa Magang',
    nisn: '0061234567',
    avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150',
    pendingJournals: 1,
    attendanceRate: 96.4,
    lastJournalDate: '26 Sep 2026',
    lastJournalTitle: 'Split-Screen UX Validasi'
  }
])

const goToValidation = (studentId: number) => {
  activeMenu.value = 'validasi_jurnal'
}
</script>
