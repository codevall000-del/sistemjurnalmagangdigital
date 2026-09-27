<template>
  <div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
      <div>
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
          <span>🎓 Manajemen &amp; Kompilasi Nilai PKL</span>
        </h2>
        <p class="text-xs text-slate-500 mt-1">
          Kompilasi nilai industri, input evaluasi laporan sekolah, dan kalkulasi otomatis nilai akhir PKL.
        </p>
      </div>

      <div class="flex items-center gap-2">
        <button
          @click="saveAllScores"
          class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm active:scale-95"
        >
          <span>💾</span> Simpan Semua Nilai Sekolah
        </button>
      </div>
    </div>

    <!-- Formula Rumus Banner -->
    <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center text-lg font-bold">
          🧮
        </div>
        <div>
          <span class="text-xs font-bold text-slate-900">Standar Bobot Penilaian PKL Kurikulum Merdeka</span>
          <p class="text-[11px] text-slate-500">
            Nilai Akhir = <strong class="text-emerald-700">(60% × Nilai DUDI)</strong> + <strong class="text-amber-700">(40% × Nilai Laporan Sekolah)</strong>
          </p>
        </div>
      </div>

      <div class="flex items-center gap-4 text-xs font-mono text-slate-700">
        <span class="px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200">KKM Minimal: 78.00</span>
        <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200 font-semibold">Terintegrasi QR DUDI</span>
      </div>
    </div>

    <!-- TABEL KOMPILASI NILAI -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
      <div class="pb-4 mb-4 border-b border-slate-200 flex items-center justify-between">
        <h3 class="text-sm font-bold text-slate-900">Tabel Kompilasi Nilai Siswa Binaan</h3>
        <span class="text-xs text-slate-500 font-mono">4 Siswa Terdaftar</span>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-slate-700">
          <thead class="bg-slate-50 text-slate-600 uppercase text-[10px] tracking-wider border-b border-slate-200">
            <tr>
              <th class="py-3.5 px-4">Nama Siswa</th>
              <th class="py-3.5 px-4">Perusahaan (DUDI)</th>
              <th class="py-3.5 px-4 text-center">Nilai DUDI (60%)</th>
              <th class="py-3.5 px-4 text-center">Nilai Laporan Sekolah (40%)</th>
              <th class="py-3.5 px-4 text-center font-bold text-amber-700">Nilai Akhir PKL</th>
              <th class="py-3.5 px-4 text-center">Predikat</th>
              <th class="py-3.5 px-4 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200">
            <tr v-for="student in studentsScores" :key="student.id" class="hover:bg-slate-50 transition">
              <!-- Student -->
              <td class="py-3.5 px-4 whitespace-nowrap">
                <div class="flex items-center gap-3">
                  <img :src="student.avatar" class="w-8 h-8 rounded-lg object-cover border border-slate-200" />
                  <div>
                    <div class="font-bold text-slate-900">{{ student.name }}</div>
                    <div class="text-[10px] text-slate-500 font-mono">NISN: {{ student.nisn }}</div>
                  </div>
                </div>
              </td>

              <!-- Company -->
              <td class="py-3.5 px-4 text-slate-700 whitespace-nowrap">
                {{ student.company }}
              </td>

              <!-- NILAI DARI DUDI (OTOMATIS TERISI JIKA SUDAH INPUT DUDI) -->
              <td class="py-3.5 px-4 text-center whitespace-nowrap">
                <div v-if="student.dudiScore !== null">
                  <span class="font-mono text-sm font-extrabold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200">
                    {{ student.dudiScore.toFixed(2) }}
                  </span>
                  <span class="block text-[9px] text-emerald-700 mt-1 font-semibold">✓ Terverifikasi QR</span>
                </div>
                <div v-else class="text-amber-800 font-mono text-[11px] italic bg-amber-50 px-2 py-1 rounded-lg border border-amber-200">
                  ⏳ Menunggu DUDI
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
                    class="w-24 px-2.5 py-1.5 bg-white border border-slate-300 rounded-lg text-center font-mono font-bold text-amber-700 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500 shadow-sm"
                  />
                  <span class="text-[11px] text-slate-500 font-mono">/ 100</span>
                </div>
              </td>

              <!-- KALKULASI OTOMATIS NILAI AKHIR PKL -->
              <td class="py-3.5 px-4 text-center whitespace-nowrap font-mono">
                <span
                  v-if="student.finalScore !== null"
                  class="text-base font-black text-slate-900 px-3 py-1 rounded-xl bg-slate-100 border border-slate-300 shadow-sm"
                >
                  {{ student.finalScore.toFixed(2) }}
                </span>
                <span v-else class="text-slate-400 text-xs italic">
                  Belum Lengkap
                </span>
              </td>

              <!-- Predikat -->
              <td class="py-3.5 px-4 text-center whitespace-nowrap">
                <span
                  v-if="student.predicate"
                  :class="student.predicate.startsWith('A') ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-blue-50 text-blue-700 border-blue-200'"
                  class="px-2 py-0.5 rounded-full text-[10px] font-bold border"
                >
                  {{ student.predicate }}
                </span>
                <span v-else class="text-slate-400 text-[10px]">-</span>
              </td>

              <!-- Aksi -->
              <td class="py-3.5 px-4 text-center whitespace-nowrap">
                <button
                  @click="saveSingleScore(student)"
                  class="px-3 py-1 bg-white hover:bg-slate-100 text-slate-700 rounded-lg text-[11px] font-semibold border border-slate-300 shadow-sm transition active:scale-95"
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
    id: 1,
    name: 'Budi Santoso',
    nisn: '0061234567',
    avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150',
    company: 'PT Telkom Digital Solusi',
    dudiScore: 92.50,
    schoolScore: 90.00,
    finalScore: 91.50,
    predicate: 'A (Amat Baik)'
  },
  {
    id: 2,
    name: 'Siti Rahma',
    nisn: '0061234568',
    avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150',
    company: 'PT Telkom Digital Solusi',
    dudiScore: 88.00,
    schoolScore: 86.00,
    finalScore: 87.20,
    predicate: 'B+ (Sangat Baik)'
  },
  {
    id: 3,
    name: 'Rizky Pratama',
    nisn: '0061234569',
    avatar: 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=150',
    company: 'PT Inovasi Media Kreatif',
    dudiScore: null,
    schoolScore: 78.00,
    finalScore: null,
    predicate: null
  },
  {
    id: 4,
    name: 'Dewi Anggraeni',
    nisn: '0061234570',
    avatar: 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150',
    company: 'Bank Mandiri IT Hub',
    dudiScore: 95.00,
    schoolScore: 92.00,
    finalScore: 93.80,
    predicate: 'A (Amat Baik)'
  }
])

const recalculateFinalScore = (student: any) => {
  if (student.schoolScore === null || isNaN(student.schoolScore)) {
    student.finalScore = null
    student.predicate = null
    return
  }

  if (student.dudiScore !== null) {
    const finalVal = (student.dudiScore * 0.6) + (student.schoolScore * 0.4)
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
