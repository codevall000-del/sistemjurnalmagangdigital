<template>
  <div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-black/[0.06]">
      <div>
        <div class="flex items-center gap-2 mb-1">
          <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold tracking-wide bg-[#0071e3]/10 text-[#0071e3]">
            Monitoring Jurnal &amp; Kehadiran
          </span>
          <span class="text-[#86868b]">•</span>
          <span class="text-xs font-medium text-[#86868b]">SMKN 71 Jakarta</span>
        </div>
        <h2 class="text-2xl font-bold text-[#1d1d1f] tracking-tight flex items-center gap-2">
          <span>Monitoring Timeline Jurnal Siswa</span>
        </h2>
        <p class="text-xs text-[#86868b] mt-0.5">
          Filter dan pantau rekam jejak jurnal per mitra industri (PT) secara transparan dan akurat.
        </p>
      </div>

      <!-- FILTER PENCARIAN SISWA -->
      <div class="relative w-full sm:w-72">
        <input
          v-model="searchQuery"
          type="text"
          placeholder="Cari nama siswa, NISN, atau kelas..."
          class="w-full pl-9 pr-4 py-2 bg-black/[0.03] focus:bg-white border border-transparent focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-xs text-[#1d1d1f] placeholder-[#86868b] transition"
        />
        <svg class="w-3.5 h-3.5 absolute left-3 top-2.5 text-[#86868b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </div>
    </div>

    <!-- SEKSI FILTER BERDASARKAN PERUSAHAAN (PT) -->
    <div class="bg-white p-5 rounded-2xl border border-black/[0.05] shadow-[0_2px_12px_rgba(0,0,0,0.03)] space-y-3">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
        <span class="text-xs font-semibold text-[#1d1d1f] flex items-center gap-1.5">
          <span>🏢</span>
          <span>Pilih Seksi Mitra Industri (Tempat PKL):</span>
        </span>
        <span class="text-[11px] text-[#86868b] font-mono">
          Menampilkan {{ filteredStudents.length }} dari {{ students.length }} siswa
        </span>
      </div>

      <!-- PT Filter Buttons (Apple Segmented Style) -->
      <div class="apple-segmented-container overflow-x-auto">
        <button
          type="button"
          @click="selectedCompanyId = 'all'"
          :class="{ active: selectedCompanyId === 'all' }"
          class="apple-segmented-item whitespace-nowrap"
        >
          Semua Perusahaan ({{ students.length }})
        </button>

        <button
          type="button"
          v-for="comp in companyList"
          :key="comp.id"
          @click="selectedCompanyId = comp.id"
          :class="{ active: selectedCompanyId === comp.id }"
          class="apple-segmented-item whitespace-nowrap flex items-center gap-1.5"
        >
          <span>{{ comp.icon }}</span>
          <span>{{ comp.name }}</span>
          <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-black/[0.06] text-[#1d1d1f] font-mono font-semibold">
            {{ getStudentCountByCompany(comp.id) }}
          </span>
        </button>
      </div>
    </div>

    <!-- CHIPS DAFTAR SISWA (SESUAI PT TERPILIH) -->
    <div class="flex items-center gap-2.5 overflow-x-auto pb-1">
      <button
        v-for="student in filteredStudents"
        :key="student.id"
        type="button"
        @click="selectedStudent = student"
        :class="selectedStudent.id === student.id ? 'bg-[#0071e3] text-white shadow-[0_2px_8px_rgba(0,113,227,0.25)]' : 'bg-white text-[#1d1d1f] border border-black/[0.05] hover:bg-black/[0.03] shadow-xs'"
        class="px-4 py-2.5 rounded-2xl text-xs font-medium whitespace-nowrap transition-all flex items-center gap-3 cursor-pointer shrink-0 apple-press"
      >
        <img :src="student.avatar" class="w-7 h-7 rounded-full object-cover border border-white/20 shadow-xs" />
        <div class="flex flex-col text-left">
          <span class="font-semibold leading-tight">{{ student.name }}</span>
          <span class="text-[10px] opacity-75 font-mono">
            {{ student.major }} • {{ student.companyShort }}
          </span>
        </div>
        <span
          v-if="student.status === 'Kritis'"
          class="w-2 h-2 rounded-full bg-[#ff3b30] ring-2 ring-[#ff3b30]/30"
          title="Status Kritis: 4 Hari Tidak Aktif"
        ></span>
      </button>
    </div>

    <!-- KARTU PROFIL SISWA TERPILIH -->
    <div class="p-6 rounded-2xl bg-white border border-black/[0.05] shadow-[0_2px_12px_rgba(0,0,0,0.03)] flex flex-col lg:flex-row lg:items-center justify-between gap-5">
      <div class="flex items-start sm:items-center gap-4">
        <img :src="selectedStudent.avatar" class="w-16 h-16 rounded-2xl object-cover border border-black/[0.06] shadow-xs shrink-0" />
        <div class="flex flex-col">
          <div class="flex items-center gap-2 flex-wrap">
            <h3 class="text-lg font-bold text-[#1d1d1f] tracking-tight">{{ selectedStudent.name }}</h3>
            <span
              class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold uppercase tracking-wider"
              :class="(selectedStudent.major === 'RPL' || selectedStudent.major === 'PPLG') ? 'bg-[#0071e3]/10 text-[#0071e3]' : (selectedStudent.major === 'Animasi' ? 'bg-[#af52de]/10 text-[#af52de]' : 'bg-[#ff9500]/10 text-[#ff9500]')"
            >
              {{ selectedStudent.major === 'PPLG' ? 'RPL' : selectedStudent.major }}
            </span>
            <span class="text-xs font-mono text-[#86868b] font-medium">{{ selectedStudent.className }}</span>
          </div>
          <p class="text-xs text-[#86868b] mt-1">
            Penempatan: <strong class="text-[#1d1d1f]">{{ selectedStudent.company }}</strong> • NISN: <span class="font-mono">{{ selectedStudent.nisn }}</span>
          </p>
          <div class="flex items-center gap-3 mt-1.5 text-xs text-[#86868b]">
            <span>Pembimbing Lapangan: <strong class="text-[#1d1d1f]">{{ selectedStudent.mentorDudi }}</strong></span>
            <span>•</span>
            <a
              :href="`https://wa.me/${selectedStudent.phoneClean}`"
              target="_blank"
              class="text-[#34c759] hover:underline font-medium flex items-center gap-1"
            >
              <span>💬</span> Hubungi Siswa (WhatsApp)
            </a>
          </div>
        </div>
      </div>

      <!-- Ringkasan Logbook Siswa Terpilih -->
      <div class="flex items-center gap-3 sm:gap-6 self-start lg:self-auto bg-black/[0.02] p-4 rounded-2xl border border-black/[0.04] text-xs">
        <div class="text-center sm:text-right pr-4 border-r border-black/[0.06]">
          <span class="text-[#86868b] text-[10px] uppercase font-semibold block">Status Presensi:</span>
          <span class="font-semibold text-[#34c759] font-mono text-xs mt-0.5 block">
            {{ selectedStudent.todayAttendance }}
          </span>
        </div>
        <div class="text-center sm:text-right">
          <span class="text-[#86868b] text-[10px] uppercase font-semibold block">Logbook Di-ACC:</span>
          <span class="font-bold text-[#0071e3] font-mono text-base mt-0.5 block">
            {{ selectedStudent.accJournals }} Jurnal
          </span>
        </div>
      </div>
    </div>

    <!-- TIMELINE KRONOLOGIS JURNAL SISWA (READ-ONLY) -->
    <div class="bg-white border border-black/[0.05] rounded-2xl p-6 shadow-[0_2px_12px_rgba(0,0,0,0.03)] space-y-6">
      <div class="pb-3 border-b border-black/[0.06] flex flex-col sm:flex-row sm:items-center justify-between gap-2">
        <h3 class="text-base font-bold text-[#1d1d1f] tracking-tight flex items-center gap-2">
          <span>Timeline Kronologis Jurnal &amp; Dokumentasi</span>
        </h3>
        <span class="px-2.5 py-1 rounded-full text-[11px] font-mono font-medium bg-black/[0.04] text-[#86868b]">
          Mode Guru: Read-Only
        </span>
      </div>

      <!-- Timeline List -->
      <div class="relative pl-6 space-y-6 border-l-2 border-black/[0.06] ml-3">
        <div
          v-for="entry in selectedStudent.timeline"
          :key="entry.id"
          class="relative group"
        >
          <!-- Timeline Bullet -->
          <div
            :class="entry.status === 'diacc' ? 'bg-[#34c759] ring-[#34c759]/20' : (entry.status === 'revisi' ? 'bg-[#ff3b30] ring-[#ff3b30]/20' : 'bg-[#ff9500] ring-[#ff9500]/20')"
            class="absolute -left-[31px] top-1.5 w-3.5 h-3.5 rounded-full ring-4 bg-white border-2 border-white shadow-xs"
          ></div>

          <!-- Card Content (Apple Style) -->
          <div class="p-5 rounded-2xl bg-black/[0.015] border border-black/[0.05] space-y-3 hover:bg-black/[0.03] transition">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
              <div>
                <span class="text-xs font-mono text-[#0071e3] font-medium">{{ entry.dateFormatted }}</span>
                <h4 class="text-sm font-semibold text-[#1d1d1f] mt-0.5">{{ entry.title }}</h4>
              </div>

              <!-- Status ACC Pembimbing Lapangan Badge -->
              <div>
                <span
                  v-if="entry.status === 'diacc'"
                  class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-[#34c759]/10 text-[#34c759]"
                >
                  ✓ Disetujui Pembimbing Lapangan
                </span>
                <span
                  v-else-if="entry.status === 'revisi'"
                  class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-[#ff3b30]/10 text-[#ff3b30]"
                >
                  ⚠️ Revisi Pembimbing Lapangan
                </span>
                <span
                  v-else
                  class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-[#ff9500]/10 text-[#ff9500]"
                >
                  ⏳ Menunggu Review Pembimbing
                </span>
              </div>
            </div>

            <!-- Description -->
            <p class="text-xs text-[#1d1d1f] leading-relaxed bg-white p-4 rounded-xl border border-black/[0.05] shadow-xs">
              {{ entry.activity }}
            </p>

            <!-- Foto Bukti & Ulasan Mentor -->
            <div class="flex flex-col sm:flex-row items-start gap-4 pt-1">
              <img
                :src="entry.photo"
                alt="Dokumentasi Siswa"
                class="w-36 h-24 object-cover rounded-xl border border-black/[0.06] shadow-xs shrink-0"
              />

              <div class="flex-1 text-xs">
                <span class="text-[10px] uppercase font-semibold text-[#86868b] block mb-1">Catatan Validasi Pembimbing Lapangan:</span>
                <div v-if="entry.mentorNote || entry.dudiNote" class="text-[#ff9500] italic bg-[#ff9500]/10 p-3 rounded-xl border border-[#ff9500]/20 text-[11px] leading-relaxed">
                  "{{ entry.mentorNote || entry.dudiNote }}"
                </div>
                <div v-else class="text-[#86868b] italic text-[11px] bg-black/[0.03] p-2.5 rounded-xl border border-black/[0.04]">
                  Tidak ada catatan khusus / Jurnal telah disetujui tanpa revisi.
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
const selectedCompanyId = ref<string | number>('all')

const companyList = [
  { id: 1, name: 'PT Telkom Digital Solusi', icon: '💻' },
  { id: 2, name: 'Studio Animasi Kinetik Digital', icon: '🎬' },
  { id: 3, name: 'Pixel Kreatif Visual Agency', icon: '🎨' },
]

// 6 Siswa Binaan lengkap dari 3 PT & 3 Jurusan
const students = ref([
  {
    id: 4,
    name: 'Budi Santoso',
    nisn: '0061234567',
    className: 'XII RPL 1',
    major: 'RPL',
    majorBadge: 'bg-blue-50 text-blue-800 border border-blue-200',
    companyId: 1,
    company: 'PT Telkom Digital Solusi',
    companyShort: 'PT Telkom',
    mentorDudi: 'Hendra Wijaya, S.Kom',
    phoneClean: '6281200000004',
    status: 'Aktif',
    todayAttendance: 'Hadir 07:35 WIB (WFO)',
    accJournals: 18,
    avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150',
    timeline: [
      {
        id: 1,
        dateFormatted: 'Kamis, 2 Okt 2026',
        title: 'Implementasi Endpoint Geofencing & API Tap In/Out',
        activity: 'Membuat kalkulasi jarak Haversine formula pada Laravel controller untuk memvalidasi koordinat latitude dan longitude siswa terhadap radius gedung kantor tempat magang.',
        photo: 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=600',
        status: 'diacc',
        dudiNote: 'Logika perhitungan jarak sangat akurat dan teruji.'
      },
      {
        id: 2,
        dateFormatted: 'Rabu, 1 Okt 2026',
        title: 'Optimasi Upload Foto Jurnal dengan Kompresi Canvas',
        activity: 'Menerapkan kompresi gambar berbasis HTML5 Canvas client-side sebelum upload ke backend untuk menghemat bandwidth pengguna.',
        photo: 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=600',
        status: 'diacc',
        dudiNote: 'Hasil kompresi optimal dan jernih.'
      }
    ]
  },
  {
    id: 5,
    name: 'Siti Fauziah',
    nisn: '0061234568',
    className: 'XII RPL 2',
    major: 'RPL',
    majorBadge: 'bg-blue-50 text-blue-800 border border-blue-200',
    companyId: 1,
    company: 'PT Telkom Digital Solusi',
    companyShort: 'PT Telkom',
    mentorDudi: 'Hendra Wijaya, S.Kom',
    phoneClean: '6281200000005',
    status: 'Aktif',
    todayAttendance: 'Hadir 07:42 WIB (WFH)',
    accJournals: 16,
    avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150',
    timeline: [
      {
        id: 1,
        dateFormatted: 'Kamis, 2 Okt 2026',
        title: 'Pembuatan Komponen UI Vue 3 untuk Multi-PT Guru',
        activity: 'Membangun komponen Nuxt 3 untuk filter dan grouping data siswa binaan berdasarkan perusahaan tempat magang.',
        photo: 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?w=600',
        status: 'diacc',
        dudiNote: 'Desain antarmuka rapi dan responsif.'
      }
    ]
  },
  {
    id: 6,
    name: 'Ahmad Danu',
    nisn: '0061234569',
    className: 'XII Animasi 1',
    major: 'Animasi',
    majorBadge: 'bg-purple-50 text-purple-800 border border-purple-200',
    companyId: 2,
    company: 'Studio Animasi Kinetik Digital',
    companyShort: 'Studio Kinetik',
    mentorDudi: 'Raditya Pratama, S.Sn',
    phoneClean: '6281200000006',
    status: 'Aktif',
    todayAttendance: 'Hadir 08:05 WIB (WFA Studio)',
    accJournals: 17,
    avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150',
    timeline: [
      {
        id: 1,
        dateFormatted: 'Kamis, 2 Okt 2026',
        title: 'Rigging Karakter 3D Protagonis Seri Animasi Edukasi',
        activity: 'Menyelesaikan skeletal bone hierarchy dan inverse kinematics (IK) rigging pada karakter 3D Blender untuk adegan aksi lari.',
        photo: 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=600',
        status: 'diacc',
        dudiNote: 'Weight painting pada bagian sendi siku sudah natural.'
      }
    ]
  },
  {
    id: 7,
    name: 'Putri Maharani',
    nisn: '0061234570',
    className: 'XII Animasi 2',
    major: 'Animasi',
    majorBadge: 'bg-purple-50 text-purple-800 border border-purple-200',
    companyId: 2,
    company: 'Studio Animasi Kinetik Digital',
    companyShort: 'Studio Kinetik',
    mentorDudi: 'Raditya Pratama, S.Sn',
    phoneClean: '6281200000007',
    status: 'Aktif',
    todayAttendance: 'Hadir 07:50 WIB (WFO)',
    accJournals: 15,
    avatar: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150',
    timeline: [
      {
        id: 1,
        dateFormatted: 'Kamis, 2 Okt 2026',
        title: 'Lighting & Texturing Background Lingkungan Futuristik',
        activity: 'Menerapkan shader PBR (Physically Based Rendering) pada scene ruangan laboratorium virtual dan mengatur key light serta rim light.',
        photo: 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?w=600',
        status: 'diacc',
        dudiNote: 'Pencahayaan atmosferik sangat sesuai mood scene.'
      }
    ]
  },
  {
    id: 8,
    name: 'Rizky Pratama',
    nisn: '0061234571',
    className: 'XII DKV 1',
    major: 'DKV',
    majorBadge: 'bg-amber-50 text-amber-800 border border-amber-200',
    companyId: 3,
    company: 'Pixel Kreatif Visual Agency',
    companyShort: 'Pixel Kreatif',
    mentorDudi: 'Maya Safitri, M.Ds',
    phoneClean: '6281200000008',
    status: 'Kritis',
    todayAttendance: '⚠️ Belum Absen (4 Hari Kosong)',
    accJournals: 10,
    avatar: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150',
    timeline: [
      {
        id: 1,
        dateFormatted: 'Senin, 28 Sep 2026',
        title: 'Pembuatan Moodboard dan Desain Poster Kampanye',
        activity: 'Menyusun color palette dan tipografi untuk poster promosi produk UMKM mitra.',
        photo: 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=600',
        status: 'revisi',
        dudiNote: 'Komposisi huruf headline terlalu rapat, tolong lakukan penyesuaian kerning dan kirim ulang revisi.'
      }
    ]
  },
  {
    id: 9,
    name: 'Jessica Tan',
    nisn: '0061234572',
    className: 'XII DKV 2',
    major: 'DKV',
    majorBadge: 'bg-amber-50 text-amber-800 border border-amber-200',
    companyId: 3,
    company: 'Pixel Kreatif Visual Agency',
    companyShort: 'Pixel Kreatif',
    mentorDudi: 'Maya Safitri, M.Ds',
    phoneClean: '6281200000009',
    status: 'Aktif',
    todayAttendance: 'Hadir 07:55 WIB (WFH)',
    accJournals: 14,
    avatar: 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150',
    timeline: [
      {
        id: 1,
        dateFormatted: 'Kamis, 2 Okt 2026',
        title: 'Penyusunan Desain UI/UX Mobile App Katalog Interaktif',
        activity: 'Merancang wireframe fidelity tinggi di Figma dengan 12 artboard interaktif dan sistem design token.',
        photo: 'https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?w=600',
        status: 'diacc',
        dudiNote: 'Alur navigasi user flow sangat intuitif.'
      }
    ]
  }
])

const selectedStudent = ref(students.value[0])

const getStudentCountByCompany = (compId: number) => {
  return students.value.filter(s => s.companyId === compId).length
}

const filteredStudents = computed(() => {
  let list = students.value
  if (selectedCompanyId.value !== 'all') {
    list = list.filter(s => s.companyId === selectedCompanyId.value)
  }
  if (!searchQuery.value) return list
  const q = searchQuery.value.toLowerCase()
  return list.filter(s =>
    s.name.toLowerCase().includes(q) ||
    s.nisn.includes(q) ||
    s.className.toLowerCase().includes(q) ||
    s.major.toLowerCase().includes(q)
  )
})
</script>
