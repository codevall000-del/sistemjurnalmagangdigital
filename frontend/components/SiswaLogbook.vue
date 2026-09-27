<template>
  <div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between pb-4 border-b border-outline-variant">
      <div>
        <h2 class="text-2xl font-bold font-headline text-on-surface tracking-tight flex items-center gap-2">
          <span>Logbook Jurnal Harian</span>
        </h2>
        <p class="text-xs text-on-surface-variant mt-1 font-body">
          Dokumentasikan aktivitas dan capaian kompetensi magang Anda setiap hari kerja.
        </p>
      </div>

      <div class="flex items-center gap-2">
        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-surface-container text-primary border border-outline-variant font-mono">
          Minggu ke-9 • Periode Aktif
        </span>
      </div>
    </div>

    <!-- BAGIAN ATAS: FORM INPUT JURNAL BARU (STITCH FIELD VERIFIED ENTERPRISE) -->
    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-space-lg shadow-sm relative">
      <div class="flex items-center justify-between pb-3 mb-5 border-b border-outline-variant">
        <div class="flex items-center gap-2.5">
          <span class="w-8 h-8 rounded-lg bg-surface-container text-primary flex items-center justify-center font-bold text-sm border border-outline-variant">
            <span class="material-symbols-outlined text-[18px]">add_circle</span>
          </span>
          <div>
            <h3 class="text-sm font-bold font-headline text-on-surface">Form Input Jurnal Baru</h3>
            <p class="text-[11px] text-on-surface-variant">Isi uraian kegiatan dan lampirkan bukti foto pekerjaan terkompresi</p>
          </div>
        </div>

        <span class="text-xs text-primary font-mono font-medium">Kompresi Otomatis: HTML5 Canvas (WebP/JPEG)</span>
      </div>

      <form @submit.prevent="handleSubmitLogbook" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <!-- Tanggal Kegiatan -->
          <div>
            <label class="block text-xs font-bold text-on-surface mb-1.5">Tanggal Jurnal *</label>
            <input
              v-model="form.date"
              type="date"
              required
              class="w-full px-3.5 py-2.5 bg-surface-container-lowest border border-outline-variant rounded-lg text-xs text-on-surface focus:outline-none focus:ring-2 focus:ring-primary-container transition shadow-sm font-mono"
            />
          </div>

          <!-- Judul Kegiatan -->
          <div class="md:col-span-2">
            <label class="block text-xs font-bold text-on-surface mb-1.5">Judul Kegiatan / Topik Pekerjaan *</label>
            <input
              v-model="form.title"
              type="text"
              placeholder="Contoh: Implementasi Otentikasi Sanctum & Setup Docker Container"
              required
              class="w-full px-3.5 py-2.5 bg-surface-container-lowest border border-outline-variant rounded-lg text-xs text-on-surface placeholder-on-surface-variant/60 focus:outline-none focus:ring-2 focus:ring-primary-container transition shadow-sm"
            />
          </div>
        </div>

        <!-- Deskripsi Kegiatan -->
        <div>
          <label class="block text-xs font-bold text-on-surface mb-1.5">
            Deskripsi Kegiatan &amp; Uraian Pekerjaan Detail *
          </label>
          <textarea
            v-model="form.activity_description"
            rows="4"
            required
            placeholder="Jelaskan secara terperinci apa yang Anda kerjakan, kendala yang dihadapi, dan solusi yang diterapkan bersama tim industri..."
            class="w-full px-3.5 py-2.5 bg-surface-container-lowest border border-outline-variant rounded-lg text-xs text-on-surface placeholder-on-surface-variant/60 focus:outline-none focus:ring-2 focus:ring-primary-container transition shadow-sm"
          ></textarea>
        </div>

        <!-- Upload Foto Kompresi (Client-side HTML5 Canvas Compression) -->
        <div class="p-4 bg-surface-container-low border border-dashed border-outline-variant rounded-xl">
          <label class="block text-xs font-bold text-on-surface mb-2 flex items-center justify-between">
            <span class="flex items-center gap-1.5">
              <span class="material-symbols-outlined text-[16px] text-primary">photo_camera</span>
              Upload Foto Dokumentasi Pekerjaan
            </span>
            <span v-if="compressedInfo" class="text-tertiary font-mono text-[11px] font-bold">
              Terkonversi: {{ compressedInfo }}
            </span>
          </label>

          <div class="flex flex-col sm:flex-row items-center gap-4">
            <input
              type="file"
              accept="image/*"
              @change="handleImageUpload"
              class="block w-full text-xs text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-primary-container file:text-on-primary hover:file:bg-primary cursor-pointer"
            />

            <!-- Preview Image -->
            <div v-if="previewPhoto" class="relative shrink-0">
              <img
                :src="previewPhoto"
                alt="Preview"
                class="w-16 h-16 object-cover rounded-lg border border-outline-variant shadow-sm"
              />
              <button
                @click="removePhoto"
                type="button"
                class="absolute -top-2 -right-2 w-5 h-5 bg-error text-on-error rounded-full flex items-center justify-center text-[10px] font-bold shadow"
              >
                ✕
              </button>
            </div>
          </div>
        </div>

        <!-- Tombol Simpan -->
        <div class="flex items-center justify-end gap-3 pt-2">
          <button
            type="button"
            @click="resetForm"
            class="px-4 py-2 bg-surface-container hover:bg-surface-container-high text-on-surface rounded-lg text-xs font-semibold transition border border-outline-variant"
          >
            Reset Form
          </button>
          <button
            type="submit"
            :disabled="isSubmitting"
            class="px-6 py-2.5 bg-primary-container hover:bg-primary text-on-primary rounded-lg text-xs font-bold shadow-sm transition flex items-center gap-2 active:scale-95 disabled:opacity-50"
          >
            <span v-if="isSubmitting" class="animate-spin inline-block">⏳</span>
            <span class="material-symbols-outlined text-[16px]">save</span>
            <span>Simpan Jurnal Harian</span>
          </button>
        </div>
      </form>
    </div>

    <!-- BAGIAN BAWAH: TABEL RIWAYAT JURNAL MINGGU INI LENGKAP DENGAN BADGE STATUS -->
    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-space-lg shadow-sm">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-4 mb-4 border-b border-outline-variant">
        <div>
          <h3 class="text-sm font-bold font-headline text-on-surface flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px] text-primary">calendar_month</span>
            <span>Riwayat Jurnal Minggu Ini</span>
          </h3>
          <p class="text-[11px] text-on-surface-variant">Status evaluasi dan umpan balik dari Pembimbing Industri (DUDI)</p>
        </div>

        <!-- Filter / Legend Badge -->
        <div class="flex items-center gap-2 text-[10px]">
          <span class="px-2.5 py-0.5 rounded bg-tertiary-fixed text-tertiary font-bold flex items-center gap-1">
            <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
            ✓ Di-ACC
          </span>
          <span class="px-2.5 py-0.5 rounded bg-secondary-container text-on-secondary-fixed font-bold flex items-center gap-1">
            <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
            ⏳ Menunggu
          </span>
          <span class="px-2.5 py-0.5 rounded bg-error-container text-error font-bold flex items-center gap-1">
            <span class="w-1.5 h-1.5 rounded-full bg-error"></span>
            ⚠️ Revisi
          </span>
        </div>
      </div>

      <!-- Tabel Riwayat Jurnal -->
      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs border-collapse">
          <thead>
            <tr class="bg-surface-container-low text-on-surface-variant uppercase text-[10px] tracking-wider border-b border-outline-variant font-bold">
              <th class="py-3 px-4">Hari / Tanggal</th>
              <th class="py-3 px-4">Judul &amp; Uraian Aktivitas</th>
              <th class="py-3 px-4 text-center">Foto Bukti</th>
              <th class="py-3 px-4 text-center">Status</th>
              <th class="py-3 px-4">Catatan / Umpan Balik DUDI</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-outline-variant/60 font-body text-xs text-on-surface">
            <tr v-for="item in logbooks" :key="item.id" class="hover:bg-surface-container-low/50 transition-colors">
              <!-- Tanggal -->
              <td class="py-3.5 px-4 font-mono whitespace-nowrap align-top">
                <div class="font-bold text-on-surface">{{ item.dateFormatted }}</div>
                <div class="text-[10px] text-on-surface-variant">{{ item.dayName }}</div>
              </td>

              <!-- Uraian -->
              <td class="py-3.5 px-4 align-top max-w-md">
                <div class="font-bold text-on-surface text-xs mb-1">{{ item.title }}</div>
                <p class="text-on-surface-variant text-[11px] leading-relaxed line-clamp-3">
                  {{ item.activity_description }}
                </p>
              </td>

              <!-- Foto -->
              <td class="py-3.5 px-4 text-center align-top whitespace-nowrap">
                <div v-if="item.photo_url" class="inline-block relative group">
                  <img
                    :src="item.photo_url"
                    alt="Foto Pekerjaan"
                    class="w-12 h-12 object-cover rounded-lg border border-outline-variant cursor-pointer transition group-hover:scale-105 shadow-sm"
                    @click="openImageModal(item.photo_url)"
                  />
                  <span class="block text-[9px] text-on-surface-variant mt-0.5 font-medium">Lihat</span>
                </div>
                <span v-else class="text-on-surface-variant/50 text-[11px]">-</span>
              </td>

              <!-- Badge Status (*Menunggu, Di-ACC, Revisi*) -->
              <td class="py-3.5 px-4 text-center align-top whitespace-nowrap">
                <span
                  v-if="item.status === 'diacc'"
                  class="px-2.5 py-1 rounded text-[10px] font-bold bg-tertiary-fixed text-tertiary inline-flex items-center gap-1"
                >
                  <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                  ✓ Di-ACC
                </span>
                <span
                  v-else-if="item.status === 'menunggu'"
                  class="px-2.5 py-1 rounded text-[10px] font-bold bg-secondary-container text-on-secondary-fixed inline-flex items-center gap-1"
                >
                  <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                  ⏳ Menunggu
                </span>
                <span
                  v-else-if="item.status === 'revisi'"
                  class="px-2.5 py-1 rounded text-[10px] font-bold bg-error-container text-error inline-flex items-center gap-1"
                >
                  <span class="w-1.5 h-1.5 rounded-full bg-error"></span>
                  ⚠️ Revisi
                </span>
              </td>

              <!-- Catatan Umpan Balik -->
              <td class="py-3.5 px-4 align-top max-w-xs">
                <div v-if="item.feedback_note" class="p-2.5 rounded-lg bg-surface-container-low border border-outline-variant text-[11px]">
                  <p class="text-on-surface italic font-medium">"{{ item.feedback_note }}"</p>
                  <span class="block text-[9px] text-primary mt-1 font-bold">
                    Oleh: {{ item.validator_name || 'Hendra Wijaya, S.Kom' }}
                  </span>
                </div>
                <span v-else class="text-on-surface-variant/50 text-[11px] italic">Belum ada umpan balik</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Image Preview Modal -->
    <div v-if="modalPhoto" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-on-surface/50 backdrop-blur-sm" @click="modalPhoto = null">
      <div class="relative max-w-2xl bg-surface-container-lowest p-2.5 rounded-xl border border-outline-variant shadow-2xl" @click.stop>
        <img :src="modalPhoto" alt="Full Preview" class="max-h-[80vh] w-auto rounded-lg object-contain" />
        <button @click="modalPhoto = null" class="absolute top-4 right-4 bg-on-surface text-surface w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold shadow">
          ✕
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue'
import { useAppStore } from '~/composables/useAppStore'

const { showToast } = useAppStore()

const isSubmitting = ref(false)
const previewPhoto = ref<string | null>(null)
const compressedInfo = ref<string | null>(null)
const modalPhoto = ref<string | null>(null)

const todayStr = new Date().toISOString().split('T')[0]

const form = reactive({
  date: todayStr,
  title: '',
  activity_description: '',
  photo_url: ''
})

// Sample weekly logbook data
const logbooks = ref([
  {
    id: 1,
    dateFormatted: '26 Sep 2026',
    dayName: 'Jumat',
    title: 'Pembuatan Tampilan Split-Screen Validasi Jurnal DUDI',
    activity_description: 'Merancang layout split view sesuai panduan UX desktop: daftar siswa di panel samping kiri dan detail jurnal interaktif beserta aksi validasi di panel kanan.',
    photo_url: 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?w=600',
    status: 'menunggu',
    feedback_note: null,
    validator_name: null
  },
  {
    id: 2,
    dateFormatted: '25 Sep 2026',
    dayName: 'Kamis',
    title: 'Optimasi Upload Foto Jurnal dengan Kompresi Gambar Canvas',
    activity_description: 'Menerapkan kompresi gambar berbasis HTML5 Canvas client-side sebelum upload ke server backend untuk menghemat bandwidth pengguna dan storage server.',
    photo_url: 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=600',
    status: 'revisi',
    feedback_note: 'Hasil kompresi terlalu kecil sehingga tulisan kode di layar agak blur. Tolong naikkan kualitas kompresi ke target minimal 70% dan upload ulang screenshot.',
    validator_name: 'Hendra Wijaya, S.Kom'
  },
  {
    id: 3,
    dateFormatted: '24 Sep 2026',
    dayName: 'Rabu',
    title: 'Integrasi State Management Pinia pada Nuxt 3',
    activity_description: 'Mengonfigurasi state global untuk token autentikasi, status koneksi offline/online dengan reactive indicator, dan persistence data profil menggunakan pinia-plugin-persistedstate.',
    photo_url: 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=600',
    status: 'diacc',
    feedback_note: 'Arsitektur store sangat rapi dan reusable.',
    validator_name: 'Hendra Wijaya, S.Kom'
  },
  {
    id: 4,
    dateFormatted: '23 Sep 2026',
    dayName: 'Selasa',
    title: 'Implementasi Endpoint REST API Autentikasi Sanctum',
    activity_description: 'Melakukan setup Laravel Sanctum untuk authentication token bearer, membuat middleware verifikasi peran aktor (siswa, dudi, guru, admin), dan menguji validasi request login.',
    photo_url: 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=600',
    status: 'diacc',
    feedback_note: 'Kerja bagus, struktur controller dan error handling sudah memenuhi standar code review tim backend.',
    validator_name: 'Hendra Wijaya, S.Kom'
  }
])

// HTML5 Canvas Client-side compression
const handleImageUpload = (event: Event) => {
  const target = event.target as HTMLInputElement
  if (!target.files || target.files.length === 0) return

  const file = target.files[0]
  const originalSizeKb = Math.round(file.size / 1024)

  const reader = new FileReader()
  reader.onload = (e) => {
    const img = new Image()
    img.onload = () => {
      const canvas = document.createElement('canvas')
      const ctx = canvas.getContext('2d')

      const maxWidth = 1280
      const scale = Math.min(1, maxWidth / img.width)
      canvas.width = img.width * scale
      canvas.height = img.height * scale

      ctx?.drawImage(img, 0, 0, canvas.width, canvas.height)

      const compressedDataUrl = canvas.toDataURL('image/jpeg', 0.72)
      previewPhoto.value = compressedDataUrl
      form.photo_url = compressedDataUrl

      const compressedSizeKb = Math.round((compressedDataUrl.length * 3) / 4 / 1024)
      const ratio = Math.round((1 - (compressedSizeKb / originalSizeKb)) * 100)
      compressedInfo.value = `${originalSizeKb} KB ➔ ${compressedSizeKb} KB (-${ratio}%)`
      showToast(`Foto berhasil dikompresi: hemat ${ratio}% ukuran file`, 'info')
    }
    img.src = e.target?.result as string
  }
  reader.readAsDataURL(file)
}

const removePhoto = () => {
  previewPhoto.value = null
  compressedInfo.value = null
  form.photo_url = ''
}

const resetForm = () => {
  form.title = ''
  form.activity_description = ''
  removePhoto()
}

const handleSubmitLogbook = () => {
  isSubmitting.value = true
  setTimeout(() => {
    isSubmitting.value = false
    const newEntry = {
      id: Date.now(),
      dateFormatted: '27 Sep 2026',
      dayName: 'Sabtu',
      title: form.title,
      activity_description: form.activity_description,
      photo_url: form.photo_url || 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=600',
      status: 'menunggu',
      feedback_note: null,
      validator_name: null
    }

    logbooks.value.unshift(newEntry)
    resetForm()
    showToast('Jurnal harian berhasil disimpan! Status: Menunggu validasi DUDI.', 'success')
  }, 700)
}

const openImageModal = (url: string) => {
  modalPhoto.value = url
}
</script>
