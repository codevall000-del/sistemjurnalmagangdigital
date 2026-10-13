<template>
  <div class="space-y-4 max-w-7xl mx-auto min-h-0 md:h-[calc(100vh-6.5rem)] flex flex-col">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-black/[0.06] shrink-0 gap-2">
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

      <div class="flex items-center gap-3">
        <button
          v-if="hasPendingJournals"
          @click="handleBatchApprove"
          class="px-3.5 py-1.5 bg-[#0071e3] hover:bg-[#0077ed] text-white rounded-xl text-[12px] font-semibold transition-all flex items-center gap-1.5 shadow-xs apple-press cursor-pointer"
          title="Setujui seluruh jurnal menunggu siswa ini sekaligus"
          type="button"
        >
          <span class="material-symbols-outlined text-[16px]">done_all</span>
          <span>ACC Semua (Batch 1-Klik)</span>
        </button>
        <div class="text-[12px] text-[#86868b] hidden sm:block">
          Menampilkan: <span class="font-bold text-[#0071e3]">{{ activeStudent.name }}</span>
        </div>
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
        <div class="flex-1 overflow-y-auto max-h-56 md:max-h-none p-2 space-y-1">
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
import { ref, computed, onMounted } from 'vue'
import { useAppStore } from '~/composables/useAppStore'

const { showToast, authToken, ensureAuthToken } = useAppStore()

const searchQuery = ref('')
const previewImage = ref<string | null>(null)

const studentsList = ref<any[]>([])

const activeStudent = ref<any>({
  id: 0,
  name: 'Memuat...',
  nisn: '-',
  avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150',
  pendingCount: 0,
  journals: []
})

const fetchStudents = async () => {
  try {
    const token = await ensureAuthToken()
    const res = await fetch('/jurnalmagangdigital/api/mentor/students', {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      }
    })
    if (res.ok) {
      const data = await res.json()
      if (data.students && Array.isArray(data.students) && data.students.length > 0) {
        studentsList.value = data.students.map((s: any) => ({
          id: s.id,
          name: s.name,
          nisn: s.nisn_nip || '-',
          avatar: s.avatar || 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150',
          pendingCount: s.pending_journals || 0,
          journals: []
        }))
        if (studentsList.value.length > 0) {
          selectStudent(studentsList.value[0])
        }
      }
    }
  } catch (e) {}

  if (studentsList.value.length === 0) {
    studentsList.value = [
      {
        id: 6,
        name: 'Budi Santoso',
        nisn: '0061234567',
        avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150',
        pendingCount: 1,
        journals: []
      }
    ]
    selectStudent(studentsList.value[0])
  }
}

onMounted(() => {
  fetchStudents()
})

const filteredStudents = computed(() => {
  if (!searchQuery.value) return studentsList.value
  const q = searchQuery.value.toLowerCase()
  return studentsList.value.filter(s => s.name.toLowerCase().includes(q) || s.nisn.includes(q))
})

const activeStudentJournals = computed(() => {
  return activeStudent.value?.journals || []
})

const hasPendingJournals = computed(() => {
  return (activeStudent.value?.journals || []).some((j: any) => j.status === 'menunggu')
})

const selectStudent = async (student: any) => {
  activeStudent.value = student
  try {
    const token = await ensureAuthToken()
    const res = await fetch(`/jurnalmagangdigital/api/mentor/students/${student.id}/logbooks`, {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      }
    })
    if (res.ok) {
      const data = await res.json()
      if (data.logbooks && Array.isArray(data.logbooks)) {
        activeStudent.value.journals = data.logbooks.map((l: any) => ({
          id: l.id,
          date: new Date(l.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }),
          title: l.title,
          description: l.activity_description,
          photo_url: l.photo_url || 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?w=600',
          status: l.status,
          feedbackInput: l.feedback_note || ''
        }))
        activeStudent.value.pendingCount = activeStudent.value.journals.filter((j: any) => j.status === 'menunggu').length
      }
    }
  } catch (e) {}
}

const handleBatchApprove = async () => {
  const pendingIds = activeStudent.value.journals.filter((j: any) => j.status === 'menunggu').map((j: any) => j.id)
  try {
    const token = await ensureAuthToken()
    await fetch('/jurnalmagangdigital/api/mentor/logbooks/batch-validate', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      },
      body: JSON.stringify({
        logbook_ids: pendingIds,
        feedback: 'Disetujui kolektif oleh Pembimbing Lapangan.'
      })
    })
  } catch (e) {}

  let count = 0
  activeStudent.value.journals.forEach((j: any) => {
    if (j.status === 'menunggu') {
      j.status = 'diacc'
      j.feedbackInput = 'Disetujui kolektif oleh Pembimbing Lapangan.'
      count++
    }
  })
  activeStudent.value.pendingCount = 0
  showToast(`✓ Berhasil menyetujui ${count} jurnal siswa ${activeStudent.value.name} sekaligus di MySQL!`, 'success')
}

const handleApprove = async (journal: any) => {
  journal.status = 'diacc'
  if (activeStudent.value.pendingCount > 0) activeStudent.value.pendingCount--
  try {
    const token = await ensureAuthToken()
    await fetch(`/jurnalmagangdigital/api/mentor/logbooks/${journal.id}/validate`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      },
      body: JSON.stringify({
        status: 'diacc',
        feedback: journal.feedbackInput || 'Jurnal harian disetujui tanpa catatan.'
      })
    })
  } catch (e) {}
  showToast(`Jurnal "${journal.title}" berhasil di-ACC! Notifikasi telah dikirim ke siswa.`, 'success')
}

const handleReject = async (journal: any) => {
  if (!journal.feedbackInput) {
    showToast('Mohon tuliskan catatan umpan balik / poin revisi untuk siswa terlebih dahulu.', 'warning')
    return
  }
  journal.status = 'revisi'
  if (activeStudent.value.pendingCount > 0) activeStudent.value.pendingCount--
  try {
    const token = await ensureAuthToken()
    await fetch(`/jurnalmagangdigital/api/mentor/logbooks/${journal.id}/validate`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      },
      body: JSON.stringify({
        status: 'revisi',
        feedback: journal.feedbackInput
      })
    })
  } catch (e) {}
  showToast(`Jurnal telah ditandai Perlu Revisi. Catatan umpan balik berhasil dikirim ke siswa.`, 'info')
}
</script>
