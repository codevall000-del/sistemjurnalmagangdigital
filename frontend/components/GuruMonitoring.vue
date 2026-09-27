<template>
  <div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
      <div>
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
          <span>🔎 Monitoring Jurnal &amp; Kehadiran (Read-Only)</span>
        </h2>
        <p class="text-xs text-slate-500 mt-1">
          Pantau rekam jejak jurnal siswa dan status persetujuan oleh Pembimbing Industri.
        </p>
      </div>

      <!-- FILTER PENCARIAN BERDASARKAN NAMA SISWA -->
      <div class="relative w-full sm:w-72">
        <input
          v-model="searchQuery"
          type="text"
          placeholder="Cari nama siswa atau NISN..."
          class="w-full pl-9 pr-4 py-2 bg-white border border-slate-300 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500 shadow-sm"
        />
        <span class="absolute left-3 top-2.5 text-slate-400 text-xs">🔍</span>
      </div>
    </div>

    <!-- Student Selector Chips -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1">
      <button
        v-for="student in filteredStudents"
        :key="student.id"
        @click="selectedStudent = student"
        :class="selectedStudent.id === student.id ? 'bg-amber-600 text-white border-amber-600 shadow-sm' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50'"
        class="px-3.5 py-2 rounded-xl border text-xs font-semibold whitespace-nowrap transition flex items-center gap-2"
      >
        <img :src="student.avatar" class="w-5 h-5 rounded-full object-cover" />
        <span>{{ student.name }}</span>
        <span class="text-[10px] opacity-75 font-mono">({{ student.company }})</span>
      </button>
    </div>

    <!-- Active Student Profile Card -->
    <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div class="flex items-center gap-4">
        <img :src="selectedStudent.avatar" class="w-14 h-14 rounded-2xl object-cover border-2 border-amber-500" />
        <div>
          <h3 class="text-base font-bold text-slate-900">{{ selectedStudent.name }}</h3>
          <p class="text-xs text-slate-500">NISN: {{ selectedStudent.nisn }} • Penempatan: {{ selectedStudent.company }}</p>
          <p class="text-[11px] text-amber-700 font-medium mt-0.5">Mentor DUDI: {{ selectedStudent.mentorDudi }}</p>
        </div>
      </div>

      <div class="flex items-center gap-3 text-xs">
        <div class="text-right">
          <span class="text-slate-500 block text-[11px]">Total Jurnal Di-ACC:</span>
          <span class="font-bold text-emerald-700 font-mono text-sm">{{ selectedStudent.accJournals }} Selesai</span>
        </div>
      </div>
    </div>

    <!-- TIMELINE SELURUH ISI JURNAL SISWA (READ-ONLY) -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-6">
      <div class="pb-3 border-b border-slate-200 flex items-center justify-between">
        <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
          <span>📜 Timeline Kronologis Jurnal Siswa</span>
        </h3>
        <span class="text-xs font-mono text-slate-500">Mode: Read-Only (Hanya Baca)</span>
      </div>

      <!-- Timeline List -->
      <div class="relative pl-6 space-y-6 border-l-2 border-slate-200 ml-3">
        <div
          v-for="entry in selectedStudent.timeline"
          :key="entry.id"
          class="relative group"
        >
          <!-- Timeline Bullet -->
          <div
            :class="entry.status === 'diacc' ? 'bg-emerald-600 ring-emerald-100' : (entry.status === 'revisi' ? 'bg-rose-600 ring-rose-100' : 'bg-amber-500 ring-amber-100')"
            class="absolute -left-[31px] top-1.5 w-4 h-4 rounded-full ring-4 bg-white border-2 border-white shadow-sm"
          ></div>

          <!-- Card Content (Read-Only) -->
          <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
              <div>
                <span class="text-xs font-mono text-amber-700 font-semibold">{{ entry.dateFormatted }}</span>
                <h4 class="text-sm font-bold text-slate-900 mt-0.5">{{ entry.title }}</h4>
              </div>

              <!-- Status ACC DUDI Badge -->
              <div>
                <span
                  v-if="entry.status === 'diacc'"
                  class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200"
                >
                  ✓ Di-ACC oleh DUDI
                </span>
                <span
                  v-else-if="entry.status === 'revisi'"
                  class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200"
                >
                  ⚠️ Revisi DUDI
                </span>
                <span
                  v-else
                  class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200"
                >
                  ⏳ Menunggu ACC DUDI
                </span>
              </div>
            </div>

            <!-- Description -->
            <p class="text-xs text-slate-700 leading-relaxed bg-white p-3 rounded-xl border border-slate-200">
              {{ entry.activity }}
            </p>

            <!-- Foto Lampiran & Catatan DUDI -->
            <div class="flex flex-col sm:flex-row items-start gap-4 pt-1">
              <img
                :src="entry.photo"
                alt="Bukti Siswa"
                class="w-32 h-20 object-cover rounded-xl border border-slate-200 shrink-0"
              />

              <div class="flex-1 text-xs">
                <span class="text-[10px] uppercase font-bold text-slate-500 block mb-0.5">Catatan Validasi DUDI:</span>
                <div v-if="entry.dudiNote" class="text-amber-900 italic bg-amber-50 p-2.5 rounded-lg border border-amber-200 text-[11px]">
                  "{{ entry.dudiNote }}"
                </div>
                <div v-else class="text-slate-400 italic text-[11px]">
                  Tidak ada catatan khusus / Belum divalidasi.
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'

const searchQuery = ref('')

const students = ref([
  {
    id: 1,
    name: 'Budi Santoso',
    nisn: '0061234567',
    company: 'PT Telkom Digital Solusi',
    mentorDudi: 'Hendra Wijaya, S.Kom',
    accJournals: 18,
    avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150',
    timeline: [
      {
        id: 1,
        dateFormatted: 'Jumat, 26 Sep 2026',
        title: 'Pembuatan Tampilan Split-Screen Validasi DUDI',
        activity: 'Merancang layout split view sesuai panduan UX desktop: daftar siswa di panel samping kiri dan detail jurnal interaktif beserta aksi validasi di panel kanan.',
        photo: 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?w=600',
        status: 'menunggu',
        dudiNote: null
      },
      {
        id: 2,
        dateFormatted: 'Kamis, 25 Sep 2026',
        title: 'Optimasi Upload Foto Jurnal dengan Kompresi Gambar Canvas',
        activity: 'Menerapkan kompresi gambar berbasis HTML5 Canvas client-side sebelum upload ke server backend untuk menghemat bandwidth pengguna dan storage server.',
        photo: 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=600',
        status: 'revisi',
        dudiNote: 'Hasil kompresi terlalu kecil sehingga tulisan kode di layar agak blur. Tolong perbaiki resolusi target minimal 70%.'
      },
      {
        id: 3,
        dateFormatted: 'Rabu, 24 Sep 2026',
        title: 'Integrasi State Management Pinia pada Nuxt 3',
        activity: 'Mengonfigurasi state global untuk token autentikasi, status koneksi offline/online dengan reactive indicator, dan persistence data profil.',
        photo: 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=600',
        status: 'diacc',
        dudiNote: 'Arsitektur store sangat rapi dan reusable.'
      }
    ]
  },
  {
    id: 2,
    name: 'Siti Rahma',
    nisn: '0061234568',
    company: 'PT Telkom Digital Solusi',
    mentorDudi: 'Hendra Wijaya, S.Kom',
    accJournals: 14,
    avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150',
    timeline: [
      {
        id: 4,
        dateFormatted: 'Kamis, 25 Sep 2026',
        title: 'Slicing Desain Dashboard Siswa ke Nuxt 3 & Tailwind CSS',
        activity: 'Membuat komponen widget tombol raksasa Check-In/Check-Out, widget persentase kehadiran dengan circular gauge, serta widget sisa hari magang.',
        photo: 'https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?w=600',
        status: 'menunggu',
        dudiNote: null
      }
    ]
  },
  {
    id: 3,
    name: 'Rizky Pratama',
    nisn: '0061234569',
    company: 'PT Inovasi Media Kreatif',
    mentorDudi: 'Linda Kusuma, M.Ds',
    accJournals: 8,
    avatar: 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=150',
    timeline: [
      {
        id: 5,
        dateFormatted: 'Senin, 21 Sep 2026',
        title: 'Riset Desain UI Figma',
        activity: 'Mengumpulkan wireframe dan moodboard design system aplikasi e-commerce.',
        photo: 'https://images.unsplash.com/photo-1581291518655-9523c93269c4?w=600',
        status: 'diacc',
        dudiNote: 'Desain rapi dan konsisten.'
      }
    ]
  }
])

const selectedStudent = ref(students.value[0])

const filteredStudents = computed(() => {
  if (!searchQuery.value) return students.value
  const q = searchQuery.value.toLowerCase()
  return students.value.filter(s => s.name.toLowerCase().includes(q) || s.nisn.includes(q))
})
</script>
