<template>
  <div class="flex flex-col w-full max-w-[1440px] mx-auto gap-space-xl">
    <!-- Top Greeting & Notice Banner (Stitch Serene Academic Desk) -->
    <section class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-space-lg bg-surface-container-lowest p-space-xl rounded-xl shadow-sm border border-outline-variant relative overflow-hidden">
      <div class="flex flex-col gap-space-xs max-w-2xl z-10">
        <div class="inline-flex items-center gap-space-xs text-secondary font-label-md text-label-md uppercase tracking-wider">
          <span class="w-2 h-2 rounded-full bg-secondary"></span>
          Periode Ganjil 2024/2025 • SMKN 71 Jakarta
        </div>
        <h1 class="font-headline-xl text-headline-xl text-primary font-bold tracking-tight">
          Selamat Pagi, {{ currentUser.name }}! 👋
        </h1>
        <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
          Berikut adalah ikhtisar kegiatan magang Anda per <span class="font-semibold text-on-surface">{{ todayFormatted }}</span> di <span class="font-semibold text-primary">PT Solusi Digital Pratama</span>.
        </p>
      </div>

      <!-- Notice Alert Box -->
      <div class="flex flex-col sm:flex-row items-start sm:items-center gap-space-md z-10 bg-surface-container-low/70 p-space-md rounded-lg border border-outline-variant/60">
        <div class="w-10 h-10 rounded-full bg-surface-container-highest flex items-center justify-center text-primary shrink-0">
          <span class="material-symbols-outlined text-[22px]">notification_important</span>
        </div>
        <div class="flex flex-col pr-space-sm">
          <span class="font-headline-sm text-headline-sm text-on-surface font-semibold">
            {{ isTodayLogged ? 'Jurnal Hari Ini Sudah Dikirim' : 'Jurnal Hari Ini Belum Diisi' }}
          </span>
          <span class="font-body-sm text-body-sm text-on-surface-variant">
            {{ isTodayLogged ? 'Tercatat pada 11:20 WIB • Menunggu review' : 'Batas submisi harian pukul 18:00 WIB' }}
          </span>
        </div>
        <div class="flex items-center gap-space-xs w-full sm:w-auto pt-space-xs sm:pt-0">
          <button
            @click="goToLogbook"
            class="flex-1 sm:flex-none inline-flex items-center justify-center gap-space-xs px-space-md py-2 bg-primary text-on-primary rounded-lg font-headline-sm text-headline-sm hover:bg-primary-container transition-colors shadow-sm active:scale-95"
            type="button"
          >
            <span class="material-symbols-outlined text-[18px]">edit_calendar</span>
            <span>{{ isTodayLogged ? 'Buka Logbook' : 'Isi Jurnal Hari Ini' }}</span>
          </button>
          <button
            @click="showGuideline"
            class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-container rounded-lg transition-colors"
            title="Lihat Panduan Pengisian"
            type="button"
          >
            <span class="material-symbols-outlined text-[20px]">help</span>
          </button>
        </div>
      </div>

      <!-- Subtle background ambient decor -->
      <div class="absolute -right-16 -top-16 w-64 h-64 bg-surface-container-high/40 rounded-full blur-3xl pointer-events-none"></div>
    </section>

    <!-- 4 Key Metrics Cards (Stitch Design) -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-lg">
      <!-- Metric 1: Jam Magang -->
      <div class="bg-surface-container-lowest p-space-lg rounded-xl shadow-sm border border-outline-variant flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between pb-space-md">
          <span class="font-label-md text-label-md text-on-surface-variant font-semibold">Total Jam Magang</span>
          <div class="w-9 h-9 rounded-lg bg-surface-container-low flex items-center justify-center text-secondary">
            <span class="material-symbols-outlined text-[20px]">schedule</span>
          </div>
        </div>
        <div class="flex flex-col gap-space-xs">
          <div class="flex items-baseline gap-space-xs">
            <span class="font-headline-xl text-headline-xl text-on-surface font-bold">328</span>
            <span class="font-body-md text-body-md text-on-surface-variant">/ 640 Jam</span>
          </div>
          <div class="w-full bg-surface-container h-2 rounded-full overflow-hidden mt-space-xs">
            <div class="bg-secondary h-full rounded-full transition-all duration-500" style="width: 51.2%;"></div>
          </div>
          <div class="flex justify-between items-center pt-space-xs">
            <span class="font-label-sm text-label-sm text-secondary font-semibold">51.2% Tercapai</span>
            <span class="font-label-sm text-label-sm text-on-surface-variant">Sisa 312 Jam</span>
          </div>
        </div>
      </div>

      <!-- Metric 2: Jurnal Terverifikasi -->
      <div class="bg-surface-container-lowest p-space-lg rounded-xl shadow-sm border border-outline-variant flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between pb-space-md">
          <span class="font-label-md text-label-md text-on-surface-variant font-semibold">Jurnal Terverifikasi</span>
          <div class="w-9 h-9 rounded-lg bg-surface-container-low flex items-center justify-center text-primary">
            <span class="material-symbols-outlined text-[20px]">fact_check</span>
          </div>
        </div>
        <div class="flex flex-col gap-space-xs">
          <div class="flex items-baseline gap-space-xs">
            <span class="font-headline-xl text-headline-xl text-on-surface font-bold">39</span>
            <span class="font-body-md text-body-md text-on-surface-variant">Logbook</span>
          </div>
          <div class="flex items-center gap-space-md pt-space-xs">
            <div class="flex items-center gap-1.5">
              <span class="w-2 h-2 rounded-full bg-secondary"></span>
              <span class="font-label-sm text-label-sm text-on-surface font-medium">36 Disetujui</span>
            </div>
            <div class="flex items-center gap-1.5">
              <span class="w-2 h-2 rounded-full bg-tertiary-container"></span>
              <span class="font-label-sm text-label-sm text-on-surface-variant font-medium">3 Review</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Metric 3: Kehadiran -->
      <div class="bg-surface-container-lowest p-space-lg rounded-xl shadow-sm border border-outline-variant flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between pb-space-md">
          <span class="font-label-md text-label-md text-on-surface-variant font-semibold">Persentase Kehadiran</span>
          <div class="w-9 h-9 rounded-lg bg-surface-container-low flex items-center justify-center text-secondary">
            <span class="material-symbols-outlined text-[20px]">event_seat</span>
          </div>
        </div>
        <div class="flex flex-col gap-space-xs">
          <div class="flex items-baseline gap-space-xs">
            <span class="font-headline-xl text-headline-xl text-on-surface font-bold">97.5%</span>
          </div>
          <div class="flex items-center gap-space-md pt-space-xs">
            <span class="font-label-sm text-label-sm text-on-surface-variant">
              <span class="font-semibold text-on-surface">39</span> Hadir Tepat Waktu
            </span>
            <span class="font-label-sm text-label-sm text-on-surface-variant">
              <span class="font-semibold text-on-surface">1</span> Izin Sakit
            </span>
          </div>
        </div>
      </div>

      <!-- Metric 4: Evaluasi Terakhir -->
      <div class="bg-surface-container-lowest p-space-lg rounded-xl shadow-sm border border-outline-variant flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between pb-space-md">
          <span class="font-label-md text-label-md text-on-surface-variant font-semibold">Evaluasi Terakhir Mentor</span>
          <div class="w-9 h-9 rounded-lg bg-surface-container-low flex items-center justify-center text-primary">
            <span class="material-symbols-outlined text-[20px]">military_tech</span>
          </div>
        </div>
        <div class="flex flex-col gap-space-xs">
          <div class="flex items-baseline gap-space-xs">
            <span class="font-headline-xl text-headline-xl text-on-surface font-bold">4.8</span>
            <span class="font-body-md text-body-md text-on-surface-variant">/ 5.0</span>
          </div>
          <div class="inline-flex items-center gap-1.5 pt-space-xs">
            <span class="material-symbols-outlined text-[16px] text-secondary">stars</span>
            <span class="font-label-sm text-label-sm text-secondary font-semibold">Predikat Sangat Memuaskan</span>
          </div>
        </div>
      </div>
    </section>

    <!-- 2 Column Layout (8:4 Desktop Grid) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-xl items-start">
      <!-- Main Content Column (8 cols) -->
      <div class="lg:col-span-8 flex flex-col gap-space-xl">
        <!-- Section: Aktivitas Jurnal Terbaru -->
        <div class="bg-surface-container-lowest p-space-xl rounded-xl shadow-sm border border-outline-variant flex flex-col gap-space-lg">
          <div class="flex items-center justify-between">
            <div class="flex flex-col gap-0.5">
              <h2 class="font-headline-md text-headline-md text-primary font-bold">Aktivitas Jurnal Terbaru</h2>
              <p class="font-body-sm text-body-sm text-on-surface-variant">Catatan teknis dan tugas kerja harian yang tersimpan</p>
            </div>
            <button
              @click="goToLogbook"
              class="inline-flex items-center gap-space-xs text-secondary hover:text-primary font-label-md text-label-md font-semibold transition-colors"
              type="button"
            >
              <span>Semua Jurnal</span>
              <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
            </button>
          </div>

          <!-- Entries List -->
          <div class="flex flex-col gap-space-md">
            <!-- Entry 1 -->
            <div class="bg-surface-container-low/50 hover:bg-surface-container-low p-space-lg rounded-xl border border-outline-variant/60 transition-all flex flex-col sm:flex-row sm:items-start justify-between gap-space-md">
              <div class="flex flex-col gap-space-xs flex-1">
                <div class="flex flex-wrap items-center gap-space-sm mb-1">
                  <span class="font-label-sm text-label-sm text-on-surface-variant font-medium">Selasa, 22 Okt 2024 • 08:30 - 17:00</span>
                  <span class="px-2.5 py-0.5 rounded-full font-label-sm text-label-sm font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                    Disetujui
                  </span>
                </div>
                <h3 class="font-headline-sm text-headline-sm text-primary font-bold">
                  Implementasi API Endpoint Auth &amp; Pengujian Unit
                </h3>
                <p class="font-body-md text-body-md text-on-surface-variant line-clamp-2 leading-relaxed">
                  Menyelesaikan integrasi sistem otentikasi JWT pada modul pengguna dan menulis 14 unit test dengan Jest. Seluruh suite berhasil mencapai code coverage 88%.
                </p>
                <div class="flex items-center gap-space-xs pt-space-xs flex-wrap">
                  <span class="px-2 py-0.5 bg-surface-container-lowest text-on-surface-variant font-label-sm text-label-sm rounded font-medium border border-outline-variant">#Backend</span>
                  <span class="px-2 py-0.5 bg-surface-container-lowest text-on-surface-variant font-label-sm text-label-sm rounded font-medium border border-outline-variant">#Sprint3</span>
                  <span class="px-2 py-0.5 bg-surface-container-lowest text-on-surface-variant font-label-sm text-label-sm rounded font-medium border border-outline-variant">8 Jam Kerja</span>
                </div>
              </div>
              <div class="shrink-0 self-end sm:self-center">
                <button
                  @click="goToLogbook"
                  class="inline-flex items-center gap-1 px-space-md py-1.5 bg-surface-container-lowest hover:bg-surface-container text-primary font-label-md text-label-md rounded-lg shadow-sm border border-outline-variant transition-colors"
                  type="button"
                >
                  <span>Detail</span>
                  <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                </button>
              </div>
            </div>

            <!-- Entry 2 -->
            <div class="bg-surface-container-low/50 hover:bg-surface-container-low p-space-lg rounded-xl border border-outline-variant/60 transition-all flex flex-col sm:flex-row sm:items-start justify-between gap-space-md">
              <div class="flex flex-col gap-space-xs flex-1">
                <div class="flex flex-wrap items-center gap-space-sm mb-1">
                  <span class="font-label-sm text-label-sm text-on-surface-variant font-medium">Senin, 21 Okt 2024 • 09:00 - 17:30</span>
                  <span class="px-2.5 py-0.5 rounded-full font-label-sm text-label-sm font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                    Disetujui
                  </span>
                </div>
                <h3 class="font-headline-sm text-headline-sm text-primary font-bold">
                  Sprint Planning &amp; Wireframing Modul Transaksi
                </h3>
                <p class="font-body-md text-body-md text-on-surface-variant line-clamp-2 leading-relaxed">
                  Menghadiri sesi kickoff sprint bersama tim produk, menyusun breakdown user stories untuk alur checkout multi-metode pembayaran, serta sinkronisasi diagram alur sistem.
                </p>
                <div class="flex items-center gap-space-xs pt-space-xs flex-wrap">
                  <span class="px-2 py-0.5 bg-surface-container-lowest text-on-surface-variant font-label-sm text-label-sm rounded font-medium border border-outline-variant">#ProductSync</span>
                  <span class="px-2 py-0.5 bg-surface-container-lowest text-on-surface-variant font-label-sm text-label-sm rounded font-medium border border-outline-variant">#UIUX</span>
                  <span class="px-2 py-0.5 bg-surface-container-lowest text-on-surface-variant font-label-sm text-label-sm rounded font-medium border border-outline-variant">7.5 Jam Kerja</span>
                </div>
              </div>
              <div class="shrink-0 self-end sm:self-center">
                <button
                  @click="goToLogbook"
                  class="inline-flex items-center gap-1 px-space-md py-1.5 bg-surface-container-lowest hover:bg-surface-container text-primary font-label-md text-label-md rounded-lg shadow-sm border border-outline-variant transition-colors"
                  type="button"
                >
                  <span>Detail</span>
                  <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                </button>
              </div>
            </div>

            <!-- Entry 3 -->
            <div class="bg-surface-container-low/50 hover:bg-surface-container-low p-space-lg rounded-xl border border-outline-variant/60 transition-all flex flex-col sm:flex-row sm:items-start justify-between gap-space-md">
              <div class="flex flex-col gap-space-xs flex-1">
                <div class="flex flex-wrap items-center gap-space-sm mb-1">
                  <span class="font-label-sm text-label-sm text-on-surface-variant font-medium">Jumat, 18 Okt 2024 • 08:30 - 16:30</span>
                  <span class="px-2.5 py-0.5 rounded-full font-label-sm text-label-sm font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                    Menunggu Review
                  </span>
                </div>
                <h3 class="font-headline-sm text-headline-sm text-primary font-bold">
                  Refactoring Database Query &amp; Profiling Index
                </h3>
                <p class="font-body-md text-body-md text-on-surface-variant line-clamp-2 leading-relaxed">
                  Melakukan profiling kueri lambat pada database staging PostgreSQL. Mengoptimalkan relasi join log audit yang sebelumnya memakan waktu respon di atas 1.2 detik.
                </p>
                <div class="flex items-center gap-space-xs pt-space-xs flex-wrap">
                  <span class="px-2 py-0.5 bg-surface-container-lowest text-on-surface-variant font-label-sm text-label-sm rounded font-medium border border-outline-variant">#Postgres</span>
                  <span class="px-2 py-0.5 bg-surface-container-lowest text-on-surface-variant font-label-sm text-label-sm rounded font-medium border border-outline-variant">#Optimization</span>
                  <span class="px-2 py-0.5 bg-surface-container-lowest text-on-surface-variant font-label-sm text-label-sm rounded font-medium border border-outline-variant">8 Jam Kerja</span>
                </div>
              </div>
              <div class="shrink-0 self-end sm:self-center">
                <button
                  @click="goToLogbook"
                  class="inline-flex items-center gap-1 px-space-md py-1.5 bg-surface-container-lowest hover:bg-surface-container text-primary font-label-md text-label-md rounded-lg shadow-sm border border-outline-variant transition-colors"
                  type="button"
                >
                  <span>Detail</span>
                  <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Section: Grafik Distribusi Jam & Aktivitas Mingguan -->
        <div class="bg-surface-container-lowest p-space-xl rounded-xl shadow-sm border border-outline-variant flex flex-col gap-space-lg">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-space-xs">
            <div class="flex flex-col gap-0.5">
              <h2 class="font-headline-md text-headline-md text-primary font-bold">Distribusi Jam &amp; Aktivitas Mingguan</h2>
              <p class="font-body-sm text-body-sm text-on-surface-variant">Pencatatan jam kerja reguler versus sesi bimbingan teknis (Minggu ke-8)</p>
            </div>
            <div class="flex items-center gap-space-md text-on-surface font-label-sm text-label-sm">
              <div class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-sm bg-primary"></span>
                <span>Jam Reguler</span>
              </div>
              <div class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-sm bg-secondary-container border border-secondary/30"></span>
                <span>Sesi Bimbingan</span>
              </div>
            </div>
          </div>

          <!-- Structured Visual Bar Chart -->
          <div class="w-full bg-surface-container-low/40 p-space-lg rounded-xl border border-outline-variant/60 flex flex-col gap-space-sm">
            <div class="h-56 w-full flex items-end justify-between px-2 pt-6">
              <!-- Monday -->
              <div class="flex-1 flex flex-col items-center gap-space-xs h-full justify-end">
                <div class="w-full max-w-[48px] flex flex-col items-center gap-1 h-full justify-end group cursor-pointer">
                  <span class="font-label-sm text-label-sm text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity">7.5h</span>
                  <div class="w-full bg-secondary-container rounded-t-sm h-[18%]" title="Bimbingan: 1.5 Jam"></div>
                  <div class="w-full bg-primary rounded-t-sm h-[72%]" title="Kerja Reguler: 6.0 Jam"></div>
                </div>
                <span class="font-label-md text-label-md text-on-surface-variant font-medium">Sen</span>
              </div>

              <!-- Tuesday -->
              <div class="flex-1 flex flex-col items-center gap-space-xs h-full justify-end">
                <div class="w-full max-w-[48px] flex flex-col items-center gap-1 h-full justify-end group cursor-pointer">
                  <span class="font-label-sm text-label-sm text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity">8.0h</span>
                  <div class="w-full bg-secondary-container rounded-t-sm h-[12%]" title="Bimbingan: 1.0 Jam"></div>
                  <div class="w-full bg-primary rounded-t-sm h-[84%]" title="Kerja Reguler: 7.0 Jam"></div>
                </div>
                <span class="font-label-md text-label-md text-on-surface-variant font-medium">Sel</span>
              </div>

              <!-- Wednesday (Today) -->
              <div class="flex-1 flex flex-col items-center gap-space-xs h-full justify-end">
                <div class="w-full max-w-[48px] flex flex-col items-center gap-1 h-full justify-end group cursor-pointer">
                  <span class="font-label-sm text-label-sm text-primary font-bold opacity-0 group-hover:opacity-100 transition-opacity">4.5h</span>
                  <div class="w-full bg-secondary-container rounded-t-sm h-[10%]" title="Bimbingan: 0.5 Jam"></div>
                  <div class="w-full bg-primary rounded-t-sm h-[42%]" title="Kerja Berjalan: 4.0 Jam"></div>
                </div>
                <span class="font-label-md text-label-md text-primary font-bold">Rab (Hari ini)</span>
              </div>

              <!-- Thursday -->
              <div class="flex-1 flex flex-col items-center gap-space-xs h-full justify-end">
                <div class="w-full max-w-[48px] flex flex-col items-center gap-1 h-full justify-end opacity-40">
                  <div class="w-full bg-surface-container rounded-t-sm h-[60%] border-dashed border-t-2 border-outline"></div>
                </div>
                <span class="font-label-md text-label-md text-on-surface-variant">Kam</span>
              </div>

              <!-- Friday -->
              <div class="flex-1 flex flex-col items-center gap-space-xs h-full justify-end">
                <div class="w-full max-w-[48px] flex flex-col items-center gap-1 h-full justify-end opacity-40">
                  <div class="w-full bg-surface-container rounded-t-sm h-[60%] border-dashed border-t-2 border-outline"></div>
                </div>
                <span class="font-label-md text-label-md text-on-surface-variant">Jum</span>
              </div>
            </div>

            <!-- Footer summary -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pt-space-md border-t border-outline-variant/60 gap-space-sm text-on-surface-variant">
              <span class="font-body-sm text-body-sm">
                Target mingguan: <span class="font-semibold text-on-surface">40 Jam</span> • Terpenuhi berjalan: <span class="font-semibold text-secondary">20 Jam</span>
              </span>
              <span class="font-label-sm text-label-sm text-secondary font-semibold">Tercatat On-Track (100% dari rasio waktu)</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column: Mentorship & Milestones (4 cols) -->
      <div class="lg:col-span-4 flex flex-col gap-space-xl">
        <!-- Mentor Profile Card -->
        <div class="bg-surface-container-lowest p-space-xl rounded-xl shadow-sm border border-outline-variant flex flex-col gap-space-lg">
          <div class="flex items-center justify-between">
            <span class="font-label-md text-label-md text-on-surface-variant font-semibold uppercase tracking-wider">Pembimbing Lapangan</span>
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500" title="Mentor Aktif"></span>
          </div>
          <div class="flex items-start gap-space-md">
            <div class="w-14 h-14 rounded-full bg-surface-container flex items-center justify-center text-primary font-bold text-lg shrink-0 border border-outline-variant">
              DA
            </div>
            <div class="flex flex-col">
              <h3 class="font-headline-sm text-headline-sm text-primary font-bold leading-tight">
                Dimas Ardiansyah, S.T.
              </h3>
              <p class="font-body-sm text-body-sm text-on-surface-variant">
                Lead Software Engineer &amp; Mentor
              </p>
              <span class="font-label-sm text-label-sm text-secondary font-medium pt-1">
                Review terakhir: Kemarin, 19:40
              </span>
            </div>
          </div>
          <div class="grid grid-cols-2 gap-space-sm">
            <button
              @click="sendMessageToMentor"
              class="inline-flex items-center justify-center gap-space-xs px-space-md py-2 bg-surface-container-low hover:bg-surface-container text-primary font-headline-sm text-body-sm rounded-lg transition-colors font-semibold border border-outline-variant"
              type="button"
            >
              <span class="material-symbols-outlined text-[18px]">chat</span>
              <span>Kirim Pesan</span>
            </button>
            <button
              @click="openDiscussionModal"
              class="inline-flex items-center justify-center gap-space-xs px-space-md py-2 bg-surface-container-low hover:bg-surface-container text-primary font-headline-sm text-body-sm rounded-lg transition-colors font-semibold border border-outline-variant"
              type="button"
            >
              <span class="material-symbols-outlined text-[18px]">calendar_add_on</span>
              <span>Diskusi</span>
            </button>
          </div>
        </div>

        <!-- Latest Mentor Feedback Box -->
        <div class="bg-surface-container-low p-space-xl rounded-xl shadow-sm border border-outline-variant flex flex-col gap-space-md relative overflow-hidden">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-space-xs text-primary font-headline-sm text-headline-sm font-bold">
              <span class="material-symbols-outlined text-[20px] text-secondary">mark_chat_unread</span>
              <span>Catatan Mentor Terbaru</span>
            </div>
            <span class="font-label-sm text-label-sm text-on-surface-variant">22 Okt</span>
          </div>
          <blockquote class="font-body-md text-body-md text-on-surface italic leading-relaxed pl-space-sm border-l-2 border-secondary">
            “Catatan implementasi JWT token kemarin sudah sangat rapi. Penanganan corner case session expired berjalan lancar. Siapkan demo untuk sprint review hari Jumat ya.”
          </blockquote>
          <div class="flex items-center justify-between pt-space-xs">
            <span class="font-label-sm text-label-sm text-on-surface-variant">Ref: Logbook #35 • Auth Service</span>
            <button
              @click="replyFeedback"
              class="text-secondary hover:text-primary font-label-sm text-label-sm font-semibold transition-colors"
              type="button"
            >
              Balas Tanggapan
            </button>
          </div>
        </div>

        <!-- Next Milestones & Interactive Checklists -->
        <div class="bg-surface-container-lowest p-space-xl rounded-xl shadow-sm border border-outline-variant flex flex-col gap-space-lg">
          <div class="flex items-center justify-between">
            <div class="flex flex-col">
              <h3 class="font-headline-sm text-headline-sm text-primary font-bold">Target Minggu ke-8</h3>
              <p class="font-body-sm text-body-sm text-on-surface-variant">Milestone &amp; checklist evaluasi</p>
            </div>
            <span class="px-2 py-0.5 rounded font-label-sm text-label-sm bg-surface-container text-secondary font-semibold border border-outline-variant">
              {{ completedMilestonesCount }}/{{ milestones.length }} Selesai
            </span>
          </div>

          <div class="flex flex-col gap-space-sm">
            <label
              v-for="item in milestones"
              :key="item.id"
              class="flex items-start gap-space-sm p-space-sm rounded-lg hover:bg-surface-container-low transition-colors cursor-pointer select-none"
            >
              <input
                type="checkbox"
                v-model="item.done"
                class="mt-1 h-4 w-4 rounded text-secondary focus:ring-0 cursor-pointer"
              />
              <div class="flex flex-col">
                <span
                  class="font-body-md text-body-md font-medium transition-colors"
                  :class="item.done ? 'line-through text-on-surface-variant' : 'text-primary font-semibold'"
                >
                  {{ item.title }}
                </span>
                <span class="font-label-sm text-label-sm text-on-surface-variant">
                  {{ item.desc }}
                </span>
              </div>
            </label>
          </div>

          <!-- Documentation Quick Access -->
          <div class="pt-space-sm flex items-center justify-between border-t border-outline-variant/60">
            <span class="font-body-sm text-body-sm text-on-surface-variant">Template Laporan PKL SMKN 71:</span>
            <button
              @click="downloadTemplate"
              class="inline-flex items-center gap-1 text-secondary hover:text-primary font-label-md text-label-md font-semibold transition-colors"
              type="button"
            >
              <span class="material-symbols-outlined text-[16px]">download</span>
              <span>Unduh DOCX</span>
            </button>
          </div>
        </div>

        <!-- Program Contact Support Info -->
        <div class="bg-surface-container-lowest p-space-lg rounded-xl shadow-sm border border-outline-variant flex items-center justify-between">
          <div class="flex items-center gap-space-md">
            <div class="w-10 h-10 rounded-full bg-surface-container-low flex items-center justify-center text-primary border border-outline-variant">
              <span class="material-symbols-outlined text-[20px]">school</span>
            </div>
            <div class="flex flex-col">
              <span class="font-headline-sm text-body-sm font-semibold text-primary">Guru Pembimbing Akademik</span>
              <span class="font-label-sm text-label-sm text-on-surface-variant">Dra. Nurul Hidayah, M.Pd (SMKN 71)</span>
            </div>
          </div>
          <span class="material-symbols-outlined text-secondary text-[18px]">verified</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useAppStore } from '~/composables/useAppStore'

const { currentUser, activeMenu, showToast } = useAppStore()

const todayFormatted = computed(() => {
  const options: Intl.DateTimeFormatOptions = {
    weekday: 'long',
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  }
  return new Date().toLocaleDateString('id-ID', options)
})

const isTodayLogged = ref(false)

const milestones = ref([
  {
    id: 1,
    title: 'Selesaikan modul autentikasi backend',
    desc: 'Selesai pada 22 Okt 2024',
    done: true
  },
  {
    id: 2,
    title: 'Verifikasi logbook mingguan ke mentor',
    desc: 'Disetujui kemarin sore',
    done: true
  },
  {
    id: 3,
    title: 'Penyusunan draft laporan tengah periode',
    desc: 'Batas pengumpulan: Jumat, 25 Okt',
    done: false
  }
])

const completedMilestonesCount = computed(() => {
  return milestones.value.filter(m => m.done).length
})

const goToLogbook = () => {
  activeMenu.value = 'logbook'
}

const showGuideline = () => {
  showToast('Panduan Pengisian: Isi deskripsi aktivitas menggunakan metode STAR (Situation, Task, Action, Result).', 'info')
}

const sendMessageToMentor = () => {
  showToast('Membuka ruang obrolan internal dengan Sdr. Dimas Ardiansyah (Mentor)', 'info')
}

const openDiscussionModal = () => {
  showToast('Pengajuan sesi diskusi bimbingan 1-on-1 sedang disiapkan.', 'info')
}

const replyFeedback = () => {
  showToast('Menautkan balasan tanggapan ke Logbook #35.', 'info')
}

const downloadTemplate = () => {
  showToast('Mengunduh Template Laporan Magang Resmi SMKN 71 (.docx)...', 'success')
}
</script>
