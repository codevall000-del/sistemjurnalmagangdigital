<template>
  <div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-black/[0.06]">
      <div>
        <div class="flex items-center gap-2 mb-1">
          <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold tracking-wide bg-[#0071e3]/10 text-[#0071e3]">
            Plotting &amp; Penempatan
          </span>
          <span class="text-[#86868b]">•</span>
          <span class="text-xs font-medium text-[#86868b]">SMKN 71 Jakarta</span>
        </div>
        <h2 class="text-2xl font-bold text-[#1d1d1f] tracking-tight flex items-center gap-2">
          <span>Penempatan Siswa Magang</span>
        </h2>
        <p class="text-xs text-[#86868b] mt-0.5">
          Antarmuka panel ganda untuk menjodohkan siswa dengan mitra industri dan guru pembimbing.
        </p>
      </div>

      <div class="flex items-center gap-2">
        <button
          type="button"
          @click="activeMenu = 'diagram_relasi'"
          class="px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-[#0071e3]/10 hover:bg-[#0071e3]/20 text-[#0071e3] border border-[#0071e3]/20 transition flex items-center gap-1.5 apple-press cursor-pointer"
        >
          <span class="material-symbols-outlined text-[15px]">account_tree</span>
          <span>Buka Peta Relasi (Flowchart Draw.io)</span>
        </button>
        <span class="px-3.5 py-1.5 rounded-xl text-xs font-medium bg-black/[0.04] text-[#1d1d1f] border border-black/[0.06] hidden sm:inline-block">
          Dual-Panel Matching
        </span>
      </div>
    </div>

    <!-- VIEW PANEL GANDA UNTUK MENJODOHKAN DATA -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
      <!-- PANEL KIRI (5 COLS): PILIH NAMA SISWA -->
      <div class="lg:col-span-5 bg-white border border-black/[0.05] rounded-2xl p-6 shadow-[0_2px_12px_rgba(0,0,0,0.03)] flex flex-col">
        <div class="pb-3 border-b border-black/[0.06] flex items-center justify-between">
          <div>
            <h3 class="text-sm font-semibold text-[#1d1d1f] flex items-center gap-2">
              <span>1️⃣ Panel Siswa</span>
            </h3>
            <p class="text-[11px] text-[#86868b]">Pilih siswa untuk dijodohkan:</p>
          </div>
          <span class="text-xs font-mono text-[#86868b]">{{ students.length }} Siswa</span>
        </div>

        <!-- Student Selectable List -->
        <div class="mt-4 space-y-2 flex-1 overflow-y-auto max-h-[440px] pr-1">
          <div
            v-for="s in students"
            :key="s.id"
            @click="selectedStudent = s"
            :class="selectedStudent.id === s.id ? 'bg-[#0071e3]/10 border border-[#0071e3]/30 shadow-xs' : 'bg-black/[0.02] border border-black/[0.04] hover:bg-black/[0.04]'"
            class="p-3.5 rounded-2xl cursor-pointer transition flex items-center justify-between gap-3 apple-press"
          >
            <div class="flex items-center gap-3">
              <input
                type="radio"
                :checked="selectedStudent.id === s.id"
                class="accent-[#0071e3] w-4 h-4 cursor-pointer"
              />
              <img :src="s.avatar" class="w-9 h-9 rounded-xl object-cover border border-black/[0.06] shadow-xs" />
              <div>
                <h4 class="text-xs font-semibold text-[#1d1d1f]">{{ s.name }}</h4>
                <div class="text-[10px] text-[#86868b] font-mono">NISN: {{ s.nisn }} • {{ s.major }}</div>
              </div>
            </div>

            <div>
              <span
                v-if="s.placementStatus === 'Sudah Terplotting'"
                class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-[#34c759]/10 text-[#34c759]"
              >
                ✓ Terplotting
              </span>
              <span
                v-else
                class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-[#ff9500]/10 text-[#ff9500]"
              >
                ⏳ Belum
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- PANEL KANAN (7 COLS): PILIH NAMA GURU & DUDI LALU TETAPKAN PENEMPATAN -->
      <div class="lg:col-span-7 bg-white border border-black/[0.05] rounded-2xl p-6 shadow-[0_2px_12px_rgba(0,0,0,0.03)] space-y-5">
        <div class="pb-3 border-b border-black/[0.06] flex items-center justify-between">
          <div>
            <h3 class="text-sm font-semibold text-[#1d1d1f] flex items-center gap-2">
              <span>2️⃣ Panel Penjodohan Guru &amp; Pembimbing Lapangan</span>
            </h3>
            <p class="text-[11px] text-[#86868b]">
              Siswa terpilih: <strong class="text-[#0071e3]">{{ selectedStudent.name }}</strong>
            </p>
          </div>
          <span class="text-xs font-mono font-medium text-[#0071e3]">Target Match</span>
        </div>

        <form @submit.prevent="handleAssignPlacement" class="space-y-4 text-xs">
          <!-- 1. Tempat Magang / Instansi -->
          <div>
            <label class="block font-medium text-[#1d1d1f] mb-1.5">
              Pilih Tempat Magang (Instansi / Perusahaan) *
            </label>
            <select
              v-model="form.companyId"
              required
              class="w-full px-3.5 py-2.5 bg-black/[0.03] focus:bg-white border border-transparent focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition cursor-pointer"
            >
              <option value="" disabled>-- Pilih Tempat Magang --</option>
              <option v-for="c in companies" :key="c.id" :value="c.id">
                {{ c.name }} (Sisa Kuota: {{ c.quota - c.occupied }} Kursi)
              </option>
            </select>
          </div>

          <!-- 2. Pembimbing Lapangan & Guru Pembimbing -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block font-medium text-[#1d1d1f] mb-1.5">
                Pilih Pembimbing Lapangan *
              </label>
              <select
                v-model="form.dudiMentorId"
                required
                class="w-full px-3.5 py-2.5 bg-black/[0.03] focus:bg-white border border-transparent focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition cursor-pointer"
              >
                <option value="" disabled>-- Pilih Pembimbing Lapangan --</option>
                <option v-for="m in dudiMentors" :key="m.id" :value="m.id">
                  {{ m.name }} ({{ m.company }})
                </option>
              </select>
            </div>

            <div>
              <label class="block font-medium text-[#1d1d1f] mb-1.5">
                Pilih Guru Pembimbing Sekolah *
              </label>
              <select
                v-model="form.guruMentorId"
                required
                class="w-full px-3.5 py-2.5 bg-black/[0.03] focus:bg-white border border-transparent focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition cursor-pointer"
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
              <label class="block font-medium text-[#1d1d1f] mb-1.5">Tanggal Mulai Magang *</label>
              <input
                v-model="form.startDate"
                type="date"
                required
                class="w-full px-3.5 py-2.5 bg-black/[0.03] focus:bg-white border border-transparent focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition"
              />
            </div>
            <div>
              <label class="block font-medium text-[#1d1d1f] mb-1.5">Tanggal Selesai Magang *</label>
              <input
                v-model="form.endDate"
                type="date"
                required
                class="w-full px-3.5 py-2.5 bg-black/[0.03] focus:bg-white border border-transparent focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition"
              />
            </div>
          </div>

          <!-- TOMBOL TETAPKAN PENEMPATAN -->
          <div class="pt-4">
            <button
              type="submit"
              :disabled="isAssigning"
              class="w-full py-3.5 px-6 bg-[#0071e3] hover:bg-[#0077ed] text-white rounded-xl text-xs font-semibold shadow-[0_2px_8px_rgba(0,113,227,0.25)] transition flex items-center justify-center gap-2 apple-press disabled:opacity-50 cursor-pointer"
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

const { showToast, activeMenu } = useAppStore()

const students = ref([
  { id: 4, name: 'Budi Santoso', nisn: '0061234567', major: 'RPL', placementStatus: 'Sudah Terplotting', avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150' },
  { id: 5, name: 'Siti Fauziah', nisn: '0061234568', major: 'RPL', placementStatus: 'Sudah Terplotting', avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150' },
  { id: 6, name: 'Ahmad Danu', nisn: '0061234569', major: 'Animasi', placementStatus: 'Sudah Terplotting', avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150' },
  { id: 7, name: 'Putri Maharani', nisn: '0061234570', major: 'Animasi', placementStatus: 'Sudah Terplotting', avatar: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150' },
  { id: 8, name: 'Rizky Pratama', nisn: '0061234571', major: 'DKV', placementStatus: 'Sudah Terplotting', avatar: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150' },
  { id: 9, name: 'Jessica Tan', nisn: '0061234572', major: 'DKV', placementStatus: 'Sudah Terplotting', avatar: 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150' },
])

const selectedStudent = ref(students.value[0])

const companies = ref([
  { id: 1, name: 'PT Telkom Digital Solusi (RPL)', quota: 6, occupied: 2 },
  { id: 2, name: 'Studio Animasi Kinetik Digital (Animasi)', quota: 4, occupied: 2 },
  { id: 3, name: 'Pixel Kreatif Visual Agency (DKV)', quota: 5, occupied: 2 },
])

const dudiMentors = ref([
  { id: 3, name: 'Hendra Wijaya, S.Kom', company: 'PT Telkom Digital Solusi' },
  { id: 10, name: 'Raditya Pratama, S.Sn', company: 'Studio Animasi Kinetik' },
  { id: 11, name: 'Maya Safitri, M.Ds', company: 'Pixel Kreatif Visual Agency' },
])

const guruMentors = ref([
  { id: 2, name: 'Dra. Nurul Hidayah, M.Pd (Pembimbing Utama SMKN 71)' },
])

const form = reactive({
  companyId: 1,
  dudiMentorId: 3,
  guruMentorId: 2,
  startDate: '2026-07-01',
  endDate: '2026-11-27'
})

const isAssigning = ref(false)

const handleAssignPlacement = () => {
  isAssigning.value = true
  setTimeout(() => {
    isAssigning.value = false
    selectedStudent.value.placementStatus = 'Sudah Terplotting'
    showToast(`Penempatan untuk ${selectedStudent.value.name} berhasil diperbarui secara online!`, 'success')
  }, 500)
}
</script>
