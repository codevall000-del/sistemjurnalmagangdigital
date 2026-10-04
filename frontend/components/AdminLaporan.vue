<template>
  <div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-black/[0.06] no-print">
      <div>
        <div class="flex items-center gap-2 mb-1">
          <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold tracking-wide bg-[#0071e3]/10 text-[#0071e3]">
            Arsip &amp; Ekspor Dokumen
          </span>
          <span class="text-[#86868b]">•</span>
          <span class="text-xs font-medium text-[#86868b]">SMKN 71 Jakarta</span>
        </div>
        <h2 class="text-2xl font-bold text-[#1d1d1f] tracking-tight flex items-center gap-2">
          <span>Laporan &amp; Cetak Buku Jurnal</span>
        </h2>
        <p class="text-xs text-[#86868b] mt-0.5">
          Penyusunan berkas laporan akhir PKL, arsip sertifikasi nilai, dan ekspor dokumen resmi sekolah.
        </p>
      </div>

      <!-- Action Buttons: Export to PDF & Export to Excel -->
      <div class="flex items-center gap-2.5">
        <button
          @click="exportToExcel"
          class="px-4 py-2 bg-black/[0.04] hover:bg-black/[0.07] text-[#1d1d1f] rounded-xl text-xs font-medium border border-black/[0.06] transition flex items-center gap-1.5 apple-press cursor-pointer"
        >
          <svg class="w-3.5 h-3.5 text-[#34c759]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          <span>Export Excel</span>
        </button>

        <button
          @click="exportToPdf"
          class="px-4 py-2 bg-[#0071e3] hover:bg-[#0077ed] text-white rounded-xl text-xs font-semibold shadow-[0_2px_8px_rgba(0,113,227,0.25)] transition flex items-center gap-1.5 apple-press cursor-pointer"
        >
          <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
          </svg>
          <span>Cetak Dokumen (PDF)</span>
        </button>
      </div>
    </div>

    <!-- PANEL FILTER ARSIP DOKUMEN -->
    <div class="bg-white border border-black/[0.05] rounded-2xl p-6 shadow-[0_2px_12px_rgba(0,0,0,0.03)] space-y-4 no-print">
      <div class="flex items-center justify-between pb-3 border-b border-black/[0.06]">
        <span class="text-xs font-semibold uppercase tracking-wider text-[#1d1d1f]">
          Filter Parameter Berkas
        </span>
        <span class="text-xs text-[#86868b] font-mono">Ditemukan: {{ filteredReports.length }} Rekord</span>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs">
        <!-- 1. Filter Tahun Ajaran -->
        <div>
          <label class="block font-medium text-[#1d1d1f] mb-1.5">Tahun Ajaran</label>
          <select
            v-model="filters.academicYear"
            class="w-full px-3 py-2 bg-black/[0.03] focus:bg-white border border-transparent focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition cursor-pointer"
          >
            <option value="all">Semua Tahun Ajaran</option>
            <option value="2025/2026">2025/2026 (Aktif)</option>
            <option value="2024/2025">2024/2025</option>
            <option value="2023/2024">2023/2024</option>
          </select>
        </div>

        <!-- 2. Filter Angkatan -->
        <div>
          <label class="block font-medium text-[#1d1d1f] mb-1.5">Angkatan Siswa</label>
          <select
            v-model="filters.batch"
            class="w-full px-3 py-2 bg-black/[0.03] focus:bg-white border border-transparent focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition cursor-pointer"
          >
            <option value="all">Semua Angkatan</option>
            <option value="Angkatan 32">Angkatan 32</option>
            <option value="Angkatan 31">Angkatan 31</option>
            <option value="Angkatan 30">Angkatan 30</option>
          </select>
        </div>

        <!-- 3. Filter Tempat Magang -->
        <div>
          <label class="block font-medium text-[#1d1d1f] mb-1.5">Tempat Magang (Instansi / Perusahaan)</label>
          <select
            v-model="filters.dudi"
            class="w-full px-3 py-2 bg-black/[0.03] focus:bg-white border border-transparent focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition cursor-pointer"
          >
            <option value="all">Semua Tempat Magang</option>
            <option value="PT Telkom Digital Solusi">PT Telkom Digital Solusi</option>
            <option value="PT Inovasi Media Kreatif">PT Inovasi Media Kreatif</option>
            <option value="Bank Mandiri IT Hub">Bank Mandiri IT Hub</option>
            <option value="CV Nusantara Studio">CV Nusantara Studio</option>
          </select>
        </div>

        <!-- 4. Filter Status Kelulusan -->
        <div>
          <label class="block font-medium text-[#1d1d1f] mb-1.5">Status Nilai PKL</label>
          <select
            v-model="filters.gradeStatus"
            class="w-full px-3 py-2 bg-black/[0.03] focus:bg-white border border-transparent focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition cursor-pointer"
          >
            <option value="all">Semua Status</option>
            <option value="completed">Sudah Final (Lengkap)</option>
            <option value="pending">Sedang Berlangsung</option>
          </select>
        </div>
      </div>
    </div>

    <!-- AREA BAWAH: PRATINJAU DOKUMEN CETAK (Apple Document Canvas Style) -->
    <div class="bg-white text-[#1d1d1f] rounded-2xl p-8 sm:p-12 shadow-[0_4px_24px_rgba(0,0,0,0.06)] border border-black/[0.06] print:shadow-none print:border-none print:p-0">
      <!-- Kop Surat Resmi Sekolah -->
      <div class="flex items-center justify-between pb-4 border-b-2 border-black/[0.8] gap-4">
        <img src="/images/logo-smkn71.png" alt="Logo SMKN 71" class="w-16 h-16 object-contain shrink-0" />
        <div class="flex-1 text-center space-y-1">
          <h3 class="text-xs sm:text-sm font-bold uppercase tracking-wider text-[#1d1d1f]">PEMERINTAH PROVINSI DAERAH KHUSUS IBUKOTA JAKARTA</h3>
          <h4 class="text-xs font-semibold uppercase text-[#1d1d1f]">DINAS PENDIDIKAN</h4>
          <h2 class="text-base sm:text-lg font-black uppercase text-[#1d1d1f] tracking-tight">SMK NEGERI 71 JAKARTA</h2>
          <p class="text-[10px] text-[#86868b]">
            Jl. Dr. KRT Radjiman Widyodiningrat, Cakung, Jakarta Timur • Website: smkn71jakarta.sch.id
          </p>
        </div>
        <div class="w-16 shrink-0 hidden sm:block"></div>
      </div>

      <!-- Judul Dokumen Cetak -->
      <div class="text-center my-6 space-y-1">
        <h1 class="text-sm sm:text-base font-black uppercase tracking-wide text-[#1d1d1f] underline">
          BUKU REKAPITULASI JURNAL &amp; NILAI PRAKTIK KERJA LAPANGAN (PKL)
        </h1>
        <p class="text-xs text-[#86868b]">
          Program Keahlian: Rekayasa Perangkat Lunak (RPL) • Tahun Ajaran: {{ filters.academicYear === 'all' ? '2025/2026' : filters.academicYear }}
        </p>
      </div>

      <!-- Tabel Pratinjau Buku Jurnal Cetak -->
      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs border-collapse border border-black/[0.15]">
          <thead class="bg-black/[0.03] text-[#1d1d1f] font-bold uppercase text-[10px]">
            <tr>
              <th class="border border-black/[0.15] py-2.5 px-3 text-center">No</th>
              <th class="border border-black/[0.15] py-2.5 px-3">Nama Siswa</th>
              <th class="border border-black/[0.15] py-2.5 px-3 text-center">NISN</th>
              <th class="border border-black/[0.15] py-2.5 px-3">Tempat Magang</th>
              <th class="border border-black/[0.15] py-2.5 px-3 text-center">Kehadiran</th>
              <th class="border border-black/[0.15] py-2.5 px-3 text-center">Jurnal ACC</th>
              <th class="border border-black/[0.15] py-2.5 px-3 text-center">Nilai Lapangan (60%)</th>
              <th class="border border-black/[0.15] py-2.5 px-3 text-center">Nilai Sekolah (40%)</th>
              <th class="border border-black/[0.15] py-2.5 px-3 text-center font-bold">Nilai Akhir</th>
              <th class="border border-black/[0.15] py-2.5 px-3 text-center">Predikat</th>
              <th class="border border-black/[0.15] py-2.5 px-3 text-center">Status QR</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-black/[0.1] text-[#1d1d1f]">
            <tr v-for="(row, idx) in filteredReports" :key="row.id" class="hover:bg-black/[0.015]">
              <td class="border border-black/[0.15] py-2 px-3 text-center font-mono">{{ idx + 1 }}</td>
              <td class="border border-black/[0.15] py-2 px-3 font-semibold text-[#1d1d1f]">{{ row.studentName }}</td>
              <td class="border border-black/[0.15] py-2 px-3 font-mono text-center text-[#86868b]">{{ row.nisn }}</td>
              <td class="border border-black/[0.15] py-2 px-3">{{ row.company }}</td>
              <td class="border border-black/[0.15] py-2 px-3 text-center font-mono text-[#34c759] font-bold">{{ row.attendanceRate }}%</td>
              <td class="border border-black/[0.15] py-2 px-3 text-center font-mono">{{ row.verifiedJournals }}</td>
              <td class="border border-black/[0.15] py-2 px-3 text-center font-mono font-semibold">{{ row.dudiGrade || '-' }}</td>
              <td class="border border-black/[0.15] py-2 px-3 text-center font-mono font-semibold">{{ row.schoolGrade || '-' }}</td>
              <td class="border border-black/[0.15] py-2 px-3 text-center font-mono font-bold text-[#1d1d1f]">{{ row.finalGrade || '-' }}</td>
              <td class="border border-black/[0.15] py-2 px-3 text-center font-semibold text-[10px]">{{ row.predicate || '-' }}</td>
              <td class="border border-black/[0.15] py-2 px-3 text-center font-mono text-[9px] text-[#34c759] font-semibold">
                {{ row.qrStatus }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Tanda Tangan Resmi Buku Jurnal PKL -->
      <div class="grid grid-cols-2 gap-8 mt-10 pt-6 text-xs text-center text-[#1d1d1f]">
        <div>
          <p>Mengetahui,</p>
          <p class="font-bold">Kepala Program Keahlian RPL</p>
          <div class="h-16"></div>
          <p class="font-bold underline">Administrator Sistem</p>
          <p class="font-mono text-[10px] text-[#86868b]">NIP. 19800101 200501 1 001</p>
        </div>

        <div>
          <p>Jakarta, 27 September 2026</p>
          <p class="font-bold">Kepala SMK Negeri 71 Jakarta</p>
          <div class="h-16"></div>
          <p class="font-bold underline">Dr. H. Ahmad Sudrajat, M.M.Pd</p>
          <p class="font-mono text-[10px] text-[#86868b]">NIP. 19680315 199203 1 004</p>
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
    id: 4,
    studentName: 'Siswa Magang',
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
  const headers = ['No', 'Nama Siswa', 'NISN', 'Tempat Magang', 'Kehadiran (%)', 'Jurnal ACC', 'Nilai Lapangan', 'Nilai Sekolah', 'Nilai Akhir', 'Predikat', 'Status QR']
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
