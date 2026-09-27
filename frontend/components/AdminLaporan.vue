<template>
  <div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200 no-print">
      <div>
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
          <span>📑 Laporan, Arsip &amp; Pratinjau Buku Jurnal Cetak</span>
        </h2>
        <p class="text-xs text-slate-500 mt-1">
          Penyusunan berkas laporan akhir PKL, arsip sertifikasi nilai, dan ekspor dokumen resmi.
        </p>
      </div>

      <!-- Action Buttons: Export to PDF & Export to Excel -->
      <div class="flex items-center gap-3">
        <button
          @click="exportToExcel"
          class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm active:scale-95"
        >
          <span>📊</span> Export to Excel
        </button>

        <button
          @click="exportToPdf"
          class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm active:scale-95"
        >
          <span>📄</span> Export to PDF (Cetak Dokumen)
        </button>
      </div>
    </div>

    <!-- PANEL FILTER YANG SANGAT LENGKAP (TAHUN AJARAN, ANGKATAN, DUDI) -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm space-y-4 no-print">
      <div class="flex items-center justify-between pb-2 border-b border-slate-200">
        <span class="text-xs font-bold uppercase tracking-wider text-rose-700">
          ⚙️ Panel Filter Arsip Dokumen
        </span>
        <span class="text-xs text-slate-500 font-mono">Ditemukan: {{ filteredReports.length }} Rekord</span>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs">
        <!-- 1. Filter Tahun Ajaran -->
        <div>
          <label class="block font-semibold text-slate-700 mb-1.5">Tahun Ajaran</label>
          <select
            v-model="filters.academicYear"
            class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 shadow-sm cursor-pointer"
          >
            <option value="all">Semua Tahun Ajaran</option>
            <option value="2025/2026">2025/2026 (Aktif)</option>
            <option value="2024/2025">2024/2025</option>
            <option value="2023/2024">2023/2024</option>
          </select>
        </div>

        <!-- 2. Filter Angkatan -->
        <div>
          <label class="block font-semibold text-slate-700 mb-1.5">Angkatan Siswa</label>
          <select
            v-model="filters.batch"
            class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 shadow-sm cursor-pointer"
          >
            <option value="all">Semua Angkatan</option>
            <option value="Angkatan 32">Angkatan 32</option>
            <option value="Angkatan 31">Angkatan 31</option>
            <option value="Angkatan 30">Angkatan 30</option>
          </select>
        </div>

        <!-- 3. Filter Mitra DUDI -->
        <div>
          <label class="block font-semibold text-slate-700 mb-1.5">Perusahaan Mitra (DUDI)</label>
          <select
            v-model="filters.dudi"
            class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 shadow-sm cursor-pointer"
          >
            <option value="all">Semua Perusahaan</option>
            <option value="PT Telkom Digital Solusi">PT Telkom Digital Solusi</option>
            <option value="PT Inovasi Media Kreatif">PT Inovasi Media Kreatif</option>
            <option value="Bank Mandiri IT Hub">Bank Mandiri IT Hub</option>
            <option value="CV Nusantara Studio">CV Nusantara Studio</option>
          </select>
        </div>

        <!-- 4. Filter Status Kelulusan -->
        <div>
          <label class="block font-semibold text-slate-700 mb-1.5">Status Nilai PKL</label>
          <select
            v-model="filters.gradeStatus"
            class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 shadow-sm cursor-pointer"
          >
            <option value="all">Semua Status</option>
            <option value="completed">Sudah Final (Lengkap)</option>
            <option value="pending">Sedang Berlangsung</option>
          </select>
        </div>
      </div>
    </div>

    <!-- AREA BAWAH: PRATINJAU BUKU JURNAL CETAK (PRINTABLE PREVIEW) -->
    <div class="bg-white text-slate-900 rounded-2xl p-8 shadow-sm border border-slate-300 print:shadow-none print:border-none print:p-0">
      <!-- Kop Surat Resmi Sekolah -->
      <div class="text-center pb-4 border-b-2 border-slate-900 space-y-1">
        <h3 class="text-sm font-bold uppercase tracking-wider text-slate-800">PEMERINTAH DAERAH PROVINSI JAWA BARAT</h3>
        <h4 class="text-xs font-semibold uppercase text-slate-700">DINAS PENDIDIKAN • CABANG DINAS WILAYAH VII</h4>
        <h2 class="text-base font-black uppercase text-slate-950 tracking-tight">SMK NEGERI 1 INDUSTRI DIGITAL KOTA BANDUNG</h2>
        <p class="text-[10px] text-slate-600">
          Jl. Soekarno Hatta No. 782, Bandung • Telp: (022) 7561234 • Website: smkn1industri.sch.id
        </p>
      </div>

      <!-- Judul Dokumen Cetak -->
      <div class="text-center my-6 space-y-1">
        <h1 class="text-sm font-black uppercase tracking-wide text-slate-950 underline">
          BUKU REKAPITULASI JURNAL &amp; NILAI PRAKTIK KERJA LAPANGAN (PKL)
        </h1>
        <p class="text-xs text-slate-600">
          Program Keahlian: Rekayasa Perangkat Lunak (RPL) • Tahun Ajaran: {{ filters.academicYear === 'all' ? '2025/2026' : filters.academicYear }}
        </p>
      </div>

      <!-- Tabel Pratinjau Buku Jurnal Cetak -->
      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs border-collapse border border-slate-300">
          <thead class="bg-slate-100 text-slate-800 font-bold uppercase text-[10px]">
            <tr>
              <th class="border border-slate-300 py-2.5 px-3 text-center">No</th>
              <th class="border border-slate-300 py-2.5 px-3">Nama Siswa</th>
              <th class="border border-slate-300 py-2.5 px-3 text-center">NISN</th>
              <th class="border border-slate-300 py-2.5 px-3">Perusahaan (DUDI)</th>
              <th class="border border-slate-300 py-2.5 px-3 text-center">Kehadiran</th>
              <th class="border border-slate-300 py-2.5 px-3 text-center">Jurnal ACC</th>
              <th class="border border-slate-300 py-2.5 px-3 text-center">Nilai DUDI (60%)</th>
              <th class="border border-slate-300 py-2.5 px-3 text-center">Nilai Sekolah (40%)</th>
              <th class="border border-slate-300 py-2.5 px-3 text-center font-bold">Nilai Akhir</th>
              <th class="border border-slate-300 py-2.5 px-3 text-center">Predikat</th>
              <th class="border border-slate-300 py-2.5 px-3 text-center">Status QR</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200 text-slate-800">
            <tr v-for="(row, idx) in filteredReports" :key="row.id" class="hover:bg-slate-50">
              <td class="border border-slate-300 py-2 px-3 text-center font-mono">{{ idx + 1 }}</td>
              <td class="border border-slate-300 py-2 px-3 font-bold text-slate-900">{{ row.studentName }}</td>
              <td class="border border-slate-300 py-2 px-3 font-mono text-center">{{ row.nisn }}</td>
              <td class="border border-slate-300 py-2 px-3">{{ row.company }}</td>
              <td class="border border-slate-300 py-2 px-3 text-center font-mono text-emerald-700 font-bold">{{ row.attendanceRate }}%</td>
              <td class="border border-slate-300 py-2 px-3 text-center font-mono">{{ row.verifiedJournals }}</td>
              <td class="border border-slate-300 py-2 px-3 text-center font-mono font-bold">{{ row.dudiGrade || '-' }}</td>
              <td class="border border-slate-300 py-2 px-3 text-center font-mono font-bold">{{ row.schoolGrade || '-' }}</td>
              <td class="border border-slate-300 py-2 px-3 text-center font-mono font-black text-slate-950">{{ row.finalGrade || '-' }}</td>
              <td class="border border-slate-300 py-2 px-3 text-center font-bold text-[10px]">{{ row.predicate || '-' }}</td>
              <td class="border border-slate-300 py-2 px-3 text-center font-mono text-[9px] text-emerald-700 font-semibold">
                {{ row.qrStatus }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Tanda Tangan Resmi Buku Jurnal PKL -->
      <div class="grid grid-cols-2 gap-8 mt-10 pt-6 text-xs text-center text-slate-800">
        <div>
          <p>Mengetahui,</p>
          <p class="font-bold">Kepala Program Keahlian RPL</p>
          <div class="h-16"></div>
          <p class="font-bold underline">Ir. Bambang Hermanto, M.T</p>
          <p class="font-mono text-[10px]">NIP. 19750810 199903 1 002</p>
        </div>

        <div>
          <p>Bandung, 27 September 2026</p>
          <p class="font-bold">Kepala SMK Negeri 1 Industri</p>
          <div class="h-16"></div>
          <p class="font-bold underline">Dr. H. Ahmad Sudrajat, M.M.Pd</p>
          <p class="font-mono text-[10px]">NIP. 19680315 199203 1 004</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, reactive, computed } from 'vue'
import { useAppStore } from '~/composables/useAppStore'

const { showToast } = useAppStore()

const filters = reactive({
  academicYear: 'all',
  batch: 'all',
  dudi: 'all',
  gradeStatus: 'all'
})

const reportsData = ref([
  {
    id: 1,
    studentName: 'Budi Santoso',
    nisn: '0061234567',
    company: 'PT Telkom Digital Solusi',
    academicYear: '2025/2026',
    batch: 'Angkatan 32',
    attendanceRate: 96.4,
    verifiedJournals: 18,
    dudiGrade: '92.50',
    schoolGrade: '90.00',
    finalGrade: '91.50',
    predicate: 'A (Amat Baik)',
    qrStatus: 'VERIFIED',
    gradeStatus: 'completed'
  },
  {
    id: 2,
    studentName: 'Siti Rahma',
    nisn: '0061234568',
    company: 'PT Telkom Digital Solusi',
    academicYear: '2025/2026',
    batch: 'Angkatan 32',
    attendanceRate: 92.8,
    verifiedJournals: 14,
    dudiGrade: '88.00',
    schoolGrade: '86.00',
    finalGrade: '87.20',
    predicate: 'B+ (Sangat Baik)',
    qrStatus: 'VERIFIED',
    gradeStatus: 'completed'
  },
  {
    id: 3,
    studentName: 'Rizky Pratama',
    nisn: '0061234569',
    company: 'PT Inovasi Media Kreatif',
    academicYear: '2025/2026',
    batch: 'Angkatan 32',
    attendanceRate: 85.0,
    verifiedJournals: 8,
    dudiGrade: null,
    schoolGrade: '78.00',
    finalGrade: null,
    predicate: null,
    qrStatus: 'PENDING',
    gradeStatus: 'pending'
  },
  {
    id: 4,
    studentName: 'Dewi Anggraeni',
    nisn: '0061234570',
    company: 'Bank Mandiri IT Hub',
    academicYear: '2025/2026',
    batch: 'Angkatan 32',
    attendanceRate: 98.0,
    verifiedJournals: 20,
    dudiGrade: '95.00',
    schoolGrade: '92.00',
    finalGrade: '93.80',
    predicate: 'A (Amat Baik)',
    qrStatus: 'VERIFIED',
    gradeStatus: 'completed'
  }
])

const filteredReports = computed(() => {
  return reportsData.value.filter(item => {
    if (filters.academicYear !== 'all' && item.academicYear !== filters.academicYear) return false
    if (filters.batch !== 'all' && item.batch !== filters.batch) return false
    if (filters.dudi !== 'all' && item.company !== filters.dudi) return false
    if (filters.gradeStatus !== 'all' && item.gradeStatus !== filters.gradeStatus) return false
    return true
  })
})

const exportToPdf = () => {
  window.print()
}

const exportToExcel = () => {
  // Generate CSV data download
  const headers = ['No', 'Nama Siswa', 'NISN', 'Perusahaan', 'Kehadiran (%)', 'Jurnal ACC', 'Nilai DUDI', 'Nilai Sekolah', 'Nilai Akhir', 'Predikat', 'Status QR']
  const rows = filteredReports.value.map((r, i) => [
    i + 1,
    `"${r.studentName}"`,
    r.nisn,
    `"${r.company}"`,
    r.attendanceRate,
    r.verifiedJournals,
    r.dudiGrade || '',
    r.schoolGrade || '',
    r.finalGrade || '',
    `"${r.predicate || ''}"`,
    r.qrStatus
  ])

  const csvContent = 'data:text/csv;charset=utf-8,' + [headers.join(','), ...rows.map(e => e.join(','))].join('\n')
  const encodedUri = encodeURI(csvContent)
  const link = document.createElement('a')
  link.setAttribute('href', encodedUri)
  link.setAttribute('download', `Laporan_Buku_Jurnal_PKL_${filters.academicYear.replace('/', '_')}.csv`)
  document.body.appendChild(link)
  link.click()
  document.body.removeChild(link)

  showToast('Laporan buku jurnal cetak berhasil diekspor ke Excel (CSV)!', 'success')
}
</script>
