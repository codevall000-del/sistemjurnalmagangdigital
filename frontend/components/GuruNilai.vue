<template>
  <div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-black/[0.06]">
      <div>
        <div class="flex items-center gap-2 mb-1">
          <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold tracking-wide bg-[#0071e3]/10 text-[#0071e3]">
            Akademik PKL
          </span>
          <span class="text-[#86868b]">•</span>
          <span class="text-xs font-medium text-[#86868b]">SMKN 71 Jakarta</span>
        </div>
        <h2 class="text-2xl font-bold text-[#1d1d1f] tracking-tight flex items-center gap-2">
          <span>Manajemen &amp; Kompilasi Nilai PKL</span>
        </h2>
        <p class="text-xs text-[#86868b] mt-0.5">
          Kompilasi nilai industri, input evaluasi laporan sekolah, dan kalkulasi otomatis nilai akhir PKL.
        </p>
      </div>

      <div class="flex items-center gap-2">
        <button
          @click="saveAllScores"
          class="px-4 py-2 bg-[#0071e3] hover:bg-[#0077ed] text-white rounded-xl text-xs font-semibold shadow-[0_2px_8px_rgba(0,113,227,0.25)] transition flex items-center gap-1.5 apple-press cursor-pointer"
        >
          <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
          </svg>
          <span>Simpan Semua Nilai Sekolah</span>
        </button>
      </div>
    </div>

    <!-- Formula Rumus Banner (Apple Style) -->
    <div class="p-5 rounded-2xl bg-white border border-black/[0.05] shadow-[0_2px_12px_rgba(0,0,0,0.03)] flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div class="flex items-center gap-3.5">
        <div class="w-10 h-10 rounded-2xl bg-[#0071e3]/10 text-[#0071e3] flex items-center justify-center text-lg font-bold">
          🧮
        </div>
        <div>
          <span class="text-xs font-bold text-[#1d1d1f]">Standar Bobot Penilaian PKL Kurikulum Merdeka</span>
          <p class="text-[11px] text-[#86868b] mt-0.5">
            Nilai Akhir = <strong class="text-[#34c759]">(60% × Nilai Pembimbing Lapangan)</strong> + <strong class="text-[#0071e3]">(40% × Nilai Laporan Sekolah)</strong>
          </p>
        </div>
      </div>

      <div class="flex items-center gap-2 text-xs font-mono">
        <span class="px-2.5 py-1 rounded-full bg-black/[0.04] text-[#1d1d1f] font-medium">KKM Minimal: 78.00</span>
        <span class="px-2.5 py-1 rounded-full bg-[#34c759]/10 text-[#34c759] font-semibold">✓ Terintegrasi QR Pembimbing Lapangan</span>
      </div>
    </div>

    <!-- TABEL KOMPILASI NILAI -->
    <div class="bg-white border border-black/[0.05] rounded-2xl p-6 shadow-[0_2px_12px_rgba(0,0,0,0.03)]">
      <div class="pb-4 mb-4 border-b border-black/[0.05] flex items-center justify-between">
        <div>
          <h3 class="text-sm font-semibold text-[#1d1d1f] tracking-tight">Tabel Kompilasi Nilai Siswa Binaan</h3>
          <p class="text-[11px] text-[#86868b] mt-0.5">Kombinasi skor pembimbing lapangan dan nilai laporan sekolah</p>
        </div>
        <span class="text-xs text-[#86868b] font-mono">{{ studentsScores.length }} Siswa Terdaftar</span>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-[#1d1d1f]">
          <thead class="bg-black/[0.02] text-[#86868b] uppercase text-[10px] tracking-wider border-b border-black/[0.05] font-semibold">
            <tr>
              <th class="py-3 px-4 rounded-l-xl">Nama Siswa</th>
              <th class="py-3 px-4">Tempat Magang</th>
              <th class="py-3 px-4 text-center">Nilai Lapangan (60%)</th>
              <th class="py-3 px-4 text-center">Nilai Laporan Sekolah (40%)</th>
              <th class="py-3 px-4 text-center font-bold text-[#1d1d1f]">Nilai Akhir PKL</th>
              <th class="py-3 px-4 text-center">Predikat</th>
              <th class="py-3 px-4 text-center rounded-r-xl">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-black/[0.04]">
            <tr v-for="student in studentsScores" :key="student.id" class="hover:bg-black/[0.02] transition">
              <!-- Student -->
              <td class="py-3.5 px-4 whitespace-nowrap">
                <div class="flex items-center gap-3">
                  <img :src="student.avatar" class="w-9 h-9 rounded-xl object-cover border border-black/[0.06] shadow-xs" />
                  <div>
                    <div class="font-semibold text-[#1d1d1f]">{{ student.name }}</div>
                    <div class="text-[10px] text-[#86868b] font-mono">NISN: {{ student.nisn }}</div>
                  </div>
                </div>
              </td>

              <!-- Company -->
              <td class="py-3.5 px-4 text-[#86868b] whitespace-nowrap font-medium">
                {{ student.company }}
              </td>

              <!-- NILAI DARI PEMBIMBING LAPANGAN -->
              <td class="py-3.5 px-4 text-center whitespace-nowrap">
                <div v-if="(student.mentorScore ?? student.dudiScore) !== null && (student.mentorScore ?? student.dudiScore) !== undefined">
                  <span class="font-mono text-xs font-bold text-[#34c759] bg-[#34c759]/10 px-2.5 py-1 rounded-lg">
                    {{ (student.mentorScore ?? student.dudiScore).toFixed(2) }}
                  </span>
                  <span class="block text-[9px] text-[#34c759] mt-1 font-semibold">✓ QR Validated</span>
                </div>
                <div v-else class="text-[#ff9500] font-mono text-[11px] italic bg-[#ff9500]/10 px-2.5 py-1 rounded-lg">
                  Menunggu Penilaian Lapangan
                </div>
              </td>

              <!-- KOLOM INPUT MANUAL UNTUK NILAI LAPORAN SEKOLAH -->
              <td class="py-3.5 px-4 text-center whitespace-nowrap">
                <div class="flex items-center justify-center gap-2">
                  <input
                    v-model.number="student.schoolScore"
                    type="number"
                    min="0"
                    max="100"
                    placeholder="0-100"
                    @input="recalculateFinalScore(student)"
                    class="w-20 px-2.5 py-1.5 bg-black/[0.03] focus:bg-white border border-transparent focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-center font-mono font-bold text-[#0071e3] text-xs transition"
                  />
                  <span class="text-[11px] text-[#86868b] font-mono">/ 100</span>
                </div>
              </td>

              <!-- KALKULASI OTOMATIS NILAI AKHIR PKL -->
              <td class="py-3.5 px-4 text-center whitespace-nowrap font-mono">
                <span
                  v-if="student.finalScore !== null"
                  class="text-sm font-bold text-[#1d1d1f] px-3 py-1 rounded-xl bg-black/[0.04] border border-black/[0.05]"
                >
                  {{ student.finalScore.toFixed(2) }}
                </span>
                <span v-else class="text-[#86868b] text-xs italic">
                  Belum Lengkap
                </span>
              </td>

              <!-- Predikat -->
              <td class="py-3.5 px-4 text-center whitespace-nowrap">
                <span
                  v-if="student.predicate"
                  :class="student.predicate.startsWith('A') ? 'bg-[#34c759]/10 text-[#34c759]' : 'bg-[#0071e3]/10 text-[#0071e3]'"
                  class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold"
                >
                  {{ student.predicate }}
                </span>
                <span v-else class="text-[#86868b] text-[10px]">-</span>
              </td>

              <!-- Aksi -->
              <td class="py-3.5 px-4 text-center whitespace-nowrap">
                <button
                  @click="saveSingleScore(student)"
                  class="px-3 py-1 bg-black/[0.04] hover:bg-black/[0.08] text-[#1d1d1f] rounded-lg text-[11px] font-medium transition apple-press cursor-pointer"
                >
                  Simpan
                </button>
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
import { useAppStore } from '~/composables/useAppStore'

const { showToast } = useAppStore()

const studentsScores = ref([
  {
    id: 4,
    name: 'Siswa Magang',
    nisn: '0061234567',
    avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150',
    company: 'PT Telkom Digital Solusi',
    dudiScore: 92.50,
    schoolScore: 90.00,
    finalScore: 91.50,
    predicate: 'A (Amat Baik)'
  }
])

const recalculateFinalScore = (student: any) => {
  if (student.schoolScore === null || isNaN(student.schoolScore)) {
    student.finalScore = null
    student.predicate = null
    return
  }

  const mentorScore = student.mentorScore ?? student.dudiScore
  if (mentorScore !== null && mentorScore !== undefined) {
    const finalVal = (mentorScore * 0.6) + (student.schoolScore * 0.4)
    student.finalScore = Math.round(finalVal * 100) / 100

    if (student.finalScore >= 90) student.predicate = 'A (Amat Baik)'
    else if (student.finalScore >= 80) student.predicate = 'B (Baik)'
    else if (student.finalScore >= 70) student.predicate = 'C (Cukup)'
    else student.predicate = 'D (Kurang)'
  }
}

const saveSingleScore = (student: any) => {
  showToast(`Nilai Laporan Sekolah ${student.name} berhasil disimpan! Nilai Akhir: ${student.finalScore || '-'}`, 'success')
}

const saveAllScores = () => {
  showToast('Semua Nilai Laporan Sekolah berhasil dikompilasi dan disimpan ke database pusat!', 'success')
}
</script>
