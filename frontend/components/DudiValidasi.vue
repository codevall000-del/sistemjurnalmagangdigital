<template>
  <div class="space-y-4 max-w-7xl mx-auto h-[calc(100vh-6.5rem)] flex flex-col">
    <!-- Header -->
    <div class="flex items-center justify-between pb-3 border-b border-black/[0.06] shrink-0">
      <div>
        <div class="flex items-center gap-2 mb-0.5">
          <span class="text-[11px] uppercase tracking-wider text-[#0071e3] font-semibold">Validasi Pembimbing Lapangan</span>
          <span class="text-black/20">•</span>
          <span class="text-[11px] text-[#86868b]">Split-Screen Inspector</span>
        </div>
        <h2 class="text-xl sm:text-2xl font-bold text-[#1d1d1f] tracking-tight">
          Validasi Jurnal Magang Siswa
        </h2>
        <p class="text-[12px] text-[#86868b]">
          Pilih siswa di panel kiri untuk meninjau detail logbook, foto hasil pekerjaan, dan memberikan umpan balik.
        </p>
      </div>

      <div class="text-[12px] text-[#86868b]">
        Menampilkan: <span class="font-bold text-[#0071e3]">{{ activeStudent.name }}</span>
      </div>
    </div>

    <!-- SPLIT-SCREEN CONTAINER (PANEL KIRI & PANEL KANAN) - APPLE HIG STYLE -->
    <div class="flex-1 grid grid-cols-12 gap-4 min-h-0">
      <!-- PANEL KIRI (35%): DAFTAR NAMA SISWA -->
      <div class="col-span-12 md:col-span-4 lg:col-span-4 bg-white border border-black/[0.06] rounded-2xl flex flex-col overflow-hidden shadow-[0_2px_12px_rgba(0,0,0,0.03)]">
        <div class="p-3 border-b border-black/[0.05] bg-[#f5f5f7]">
          <div class="relative">
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Cari siswa atau NISN..."
              class="w-full pl-8 pr-3 py-1.5 bg-white border border-black/[0.08] rounded-xl text-[12px] text-[#1d1d1f] placeholder-[#86868b] focus:outline-none focus:ring-4 focus:ring-[#0071e3]/15 focus:border-[#0071e3] transition-all"
            />
            <span class="material-symbols-outlined absolute left-2.5 top-2 text-[#86868b] text-[16px]">search</span>
          </div>
        </div>

        <!-- Student List Items -->
        <div class="flex-1 overflow-y-auto p-2 space-y-1">
          <div
            v-for="student in filteredStudents"
            :key="student.id"
            @click="selectStudent(student)"
            :class="activeStudent.id === student.id ? 'bg-[#0071e3]/10 border-[#0071e3]/30 text-[#0071e3] font-semibold' : 'hover:bg-black/[0.03] text-[#1d1d1f] border-transparent'"
            class="p-2.5 rounded-xl border cursor-pointer transition-all flex items-center justify-between gap-3 apple-press"
          >
            <div class="flex items-center gap-3 min-w-0">
              <img
                :src="student.avatar"
                alt="Avatar"
                class="w-10 h-10 rounded-xl object-cover border border-black/[0.08] shrink-0 shadow-xs"
              />
              <div class="min-w-0">
                <h4 class="text-[13px] font-semibold truncate text-[#1d1d1f]">{{ student.name }}</h4>
                <div class="text-[10px] text-[#86868b] font-mono">NISN: {{ student.nisn }}</div>
                <div class="text-[10px] text-[#86868b] truncate">RPL • Angkatan 32</div>
              </div>
            </div>

            <!-- Pending Badge -->
            <div class="shrink-0 text-right">
              <span
                v-if="student.pendingCount > 0"
                class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-[#ff9500]/10 text-[#b26a00]"
              >
                {{ student.pendingCount }} Baru
              </span>
              <span v-else class="text-[10px] text-[#86868b] font-mono">Lengkap</span>
            </div>
          </div>
        </div>
      </div>

      <!-- PANEL KANAN (65%): DETAIL JURNAL, FOTO BUKTI, TOMBOL ACC/TOLAK & CATATAN UMPAN BALIK -->
      <div class="col-span-12 md:col-span-8 lg:col-span-8 bg-white border border-black/[0.06] rounded-2xl flex flex-col overflow-hidden shadow-[0_2px_12px_rgba(0,0,0,0.03)]">
        <!-- Selected Student Header Bar -->
        <div class="p-3.5 border-b border-black/[0.05] bg-[#f5f5f7] flex items-center justify-between">
          <div class="flex items-center gap-3">
            <img :src="activeStudent.avatar" class="w-8 h-8 rounded-xl object-cover border border-black/[0.08]" />
            <div>
              <h3 class="text-[13px] font-bold text-[#1d1d1f]">{{ activeStudent.name }}</h3>
              <p class="text-[11px] text-[#86868b]">Menampilkan jurnal harian terbaru yang diajukan</p>
            </div>
          </div>

          <div class="flex items-center gap-1.5 text-xs">
            <span class="text-[#86868b]">Total Jurnal:</span>
            <span class="font-bold text-[#0071e3] font-mono">{{ activeStudentJournals.length }}</span>
          </div>
        </div>

        <!-- Journal Content Area -->
        <div class="flex-1 overflow-y-auto p-5 space-y-5">
          <div
            v-for="journal in activeStudentJournals"
            :key="journal.id"
            class="p-5 rounded-2xl bg-[#f5f5f7] border border-black/[0.04] space-y-4 shadow-xs"
          >
            <!-- Journal Top Info -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-3 border-b border-black/[0.05]">
              <div>
                <span class="text-[10px] font-mono text-[#0071e3] uppercase tracking-wider font-semibold block">
                  Tanggal: {{ journal.date }}
                </span>
                <h4 class="text-[14px] font-bold text-[#1d1d1f] mt-0.5">{{ journal.title }}</h4>
              </div>

              <!-- Status Badge -->
              <div>
                <span
                  v-if="journal.status === 'diacc'"
                  class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-[#34c759]/10 text-[#248a3d]"
                >
                  ✓ Disetujui (Di-ACC)
                </span>
                <span
                  v-else-if="journal.status === 'revisi'"
                  class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-[#ff3b30]/10 text-[#ff3b30]"
                >
                  ⚠️ Perlu Revisi
                </span>
                <span
                  v-else
                  class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-[#ff9500]/10 text-[#b26a00]"
                >
                  ⏳ Menunggu Validasi
                </span>
              </div>
            </div>

            <!-- Description -->
            <div class="text-[12px] text-[#1d1d1f] leading-relaxed bg-white p-3.5 rounded-xl border border-black/[0.04] shadow-xs">
              <span class="text-[10px] uppercase font-semibold text-[#86868b] block mb-1">Uraian Aktivitas:</span>
              {{ journal.description }}
            </div>

            <!-- Foto Pekerjaan (Work Photo) -->
            <div>
              <span class="text-[11px] font-semibold text-[#1d1d1f] block mb-2">Foto Dokumentasi Pekerjaan:</span>
              <div class="flex items-center gap-4">
                <img
                  :src="journal.photo_url"
                  alt="Bukti Pekerjaan"
                  class="w-48 h-32 object-cover rounded-xl border border-black/[0.08] shadow-xs cursor-pointer hover:opacity-90 transition-all apple-press"
                  @click="previewImage = journal.photo_url"
                />
                <div class="text-[11px] text-[#86868b] space-y-0.5">
                  <p>Resolusi: 1280x720 (Terkonversi)</p>
                  <p>Format: JPEG Kompresi Optimal</p>
                  <button @click="previewImage = journal.photo_url" class="text-[#0071e3] font-semibold hover:underline mt-1 block">
                    Perbesar Foto &rarr;
                  </button>
                </div>
              </div>
            </div>

            <!-- Kolom Catatan Umpan Balik & Tombol Aksi ACC / Tolak -->
            <div class="pt-3 border-t border-black/[0.05] space-y-3">
              <div>
                <label class="block text-[11px] font-semibold text-[#1d1d1f] mb-1">
                  Catatan Umpan Balik Pembimbing:
                </label>
                <textarea
                  v-model="journal.feedbackInput"
                  rows="2"
                  placeholder="Ketik catatan evaluasi, saran teknis, atau poin revisi yang harus diperbaiki siswa..."
                  class="w-full px-3.5 py-2 bg-white border border-black/[0.08] rounded-xl text-[12px] text-[#1d1d1f] placeholder-[#86868b] focus:outline-none focus:ring-4 focus:ring-[#0071e3]/15 focus:border-[#0071e3] transition-all"
                ></textarea>
              </div>

              <!-- Tombol Aksi ACC dan Tolak/Revisi -->
              <div class="flex items-center justify-end gap-2.5">
                <button
                  @click="handleReject(journal)"
                  class="px-3.5 py-2 bg-[#ff3b30]/10 hover:bg-[#ff3b30]/15 text-[#ff3b30] rounded-xl text-[12px] font-semibold transition-all flex items-center gap-1.5 apple-press cursor-pointer"
                >
                  <span>✕</span> Tolak / Minta Revisi
                </button>
                <button
                  @click="handleApprove(journal)"
                  class="px-4 py-2 bg-[#34c759] hover:bg-[#2fb350] text-white rounded-xl text-[12px] font-semibold transition-all flex items-center gap-1.5 shadow-[0_2px_8px_rgba(52,199,89,0.3)] apple-press cursor-pointer"
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
    <Teleport to="body">
      <Transition
        enter-active-class="transition-opacity duration-200 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition-opacity duration-150 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <div v-if="previewImage" class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-black/60 backdrop-blur-md select-none" @click="previewImage = null">
          <div class="modal-card-animate relative max-w-3xl bg-white p-2.5 rounded-2xl border border-slate-200 shadow-2xl select-auto" @click.stop>
            <img :src="previewImage" alt="Zoom" class="max-h-[85vh] w-auto rounded-xl object-contain" />
            <button @click="previewImage = null" class="absolute top-4 right-4 bg-slate-900 text-white w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold shadow hover:bg-black transition-all cursor-pointer">
              ✕
            </button>
          </div>
        </div>
      </Transition>
    </Teleport>
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
    id: 4,
    name: 'Siswa Magang',
    nisn: '0061234567',
    avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150',
    pendingCount: 1,
    journals: [
      {
        id: 101,
        date: '26 Sep 2026',
        title: 'Pembuatan Tampilan Antarmuka Split-Screen Validasi Pembimbing',
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
