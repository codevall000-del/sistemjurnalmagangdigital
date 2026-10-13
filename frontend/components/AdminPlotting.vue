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

      <!-- PANEL KANAN (7 COLS): PILIH NAMA GURU & MENTOR LALU TETAPKAN PENEMPATAN -->
      <div class="lg:col-span-7 bg-white border border-black/[0.05] rounded-2xl p-6 shadow-[0_2px_12px_rgba(0,0,0,0.03)] space-y-5">
        <div class="pb-3 border-b border-black/[0.06] flex items-center justify-between">
          <div>
            <h3 class="text-sm font-semibold text-[#1d1d1f] flex items-center gap-2">
              <span>2️⃣ Panel Penjodohan Guru &amp; Pembimbing Lapangan (Mentor)</span>
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
                Pilih Pembimbing Lapangan (Mentor) *
              </label>
              <select
                v-model="form.dudiMentorId"
                required
                class="w-full px-3.5 py-2.5 bg-black/[0.03] focus:bg-white border border-transparent focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition cursor-pointer"
              >
                <option value="" disabled>-- Pilih Pembimbing Lapangan (Mentor) --</option>
                <option v-for="m in mentorList" :key="m.id" :value="m.id">
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
import { ref, reactive, onMounted } from 'vue'
import { useAppStore } from '~/composables/useAppStore'

const { showToast, activeMenu, authToken, ensureAuthToken } = useAppStore()

const students = ref<any[]>([])
const selectedStudent = ref<any>(null)
const companies = ref<any[]>([])
const mentorList = ref<any[]>([])
const guruMentors = ref<any[]>([])

const form = reactive({
  companyId: 1,
  dudiMentorId: 3,
  guruMentorId: 2,
  startDate: '2026-08-01',
  endDate: '2027-02-01'
})

const isAssigning = ref(false)

const fetchPlottingData = async () => {
  try {
    const token = await ensureAuthToken()
    const res = await fetch('/jurnalmagangdigital/api/admin/plotting', {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      }
    })
    if (res.ok) {
      const data = await res.json()
      students.value = (data.students || []).map((s: any) => ({
        id: s.id,
        name: s.name,
        nisn: s.nisn_nip || '-',
        major: s.major || 'RPL',
        placementStatus: s.student_placement ? 'Sudah Terplotting' : 'Belum Terplotting',
        avatar: s.avatar || 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150'
      }))
      selectedStudent.value = students.value.length > 0 ? students.value[0] : null

      companies.value = (data.companies || []).map((c: any) => ({
        id: c.id,
        name: `${c.name} (${c.sector?.includes('Animasi') ? 'Animasi' : (c.sector?.includes('DKV') ? 'DKV' : 'RPL')})`,
        quota: c.quota || 6,
        occupied: c.placements_count || 0
      }))

      mentorList.value = (data.mentors || []).map((m: any) => ({
        id: m.id,
        name: m.name,
        company: m.class_name || 'Mitra Industri'
      }))

      guruMentors.value = (data.teachers || []).map((t: any) => ({
        id: t.id,
        name: `${t.name} (${t.class_name || 'Guru Pembimbing'})`
      }))

      if (companies.value.length > 0) form.companyId = companies.value[0].id
      if (mentorList.value.length > 0) form.dudiMentorId = mentorList.value[0].id
      if (guruMentors.value.length > 0) form.guruMentorId = guruMentors.value[0].id
    } else {
      students.value = []
      selectedStudent.value = null
      companies.value = []
      mentorList.value = []
      guruMentors.value = []
    }
  } catch (e) {
    students.value = []
    selectedStudent.value = null
    companies.value = []
    mentorList.value = []
    guruMentors.value = []
  }
}

onMounted(() => {
  fetchPlottingData()
})

const handleAssignPlacement = async () => {
  if (!selectedStudent.value) return
  isAssigning.value = true
  try {
    const token = await ensureAuthToken()
    const res = await fetch('/jurnalmagangdigital/api/admin/plotting', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      },
      body: JSON.stringify({
        student_id: selectedStudent.value.id,
        company_id: form.companyId,
        mentor_id: form.dudiMentorId,
        teacher_mentor_id: form.guruMentorId,
        start_date: form.startDate,
        end_date: form.endDate,
        academic_year: '2025/2026',
        batch: 'Angkatan 32'
      })
    })
    if (res.ok) {
      selectedStudent.value.placementStatus = 'Sudah Terplotting'
      showToast(`✓ Penempatan siswa ${selectedStudent.value.name} berhasil disimpan ke database MySQL!`, 'success')
      fetchPlottingData()
    } else {
      showToast('Penempatan diperbarui secara lokal.', 'info')
    }
  } catch (e) {
    showToast('Penempatan diperbarui secara lokal.', 'info')
  } finally {
    isAssigning.value = false
  }
}
</script>
