<template>
  <div class="flex flex-col w-full max-w-[1440px] mx-auto gap-space-lg">
    <!-- Header & Breadcrumb Context -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-md">
      <div>
        <div class="flex items-center gap-space-xs mb-1">
          <span class="font-label-sm text-label-sm text-secondary tracking-widest uppercase font-semibold">Administrasi &amp; Logbook</span>
          <span class="text-outline text-[10px]">•</span>
          <span class="font-label-sm text-label-sm text-on-surface-variant">Semester Ganjil 2024 • SMKN 71 Jakarta</span>
        </div>
        <h1 class="font-headline-xl text-headline-xl text-primary font-bold tracking-tight">Lembar Kehadiran &amp; Presensi</h1>
        <p class="font-body-md text-body-md text-on-surface-variant mt-0.5 leading-relaxed">
          Pemantauan rekapitulasi jam kerja reguler, bukti lokasi presensi, dan validasi mentor.
        </p>
      </div>

      <div class="flex items-center gap-space-sm self-start md:self-auto">
        <button
          @click="downloadRekapPdf"
          class="inline-flex items-center gap-space-xs px-space-md py-2.5 rounded-lg bg-surface-container-lowest text-primary shadow-sm hover:bg-surface-container-low transition-colors font-headline-sm text-headline-sm border border-outline-variant"
          type="button"
        >
          <span class="material-symbols-outlined text-[18px]">file_download</span>
          <span class="font-body-sm text-body-sm font-semibold">Unduh Rekap PDF</span>
        </button>
        <button
          @click="isIzinModalOpen = true"
          class="inline-flex items-center gap-space-xs px-space-md py-2.5 rounded-lg bg-secondary text-on-secondary shadow-sm hover:opacity-90 transition-opacity font-headline-sm text-headline-sm active:scale-95"
          type="button"
        >
          <span class="material-symbols-outlined text-[18px]">add_circle</span>
          <span class="font-body-sm text-body-sm font-semibold">Ajukan Izin / Sakit</span>
        </button>
      </div>
    </div>

    <!-- Quick Presensi Today Panel (Hero-like split banner) -->
    <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant p-space-lg relative overflow-hidden">
      <div class="absolute -right-16 -top-16 w-80 h-80 rounded-full bg-secondary-container/20 blur-3xl pointer-events-none"></div>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg items-center relative z-10">
        <!-- Left Sub-panel: Realtime Clock & Status -->
        <div class="lg:col-span-4 flex flex-col gap-space-xs pr-0 lg:pr-space-md">
          <div class="flex items-center gap-space-xs text-on-surface-variant font-label-md text-label-md">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>Rabu, 23 Oktober 2024</span>
            <span class="text-outline">•</span>
            <span class="text-secondary font-semibold">Sesi Siang</span>
          </div>

          <div class="flex items-baseline gap-space-sm mt-1">
            <span class="font-headline-xl text-[44px] leading-none text-primary font-bold tracking-tight font-mono">
              {{ currentTime }}
            </span>
            <span class="font-label-sm text-label-sm text-on-surface-variant font-medium">WIB</span>
          </div>

          <div class="mt-2 flex items-center gap-space-xs text-on-surface-variant bg-surface-container-low px-space-md py-2 rounded-lg border border-outline-variant/60">
            <span class="material-symbols-outlined text-[18px] text-secondary">verified</span>
            <span class="font-label-sm text-label-sm text-on-surface truncate">Tervalidasi GPS Kantor • Lantai 4 Tech Hub</span>
          </div>
        </div>

        <!-- Middle Sub-panel: Check-in Details -->
        <div class="lg:col-span-5 bg-surface-container-low/70 rounded-xl p-space-md flex flex-col justify-between gap-space-sm border border-outline-variant/60">
          <div class="flex items-center justify-between">
            <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-semibold">Status Presensi Masuk</span>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 font-label-sm text-label-sm font-semibold border border-emerald-200">
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
              Tepat Waktu
            </span>
          </div>

          <div class="flex items-center gap-space-md my-1">
            <div class="w-12 h-12 rounded-xl bg-primary text-on-primary flex items-center justify-center shadow-sm">
              <span class="material-symbols-outlined text-[26px]">login</span>
            </div>
            <div>
              <div class="font-headline-sm text-headline-sm text-on-surface font-bold">08:24 WIB</div>
              <p class="font-body-sm text-body-sm text-on-surface-variant">Check-in Terverifikasi • WFO Kantor Pusat</p>
            </div>
          </div>

          <div class="w-full bg-surface-container rounded-full h-1.5 overflow-hidden">
            <div class="bg-secondary h-1.5 rounded-full" style="width: 60%;"></div>
          </div>

          <div class="flex justify-between items-center text-on-surface-variant font-label-sm text-label-sm">
            <span>Masuk 08:24 WIB</span>
            <span class="text-primary font-medium">Target Jam Pulang: 17:30 WIB</span>
          </div>
        </div>

        <!-- Right Sub-panel: Quick Checkout & Secondary Actions -->
        <div class="lg:col-span-3 flex flex-col justify-center gap-space-xs">
          <button
            @click="handleCheckOut"
            :disabled="hasCheckedOut"
            :class="hasCheckedOut ? 'bg-surface-container text-on-surface-variant cursor-default' : 'bg-primary-container text-on-primary hover:bg-primary active:scale-95 shadow-sm'"
            class="w-full py-3 px-space-md rounded-lg flex items-center justify-center gap-space-xs font-headline-sm text-headline-sm transition-colors"
            type="button"
          >
            <span class="material-symbols-outlined text-[20px]">logout</span>
            <span class="font-body-sm text-body-sm font-semibold">
              {{ hasCheckedOut ? 'Sudah Check-out Sore' : 'Check-out Sore' }}
            </span>
          </button>
          <div class="text-center font-label-sm text-label-sm text-on-surface-variant mt-1">
            {{ hasCheckedOut ? 'Presensi hari ini tuntas tersimpan' : 'Aktif otomatis pada 17:00 WIB' }}
          </div>
          <button
            @click="isGeofenceModalOpen = true"
            class="w-full py-2 px-space-sm text-secondary hover:text-primary transition-colors text-center font-body-sm text-body-sm font-medium flex items-center justify-center gap-1"
            type="button"
          >
            <span class="material-symbols-outlined text-[16px]">pin_drop</span>
            <span>Lihat Radius Geofence</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Monthly Summary Metric Cards (4 Grid) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
      <!-- Metric 1: Total Hari Kerja -->
      <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm border border-outline-variant hover:shadow-md transition-shadow flex flex-col justify-between">
        <div class="flex items-center justify-between">
          <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-semibold">Target Periode</span>
          <div class="w-8 h-8 rounded-lg bg-surface-container-low flex items-center justify-center text-primary border border-outline-variant">
            <span class="material-symbols-outlined text-[18px]">calendar_month</span>
          </div>
        </div>
        <div class="my-space-sm">
          <div class="font-headline-xl text-headline-xl text-primary font-bold">22 Hari</div>
          <div class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">Total hari kerja Oktober 2024</div>
        </div>
        <div class="flex items-center gap-1 font-label-sm text-label-sm text-secondary">
          <span class="material-symbols-outlined text-[15px]">info</span>
          <span>17 hari telah terselesaikan</span>
        </div>
      </div>

      <!-- Metric 2: Tepat Waktu -->
      <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm border border-outline-variant hover:shadow-md transition-shadow flex flex-col justify-between">
        <div class="flex items-center justify-between">
          <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-semibold">Tepat Waktu</span>
          <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-700 border border-emerald-200">
            <span class="material-symbols-outlined text-[18px]">timer</span>
          </div>
        </div>
        <div class="my-space-sm">
          <div class="font-headline-xl text-headline-xl text-primary font-bold">21 Hari</div>
          <div class="flex items-center gap-2 mt-0.5">
            <span class="inline-flex px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 font-label-sm text-label-sm font-semibold">95.5% Rasio</span>
            <span class="font-body-sm text-body-sm text-on-surface-variant">Sangat Bagus</span>
          </div>
        </div>
        <div class="w-full bg-surface-container-low rounded-full h-1.5 overflow-hidden">
          <div class="bg-emerald-600 h-1.5 rounded-full" style="width: 95.5%;"></div>
        </div>
      </div>

      <!-- Metric 3: Terlambat -->
      <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm border border-outline-variant hover:shadow-md transition-shadow flex flex-col justify-between">
        <div class="flex items-center justify-between">
          <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-semibold">Terlambat</span>
          <div class="w-8 h-8 rounded-lg bg-surface-container-low flex items-center justify-center text-on-surface-variant border border-outline-variant">
            <span class="material-symbols-outlined text-[18px]">running_with_errors</span>
          </div>
        </div>
        <div class="my-space-sm">
          <div class="font-headline-xl text-headline-xl text-primary font-bold">0 Hari</div>
          <div class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">0 Menit akumulasi penalti</div>
        </div>
        <div class="flex items-center gap-1 font-label-sm text-label-sm text-emerald-700 font-medium">
          <span class="material-symbols-outlined text-[15px]">check_circle</span>
          <span>Catatan kehadiran bersih</span>
        </div>
      </div>

      <!-- Metric 4: Izin & Sakit -->
      <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm border border-outline-variant hover:shadow-md transition-shadow flex flex-col justify-between">
        <div class="flex items-center justify-between">
          <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-semibold">Izin / Sakit</span>
          <div class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center text-secondary border border-outline-variant">
            <span class="material-symbols-outlined text-[18px]">medical_services</span>
          </div>
        </div>
        <div class="my-space-sm">
          <div class="font-headline-xl text-headline-xl text-primary font-bold">1 Hari</div>
          <div class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">18 Okt 2024 (Surat Dokter)</div>
        </div>
        <div class="flex items-center gap-1 font-label-sm text-label-sm text-on-surface-variant">
          <span class="material-symbols-outlined text-[15px]">task_alt</span>
          <span>Disetujui Pembimbing</span>
        </div>
      </div>
    </div>

    <!-- Main Content: Filters & Views -->
    <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant p-space-md flex flex-col gap-space-md">
      <!-- Toolbar -->
      <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-space-sm pb-space-sm border-b border-outline-variant/60">
        <!-- Left: Month Selector & Category Pills -->
        <div class="flex flex-wrap items-center gap-space-xs">
          <div class="flex items-center bg-surface-container-low rounded-lg p-1 border border-outline-variant/60">
            <button class="p-1 hover:bg-surface-container rounded text-on-surface-variant hover:text-on-surface transition-colors" title="Bulan Sebelumnya" type="button">
              <span class="material-symbols-outlined text-[18px]">chevron_left</span>
            </button>
            <div class="px-space-sm flex items-center gap-1 font-headline-sm text-body-sm font-semibold text-primary">
              <span class="material-symbols-outlined text-[16px] text-secondary">calendar_today</span>
              <span>Oktober 2024</span>
            </div>
            <button class="p-1 hover:bg-surface-container rounded text-on-surface-variant hover:text-on-surface transition-colors" title="Bulan Berikutnya" type="button">
              <span class="material-symbols-outlined text-[18px]">chevron_right</span>
            </button>
          </div>

          <div class="inline-flex rounded-lg bg-surface-container-low p-1 text-on-surface-variant font-label-md text-label-md border border-outline-variant/60">
            <button
              @click="modeFilter = 'all'"
              :class="modeFilter === 'all' ? 'bg-surface-container-lowest text-primary font-semibold shadow-xs' : 'hover:text-on-surface'"
              class="px-space-md py-1.5 rounded-lg transition-all"
              type="button"
            >
              Semua Jenis ({{ records.length }})
            </button>
            <button
              @click="modeFilter = 'wfo'"
              :class="modeFilter === 'wfo' ? 'bg-surface-container-lowest text-primary font-semibold shadow-xs' : 'hover:text-on-surface'"
              class="px-space-md py-1.5 rounded-lg transition-all"
              type="button"
            >
              WFO (4)
            </button>
            <button
              @click="modeFilter = 'wfh'"
              :class="modeFilter === 'wfh' ? 'bg-surface-container-lowest text-primary font-semibold shadow-xs' : 'hover:text-on-surface'"
              class="px-space-md py-1.5 rounded-lg transition-all"
              type="button"
            >
              WFH (1)
            </button>
          </div>
        </div>

        <!-- Right: View Toggle -->
        <div class="flex items-center gap-space-xs self-end md:self-auto">
          <div class="bg-surface-container-low p-1 rounded-lg flex items-center border border-outline-variant/60">
            <button
              @click="viewType = 'table'"
              :class="viewType === 'table' ? 'bg-surface-container-lowest text-primary shadow-xs font-semibold' : 'text-on-surface-variant hover:text-on-surface'"
              class="flex items-center gap-1.5 px-space-md py-1.5 rounded-lg font-label-md text-label-md transition-all"
              type="button"
            >
              <span class="material-symbols-outlined text-[16px]">table_rows</span>
              <span>Tabel Rekap</span>
            </button>
            <button
              @click="viewType = 'calendar'"
              :class="viewType === 'calendar' ? 'bg-surface-container-lowest text-primary shadow-xs font-semibold' : 'text-on-surface-variant hover:text-on-surface'"
              class="flex items-center gap-1.5 px-space-md py-1.5 rounded-lg font-label-md text-label-md transition-all"
              type="button"
            >
              <span class="material-symbols-outlined text-[16px]">calendar_month</span>
              <span>Kalender Presensi</span>
            </button>
          </div>
        </div>
      </div>

      <!-- VIEW 1: TABEL REKAP (STITCH DESIGN) -->
      <div v-if="viewType === 'table'" class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse text-xs">
          <thead>
            <tr class="bg-surface-container-low text-on-surface-variant font-label-sm text-[11px] uppercase tracking-wider border-b border-outline-variant">
              <th class="py-space-sm px-space-md">Tanggal &amp; Sesi</th>
              <th class="py-space-sm px-space-md">Jam Masuk</th>
              <th class="py-space-sm px-space-md">Jam Pulang</th>
              <th class="py-space-sm px-space-md">Durasi</th>
              <th class="py-space-sm px-space-md">Lokasi &amp; Moda</th>
              <th class="py-space-sm px-space-md">Status Kehadiran</th>
              <th class="py-space-sm px-space-md">Validasi Mentor</th>
              <th class="py-space-sm px-space-md text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-outline-variant/60 font-body text-xs text-on-surface">
            <tr
              v-for="rec in filteredRecords"
              :key="rec.id"
              class="hover:bg-surface-container-low/50 transition-colors"
            >
              <!-- Tanggal -->
              <td class="py-3 px-space-md whitespace-nowrap">
                <div class="font-mono font-bold text-on-surface text-xs">{{ rec.date }}</div>
                <div class="text-[11px] text-on-surface-variant">{{ rec.day }}</div>
              </td>

              <!-- Jam Masuk -->
              <td class="py-3 px-space-md whitespace-nowrap">
                <span class="font-mono font-semibold text-primary">{{ rec.checkIn || '-' }}</span>
              </td>

              <!-- Jam Pulang -->
              <td class="py-3 px-space-md whitespace-nowrap">
                <span class="font-mono font-semibold" :class="rec.checkOut ? 'text-on-surface' : 'text-on-surface-variant italic'">
                  {{ rec.checkOut || 'Berjalan' }}
                </span>
              </td>

              <!-- Durasi -->
              <td class="py-3 px-space-md whitespace-nowrap">
                <span class="font-mono font-medium">{{ rec.duration }}</span>
              </td>

              <!-- Lokasi & Moda -->
              <td class="py-3 px-space-md whitespace-nowrap">
                <div class="font-medium text-xs">{{ rec.location }}</div>
                <div class="text-[10px] text-on-surface-variant">{{ rec.mode }}</div>
              </td>

              <!-- Status Kehadiran -->
              <td class="py-3 px-space-md whitespace-nowrap">
                <span
                  class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full font-label-sm text-label-sm font-semibold border"
                  :class="{
                    'bg-emerald-50 text-emerald-800 border-emerald-200': rec.status === 'ontime',
                    'bg-amber-50 text-amber-800 border-amber-200': rec.status === 'late',
                    'bg-sky-50 text-sky-800 border-sky-200': rec.status === 'sick'
                  }"
                >
                  <span
                    class="w-1.5 h-1.5 rounded-full"
                    :class="{
                      'bg-emerald-600': rec.status === 'ontime',
                      'bg-amber-600': rec.status === 'late',
                      'bg-sky-600': rec.status === 'sick'
                    }"
                  ></span>
                  {{ rec.statusLabel }}
                </span>
              </td>

              <!-- Validasi Mentor -->
              <td class="py-3 px-space-md whitespace-nowrap">
                <div class="flex items-center gap-1.5 text-secondary">
                  <span class="material-symbols-outlined text-[16px]">verified</span>
                  <span class="font-medium text-[11px]">{{ rec.validation }}</span>
                </div>
              </td>

              <!-- Aksi -->
              <td class="py-3 px-space-md text-right whitespace-nowrap">
                <button
                  @click="viewDetail(rec)"
                  class="text-[11px] px-2.5 py-1 rounded bg-surface-container text-primary font-bold hover:bg-surface-container-high transition-colors border border-outline-variant"
                  type="button"
                >
                  Detail
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- VIEW 2: KALENDER PRESENSI -->
      <div v-else class="p-space-lg flex flex-col gap-space-md">
        <div class="grid grid-cols-7 gap-2 text-center">
          <div v-for="d in ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']" :key="d" class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-bold pb-2">
            {{ d }}
          </div>
          <!-- Sample days for October 2024 -->
          <div
            v-for="day in calendarDays"
            :key="day.dayNumber"
            class="h-20 p-2 rounded-xl border border-outline-variant/60 flex flex-col justify-between text-left transition-colors"
            :class="day.isToday ? 'bg-surface-container-low border-primary' : 'bg-surface-container-lowest hover:bg-surface-container-low/50'"
          >
            <div class="flex items-center justify-between">
              <span class="font-mono text-xs font-bold" :class="day.isToday ? 'text-primary' : 'text-on-surface'">
                {{ day.dayNumber }}
              </span>
              <span v-if="day.isToday" class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
            </div>
            <div v-if="day.status" class="flex flex-col">
              <span
                class="text-[10px] px-1 py-0.5 rounded font-semibold truncate"
                :class="day.status === 'Hadir' ? 'bg-emerald-50 text-emerald-700' : 'bg-sky-50 text-sky-700'"
              >
                {{ day.status }}
              </span>
              <span class="font-mono text-[9px] text-on-surface-variant mt-0.5">{{ day.time }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- MODAL: AJUKAN IZIN / SAKIT -->
    <div
      v-if="isIzinModalOpen"
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm"
    >
      <div class="bg-surface-container-lowest rounded-2xl max-w-lg w-full p-6 shadow-xl border border-outline-variant flex flex-col gap-4">
        <div class="flex items-center justify-between pb-3 border-b border-outline-variant/60">
          <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[22px] text-secondary">medical_services</span>
            <h3 class="font-headline-sm text-headline-sm text-primary font-bold">Form Pengajuan Izin / Sakit</h3>
          </div>
          <button @click="isIzinModalOpen = false" class="text-on-surface-variant hover:text-on-surface p-1">
            <span class="material-symbols-outlined text-[20px]">close</span>
          </button>
        </div>

        <form @submit.prevent="submitIzin" class="flex flex-col gap-4">
          <div class="flex flex-col gap-1.5">
            <label class="font-label-md text-label-md text-primary font-semibold">Jenis Pengajuan</label>
            <select v-model="izinForm.type" class="w-full px-3.5 py-2.5 bg-surface-container-low text-on-surface text-body-sm font-body-sm rounded-lg border border-outline-variant/60 outline-none">
              <option value="sakit">Sakit (Dengan Surat Keterangan Dokter)</option>
              <option value="izin">Izin Kepentingan Akademik / Khusus</option>
            </select>
          </div>

          <div class="grid grid-cols-2 gap-3">
            <div class="flex flex-col gap-1.5">
              <label class="font-label-md text-label-md text-primary font-semibold">Tanggal Mulai</label>
              <input v-model="izinForm.startDate" type="date" class="w-full px-3.5 py-2.5 bg-surface-container-low text-on-surface text-body-sm font-body-sm rounded-lg border border-outline-variant/60 outline-none" required />
            </div>
            <div class="flex flex-col gap-1.5">
              <label class="font-label-md text-label-md text-primary font-semibold">Tanggal Selesai</label>
              <input v-model="izinForm.endDate" type="date" class="w-full px-3.5 py-2.5 bg-surface-container-low text-on-surface text-body-sm font-body-sm rounded-lg border border-outline-variant/60 outline-none" required />
            </div>
          </div>

          <div class="flex flex-col gap-1.5">
            <label class="font-label-md text-label-md text-primary font-semibold">Keterangan / Alasan Lengkap</label>
            <textarea v-model="izinForm.reason" rows="3" class="w-full px-3.5 py-2.5 bg-surface-container-low text-on-surface text-body-sm font-body-sm rounded-lg border border-outline-variant/60 outline-none" placeholder="Uraikan kondisi sakit atau alasan perizinan..." required></textarea>
          </div>

          <div class="flex flex-col gap-1.5">
            <label class="font-label-md text-label-md text-primary font-semibold">Upload Berkas Pendukung (Surat Dokter / Dokumen)</label>
            <input type="file" class="w-full text-xs text-on-surface-variant file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border file:border-outline-variant file:text-xs file:font-semibold file:bg-surface-container-lowest file:text-primary hover:file:bg-surface-container" />
          </div>

          <div class="flex items-center justify-end gap-2 pt-3 border-t border-outline-variant/60">
            <button @click="isIzinModalOpen = false" type="button" class="px-4 py-2 rounded-lg bg-surface-container-low text-on-surface-variant text-body-sm font-body-sm font-semibold hover:bg-surface-container">
              Batal
            </button>
            <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-on-primary text-body-sm font-body-sm font-semibold hover:bg-primary-container shadow-sm">
              Kirim Pengajuan
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- MODAL: RADIUS GEOFENCE -->
    <div
      v-if="isGeofenceModalOpen"
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm"
    >
      <div class="bg-surface-container-lowest rounded-2xl max-w-md w-full p-6 shadow-xl border border-outline-variant flex flex-col gap-4">
        <div class="flex items-center justify-between pb-3 border-b border-outline-variant/60">
          <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[22px] text-secondary">pin_drop</span>
            <h3 class="font-headline-sm text-headline-sm text-primary font-bold">Radius Geofence Kantor</h3>
          </div>
          <button @click="isGeofenceModalOpen = false" class="text-on-surface-variant hover:text-on-surface p-1">
            <span class="material-symbols-outlined text-[20px]">close</span>
          </button>
        </div>

        <div class="flex flex-col gap-3">
          <div class="h-40 bg-surface-container-low rounded-xl border border-outline-variant flex items-center justify-center relative overflow-hidden">
            <div class="w-24 h-24 rounded-full border-2 border-secondary bg-secondary/10 flex items-center justify-center animate-pulse">
              <span class="material-symbols-outlined text-[28px] text-primary">domain</span>
            </div>
            <div class="absolute bottom-2 right-2 px-2 py-0.5 rounded bg-surface-container-lowest text-[10px] font-mono text-on-surface-variant border border-outline-variant">
              Radius: 50 Meter
            </div>
          </div>

          <div class="p-3 rounded-lg bg-surface-container-low border border-outline-variant/60 flex flex-col gap-1 text-xs">
            <div class="flex justify-between">
              <span class="text-on-surface-variant">Lokasi Kantor:</span>
              <span class="font-semibold text-primary">PT Solusi Digital Pratama</span>
            </div>
            <div class="flex justify-between">
              <span class="text-on-surface-variant">Koordinat Titik:</span>
              <span class="font-mono text-on-surface">-6.2088° S, 106.8456° E</span>
            </div>
            <div class="flex justify-between">
              <span class="text-on-surface-variant">Jarak Posisi Anda:</span>
              <span class="font-semibold text-emerald-700">12 meter (Di dalam radius)</span>
            </div>
          </div>
        </div>

        <div class="flex justify-end pt-2">
          <button @click="isGeofenceModalOpen = false" class="px-4 py-2 rounded-lg bg-primary text-on-primary text-body-sm font-semibold">
            Tutup
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useAppStore } from '~/composables/useAppStore'

const { showToast } = useAppStore()

const currentTime = ref('09:14:02')
const hasCheckedOut = ref(false)
const modeFilter = ref('all')
const viewType = ref<'table' | 'calendar'>('table')

const isIzinModalOpen = ref(false)
const isGeofenceModalOpen = ref(false)

const izinForm = ref({
  type: 'sakit',
  startDate: '',
  endDate: '',
  reason: ''
})

let timer: any = null

onMounted(() => {
  const updateClock = () => {
    const now = new Date()
    currentTime.value = now.toTimeString().split(' ')[0]
  }
  updateClock()
  timer = setInterval(updateClock, 1000)
})

onUnmounted(() => {
  if (timer) clearInterval(timer)
})

const records = ref([
  {
    id: 1,
    date: '23 Okt 2024',
    day: 'Rabu',
    checkIn: '08:24',
    checkOut: '',
    duration: '5.5 Jam',
    location: 'Tech Hub Lt. 4',
    mode: 'WFO Kantor Pusat',
    status: 'ontime',
    statusLabel: 'Hadir Tepat Waktu',
    validation: 'Menunggu Checkout'
  },
  {
    id: 2,
    date: '22 Okt 2024',
    day: 'Selasa',
    checkIn: '08:28',
    checkOut: '17:32',
    duration: '8 Jam',
    location: 'Tech Hub Lt. 4',
    mode: 'WFO Kantor Pusat',
    status: 'ontime',
    statusLabel: 'Hadir Tepat Waktu',
    validation: 'Disetujui Mentor'
  },
  {
    id: 3,
    date: '21 Okt 2024',
    day: 'Senin',
    checkIn: '08:35',
    checkOut: '17:40',
    duration: '8 Jam',
    location: 'Tech Hub Lt. 4',
    mode: 'WFO Kantor Pusat',
    status: 'ontime',
    statusLabel: 'Hadir Tepat Waktu',
    validation: 'Disetujui Mentor'
  },
  {
    id: 4,
    date: '18 Okt 2024',
    day: 'Jumat',
    checkIn: '',
    checkOut: '',
    duration: '-',
    location: 'Klinik Pratama',
    mode: 'Surat Keterangan Dokter',
    status: 'sick',
    statusLabel: 'Izin Sakit',
    validation: 'Disetujui Mentor'
  },
  {
    id: 5,
    date: '17 Okt 2024',
    day: 'Kamis',
    checkIn: '08:40',
    checkOut: '17:35',
    duration: '8 Jam',
    location: 'Rumah (Remote)',
    mode: 'WFH Mandiri',
    status: 'ontime',
    statusLabel: 'Hadir Tepat Waktu',
    validation: 'Disetujui Mentor'
  }
])

const filteredRecords = computed(() => {
  if (modeFilter.value === 'wfo') {
    return records.value.filter(r => r.mode.includes('WFO'))
  }
  if (modeFilter.value === 'wfh') {
    return records.value.filter(r => r.mode.includes('WFH'))
  }
  return records.value
})

const calendarDays = [
  { dayNumber: 14, status: 'Hadir', time: '08:25 - 17:30' },
  { dayNumber: 15, status: 'Hadir', time: '08:20 - 17:30' },
  { dayNumber: 16, status: 'Hadir', time: '08:30 - 17:30' },
  { dayNumber: 17, status: 'Hadir', time: '08:40 - 17:35' },
  { dayNumber: 18, status: 'Sakit', time: 'Surat Dokter' },
  { dayNumber: 19, status: '', time: '' },
  { dayNumber: 20, status: '', time: '' },
  { dayNumber: 21, status: 'Hadir', time: '08:35 - 17:40' },
  { dayNumber: 22, status: 'Hadir', time: '08:28 - 17:32' },
  { dayNumber: 23, status: 'Hadir', time: '08:24 - Aktif', isToday: true }
]

const handleCheckOut = () => {
  hasCheckedOut.value = true
  const first = records.value[0]
  if (first) {
    first.checkOut = currentTime.value.substring(0, 5)
    first.validation = 'Disetujui Mentor'
  }
  showToast('Presensi Check-out Sore berhasil dicatat! Terima kasih atas dedikasi hari ini.', 'success')
}

const submitIzin = () => {
  isIzinModalOpen.value = false
  showToast('Pengajuan izin/sakit berhasil dikirim ke Pembimbing & Guru!', 'success')
}

const downloadRekapPdf = () => {
  showToast('Mengunduh Lembar Rekapitulasi Presensi Kehadiran SMKN 71...', 'success')
}

const viewDetail = (rec: typeof records.value[0]) => {
  showToast(`Detail presensi ${rec.date}: ${rec.statusLabel} (${rec.mode})`, 'info')
}
</script>
