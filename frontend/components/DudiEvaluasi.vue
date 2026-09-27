<template>
  <div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
      <div>
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
          <span>⭐ Evaluasi &amp; Rubrik Penilaian DUDI</span>
        </h2>
        <p class="text-xs text-slate-500 mt-1">
          Penilaian capaian kompetensi magang industri siswa dengan penerbitan sertifikat digital berbasis QR Code.
        </p>
      </div>

      <div class="flex items-center gap-2">
        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-300">
          Bobot DUDI: 60% dari Nilai Akhir PKL
        </span>
      </div>
    </div>

    <!-- MAIN FORM RUBRIK PENILAIAN - LIGHT FLAT DESIGN -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
      <!-- FORM LEFT (7 COLS): SELECT SISWA & SLIDERS RUBRIK -->
      <div class="lg:col-span-7 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-6">
        <!-- 1. Pemilihan Siswa -->
        <div>
          <label class="block text-xs font-bold text-slate-900 mb-2">Pilih Nama Siswa yang Dinilai *</label>
          <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
            <button
              v-for="s in students"
              :key="s.id"
              type="button"
              @click="selectedStudent = s"
              :class="selectedStudent.id === s.id ? 'bg-emerald-600 text-white border-emerald-600 ring-2 ring-emerald-500' : 'bg-slate-50 text-slate-700 border-slate-200 hover:border-slate-300'"
              class="p-2.5 rounded-xl border text-left transition flex items-center gap-2.5 shadow-sm"
            >
              <img :src="s.avatar" class="w-8 h-8 rounded-lg object-cover" />
              <div class="min-w-0">
                <div class="text-xs font-bold truncate">{{ s.name }}</div>
                <div class="text-[9px] opacity-80 font-mono">{{ s.nisn }}</div>
              </div>
            </button>
          </div>
        </div>

        <!-- 2. Form Skala Nilai Rubrik -->
        <div class="space-y-4 pt-2 border-t border-slate-200">
          <div class="flex items-center justify-between">
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500">Skala Rubrik Kompetensi (0 – 100)</h4>
            <span class="text-xs font-mono text-emerald-700 font-bold">Skala Mutu Industri</span>
          </div>

          <!-- Aspek 1: Disiplin & Etos Kerja -->
          <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 space-y-2">
            <div class="flex items-center justify-between text-xs">
              <span class="font-bold text-slate-800">1. Kedisiplinan &amp; Etos Kerja</span>
              <span class="font-mono text-sm font-extrabold text-emerald-700">{{ scores.disiplin }} / 100</span>
            </div>
            <input
              v-model.number="scores.disiplin"
              type="range"
              min="50"
              max="100"
              class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-emerald-600"
            />
            <p class="text-[10px] text-slate-500">Ketepatan waktu kehadiran, kepatuhan SOP perusahaan, dan tata krama.</p>
          </div>

          <!-- Aspek 2: Keahlian Teknis & Problem Solving -->
          <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 space-y-2">
            <div class="flex items-center justify-between text-xs">
              <span class="font-bold text-slate-800">2. Keahlian Teknis &amp; Kualitas Kerja</span>
              <span class="font-mono text-sm font-extrabold text-indigo-700">{{ scores.teknis }} / 100</span>
            </div>
            <input
              v-model.number="scores.teknis"
              type="range"
              min="50"
              max="100"
              class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-indigo-600"
            />
            <p class="text-[10px] text-slate-500">Kemampuan coding, implementasi arsitektur REST API, dan debugging mandiri.</p>
          </div>

          <!-- Aspek 3: Kerjasama Tim & Komunikasi -->
          <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 space-y-2">
            <div class="flex items-center justify-between text-xs">
              <span class="font-bold text-slate-800">3. Kerjasama Tim &amp; Komunikasi</span>
              <span class="font-mono text-sm font-extrabold text-cyan-700">{{ scores.kerjasama }} / 100</span>
            </div>
            <input
              v-model.number="scores.kerjasama"
              type="range"
              min="50"
              max="100"
              class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-cyan-600"
            />
            <p class="text-[10px] text-slate-500">Kolaborasi dalam sprint scrum tim, daily standup, dan etika komunikasi tertulis.</p>
          </div>

          <!-- Aspek 4: Inisiatif & Kreativitas -->
          <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 space-y-2">
            <div class="flex items-center justify-between text-xs">
              <span class="font-bold text-slate-800">4. Inisiatif &amp; Inovasi</span>
              <span class="font-mono text-sm font-extrabold text-amber-700">{{ scores.inisiatif }} / 100</span>
            </div>
            <input
              v-model.number="scores.inisiatif"
              type="range"
              min="50"
              max="100"
              class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-amber-600"
            />
            <p class="text-[10px] text-slate-500">Proaktif mencari solusi alternatif, ketertarikan mempelajari teknologi baru.</p>
          </div>
        </div>

        <!-- 3. Catatan Evaluasi Akhir -->
        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1.5">Catatan &amp; Rekomendasi Akhir Pembimbing DUDI</label>
          <textarea
            v-model="scores.catatan"
            rows="3"
            placeholder="Tuliskan testimoni etos kerja dan kompetensi siswa selama magang di perusahaan Anda..."
            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:bg-white transition"
          ></textarea>
        </div>

        <!-- Tombol Aksi Finalisasi (Solid Emerald, No Gradient) -->
        <div>
          <button
            @click="handleFinalize"
            :disabled="isFinalizing"
            class="w-full py-4 px-6 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold shadow-md transition flex items-center justify-center gap-2 active:scale-95 disabled:opacity-50"
          >
            <span v-if="isFinalizing" class="animate-spin inline-block">⏳</span>
            <span>🔐 Finalisasi Nilai &amp; Generate QR Code</span>
          </button>
        </div>
      </div>

      <!-- FORM RIGHT (5 COLS): REAL-TIME PREVIEW & QR CODE VERIFIKASI -->
      <div class="lg:col-span-5 space-y-6">
        <!-- Live Kalkulasi Rata-rata (Flat Clean Card) -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm text-center relative">
          <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Kalkulasi Nilai Rata-rata DUDI</span>
          <!-- Solid Emerald Text (No gradient) -->
          <div class="text-5xl font-black text-emerald-600 my-2">
            {{ calculatedAverage }}
          </div>
          <div class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-300">
            Predikat: {{ calculatedPredicate }}
          </div>

          <div class="mt-4 pt-4 border-t border-slate-200 text-xs text-slate-600 text-left space-y-1.5 font-medium">
            <div class="flex justify-between"><span>Disiplin:</span> <span class="font-mono font-bold text-slate-900">{{ scores.disiplin }}</span></div>
            <div class="flex justify-between"><span>Keahlian Teknis:</span> <span class="font-mono font-bold text-slate-900">{{ scores.teknis }}</span></div>
            <div class="flex justify-between"><span>Kerjasama:</span> <span class="font-mono font-bold text-slate-900">{{ scores.kerjasama }}</span></div>
            <div class="flex justify-between"><span>Inisiatif:</span> <span class="font-mono font-bold text-slate-900">{{ scores.inisiatif }}</span></div>
          </div>
        </div>

        <!-- GENERATED QR CODE CONTAINER -->
        <div v-if="isFinalized" class="bg-white border-2 border-emerald-500 rounded-2xl p-6 shadow-sm text-center space-y-4 animate-fade-in">
          <div class="flex items-center justify-center gap-2 text-xs font-bold text-emerald-700 uppercase tracking-wider">
            <span>🛡️</span> Sertifikat Digital Terverifikasi
          </div>

          <!-- Canvas QR Code -->
          <div class="flex justify-center my-2">
            <div class="p-3 bg-white rounded-2xl shadow-sm border border-slate-300">
              <canvas ref="qrCanvas" class="w-36 h-36"></canvas>
            </div>
          </div>

          <div class="space-y-1 text-xs">
            <div class="font-mono text-slate-800 font-bold tracking-wider text-[11px] bg-slate-50 p-2 rounded-lg border border-slate-200">
              HASH: {{ qrHash }}
            </div>
            <p class="text-[11px] text-slate-600">
              QR Code ini memvalidasi bahwa nilai sebesar <strong class="text-slate-900">{{ calculatedAverage }}</strong> untuk <strong class="text-emerald-700">{{ selectedStudent.name }}</strong> telah resmi diterbitkan oleh PT Telkom Digital Solusi.
            </p>
          </div>

          <div class="pt-2">
            <button
              @click="printCertificate"
              class="w-full py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold transition flex items-center justify-center gap-2 shadow-sm"
            >
              <span>🖨️</span> Cetak Berita Acara Nilai DUDI
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, reactive, computed, watch, nextTick } from 'vue'
import { useAppStore } from '~/composables/useAppStore'
import QRCode from 'qrcode'
import confetti from 'canvas-confetti'

const { showToast } = useAppStore()

const students = ref([
  { id: 1, name: 'Budi Santoso', nisn: '0061234567', avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150' },
  { id: 2, name: 'Siti Rahma', nisn: '0061234568', avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150' },
  { id: 4, name: 'Dewi Anggraeni', nisn: '0061234570', avatar: 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150' }
])

const selectedStudent = ref(students.value[0])

const scores = reactive({
  disiplin: 92,
  teknis: 95,
  kerjasama: 90,
  inisiatif: 93,
  catatan: 'Budi menunjukkan penguasaan teknis yang luar biasa, disiplin tinggi dalam kehadiran, dan selalu menyelesaikan tugas tepat waktu sesuai standar sprint industri.'
})

const calculatedAverage = computed(() => {
  const avg = (scores.disiplin + scores.teknis + scores.kerjasama + scores.inisiatif) / 4
  return avg.toFixed(2)
})

const calculatedPredicate = computed(() => {
  const avg = parseFloat(calculatedAverage.value)
  if (avg >= 90) return 'A (Sangat Memuaskan / Amat Baik)'
  if (avg >= 80) return 'B (Baik / Memuaskan)'
  if (avg >= 70) return 'C (Cukup)'
  return 'D (Kurang)'
})

const isFinalizing = ref(false)
const isFinalized = ref(true)
const qrHash = ref('PKL-2026-TELKOM-BUDI-9250-VERIFIED')
const qrCanvas = ref<HTMLCanvasElement | null>(null)

const renderQr = () => {
  if (!qrCanvas.value) return
  const verifyData = `https://magang.smkn1industri.sch.id/verify?hash=${qrHash.value}&student=${encodeURIComponent(selectedStudent.value.name)}&score=${calculatedAverage.value}`
  QRCode.toCanvas(qrCanvas.value, verifyData, {
    width: 144,
    margin: 1,
    color: {
      dark: '#0f172a',
      light: '#ffffff'
    }
  })
}

watch(selectedStudent, () => {
  qrHash.value = `PKL-2026-TELKOM-${selectedStudent.value.name.toUpperCase().replace(/\s+/g, '')}-${Math.round(parseFloat(calculatedAverage.value) * 100)}`
  nextTick(() => renderQr())
})

const handleFinalize = () => {
  isFinalizing.value = true
  setTimeout(() => {
    isFinalizing.value = false
    isFinalized.value = true
    qrHash.value = `PKL-2026-TELKOM-${selectedStudent.value.name.toUpperCase().replace(/\s+/g, '')}-${Math.round(parseFloat(calculatedAverage.value) * 100)}-VERIFIED`

    nextTick(() => {
      renderQr()
      confetti({
        particleCount: 80,
        spread: 70,
        origin: { y: 0.6 }
      })
    })

    showToast(`Nilai evaluasi ${selectedStudent.value.name} (${calculatedAverage.value}) berhasil difinalisasi & QR Code resmi diterbitkan!`, 'success')
  }, 800)
}

const printCertificate = () => {
  window.print()
}

nextTick(() => {
  renderQr()
})
</script>
