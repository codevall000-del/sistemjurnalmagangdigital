<template>
  <div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
      <div>
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
          <span>🎯 Plotting &amp; Penempatan Siswa Magang</span>
        </h2>
        <p class="text-xs text-slate-500 mt-1">
          Antarmuka panel ganda untuk menjodohkan siswa dengan mitra industri dan guru pembimbing.
        </p>
      </div>

      <div class="flex items-center gap-2">
        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
          Mode: Dual-Panel Matching System
        </span>
      </div>
    </div>

    <!-- VIEW PANEL GANDA UNTUK MENJODOHKAN DATA -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
      <!-- PANEL KIRI (5 COLS): PILIH NAMA SISWA -->
      <div class="lg:col-span-5 bg-white border border-slate-200 rounded-2xl p-5 shadow-sm flex flex-col">
        <div class="pb-3 border-b border-slate-200 flex items-center justify-between">
          <div>
            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
              <span>1️⃣ Panel Siswa</span>
            </h3>
            <p class="text-[11px] text-slate-500">Pilih salah satu siswa di bawah:</p>
          </div>
          <span class="text-xs font-mono text-slate-500">{{ students.length }} Siswa</span>
        </div>

        <!-- Student Selectable List -->
        <div class="mt-4 space-y-2 flex-1 overflow-y-auto max-h-[420px] pr-1">
          <div
            v-for="s in students"
            :key="s.id"
            @click="selectedStudent = s"
            :class="selectedStudent.id === s.id ? 'bg-rose-50 border-2 border-rose-500 text-rose-950 shadow-sm' : 'bg-white border border-slate-200 text-slate-800 hover:border-slate-300 hover:bg-slate-50'"
            class="p-3.5 rounded-xl cursor-pointer transition flex items-center justify-between gap-3"
          >
            <div class="flex items-center gap-3">
              <input
                type="radio"
                :checked="selectedStudent.id === s.id"
                class="accent-rose-600 w-4 h-4 cursor-pointer"
              />
              <img :src="s.avatar" class="w-9 h-9 rounded-xl object-cover border border-slate-200" />
              <div>
                <h4 class="text-xs font-bold text-slate-900">{{ s.name }}</h4>
                <div class="text-[10px] text-slate-500 font-mono">NISN: {{ s.nisn }}</div>
              </div>
            </div>

            <div>
              <span
                v-if="s.placementStatus === 'Sudah Terplotting'"
                class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200"
              >
                ✓ Terplotting
              </span>
              <span
                v-else
                class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-50 text-amber-700 border border-amber-200"
              >
                ⏳ Belum
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- PANEL KANAN (7 COLS): PILIH NAMA GURU & DUDI LALU TETAPKAN PENEMPATAN -->
      <div class="lg:col-span-7 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-5">
        <div class="pb-3 border-b border-slate-200 flex items-center justify-between">
          <div>
            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
              <span>2️⃣ Panel Penjodohan Guru &amp; DUDI</span>
            </h3>
            <p class="text-[11px] text-slate-500">
              Siswa terpilih: <strong class="text-rose-700">{{ selectedStudent.name }}</strong>
            </p>
          </div>
          <span class="text-xs font-mono font-bold text-emerald-700">Target Match</span>
        </div>

        <form @submit.prevent="handleAssignPlacement" class="space-y-4 text-xs">
          <!-- 1. Perusahaan Mitra DUDI -->
          <div>
            <label class="block font-semibold text-slate-700 mb-1.5">
              Pilih Mitra Industri (Perusahaan DUDI) *
            </label>
            <select
              v-model="form.companyId"
              required
              class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 shadow-sm cursor-pointer"
            >
              <option value="" disabled>-- Pilih Perusahaan Industri --</option>
              <option v-for="c in companies" :key="c.id" :value="c.id">
                {{ c.name }} (Sisa Kuota: {{ c.quota - c.occupied }} Kursi)
              </option>
            </select>
          </div>

          <!-- 2. Pembimbing DUDI & Guru Pembimbing -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block font-semibold text-slate-700 mb-1.5">
                Pilih Pembimbing Industri (DUDI) *
              </label>
              <select
                v-model="form.dudiMentorId"
                required
                class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 shadow-sm cursor-pointer"
              >
                <option value="" disabled>-- Pilih Mentor DUDI --</option>
                <option v-for="m in dudiMentors" :key="m.id" :value="m.id">
                  {{ m.name }} ({{ m.company }})
                </option>
              </select>
            </div>

            <div>
              <label class="block font-semibold text-slate-700 mb-1.5">
                Pilih Guru Pembimbing Sekolah *
              </label>
              <select
                v-model="form.guruMentorId"
                required
                class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 shadow-sm cursor-pointer"
              >
                <option value="" disabled>-- Pilih Guru Pembimbing --</option>
                <option v-for="g in guruMentors" :key="g.id" :value="g.id">
                  {{ g.name }}
                </option>
              </select>
            </div>
          </div>

          <!-- 3. Periode Tanggal Magang -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block font-semibold text-slate-700 mb-1.5">Tanggal Mulai Magang *</label>
              <input
                v-model="form.startDate"
                type="date"
                required
                class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 shadow-sm"
              />
            </div>
            <div>
              <label class="block font-semibold text-slate-700 mb-1.5">Tanggal Selesai Magang *</label>
              <input
                v-model="form.endDate"
                type="date"
                required
                class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 shadow-sm"
              />
            </div>
          </div>

          <!-- TOMBOL TETAPKAN PENEMPATAN -->
          <div class="pt-4">
            <button
              type="submit"
              :disabled="isAssigning"
              class="w-full py-3.5 px-6 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold shadow-sm transition flex items-center justify-center gap-2 active:scale-95 disabled:opacity-50"
            >
              <span v-if="isAssigning" class="animate-spin inline-block">⏳</span>
              <span>🔗 Tetapkan Penempatan</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue'
import { useAppStore } from '~/composables/useAppStore'

const { showToast } = useAppStore()

const students = ref([
  { id: 1, name: 'Budi Santoso', nisn: '0061234567', placementStatus: 'Sudah Terplotting', avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150' },
  { id: 2, name: 'Siti Rahma', nisn: '0061234568', placementStatus: 'Sudah Terplotting', avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150' },
  { id: 3, name: 'Rizky Pratama', nisn: '0061234569', placementStatus: 'Sudah Terplotting', avatar: 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=150' },
  { id: 4, name: 'Dewi Anggraeni', nisn: '0061234570', placementStatus: 'Sudah Terplotting', avatar: 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150' },
  { id: 5, name: 'Fajar Nugraha', nisn: '0061234571', placementStatus: 'Belum Terplotting', avatar: 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150' },
])

const selectedStudent = ref(students.value[0])

const companies = ref([
  { id: 1, name: 'PT Telkom Digital Solusi', quota: 6, occupied: 6 },
  { id: 2, name: 'PT Inovasi Media Kreatif', quota: 4, occupied: 3 },
  { id: 3, name: 'Bank Mandiri IT Hub Innovation', quota: 8, occupied: 7 },
  { id: 4, name: 'CV Nusantara Studio Digital', quota: 4, occupied: 2 },
])

const dudiMentors = ref([
  { id: 1, name: 'Hendra Wijaya, S.Kom', company: 'PT Telkom Digital Solusi' },
  { id: 2, name: 'Linda Kusuma, M.Ds', company: 'PT Inovasi Media Kreatif' },
  { id: 3, name: 'Bagus Setiawan', company: 'CV Nusantara Studio' },
])

const guruMentors = ref([
  { id: 1, name: 'Dra. Nurul Hidayah, M.Pd' },
  { id: 2, name: 'Ahmad Fauzi, S.Pd' },
])

const form = reactive({
  companyId: 1,
  dudiMentorId: 1,
  guruMentorId: 1,
  startDate: '2026-07-01',
  endDate: '2026-11-27'
})

const isAssigning = ref(false)

const handleAssignPlacement = () => {
  isAssigning.value = true
  setTimeout(() => {
    isAssigning.value = false
    selectedStudent.value.placementStatus = 'Sudah Terplotting'
    showToast(`Penempatan untuk ${selectedStudent.value.name} berhasil ditetapkan! Surat tugas telah digenerate.`, 'success')
  }, 700)
}
</script>
