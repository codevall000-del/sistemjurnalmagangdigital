<template>
  <div class="flex flex-col w-full max-w-[1440px] mx-auto gap-space-xl">
    <!-- Top Context & Header Action -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-lg">
      <div class="flex flex-col gap-space-xs max-w-2xl">
        <div class="flex items-center gap-space-xs">
          <span class="inline-flex items-center justify-center px-2 py-0.5 rounded-full bg-secondary-container text-on-secondary-container font-label-sm text-label-sm uppercase tracking-wider font-semibold border border-secondary/30">
            Modul Pembimbingan
          </span>
          <span class="text-outline">•</span>
          <span class="font-label-sm text-label-sm text-on-surface-variant flex items-center gap-1">
            <span class="material-symbols-outlined text-[14px] text-secondary">verified_user</span>
            Akreditasi Vokasi SMKN 71 Jakarta
          </span>
        </div>
        <h1 class="font-headline-xl text-headline-xl text-primary font-bold tracking-tight">
          Bimbingan &amp; Catatan Mentor
        </h1>
        <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
          Ruang diskusi terarah, umpan balik performa berkala, dan rekap bimbingan akademik magang.
        </p>
      </div>

      <div class="flex items-center flex-wrap gap-space-sm">
        <button
          @click="downloadVerificationSheet"
          class="inline-flex items-center gap-space-xs bg-surface-container hover:bg-surface-container-high text-primary px-space-md py-2.5 rounded-lg font-label-md text-label-md transition-all shadow-sm border border-outline-variant"
          type="button"
        >
          <span class="material-symbols-outlined text-[18px]">cloud_download</span>
          <span>Unduh Lembar Verifikasi Bimbingan</span>
        </button>
        <button
          @click="isRequestModalOpen = true"
          class="inline-flex items-center gap-space-xs bg-primary hover:bg-primary-container text-on-primary px-space-md py-2.5 rounded-lg font-headline-sm text-headline-sm transition-all shadow-sm active:scale-95"
          type="button"
        >
          <span class="material-symbols-outlined text-[18px]">add</span>
          <span>Ajukan Sesi Bimbingan 1-on-1</span>
        </button>
      </div>
    </div>

    <!-- Dual Supervisor Overview Strip (Stitch Design) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-md">
      <!-- Industry Mentor Card -->
      <div class="lg:col-span-5 bg-surface-container-lowest rounded-xl p-space-lg shadow-sm border border-outline-variant flex flex-col justify-between relative overflow-hidden group">
        <div class="flex items-start justify-between gap-space-md">
          <div class="flex gap-space-md">
            <div class="relative">
              <div class="w-14 h-14 rounded-xl bg-surface-container flex items-center justify-center text-primary font-bold text-lg shadow-sm border border-outline-variant">
                DA
              </div>
              <span class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 rounded-full border-2 border-surface-container-lowest ring-1 ring-emerald-300"></span>
            </div>
            <div class="flex flex-col min-w-0">
              <div class="inline-flex items-center gap-1.5 self-start px-2 py-0.5 rounded-full bg-surface-container-low text-secondary font-label-sm text-label-sm mb-1 border border-outline-variant/60 font-semibold">
                <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                Mentor Perusahaan
              </div>
              <h2 class="font-headline-sm text-headline-sm text-on-surface truncate font-bold">Dimas Ardiansyah, S.T.</h2>
              <p class="font-body-sm text-body-sm text-on-surface-variant truncate">Tech Lead • PT Solusi Digital Pratama</p>
            </div>
          </div>
          <button
            @click="chatWithMentor('Dimas Ardiansyah')"
            class="text-outline-variant hover:text-primary transition-colors cursor-pointer p-1"
            title="Kirim Pesan Chat"
            type="button"
          >
            <span class="material-symbols-outlined text-[20px]">chat_bubble_outline</span>
          </button>
        </div>
        <div class="mt-space-md pt-space-sm flex items-center justify-between font-label-sm text-label-sm text-on-surface-variant border-t border-outline-variant/60">
          <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px] text-secondary">domain</span> Divisi Frontend Architecture</span>
          <span class="text-primary font-semibold">3 Sesi Selesai</span>
        </div>
      </div>

      <!-- Academic Advisor Card -->
      <div class="lg:col-span-5 bg-surface-container-lowest rounded-xl p-space-lg shadow-sm border border-outline-variant flex flex-col justify-between relative overflow-hidden group">
        <div class="flex items-start justify-between gap-space-md">
          <div class="flex gap-space-md">
            <div class="relative">
              <div class="w-14 h-14 rounded-xl bg-surface-container flex items-center justify-center text-primary font-bold text-lg shadow-sm border border-outline-variant">
                NH
              </div>
              <span class="absolute -bottom-1 -right-1 w-4 h-4 bg-primary rounded-full border-2 border-surface-container-lowest ring-1 ring-primary-fixed"></span>
            </div>
            <div class="flex flex-col min-w-0">
              <div class="inline-flex items-center gap-1.5 self-start px-2 py-0.5 rounded-full bg-surface-container-high text-primary font-label-sm text-label-sm mb-1 border border-outline-variant/60 font-semibold">
                <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                Guru Pembimbing Sekolah
              </div>
              <h2 class="font-headline-sm text-headline-sm text-on-surface truncate font-bold">Dra. Nurul Hidayah, M.Pd.</h2>
              <p class="font-body-sm text-body-sm text-on-surface-variant truncate">Guru Pamong PKL • SMKN 71 Jakarta</p>
            </div>
          </div>
          <button
            @click="chatWithMentor('Dra. Nurul Hidayah')"
            class="text-outline-variant hover:text-primary transition-colors cursor-pointer p-1"
            title="Kirim Surel / Pesan"
            type="button"
          >
            <span class="material-symbols-outlined text-[20px]">alternate_email</span>
          </button>
        </div>
        <div class="mt-space-md pt-space-sm flex items-center justify-between font-label-sm text-label-sm text-on-surface-variant border-t border-outline-variant/60">
          <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px] text-primary">school</span> NIP: 198005122005012003</span>
          <span class="text-primary font-semibold">2 Sesi Evaluasi</span>
        </div>
      </div>

      <!-- Alignment / Status Widget -->
      <div class="lg:col-span-2 bg-gradient-to-br from-primary to-primary-container text-on-primary rounded-xl p-space-md flex flex-col justify-between shadow-sm">
        <div class="flex items-center justify-between">
          <span class="material-symbols-outlined text-[24px] text-secondary-fixed">sync_saved_locally</span>
          <span class="px-2 py-0.5 rounded-full bg-white/10 text-on-primary font-label-sm text-label-sm font-semibold">100% Valid</span>
        </div>
        <div class="my-space-xs">
          <span class="font-label-sm text-label-sm text-on-primary-container uppercase tracking-wider block">Status Sinkronisasi</span>
          <h3 class="font-headline-sm text-headline-sm text-white font-semibold">Selaras Sempurna</h3>
          <p class="font-label-sm text-label-sm text-surface-container-highest/80 mt-0.5">Sinkron terakhir 2 hari lalu</p>
        </div>
        <div class="w-full bg-white/20 h-1.5 rounded-full overflow-hidden">
          <div class="bg-secondary-fixed h-full rounded-full w-full"></div>
        </div>
      </div>
    </div>

    <!-- Main Two-Column Layout (7:5 Desktop Grid) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-xl items-start">
      <!-- Left Column: Umpan Balik & Evaluasi Kinerja (7 cols) -->
      <div class="lg:col-span-7 flex flex-col gap-space-lg">
        <!-- Section Title -->
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-space-sm">
            <span class="w-2.5 h-6 bg-secondary rounded-full"></span>
            <h2 class="font-headline-md text-headline-md text-primary font-bold">Umpan Balik &amp; Evaluasi Kinerja</h2>
          </div>
          <span class="font-label-sm text-label-sm text-on-surface-variant bg-surface-container-low px-space-sm py-1 rounded-md border border-outline-variant/60">
            Periode: Bulan ke-2 (Mid-Internship)
          </span>
        </div>

        <!-- Competency Matrix Card -->
        <div class="bg-surface-container-lowest rounded-xl p-space-lg shadow-sm border border-outline-variant flex flex-col gap-space-lg">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-space-md">
            <div>
              <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">Skor Aspek Kompetensi Magang</h3>
              <p class="font-body-sm text-body-sm text-on-surface-variant">Penilaian gabungan oleh mentor industri dan rubrik akademik SMKN 71</p>
            </div>
            <div class="flex items-baseline gap-1 bg-surface-container-low px-space-md py-space-xs rounded-lg self-start border border-outline-variant/60">
              <span class="font-headline-xl text-headline-xl text-primary font-bold leading-none">4.75</span>
              <span class="font-label-md text-label-md text-on-surface-variant">/ 5.0</span>
            </div>
          </div>

          <!-- Rating Bars -->
          <div class="grid grid-cols-1 gap-space-md">
            <!-- Metric 1 -->
            <div class="flex flex-col gap-1.5">
              <div class="flex justify-between items-center font-label-md text-label-md">
                <span class="text-on-surface flex items-center gap-1.5 font-medium">
                  <span class="material-symbols-outlined text-[16px] text-secondary">code_blocks</span>
                  Kualitas Teknis &amp; Problem Solving
                </span>
                <span class="font-bold text-primary">4.8 <span class="text-outline font-normal">/ 5.0</span></span>
              </div>
              <div class="w-full bg-surface-container-low h-2.5 rounded-full overflow-hidden p-0.5 border border-outline-variant/60">
                <div class="bg-primary h-full rounded-full transition-all duration-1000 ease-out" style="width: 96%"></div>
              </div>
              <span class="font-label-sm text-label-sm text-on-surface-variant">Keahlian slicing UI, clean code, serta integrasi REST API sangat konsisten.</span>
            </div>

            <!-- Metric 2 -->
            <div class="flex flex-col gap-1.5">
              <div class="flex justify-between items-center font-label-md text-label-md">
                <span class="text-on-surface flex items-center gap-1.5 font-medium">
                  <span class="material-symbols-outlined text-[16px] text-secondary">forum</span>
                  Komunikasi &amp; Kerjasama Tim
                </span>
                <span class="font-bold text-primary">4.7 <span class="text-outline font-normal">/ 5.0</span></span>
              </div>
              <div class="w-full bg-surface-container-low h-2.5 rounded-full overflow-hidden p-0.5 border border-outline-variant/60">
                <div class="bg-secondary h-full rounded-full transition-all duration-1000 ease-out" style="width: 94%"></div>
              </div>
              <span class="font-label-sm text-label-sm text-on-surface-variant">Aktif berdiskusi saat daily standup dan selalu proaktif mengabarkan blocker.</span>
            </div>

            <!-- Metric 3 -->
            <div class="flex flex-col gap-1.5">
              <div class="flex justify-between items-center font-label-md text-label-md">
                <span class="text-on-surface flex items-center gap-1.5 font-medium">
                  <span class="material-symbols-outlined text-[16px] text-secondary">timer</span>
                  Disiplin &amp; Manajemen Waktu
                </span>
                <span class="font-bold text-primary">4.9 <span class="text-outline font-normal">/ 5.0</span></span>
              </div>
              <div class="w-full bg-surface-container-low h-2.5 rounded-full overflow-hidden p-0.5 border border-outline-variant/60">
                <div class="bg-primary h-full rounded-full transition-all duration-1000 ease-out" style="width: 98%"></div>
              </div>
              <span class="font-label-sm text-label-sm text-on-surface-variant">Semua deliverable sprint dikirim tepat waktu tanpa penundaan.</span>
            </div>

            <!-- Metric 4 -->
            <div class="flex flex-col gap-1.5">
              <div class="flex justify-between items-center font-label-md text-label-md">
                <span class="text-on-surface flex items-center gap-1.5 font-medium">
                  <span class="material-symbols-outlined text-[16px] text-secondary">psychology</span>
                  Inisiatif &amp; Kemandirian
                </span>
                <span class="font-bold text-primary">4.6 <span class="text-outline font-normal">/ 5.0</span></span>
              </div>
              <div class="w-full bg-surface-container-low h-2.5 rounded-full overflow-hidden p-0.5 border border-outline-variant/60">
                <div class="bg-secondary h-full rounded-full transition-all duration-1000 ease-out" style="width: 92%"></div>
              </div>
              <span class="font-label-sm text-label-sm text-on-surface-variant">Dapat mencari solusi dokumentasi teknis secara mandiri sebelum eskalasi.</span>
            </div>
          </div>
        </div>

        <!-- Latest Official Mentor Recommendation & Quote -->
        <div class="bg-surface-container-lowest rounded-xl p-space-lg shadow-sm border border-outline-variant flex flex-col gap-space-md relative overflow-hidden">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-space-xs text-primary font-headline-sm text-headline-sm font-bold">
              <span class="material-symbols-outlined text-[20px] text-secondary">rate_review</span>
              <h3>Catatan Evaluasi Resmi Terakhir</h3>
            </div>
            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 font-label-sm text-label-sm font-semibold border border-emerald-200">
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
              Tervalidasi Digital
            </span>
          </div>

          <blockquote class="font-body-md text-body-md text-on-surface italic relative z-10 leading-relaxed bg-surface-container-low/60 p-space-md rounded-lg border border-outline-variant/60">
            “Reza menunjukkan adaptasi luar biasa dalam menangani modul rekayasa antarmuka internal kami. Arsitektur state management yang disusun menggunakan Tailwind dan modular pattern sangat rapi. Untuk sprint berikutnya, kami mendorong Reza untuk lebih mendalami automated integration test (Vitest/Playwright) agar stabilitas rilis semakin terjamin.”
          </blockquote>

          <div class="flex flex-col sm:flex-row sm:items-center justify-between pt-space-xs gap-space-sm z-10 border-t border-outline-variant/60">
            <div class="flex items-center gap-space-sm">
              <div class="w-9 h-9 rounded-full bg-surface-container-high flex items-center justify-center text-primary font-semibold font-headline-sm text-body-sm border border-outline-variant">
                DA
              </div>
              <div class="flex flex-col">
                <span class="font-label-md text-label-md text-on-surface font-semibold">Dimas Ardiansyah, S.T.</span>
                <span class="font-label-sm text-label-sm text-on-surface-variant">Direview pada 18 Oktober 2024 • 17:35 WIB</span>
              </div>
            </div>

            <!-- Digital Stamp Verification -->
            <div class="flex items-center gap-2 bg-surface-container-low px-space-sm py-1.5 rounded-md border border-outline-variant/60">
              <span class="material-symbols-outlined text-secondary text-[22px]">verified</span>
              <div class="flex flex-col">
                <span class="font-label-sm text-label-sm font-semibold text-primary">SHA-256 DIGITAL SIG</span>
                <span class="font-label-sm text-[10px] text-on-surface-variant uppercase tracking-widest font-mono">0x8F3A...419C</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Action Items (Rencana Pengembangan) -->
        <div class="bg-surface-container-lowest rounded-xl p-space-lg shadow-sm border border-outline-variant flex flex-col gap-space-md">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-space-xs">
              <span class="material-symbols-outlined text-primary text-[20px]">checklist</span>
              <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">Rencana Pengembangan (Next 2 Weeks)</h3>
            </div>
            <span class="font-label-sm text-label-sm text-on-surface-variant">
              {{ developmentItems.filter(i => i.done).length }} dari {{ developmentItems.length }} Terselesaikan
            </span>
          </div>

          <div class="flex flex-col gap-space-xs">
            <label
              v-for="item in developmentItems"
              :key="item.id"
              class="flex items-start gap-space-sm p-space-sm rounded-lg hover:bg-surface-container-low transition-colors cursor-pointer group"
              :class="!item.done ? 'bg-surface-container-low/70' : ''"
            >
              <input
                v-model="item.done"
                type="checkbox"
                class="mt-1 w-4 h-4 rounded text-primary focus:ring-secondary accent-primary cursor-pointer"
              />
              <div class="flex flex-col flex-1">
                <span
                  class="font-body-md text-body-md transition-colors"
                  :class="item.done ? 'line-through text-on-surface-variant opacity-70 font-medium' : 'text-on-surface font-semibold'"
                >
                  {{ item.title }}
                </span>
                <span
                  class="font-label-sm text-label-sm"
                  :class="item.done ? 'text-on-surface-variant' : 'text-secondary font-medium'"
                >
                  {{ item.subtitle }}
                </span>
              </div>
              <span
                class="material-symbols-outlined text-[18px]"
                :class="item.done ? 'text-emerald-600' : 'text-outline'"
              >
                {{ item.done ? 'check_circle' : 'pending' }}
              </span>
            </label>
          </div>
        </div>
      </div>

      <!-- Right Column: Log Pertemuan & Agenda Konsultasi (5 cols) -->
      <div class="lg:col-span-5 flex flex-col gap-space-lg">
        <!-- Section Title -->
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-space-sm">
            <span class="w-2.5 h-6 bg-primary rounded-full"></span>
            <h2 class="font-headline-md text-headline-md text-primary font-bold">Log &amp; Riwayat Bimbingan</h2>
          </div>
          <span class="font-label-md text-label-md text-secondary font-semibold cursor-pointer hover:underline">
            Semua (3 Sesi Selesai)
          </span>
        </div>

        <!-- Upcoming Featured Agenda Card -->
        <div class="bg-surface-container-lowest rounded-xl p-space-lg shadow-sm border border-outline-variant relative overflow-hidden">
          <div class="flex items-center justify-between mb-space-sm">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-secondary text-on-secondary font-label-sm text-label-sm font-semibold">
              <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
              Agenda Terdekat
            </span>
            <span class="font-label-sm text-label-sm text-on-surface-variant flex items-center gap-1">
              <span class="material-symbols-outlined text-[16px]">videocam</span> Google Meet
            </span>
          </div>

          <h3 class="font-headline-md text-headline-md text-primary font-bold leading-tight">
            Sesi Review Tengah Periode (Mid-term Evaluation)
          </h3>
          <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 leading-relaxed">
            Evaluasi menyeluruh 8 minggu pertama bersama kedua pihak pembimbing untuk penyelarasan nilai konversi PKL SMKN 71.
          </p>

          <!-- Schedule Meta Box -->
          <div class="mt-space-md p-space-md rounded-lg bg-surface-container border border-outline-variant/60 flex flex-col gap-space-xs">
            <div class="flex items-center justify-between font-label-md text-label-md text-primary">
              <span class="flex items-center gap-1.5 font-semibold">
                <span class="material-symbols-outlined text-[18px]">calendar_month</span>
                Jumat, 25 Okt 2024
              </span>
              <span class="flex items-center gap-1 text-on-surface">
                <span class="material-symbols-outlined text-[18px] text-secondary">schedule</span>
                14:00 - 15:00 WIB
              </span>
            </div>
            <div class="pt-space-xs flex items-center justify-between font-label-sm text-label-sm text-on-surface-variant border-t border-outline-variant/60">
              <span>Peserta: Guru, Mentor &amp; Siswa</span>
              <span class="text-emerald-700 font-semibold flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Disetujui Bersama
              </span>
            </div>
          </div>

          <!-- Agenda points -->
          <div class="mt-space-md flex flex-col gap-1.5">
            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-semibold">
              Poin Pokok Agenda:
            </span>
            <ul class="font-body-sm text-body-sm text-on-surface space-y-1 list-disc list-inside">
              <li>Pemaparan capaian progress modul frontend (demo interaktif)</li>
              <li>Validasi logbook kehadiran dan pengisian catatan mingguan</li>
              <li>Penilaian kualitatif dan feedback dari Tech Lead</li>
            </ul>
          </div>

          <!-- Action Link -->
          <div class="mt-space-md pt-space-xs flex items-center justify-between gap-space-sm border-t border-outline-variant/60">
            <button
              @click="joinGoogleMeet"
              class="flex-1 inline-flex items-center justify-center gap-space-xs bg-primary text-on-primary hover:bg-primary-container px-space-md py-2.5 rounded-lg font-headline-sm text-headline-sm transition-all shadow-sm active:scale-95"
              type="button"
            >
              <span class="material-symbols-outlined text-[18px]">video_call</span>
              <span>Buka Google Meet Room</span>
            </button>
            <button
              @click="copyCalendar"
              class="p-2.5 bg-surface-container hover:bg-surface-container-high rounded-lg text-primary transition-colors border border-outline-variant"
              title="Salin Jadwal ke Kalender"
              type="button"
            >
              <span class="material-symbols-outlined text-[20px]">event_repeat</span>
            </button>
          </div>
        </div>

        <!-- Consultation History Timeline -->
        <div class="bg-surface-container-lowest rounded-xl p-space-lg shadow-sm border border-outline-variant flex flex-col gap-space-md">
          <div class="flex items-center justify-between">
            <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">Riwayat Sesi Selesai</h3>
            <span class="font-label-sm text-label-sm text-on-surface-variant">Diurutkan terbaru</span>
          </div>

          <div class="relative pl-6 space-y-space-lg before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-surface-container">
            <!-- Session 3 -->
            <div class="relative group">
              <div class="absolute -left-[27px] top-1 w-3.5 h-3.5 rounded-full bg-secondary ring-4 ring-surface-container-lowest"></div>
              <div class="flex flex-col gap-1">
                <div class="flex items-center justify-between gap-space-xs">
                  <span class="font-label-sm text-label-sm text-secondary font-semibold uppercase tracking-wider">
                    Pertemuan ke-3 • 11 Okt 2024
                  </span>
                  <span class="px-2 py-0.5 rounded-full bg-surface-container-low text-on-surface font-label-sm text-label-sm font-medium border border-outline-variant/60">
                    Catatan Diterbitkan
                  </span>
                </div>
                <h4 class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors font-bold">
                  Evaluasi Arsitektur Database &amp; Relasi Model
                </h4>
                <p class="font-body-sm text-body-sm text-on-surface-variant">
                  Pembimbing: <span class="font-medium text-on-surface">Dimas Ardiansyah (Mentor Industri)</span>
                </p>
                <div class="mt-1 text-on-surface-variant font-body-sm text-body-sm bg-surface-container-low p-space-sm rounded-md border border-outline-variant/60">
                  “Refactor foreign key indexes dan optimasi query paginasi pada log aktivitas telah divalidasi.”
                </div>
                <div class="flex items-center gap-space-sm pt-1 font-label-sm text-label-sm text-secondary font-semibold">
                  <button @click="showBeritaAcara(3)" class="hover:underline flex items-center gap-0.5" type="button">
                    <span class="material-symbols-outlined text-[14px]">description</span> Lihat Berita Acara
                  </button>
                </div>
              </div>
            </div>

            <!-- Session 2 -->
            <div class="relative group">
              <div class="absolute -left-[27px] top-1 w-3.5 h-3.5 rounded-full bg-primary ring-4 ring-surface-container-lowest"></div>
              <div class="flex flex-col gap-1">
                <div class="flex items-center justify-between gap-space-xs">
                  <span class="font-label-sm text-label-sm text-primary font-semibold uppercase tracking-wider">
                    Pertemuan ke-2 • 27 Sep 2024
                  </span>
                  <span class="px-2 py-0.5 rounded-full bg-surface-container-low text-on-surface font-label-sm text-label-sm font-medium border border-outline-variant/60">
                    Selesai
                  </span>
                </div>
                <h4 class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors font-bold">
                  Sinkronisasi Silabus PKL &amp; Project Scope
                </h4>
                <p class="font-body-sm text-body-sm text-on-surface-variant">
                  Pembimbing: <span class="font-medium text-on-surface">Dra. Nurul Hidayah &amp; Dimas Ardiansyah</span>
                </p>
                <div class="mt-1 text-on-surface-variant font-body-sm text-body-sm bg-surface-container-low p-space-sm rounded-md border border-outline-variant/60">
                  “Penetapan 4 pilar kompetensi akademik yang dikonversikan ke dalam tugas harian industri.”
                </div>
                <div class="flex items-center gap-space-sm pt-1 font-label-sm text-label-sm text-secondary font-semibold">
                  <button @click="showBeritaAcara(2)" class="hover:underline flex items-center gap-0.5" type="button">
                    <span class="material-symbols-outlined text-[14px]">description</span> Lihat Berita Acara
                  </button>
                </div>
              </div>
            </div>

            <!-- Session 1 -->
            <div class="relative group">
              <div class="absolute -left-[27px] top-1 w-3.5 h-3.5 rounded-full bg-outline ring-4 ring-surface-container-lowest"></div>
              <div class="flex flex-col gap-1">
                <div class="flex items-center justify-between gap-space-xs">
                  <span class="font-label-sm text-label-sm text-on-surface-variant font-semibold uppercase tracking-wider">
                    Pertemuan ke-1 • 13 Sep 2024
                  </span>
                  <span class="px-2 py-0.5 rounded-full bg-surface-container-low text-on-surface font-label-sm text-label-sm font-medium border border-outline-variant/60">
                    Terarsip
                  </span>
                </div>
                <h4 class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors font-bold">
                  Onboarding &amp; Penentuan Target Pembelajaran Magang
                </h4>
                <p class="font-body-sm text-body-sm text-on-surface-variant">
                  Pembimbing: <span class="font-medium text-on-surface">Dimas Ardiansyah (Mentor Industri)</span>
                </p>
                <div class="mt-1 text-on-surface-variant font-body-sm text-body-sm bg-surface-container-low p-space-sm rounded-md border border-outline-variant/60">
                  “Setup lingkungan repositori, standarisasi commit convention Git, dan pengenalan tim dev.”
                </div>
                <div class="flex items-center gap-space-sm pt-1 font-label-sm text-label-sm text-secondary font-semibold">
                  <button @click="showBeritaAcara(1)" class="hover:underline flex items-center gap-0.5" type="button">
                    <span class="material-symbols-outlined text-[14px]">description</span> Lihat Berita Acara
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Academic Guidelines & Verification Helper Notice -->
        <div class="bg-surface-container-low p-space-md rounded-xl flex items-start gap-space-sm border border-outline-variant">
          <span class="material-symbols-outlined text-secondary text-[22px] mt-0.5">info</span>
          <div class="flex flex-col">
            <span class="font-headline-sm text-body-sm font-semibold text-primary">Ketentuan Bimbingan SMKN 71</span>
            <p class="font-label-sm text-label-sm text-on-surface-variant mt-0.5 leading-relaxed">
              Minimal 4 sesi bimbingan industri dan 2 sesi bimbingan sekolah wajib diselesaikan sebelum pengajuan sidang laporan PKL.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- MODAL: AJUKAN SESI BIMBINGAN 1-ON-1 -->
    <div
      v-if="isRequestModalOpen"
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm"
    >
      <div class="bg-surface-container-lowest rounded-2xl max-w-lg w-full p-6 shadow-xl border border-outline-variant flex flex-col gap-4">
        <div class="flex items-center justify-between pb-3 border-b border-outline-variant/60">
          <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[22px] text-secondary">calendar_add_on</span>
            <h3 class="font-headline-sm text-headline-sm text-primary font-bold">Ajukan Sesi Bimbingan 1-on-1</h3>
          </div>
          <button @click="isRequestModalOpen = false" class="text-on-surface-variant hover:text-on-surface p-1">
            <span class="material-symbols-outlined text-[20px]">close</span>
          </button>
        </div>

        <form @submit.prevent="submitBimbinganRequest" class="flex flex-col gap-4">
          <div class="flex flex-col gap-1.5">
            <label class="font-label-md text-label-md text-primary font-semibold">Tujuan Pembimbing</label>
            <select v-model="requestForm.mentor" class="w-full px-3.5 py-2.5 bg-surface-container-low text-on-surface text-body-sm font-body-sm rounded-lg border border-outline-variant/60 outline-none">
              <option value="dudi">Dimas Ardiansyah, S.T. (Mentor Industri)</option>
              <option value="guru">Dra. Nurul Hidayah, M.Pd. (Guru Pembimbing Sekolah)</option>
              <option value="both">Keduanya (Review Bersama)</option>
            </select>
          </div>

          <div class="grid grid-cols-2 gap-3">
            <div class="flex flex-col gap-1.5">
              <label class="font-label-md text-label-md text-primary font-semibold">Usulan Tanggal</label>
              <input v-model="requestForm.date" type="date" class="w-full px-3.5 py-2.5 bg-surface-container-low text-on-surface text-body-sm font-body-sm rounded-lg border border-outline-variant/60 outline-none" required />
            </div>
            <div class="flex flex-col gap-1.5">
              <label class="font-label-md text-label-md text-primary font-semibold">Usulan Waktu</label>
              <input v-model="requestForm.time" type="time" class="w-full px-3.5 py-2.5 bg-surface-container-low text-on-surface text-body-sm font-body-sm rounded-lg border border-outline-variant/60 outline-none" required />
            </div>
          </div>

          <div class="flex flex-col gap-1.5">
            <label class="font-label-md text-label-md text-primary font-semibold">Topik Bahasan / Masalah Teknis</label>
            <textarea v-model="requestForm.topic" rows="3" class="w-full px-3.5 py-2.5 bg-surface-container-low text-on-surface text-body-sm font-body-sm rounded-lg border border-outline-variant/60 outline-none" placeholder="Tuliskan poin bahasan atau kendala arsitektur yang ingin dikonsultasikan..." required></textarea>
          </div>

          <div class="flex items-center justify-end gap-2 pt-3 border-t border-outline-variant/60">
            <button @click="isRequestModalOpen = false" type="button" class="px-4 py-2 rounded-lg bg-surface-container-low text-on-surface-variant text-body-sm font-body-sm font-semibold hover:bg-surface-container">
              Batal
            </button>
            <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-on-primary text-body-sm font-body-sm font-semibold hover:bg-primary-container shadow-sm">
              Kirim Undangan Bimbingan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useAppStore } from '~/composables/useAppStore'

const { showToast } = useAppStore()

const isRequestModalOpen = ref(false)

const requestForm = ref({
  mentor: 'dudi',
  date: '',
  time: '14:00',
  topic: ''
})

const developmentItems = ref([
  {
    id: 1,
    title: 'Implementasi caching token HTTP-Only pada pipeline auth klien',
    subtitle: 'Saran teknis mentor perusahaan • Selesai 14 Okt',
    done: true
  },
  {
    id: 2,
    title: 'Konsultasi draft bab 3 laporan magang ke guru pembimbing',
    subtitle: 'Target akademik SMKN 71 • Selesai 17 Okt',
    done: true
  },
  {
    id: 3,
    title: 'Penyelarasan dokumentasi Swagger API bersama backend team',
    subtitle: 'Deliverable kolaboratif sprint 4 • Selesai 19 Okt',
    done: true
  },
  {
    id: 4,
    title: 'Penyusunan automated end-to-end testing coverage minimal 75%',
    subtitle: 'Batas waktu: 28 Oktober 2024 • Sedang Berjalan',
    done: false
  }
])

const downloadVerificationSheet = () => {
  showToast('Mengunduh Lembar Verifikasi Bimbingan Akademik (PDF resmi SMKN 71)...', 'success')
}

const chatWithMentor = (name: string) => {
  showToast(`Membuka kanal pesan langsung dengan ${name}`, 'info')
}

const joinGoogleMeet = () => {
  window.open('https://meet.google.com/abc-defg-hij', '_blank')
}

const copyCalendar = () => {
  showToast('Tautan sesi bimbingan berhasil disalin ke clipboard!', 'success')
}

const showBeritaAcara = (num: number) => {
  showToast(`Membuka dokumen Berita Acara Pertemuan ke-${num}`, 'info')
}

const submitBimbinganRequest = () => {
  isRequestModalOpen.value = false
  showToast('Pengajuan sesi bimbingan 1-on-1 berhasil dikirim ke pembimbing!', 'success')
}
</script>
