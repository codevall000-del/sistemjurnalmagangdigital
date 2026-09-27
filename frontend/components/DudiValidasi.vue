<template>
  <div class="space-y-4 max-w-7xl mx-auto h-[calc(100vh-6.5rem)] flex flex-col">
    <!-- Header -->
    <div class="flex items-center justify-between pb-3 border-b border-slate-200 shrink-0">
      <div>
        <h2 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
          <span>✍️ Antarmuka Belah: Validasi Jurnal Magang (Split-Screen)</span>
        </h2>
        <p class="text-xs text-slate-500">
          Pilih siswa di panel kiri untuk meninjau detail logbook, foto hasil pekerjaan, dan memberikan umpan balik.
        </p>
      </div>

      <div class="text-xs text-slate-500 font-medium">
        Menampilkan: <span class="font-bold text-emerald-700">{{ activeStudent.name }}</span>
      </div>
    </div>

    <!-- SPLIT-SCREEN CONTAINER (PANEL KIRI & PANEL KANAN) - LIGHT FLAT DESIGN -->
    <div class="flex-1 grid grid-cols-12 gap-5 min-h-0">
      <!-- PANEL KIRI (35%): DAFTAR NAMA SISWA -->
      <div class="col-span-12 md:col-span-4 lg:col-span-4 bg-white border border-slate-200 rounded-2xl flex flex-col overflow-hidden shadow-sm">
        <div class="p-3.5 border-b border-slate-200 bg-slate-50">
          <div class="relative">
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Cari siswa atau NISN..."
              class="w-full pl-8 pr-3 py-2 bg-white border border-slate-300 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-600 transition"
            />
            <span class="absolute left-2.5 top-2.5 text-slate-400 text-xs">🔍</span>
          </div>
        </div>

        <!-- Student List Items -->
        <div class="flex-1 overflow-y-auto divide-y divide-slate-100 p-2 space-y-1">
          <div
            v-for="student in filteredStudents"
            :key="student.id"
            @click="selectStudent(student)"
            :class="activeStudent.id === student.id ? 'bg-emerald-50 border-emerald-500 text-emerald-950 ring-1 ring-emerald-500' : 'hover:bg-slate-50 text-slate-700 border-transparent'"
            class="p-3 rounded-xl border cursor-pointer transition flex items-center justify-between gap-3"
          >
            <div class="flex items-center gap-3 min-w-0">
              <img
                :src="student.avatar"
                alt="Avatar"
                class="w-10 h-10 rounded-xl object-cover border border-slate-300 shrink-0"
              />
              <div class="min-w-0">
                <h4 class="text-xs font-bold truncate text-slate-900">{{ student.name }}</h4>
                <div class="text-[10px] text-slate-500 font-mono">NISN: {{ student.nisn }}</div>
                <div class="text-[10px] text-indigo-700 font-medium truncate">RPL • Angkatan 32</div>
              </div>
            </div>

            <!-- Pending Badge -->
            <div class="shrink-0 text-right">
              <span
                v-if="student.pendingCount > 0"
                class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-300"
              >
                {{ student.pendingCount }} Baru
              </span>
              <span v-else class="text-[10px] text-slate-400 font-mono font-medium">Lengkap</span>
            </div>
          </div>
        </div>
      </div>

      <!-- PANEL KANAN (65%): DETAIL JURNAL, FOTO BUKTI, TOMBOL ACC/TOLAK & CATATAN UMPAN BALIK -->
      <div class="col-span-12 md:col-span-8 lg:col-span-8 bg-white border border-slate-200 rounded-2xl flex flex-col overflow-hidden shadow-sm">
        <!-- Selected Student Header Bar -->
        <div class="p-4 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
          <div class="flex items-center gap-3">
            <img :src="activeStudent.avatar" class="w-9 h-9 rounded-xl object-cover border border-slate-300" />
            <div>
              <h3 class="text-sm font-bold text-slate-900">{{ activeStudent.name }}</h3>
              <p class="text-[11px] text-slate-500">Menampilkan jurnal harian terbaru yang diajukan</p>
            </div>
          </div>

          <div class="flex items-center gap-2 text-xs">
            <span class="text-slate-500 font-medium">Total Jurnal:</span>
            <span class="font-bold text-slate-900 font-mono">{{ activeStudentJournals.length }}</span>
          </div>
        </div>

        <!-- Journal Content Area -->
        <div class="flex-1 overflow-y-auto p-5 space-y-6">
          <div
            v-for="journal in activeStudentJournals"
            :key="journal.id"
            class="p-5 rounded-2xl bg-white border border-slate-200 space-y-4 shadow-sm"
          >
            <!-- Journal Top Info -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-3 border-b border-slate-200">
              <div>
                <span class="text-[10px] font-mono text-indigo-700 uppercase tracking-wider font-bold block">
                  Tanggal: {{ journal.date }}
                </span>
                <h4 class="text-sm font-bold text-slate-900 mt-0.5">{{ journal.title }}</h4>
              </div>

              <!-- Status Badge -->
              <div>
                <span
                  v-if="journal.status === 'diacc'"
                  class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-300"
                >
                  ✓ Disetujui (Di-ACC)
                </span>
                <span
                  v-else-if="journal.status === 'revisi'"
                  class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-800 border border-rose-300"
                >
                  ⚠️ Perlu Revisi
                </span>
                <span
                  v-else
                  class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-300"
                >
                  ⏳ Menunggu Validasi
                </span>
              </div>
            </div>

            <!-- Description -->
            <div class="text-xs text-slate-800 leading-relaxed bg-slate-50 p-3.5 rounded-xl border border-slate-200">
              <span class="text-[10px] uppercase font-bold text-slate-500 block mb-1">Uraian Aktivitas:</span>
              {{ journal.description }}
            </div>

            <!-- Foto Pekerjaan (Work Photo) -->
            <div>
              <span class="text-[11px] font-bold text-slate-700 block mb-2">📸 Foto Dokumentasi Pekerjaan:</span>
              <div class="flex items-center gap-4">
                <img
                  :src="journal.photo_url"
                  alt="Bukti Pekerjaan"
                  class="w-48 h-32 object-cover rounded-xl border border-slate-300 shadow-sm cursor-pointer hover:opacity-90 transition"
                  @click="previewImage = journal.photo_url"
                />
                <div class="text-[11px] text-slate-500 space-y-0.5">
                  <p>Resolusi: 1280x720 (Terkonversi)</p>
                  <p>Format: JPEG Kompresi Optimal</p>
                  <button @click="previewImage = journal.photo_url" class="text-indigo-600 font-bold hover:underline mt-1 block">
                    Perbesar Foto &rarr;
                  </button>
                </div>
              </div>
            </div>

            <!-- Kolom Catatan Umpan Balik & Tombol Aksi ACC / Tolak -->
            <div class="pt-3 border-t border-slate-200 space-y-3">
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">
                  💬 Kolom Catatan Umpan Balik Pembimbing (Feedback / Catatan Revisi):
                </label>
                <textarea
                  v-model="journal.feedbackInput"
                  rows="2"
                  placeholder="Ketik catatan evaluasi, saran teknis, atau poin revisi yang harus diperbaiki siswa..."
                  class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:bg-white transition"
                ></textarea>
              </div>

              <!-- Tombol Aksi ACC dan Tolak/Revisi (Solid Colors, No Gradients) -->
              <div class="flex items-center justify-end gap-3">
                <button
                  @click="handleReject(journal)"
                  class="px-4 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-xl text-xs font-bold border border-rose-300 transition flex items-center gap-1.5 active:scale-95"
                >
                  <span>✕</span> Tolak / Minta Revisi
                </button>
                <button
                  @click="handleApprove(journal)"
                  class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm active:scale-95"
                >
                  <span>✓</span> ACC (Setujui Jurnal)
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Image Preview Modal -->
    <div v-if="previewImage" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" @click="previewImage = null">
      <div class="relative max-w-3xl bg-white p-2.5 rounded-2xl border border-slate-200 shadow-2xl" @click.stop>
        <img :src="previewImage" alt="Zoom" class="max-h-[85vh] w-auto rounded-xl object-contain" />
        <button @click="previewImage = null" class="absolute top-4 right-4 bg-slate-900 text-white w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold shadow">
          ✕
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useAppStore } from '~/composables/useAppStore'

const { showToast } = useAppStore()

const searchQuery = ref('')
const previewImage = ref<string | null>(null)

const studentsList = ref([
  {
    id: 1,
    name: 'Budi Santoso',
    nisn: '0061234567',
    avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150',
    pendingCount: 1,
    journals: [
      {
        id: 101,
        date: '26 Sep 2026',
        title: 'Pembuatan Tampilan Antarmuka Split-Screen Validasi DUDI',
        description: 'Merancang layout split view sesuai panduan UX desktop: daftar siswa di panel samping kiri dan detail jurnal interaktif beserta aksi validasi di panel kanan. Menyesuaikan palet warna Tailwind CSS dan komponen responsive.',
        photo_url: 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?w=600',
        status: 'menunggu',
        feedbackInput: ''
      },
      {
        id: 102,
        date: '25 Sep 2026',
        title: 'Optimasi Upload Foto Jurnal dengan Kompresi Gambar Canvas',
        description: 'Menerapkan kompresi gambar berbasis HTML5 Canvas client-side sebelum upload ke server backend untuk menghemat bandwidth pengguna dan storage server.',
        photo_url: 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=600',
        status: 'revisi',
        feedbackInput: 'Hasil kompresi terlalu kecil sehingga tulisan kode di layar agak blur. Tolong perbaiki resolusi target minimal 70%.'
      }
    ]
  },
  {
    id: 2,
    name: 'Siti Rahma',
    nisn: '0061234568',
    avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150',
    pendingCount: 2,
    journals: [
      {
        id: 201,
        date: '25 Sep 2026',
        title: 'Slicing Desain Dashboard Siswa ke Nuxt 3 & Tailwind CSS',
        description: 'Membuat komponen widget tombol raksasa Check-In/Check-Out, widget persentase kehadiran dengan circular gauge, serta widget sisa hari magang.',
        photo_url: 'https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?w=600',
        status: 'menunggu',
        feedbackInput: ''
      }
    ]
  },
  {
    id: 3,
    name: 'Rizky Pratama',
    nisn: '0061234569',
    avatar: 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=150',
    pendingCount: 0,
    journals: [
      {
        id: 301,
        date: '21 Sep 2026',
        title: 'Riset Desain UI Figma',
        description: 'Mengumpulkan wireframe dan moodboard design system aplikasi e-commerce.',
        photo_url: 'https://images.unsplash.com/photo-1581291518655-9523c93269c4?w=600',
        status: 'diacc',
        feedbackInput: 'Desain rapi dan konsisten.'
      }
    ]
  }
])

const activeStudent = ref(studentsList.value[0])

const filteredStudents = computed(() => {
  if (!searchQuery.value) return studentsList.value
  const q = searchQuery.value.toLowerCase()
  return studentsList.value.filter(s => s.name.toLowerCase().includes(q) || s.nisn.includes(q))
})

const activeStudentJournals = computed(() => {
  return activeStudent.value.journals
})

const selectStudent = (student: any) => {
  activeStudent.value = student
}

const handleApprove = (journal: any) => {
  journal.status = 'diacc'
  if (activeStudent.value.pendingCount > 0) activeStudent.value.pendingCount--
  showToast(`Jurnal "${journal.title}" berhasil di-ACC! Notifikasi telah dikirim ke siswa.`, 'success')
}

const handleReject = (journal: any) => {
  if (!journal.feedbackInput) {
    showToast('Mohon tuliskan catatan umpan balik / poin revisi untuk siswa terlebih dahulu.', 'warning')
    return
  }
  journal.status = 'revisi'
  if (activeStudent.value.pendingCount > 0) activeStudent.value.pendingCount--
  showToast(`Jurnal telah ditandai Perlu Revisi. Catatan umpan balik berhasil diteruskan ke siswa.`, 'info')
}
</script>
