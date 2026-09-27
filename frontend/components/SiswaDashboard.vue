<template>
  <div class="flex flex-col w-full gap-space-lg max-w-7xl mx-auto">
    <!-- Top Operational Banner Card (Stitch Design) -->
    <section class="w-full bg-surface-container-lowest rounded-xl shadow-sm p-space-lg flex flex-col lg:flex-row lg:items-center justify-between gap-space-lg border border-outline-variant">
      <div class="flex flex-col gap-space-xs max-w-2xl">
        <div class="flex items-center gap-space-sm flex-wrap">
          <span class="font-label-sm text-label-sm uppercase px-2 py-0.5 rounded bg-surface-container text-primary font-bold tracking-wider">
            Semester Ganjil 2025/2026
          </span>
          <span class="font-label-sm text-label-sm px-2 py-0.5 rounded bg-tertiary-fixed text-tertiary font-bold flex items-center gap-1">
            <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
            Status: Verifikasi Sinkron
          </span>
        </div>

        <h1 class="font-headline text-2xl font-bold text-on-surface tracking-tight mt-1">
          Halo, {{ currentUser.name }}! 👋
        </h1>
        <p class="font-body text-xs text-on-surface-variant">
          Minggu ke-9 dari 24 Minggu Magang di <strong class="text-on-surface">PT Telkom Digital Solusi</strong> • Konsentrasi Software &amp; Cloud Engineering
        </p>

        <!-- Progress Track -->
        <div class="mt-space-sm flex flex-col gap-1.5">
          <div class="flex justify-between items-center text-xs">
            <span class="text-on-surface-variant font-medium">
              Target Durasi Kumulatif: <strong class="text-on-surface font-bold">680 Jam</strong>
            </span>
            <span class="font-code-sm text-xs font-semibold text-primary font-mono">
              Tercapai: 364 Jam (53.5%)
            </span>
          </div>
          <div class="w-full h-3 bg-surface-container rounded-full overflow-hidden p-0.5 flex items-center border border-outline-variant/60">
            <div class="h-full bg-primary-container rounded-full transition-all duration-500 ease-out" style="width: 53.5%;"></div>
          </div>
        </div>
      </div>

      <!-- Quick CTA Buttons -->
      <div class="flex flex-wrap lg:flex-col sm:flex-row items-stretch gap-space-sm shrink-0">
        <button
          @click="goToLogbook"
          class="flex items-center justify-center gap-space-sm bg-primary-container text-on-primary px-space-md py-2.5 rounded-lg text-xs font-semibold hover:bg-primary transition-colors shadow-sm active:scale-95"
          type="button"
        >
          <span class="material-symbols-outlined text-[18px]">add_circle</span>
          <span>+ Buat Logbook Hari Ini</span>
        </button>

        <button
          @click="handleCheckIn"
          :disabled="hasCheckedIn"
          :class="hasCheckedIn ? 'bg-surface-container text-tertiary border-tertiary/40 cursor-default' : 'bg-surface-container-low text-on-surface hover:bg-surface-container active:scale-95 border-outline-variant'"
          class="flex items-center justify-center gap-space-sm px-space-md py-2.5 rounded-lg text-xs font-medium transition-colors border"
          type="button"
        >
          <span class="material-symbols-outlined text-[18px]" :class="hasCheckedIn ? 'text-tertiary' : 'text-primary'">
            {{ hasCheckedIn ? 'verified' : 'location_on' }}
          </span>
          <span>{{ hasCheckedIn ? `Presensi Masuk (${checkInTime} WIB)` : 'Presensi Masuk (GPS Aktif)' }}</span>
        </button>
      </div>
    </section>

    <!-- 4 Stat Metric Cards (Stitch Design) -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md w-full">
      <!-- Stat 1 -->
      <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm border border-outline-variant flex flex-col justify-between gap-space-md hover:bg-surface-container-low/40 transition-colors">
        <div class="flex items-start justify-between">
          <div class="flex flex-col">
            <span class="font-label-sm text-[11px] text-on-surface-variant uppercase tracking-wider font-semibold">Total Kehadiran</span>
            <span class="font-headline text-2xl font-bold text-on-surface mt-1">46 <span class="text-xs text-on-surface-variant font-normal">Hari</span></span>
          </div>
          <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-primary">
            <span class="material-symbols-outlined text-[22px]">calendar_month</span>
          </div>
        </div>
        <div class="flex items-center gap-2">
          <span class="font-label-sm text-[10px] px-2 py-0.5 rounded bg-tertiary-fixed text-tertiary font-bold flex items-center gap-1">
            <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
            95.8% Kehadiran
          </span>
          <span class="text-[11px] text-on-surface-variant">Sesuai SOP DUDI</span>
        </div>
      </div>

      <!-- Stat 2 -->
      <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm border border-outline-variant flex flex-col justify-between gap-space-md hover:bg-surface-container-low/40 transition-colors">
        <div class="flex items-start justify-between">
          <div class="flex flex-col">
            <span class="font-label-sm text-[11px] text-on-surface-variant uppercase tracking-wider font-semibold">Logbook Harian</span>
            <span class="font-headline text-2xl font-bold text-on-surface mt-1">42 <span class="text-xs text-on-surface-variant font-normal">Terverifikasi</span></span>
          </div>
          <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-primary">
            <span class="material-symbols-outlined text-[22px]">verified</span>
          </div>
        </div>
        <div class="flex items-center gap-2">
          <span class="font-label-sm text-[10px] px-2 py-0.5 rounded bg-secondary-container text-on-secondary-fixed font-bold">
            2 Menunggu Review
          </span>
          <span class="text-[11px] text-on-surface-variant">Daftar Antrean</span>
        </div>
      </div>

      <!-- Stat 3 -->
      <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm border border-outline-variant flex flex-col justify-between gap-space-md hover:bg-surface-container-low/40 transition-colors">
        <div class="flex items-start justify-between">
          <div class="flex flex-col">
            <span class="font-label-sm text-[11px] text-on-surface-variant uppercase tracking-wider font-semibold">Evaluasi Mingguan</span>
            <span class="font-headline text-2xl font-bold text-on-surface mt-1">88.5 <span class="text-xs text-on-surface-variant font-normal">/ 100</span></span>
          </div>
          <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-primary">
            <span class="material-symbols-outlined text-[22px]">stars</span>
          </div>
        </div>
        <div class="flex items-center gap-2">
          <span class="font-label-sm text-[10px] px-2 py-0.5 rounded bg-surface-container-high text-primary font-bold">
            Sangat Baik (A)
          </span>
          <span class="text-[11px] text-on-surface-variant">Rata-rata mentor</span>
        </div>
      </div>

      <!-- Stat 4 -->
      <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm border border-outline-variant flex flex-col justify-between gap-space-md hover:bg-surface-container-low/40 transition-colors">
        <div class="flex items-start justify-between">
          <div class="flex flex-col">
            <span class="font-label-sm text-[11px] text-on-surface-variant uppercase tracking-wider font-semibold">Masa Praktik</span>
            <span class="font-headline text-2xl font-bold text-on-surface mt-1">58 <span class="text-xs text-on-surface-variant font-normal">Hari Tersisa</span></span>
          </div>
          <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-secondary">
            <span class="material-symbols-outlined text-[22px]">timelapse</span>
          </div>
        </div>
        <div class="flex items-center gap-2">
          <span class="font-label-sm text-[10px] px-2 py-0.5 rounded bg-surface-container text-on-surface-variant font-semibold">
            Hingga 27 Nov 2026
          </span>
          <span class="text-[11px] text-on-surface-variant">Fase Akhir</span>
        </div>
      </div>
    </section>

    <!-- Two Column Main Layout (12 cols: 8 cols left, 4 cols right) -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg w-full items-start">
      <!-- Left Column (8 cols) -->
      <div class="lg:col-span-8 flex flex-col gap-space-lg min-w-0">
        <!-- 1. Aktivitas Logbook Terbaru (Stitch Data Table) -->
        <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant flex flex-col overflow-hidden">
          <div class="p-space-md bg-surface-container-low/50 flex flex-col sm:flex-row sm:items-center justify-between gap-space-sm border-b border-outline-variant">
            <div class="flex items-center gap-space-sm">
              <span class="material-symbols-outlined text-[20px] text-primary">history_edu</span>
              <h2 class="font-headline text-sm font-bold text-on-surface">Aktivitas Logbook Terbaru</h2>
            </div>
            <div class="flex items-center gap-2">
              <span class="font-label-sm text-[11px] text-on-surface-variant">Menampilkan 4 entri terakhir</span>
              <button @click="goToLogbook" class="font-label-sm text-[11px] text-primary font-bold hover:underline ml-1" type="button">
                Lihat Semua
              </button>
            </div>
          </div>

          <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse text-xs">
              <thead>
                <tr class="bg-surface-container-low text-on-surface-variant font-label-sm text-[11px] uppercase tracking-wider border-b border-outline-variant">
                  <th class="py-space-sm px-space-md">Tanggal</th>
                  <th class="py-space-sm px-space-md">Aktivitas Pekerjaan Lapangan</th>
                  <th class="py-space-sm px-space-md">Pembimbing</th>
                  <th class="py-space-sm px-space-md">Verifikasi</th>
                  <th class="py-space-sm px-space-md text-right">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-outline-variant/60 font-body text-xs text-on-surface">
                <tr v-for="log in recentLogs" :key="log.id" class="hover:bg-surface-container-low/50 transition-colors">
                  <!-- Tanggal -->
                  <td class="py-3 px-space-md whitespace-nowrap">
                    <div class="font-mono font-bold text-on-surface text-xs">{{ log.date }}</div>
                    <div class="text-[11px] text-on-surface-variant">{{ log.time }}</div>
                  </td>

                  <!-- Aktivitas -->
                  <td class="py-3 px-space-md min-w-[220px]">
                    <div class="font-semibold text-on-surface line-clamp-1 text-xs">{{ log.title }}</div>
                    <div class="text-[11px] text-on-surface-variant line-clamp-1">{{ log.desc }}</div>
                  </td>

                  <!-- Pembimbing -->
                  <td class="py-3 px-space-md whitespace-nowrap text-on-surface">
                    <div class="font-medium text-xs">{{ log.mentor }}</div>
                    <div class="text-[10px] text-on-surface-variant">{{ log.company }}</div>
                  </td>

                  <!-- Verifikasi -->
                  <td class="py-3 px-space-md whitespace-nowrap">
                    <span
                      v-if="log.status === 'diacc'"
                      class="text-[10px] px-2 py-0.5 rounded bg-tertiary-fixed text-tertiary font-bold inline-flex items-center gap-1"
                    >
                      <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                      Disetujui
                    </span>
                    <span
                      v-else-if="log.status === 'revisi'"
                      class="text-[10px] px-2 py-0.5 rounded bg-error-container text-error font-bold inline-flex items-center gap-1"
                    >
                      <span class="w-1.5 h-1.5 rounded-full bg-error"></span>
                      Revisi
                    </span>
                    <span
                      v-else
                      class="text-[10px] px-2 py-0.5 rounded bg-secondary-container text-on-secondary-fixed font-bold inline-flex items-center gap-1"
                    >
                      <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                      Menunggu Review
                    </span>
                  </td>

                  <!-- Aksi -->
                  <td class="py-3 px-space-md text-right whitespace-nowrap">
                    <button
                      @click="goToLogbook"
                      class="text-[11px] px-2.5 py-1 rounded bg-surface-container text-primary font-bold hover:bg-surface-container-high transition-colors"
                      type="button"
                    >
                      Lihat Detail
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- 2. Jadwal Bimbingan & Catatan Mentor Lapangan Card (Stitch Design) -->
        <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant p-space-lg flex flex-col gap-space-md">
          <div class="flex items-center justify-between pb-space-sm border-b border-outline-variant">
            <div class="flex items-center gap-space-sm">
              <span class="material-symbols-outlined text-[20px] text-tertiary">assignment_turned_in</span>
              <h2 class="font-headline text-sm font-bold text-on-surface">Jadwal Bimbingan &amp; Catatan Mentor Lapangan</h2>
            </div>
            <span class="font-label-sm text-[11px] px-2 py-1 rounded bg-surface-container text-on-surface-variant font-semibold">
              Sesi Evaluasi Pekan #8
            </span>
          </div>

          <!-- Mentor Metadata Box -->
          <div class="p-space-md rounded-lg bg-surface-container-low border border-outline-variant flex flex-col sm:flex-row sm:items-center justify-between gap-space-md">
            <div class="flex items-center gap-space-md">
              <div class="w-12 h-12 rounded-lg bg-primary-container text-on-primary font-headline text-base flex items-center justify-center font-bold">
                HW
              </div>
              <div class="flex flex-col">
                <span class="font-label-md text-xs font-bold text-on-surface">Hendra Wijaya, S.Kom</span>
                <span class="text-[11px] text-on-surface-variant">Senior Cloud &amp; Software Lead / Pembimbing Industri DUDI</span>
                <span class="font-code-sm text-[11px] text-primary font-mono">ID. TELKOM-8821</span>
              </div>
            </div>
            <div class="flex flex-col items-start sm:items-end">
              <span class="text-[11px] text-on-surface-variant">Sesi Bimbingan Berikutnya:</span>
              <span class="text-xs font-bold text-on-surface">Jumat, 2 Okt 2026 • 14:00 WIB</span>
              <span class="text-[11px] text-tertiary font-semibold">Ruang Rapat Dev Telkom Lt. 3</span>
            </div>
          </div>

          <!-- Notes & Action Items -->
          <div class="flex flex-col gap-space-sm pt-space-xs">
            <h3 class="text-xs font-bold text-on-surface flex items-center gap-1.5">
              <span class="material-symbols-outlined text-[16px] text-primary">rate_review</span>
              Catatan Evaluasi Mingguan &amp; Rekomendasi Teknis:
            </h3>
            <ul class="space-y-2 text-xs text-on-surface-variant pl-space-sm">
              <li class="flex items-start gap-2">
                <span class="material-symbols-outlined text-[18px] text-tertiary shrink-0 mt-0.5">check_circle</span>
                <span><strong class="text-on-surface">Kualitas Arsitektur Kode Sangat Rapi:</strong> Integrasi SPA state management Pinia dan komponen Vue 3 sudah sesuai standar production.</span>
              </li>
              <li class="flex items-start gap-2">
                <span class="material-symbols-outlined text-[18px] text-tertiary shrink-0 mt-0.5">check_circle</span>
                <span><strong class="text-on-surface">Kedisiplinan Waktu:</strong> Presensi kehadiran selalu tepat waktu sebelum pukul 07:45 WIB dan jurnal diisi setiap hari kerja.</span>
              </li>
              <li class="flex items-start gap-2">
                <span class="material-symbols-outlined text-[18px] text-primary shrink-0 mt-0.5">error</span>
                <span><strong class="text-on-surface">Action Item Pekan Depan:</strong> Pelajari penanganan state offline SQLite synchronization dan kompresi foto sebelum upload ke server.</span>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Right Column (4 cols) -->
      <div class="lg:col-span-4 flex flex-col gap-space-lg">
        <!-- 1. Status Presensi Hari Ini Card (Stitch Design) -->
        <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant p-space-md flex flex-col gap-space-md">
          <div class="flex items-center justify-between pb-space-xs border-b border-outline-variant">
            <div class="flex items-center gap-2">
              <span class="material-symbols-outlined text-[20px] text-primary">pin_drop</span>
              <h2 class="font-headline text-sm font-bold text-on-surface">Presensi Hari Ini</h2>
            </div>
            <span
              :class="hasCheckedIn ? 'bg-tertiary-fixed text-tertiary' : 'bg-surface-container text-on-surface-variant'"
              class="font-label-sm text-[10px] px-2 py-0.5 rounded font-bold"
            >
              {{ hasCheckedIn ? 'Terverifikasi' : 'Belum Check-In' }}
            </span>
          </div>

          <!-- Clock & Geolocation Box -->
          <div class="p-space-md rounded-lg bg-surface-container-low border border-outline-variant flex flex-col items-center justify-center text-center gap-1">
            <span class="font-label-sm text-[10px] text-on-surface-variant uppercase tracking-wider font-semibold">
              Waktu Presensi Real-Time
            </span>
            <div class="font-headline text-2xl font-bold text-primary tracking-wider">
              {{ liveClock }} <span class="text-xs text-on-surface-variant font-normal">WIB</span>
            </div>
            <div class="text-xs text-tertiary font-semibold flex items-center gap-1 mt-1">
              <span class="material-symbols-outlined text-[16px]">verified_user</span>
              <span>{{ hasCheckedIn ? `Check-In Sukses (${checkInTime} WIB)` : 'Radius 12m dari Kantor DUDI' }}</span>
            </div>
            <span class="font-mono text-[10px] text-on-surface-variant mt-0.5">Lat: -6.917464, Long: 107.619123</span>
          </div>

          <!-- Action Buttons Check-In / Check-Out -->
          <div class="flex flex-col gap-2">
            <div class="flex items-center justify-between text-xs p-2 rounded bg-surface-container">
              <span class="text-on-surface-variant">Jadwal Kerja:</span>
              <span class="font-bold text-on-surface font-mono">08:00 - 17:00 WIB</span>
            </div>

            <!-- Giant Action Trigger -->
            <button
              v-if="!hasCheckedIn"
              @click="handleCheckIn"
              class="w-full py-3 px-space-md rounded-lg bg-primary-container text-on-primary text-xs font-bold hover:bg-primary transition-colors flex items-center justify-center gap-2 shadow-sm active:scale-95"
              type="button"
            >
              <span class="material-symbols-outlined text-[18px]">login</span>
              <span>Lakukan Check-In Pagi Sekarang</span>
            </button>

            <button
              v-else
              @click="handleCheckOut"
              :disabled="hasCheckedOut"
              :class="hasCheckedOut ? 'bg-surface-container text-on-surface-variant cursor-default' : 'bg-primary-container text-on-primary hover:bg-primary active:scale-95'"
              class="w-full py-3 px-space-md rounded-lg text-xs font-bold transition-colors flex items-center justify-center gap-2 shadow-sm"
              type="button"
            >
              <span class="material-symbols-outlined text-[18px]">logout</span>
              <span>{{ hasCheckedOut ? `Check-Out Sukses (${checkOutTime} WIB)` : 'Check-Out Sore (Mulai 16:30)' }}</span>
            </button>
          </div>
        </div>

        <!-- 2. Info Instansi Cepat Card (Stitch Design) -->
        <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant p-space-md flex flex-col gap-space-md">
          <div class="flex items-center gap-2 pb-space-xs border-b border-outline-variant">
            <span class="material-symbols-outlined text-[20px] text-primary">domain</span>
            <h2 class="font-headline text-sm font-bold text-on-surface">Info Instansi Tempat PKL</h2>
          </div>
          <div class="flex flex-col gap-space-sm text-xs">
            <div>
              <span class="text-[10px] text-on-surface-variant block uppercase tracking-wide font-semibold">Nama Industri / Perusahaan</span>
              <span class="font-bold text-on-surface">PT Telkom Digital Solusi Bandung</span>
            </div>
            <div>
              <span class="text-[10px] text-on-surface-variant block uppercase tracking-wide font-semibold">Divisi / Unit Operasi</span>
              <span class="text-on-surface">Cloud Platform &amp; Software Engineering</span>
            </div>
            <div>
              <span class="text-[10px] text-on-surface-variant block uppercase tracking-wide font-semibold">Alamat Lokasi Magang</span>
              <p class="text-on-surface-variant text-[11px] leading-relaxed">
                Jl. Gegerkalong Hilir No. 47, Sukasari, Kota Bandung, Jawa Barat 40152
              </p>
            </div>
            <div class="p-space-sm rounded-lg bg-surface-container border border-outline-variant flex items-center justify-between">
              <div class="flex flex-col">
                <span class="text-[10px] text-on-surface-variant font-semibold">Kontak Mentor Industri</span>
                <span class="font-mono text-xs font-bold text-on-surface">+62 811-2233-4455</span>
              </div>
              <a
                class="px-2.5 py-1.5 rounded-lg bg-tertiary-container text-on-tertiary-container text-[11px] font-bold flex items-center gap-1 hover:opacity-90 active:scale-95"
                href="https://wa.me/6281122334455"
                rel="noopener noreferrer"
                target="_blank"
              >
                <span class="material-symbols-outlined text-[14px]">chat</span>
                WhatsApp
              </a>
            </div>
          </div>
        </div>

        <!-- 3. Administrasi PKL Card (Stitch Design) -->
        <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant p-space-md flex flex-col gap-space-sm">
          <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px] text-primary">description</span>
            <h2 class="font-headline text-sm font-bold text-on-surface">Administrasi PKL</h2>
          </div>
          <p class="text-[11px] text-on-surface-variant leading-relaxed">
            Unduh berkas rekap presensi dan lembar logbook resmi berstempel digital untuk pelaporan ke guru pembimbing sekolah.
          </p>
          <div class="flex flex-col gap-2 pt-1">
            <button
              @click="downloadLembarKendali"
              class="w-full py-2 px-space-md rounded-lg bg-surface-container-low hover:bg-surface-container text-on-surface text-xs font-semibold flex items-center justify-between transition-colors border border-outline-variant"
              type="button"
            >
              <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px] text-error">picture_as_pdf</span>
                <span>Lembar Kendali Oktober 2026</span>
              </div>
              <span class="material-symbols-outlined text-[16px] text-on-surface-variant">download</span>
            </button>

            <button
              @click="downloadRekapExcel"
              class="w-full py-2 px-space-md rounded-lg bg-surface-container-low hover:bg-surface-container text-on-surface text-xs font-semibold flex items-center justify-between transition-colors border border-outline-variant"
              type="button"
            >
              <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px] text-primary">download</span>
                <span>Rekap Absensi Pekan 1-8 (.xlsx)</span>
              </div>
              <span class="material-symbols-outlined text-[16px] text-on-surface-variant">download</span>
            </button>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'
import { useAppStore } from '~/composables/useAppStore'

const {
  currentUser,
  activeMenu,
  showToast
} = useAppStore()

// Attendance State
const hasCheckedIn = ref(true)
const hasCheckedOut = ref(false)
const checkInTime = ref('07:35:12')
const checkOutTime = ref('')

// Live Clock Ticker (Stitch Ticker Engine)
const liveClock = ref('08:14:22')
let clockInterval: any = null

onMounted(() => {
  const updateClock = () => {
    const now = new Date()
    const hours = String(now.getHours()).padStart(2, '0')
    const minutes = String(now.getMinutes()).padStart(2, '0')
    const seconds = String(now.getSeconds()).padStart(2, '0')
    liveClock.value = `${hours}:${minutes}:${seconds}`
  }
  updateClock()
  clockInterval = setInterval(updateClock, 1000)
})

onUnmounted(() => {
  if (clockInterval) clearInterval(clockInterval)
})

const handleCheckIn = () => {
  const now = new Date()
  const hours = String(now.getHours()).padStart(2, '0')
  const minutes = String(now.getMinutes()).padStart(2, '0')
  const seconds = String(now.getSeconds()).padStart(2, '0')
  checkInTime.value = `${hours}:${minutes}:${seconds}`
  hasCheckedIn.value = true
  showToast(`Check-In berhasil tercatat pada ${checkInTime.value} WIB (Radius 12m terverifikasi GPS)!`, 'success')
}

const handleCheckOut = () => {
  const now = new Date()
  const hours = String(now.getHours()).padStart(2, '0')
  const minutes = String(now.getMinutes()).padStart(2, '0')
  const seconds = String(now.getSeconds()).padStart(2, '0')
  checkOutTime.value = `${hours}:${minutes}:${seconds}`
  hasCheckedOut.value = true
  showToast(`Check-Out pulang berhasil tercatat pada ${checkOutTime.value} WIB! Selamat beristirahat.`, 'success')
}

const goToLogbook = () => {
  activeMenu.value = 'logbook'
}

const downloadLembarKendali = () => {
  window.print()
}

const downloadRekapExcel = () => {
  showToast('Mengunduh Rekap_Absensi_Pekan_1_8_Budi_Santoso.xlsx...', 'success')
}

// Recent Logs matching Stitch
const recentLogs = ref([
  {
    id: 1,
    date: '26 Sep 2026',
    time: '08:00 - 16:30 WIB',
    title: 'Pembuatan Tampilan Split-Screen Validasi DUDI',
    desc: 'Merancang layout split view sesuai panduan UX desktop: panel daftar siswa dan panel kanan detail jurnal.',
    mentor: 'Hendra Wijaya',
    company: 'PT Telkom Digital Solusi',
    status: 'menunggu'
  },
  {
    id: 2,
    date: '25 Sep 2026',
    time: '08:00 - 17:00 WIB',
    title: 'Optimasi Upload Foto Jurnal dengan Kompresi Gambar Canvas',
    desc: 'Menerapkan kompresi gambar berbasis HTML5 Canvas client-side sebelum upload ke server backend.',
    mentor: 'Hendra Wijaya',
    company: 'PT Telkom Digital Solusi',
    status: 'revisi'
  },
  {
    id: 3,
    date: '24 Sep 2026',
    time: '08:15 - 16:30 WIB',
    title: 'Integrasi State Management Pinia pada Nuxt 3',
    desc: 'Mengonfigurasi state global untuk token autentikasi, status koneksi offline/online dengan reactive indicator.',
    mentor: 'Hendra Wijaya',
    company: 'PT Telkom Digital Solusi',
    status: 'diacc'
  },
  {
    id: 4,
    date: '23 Sep 2026',
    time: '08:00 - 16:45 WIB',
    title: 'Konfigurasi Endpoint REST API Sanctum di Laravel 11',
    desc: 'Membangun resource controller untuk siswa, DUDI, guru, dan admin beserta SQLite database seeding.',
    mentor: 'Hendra Wijaya',
    company: 'PT Telkom Digital Solusi',
    status: 'diacc'
  }
])
</script>
