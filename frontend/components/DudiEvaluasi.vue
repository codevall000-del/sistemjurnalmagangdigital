<template>
  <div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-black/[0.06]">
      <div>
        <div class="flex items-center gap-2 mb-1">
          <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold tracking-wide bg-[#0071e3]/10 text-[#0071e3]">
            Sertifikasi Industri
          </span>
          <span class="text-[#86868b]">•</span>
          <span class="text-xs font-medium text-[#86868b]">PT Telkom Digital Solusi</span>
        </div>
        <h2 class="text-2xl font-bold text-[#1d1d1f] tracking-tight flex items-center gap-2">
          <span>Evaluasi &amp; Rubrik Penilaian Lapangan</span>
        </h2>
        <p class="text-xs text-[#86868b] mt-0.5">
          Penilaian capaian kompetensi magang siswa dengan penerbitan sertifikat digital berbasis QR Code.
        </p>
      </div>

      <div class="flex items-center gap-2">
        <span class="px-3 py-1 rounded-full text-xs font-medium bg-[#0071e3]/10 text-[#0071e3]">
          Bobot Nilai Lapangan: 60% dari Nilai Akhir PKL
        </span>
      </div>
    </div>

    <!-- MAIN FORM RUBRIK PENILAIAN -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
      <!-- FORM LEFT (7 COLS): SELECT SISWA & SLIDERS RUBRIK -->
      <div class="lg:col-span-7 bg-white border border-black/[0.05] rounded-2xl p-6 shadow-[0_2px_12px_rgba(0,0,0,0.03)] space-y-6">
        <!-- 1. Pemilihan Siswa -->
        <div>
          <label class="block text-xs font-semibold text-[#1d1d1f] mb-2.5">Pilih Nama Siswa yang Dinilai *</label>
          <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
            <button
              v-for="s in students"
              :key="s.id"
              type="button"
              @click="selectedStudent = s"
              :class="selectedStudent.id === s.id ? 'bg-[#0071e3] text-white shadow-[0_2px_8px_rgba(0,113,227,0.25)]' : 'bg-black/[0.03] text-[#1d1d1f] hover:bg-black/[0.06] border border-black/[0.04]'"
              class="p-3 rounded-2xl text-left transition-all flex items-center gap-3 apple-press cursor-pointer"
            >
              <img :src="s.avatar" class="w-9 h-9 rounded-xl object-cover border border-white/20 shadow-xs" />
              <div class="min-w-0">
                <div class="text-xs font-semibold truncate">{{ s.name }}</div>
                <div class="text-[10px] opacity-75 font-mono">{{ s.nisn }}</div>
              </div>
            </button>
          </div>
        </div>

        <!-- 2. Form Skala Nilai Rubrik -->
        <div class="space-y-4 pt-3 border-t border-black/[0.06]">
          <div class="flex items-center justify-between">
            <h4 class="text-xs font-semibold uppercase tracking-wider text-[#86868b]">Skala Rubrik Kompetensi (0 – 100)</h4>
            <span class="text-xs font-mono text-[#0071e3] font-medium">Standar Industri</span>
          </div>

          <!-- Aspek 1: Disiplin & Etos Kerja -->
          <div class="p-4 bg-black/[0.02] rounded-2xl border border-black/[0.04] space-y-2">
            <div class="flex items-center justify-between text-xs">
              <span class="font-semibold text-[#1d1d1f]">1. Kedisiplinan &amp; Etos Kerja</span>
              <span class="font-mono text-sm font-bold text-[#34c759]">{{ scores.disiplin }} / 100</span>
            </div>
            <input
              v-model.number="scores.disiplin"
              type="range"
              min="50"
              max="100"
              class="w-full h-1.5 bg-black/[0.08] rounded-lg appearance-none cursor-pointer accent-[#34c759]"
            />
            <p class="text-[11px] text-[#86868b]">Ketepatan waktu kehadiran, kepatuhan SOP perusahaan, dan tata krama.</p>
          </div>

          <!-- Aspek 2: Keahlian Teknis & Problem Solving -->
          <div class="p-4 bg-black/[0.02] rounded-2xl border border-black/[0.04] space-y-2">
            <div class="flex items-center justify-between text-xs">
              <span class="font-semibold text-[#1d1d1f]">2. Keahlian Teknis &amp; Kualitas Kerja</span>
              <span class="font-mono text-sm font-bold text-[#0071e3]">{{ scores.teknis }} / 100</span>
            </div>
            <input
              v-model.number="scores.teknis"
              type="range"
              min="50"
              max="100"
              class="w-full h-1.5 bg-black/[0.08] rounded-lg appearance-none cursor-pointer accent-[#0071e3]"
            />
            <p class="text-[11px] text-[#86868b]">Kemampuan coding, implementasi arsitektur REST API, dan debugging mandiri.</p>
          </div>

          <!-- Aspek 3: Kerjasama Tim & Komunikasi -->
          <div class="p-4 bg-black/[0.02] rounded-2xl border border-black/[0.04] space-y-2">
            <div class="flex items-center justify-between text-xs">
              <span class="font-semibold text-[#1d1d1f]">3. Kerjasama Tim &amp; Komunikasi</span>
              <span class="font-mono text-sm font-bold text-[#5856d6]">{{ scores.kerjasama }} / 100</span>
            </div>
            <input
              v-model.number="scores.kerjasama"
              type="range"
              min="50"
              max="100"
              class="w-full h-1.5 bg-black/[0.08] rounded-lg appearance-none cursor-pointer accent-[#5856d6]"
            />
            <p class="text-[11px] text-[#86868b]">Kolaborasi dalam sprint scrum tim, daily standup, dan etika komunikasi tertulis.</p>
          </div>

          <!-- Aspek 4: Inisiatif & Kreativitas -->
          <div class="p-4 bg-black/[0.02] rounded-2xl border border-black/[0.04] space-y-2">
            <div class="flex items-center justify-between text-xs">
              <span class="font-semibold text-[#1d1d1f]">4. Inisiatif &amp; Inovasi</span>
              <span class="font-mono text-sm font-bold text-[#ff9500]">{{ scores.inisiatif }} / 100</span>
            </div>
            <input
              v-model.number="scores.inisiatif"
              type="range"
              min="50"
              max="100"
              class="w-full h-1.5 bg-black/[0.08] rounded-lg appearance-none cursor-pointer accent-[#ff9500]"
            />
            <p class="text-[11px] text-[#86868b]">Proaktif mencari solusi alternatif, ketertarikan mempelajari teknologi baru.</p>
          </div>
        </div>

        <!-- 3. Catatan Evaluasi Akhir -->
        <div>
          <label class="block text-xs font-semibold text-[#1d1d1f] mb-1.5">Catatan &amp; Rekomendasi Akhir Pembimbing Lapangan</label>
          <textarea
            v-model="scores.catatan"
            rows="3"
            placeholder="Tuliskan testimoni etos kerja dan kompetensi siswa selama magang..."
            class="w-full px-3.5 py-2.5 bg-black/[0.03] focus:bg-white border border-transparent focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-xs text-[#1d1d1f] placeholder-[#86868b] transition"
          ></textarea>
        </div>

        <!-- Tombol Aksi Finalisasi -->
        <div>
          <button
            @click="handleFinalize"
            :disabled="isFinalizing"
            class="w-full py-3.5 px-6 bg-[#0071e3] hover:bg-[#0077ed] text-white rounded-xl text-sm font-semibold shadow-[0_2px_8px_rgba(0,113,227,0.25)] transition flex items-center justify-center gap-2 apple-press disabled:opacity-50 cursor-pointer"
          >
            <span v-if="isFinalizing" class="animate-spin inline-block">⏳</span>
            <span>Finalisasi Nilai &amp; Generate QR Code</span>
          </button>
        </div>
      </div>

      <!-- FORM RIGHT (5 COLS): REAL-TIME PREVIEW & QR CODE VERIFIKASI -->
      <div class="lg:col-span-5 space-y-6">
        <!-- Live Kalkulasi Rata-rata (Apple Numbers / Health Card) -->
        <div class="bg-white border border-black/[0.05] rounded-2xl p-6 shadow-[0_2px_12px_rgba(0,0,0,0.03)] text-center relative">
          <span class="text-xs font-semibold text-[#86868b] uppercase tracking-wider block">Kalkulasi Nilai Rata-rata Pembimbing Lapangan</span>
          
          <div class="text-6xl font-bold text-[#0071e3] tracking-tight my-3">
            {{ calculatedAverage }}
          </div>
          
          <div class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-[#34c759]/10 text-[#34c759]">
            Predikat: {{ calculatedPredicate }}
          </div>

          <div class="mt-5 pt-4 border-t border-black/[0.05] text-xs text-[#86868b] text-left space-y-2 font-medium">
            <div class="flex justify-between"><span>Disiplin:</span> <span class="font-mono font-semibold text-[#1d1d1f]">{{ scores.disiplin }}</span></div>
            <div class="flex justify-between"><span>Keahlian Teknis:</span> <span class="font-mono font-semibold text-[#1d1d1f]">{{ scores.teknis }}</span></div>
            <div class="flex justify-between"><span>Kerjasama:</span> <span class="font-mono font-semibold text-[#1d1d1f]">{{ scores.kerjasama }}</span></div>
            <div class="flex justify-between"><span>Inisiatif:</span> <span class="font-mono font-semibold text-[#1d1d1f]">{{ scores.inisiatif }}</span></div>
          </div>
        </div>

        <!-- GENERATED QR CODE CONTAINER (Apple Passbook Style) -->
        <div v-if="isFinalized" class="bg-white border border-black/[0.05] rounded-2xl p-6 shadow-[0_2px_12px_rgba(0,0,0,0.03)] text-center space-y-4">
          <div class="flex items-center justify-center gap-1.5 text-xs font-semibold text-[#34c759]">
            <svg class="w-4 h-4 text-[#34c759]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            <span>Sertifikat Digital Terverifikasi</span>
          </div>

          <!-- Canvas QR Code -->
          <div class="flex justify-center my-2">
            <div class="p-3 bg-white rounded-2xl shadow-sm border border-black/[0.06]">
              <canvas ref="qrCanvas" class="w-36 h-36"></canvas>
            </div>
          </div>

          <div class="space-y-1.5 text-xs">
            <div class="font-mono text-[#1d1d1f] font-semibold text-[11px] bg-black/[0.03] p-2 rounded-xl border border-black/[0.04]">
              HASH: {{ qrHash }}
            </div>
            <p class="text-[11px] text-[#86868b] leading-relaxed">
              QR Code ini memvalidasi bahwa nilai sebesar <strong class="text-[#1d1d1f]">{{ calculatedAverage }}</strong> untuk <strong class="text-[#0071e3]">{{ selectedStudent.name }}</strong> telah resmi diterbitkan oleh PT Telkom Digital Solusi.
            </p>
          </div>

          <div class="pt-2">
            <button
              @click="printCertificate"
              class="w-full py-2.5 bg-black/[0.04] hover:bg-black/[0.08] text-[#1d1d1f] rounded-xl text-xs font-semibold border border-black/[0.06] transition flex items-center justify-center gap-2 shadow-xs apple-press cursor-pointer"
            >
              <svg class="w-3.5 h-3.5 text-[#86868b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
              </svg>
              <span>Cetak Berita Acara Nilai Pembimbing Lapangan</span>
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
  { id: 4, name: 'Siswa Magang', nisn: '0061234567', avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150' }
])

const selectedStudent = ref(students.value[0])

const scores = reactive({
  disiplin: 92,
  teknis: 95,
  kerjasama: 90,
  inisiatif: 93,
  catatan: 'Siswa menunjukkan penguasaan teknis yang luar biasa, disiplin tinggi dalam kehadiran, dan selalu menyelesaikan tugas tepat waktu sesuai standar sprint industri.'
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
  const verifyData = `https://magang.smkn71jakarta.sch.id/verify?hash=${qrHash.value}&student=${encodeURIComponent(selectedStudent.value.name)}&score=${calculatedAverage.value}`
  QRCode.toCanvas(qrCanvas.value, verifyData, {
    width: 144,
    margin: 1,
    color: {
      dark: '#1d1d1f',
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
