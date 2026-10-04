<template>
  <div class="flex flex-col w-full max-w-[1440px] mx-auto gap-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
      <div>
        <div class="flex items-center gap-2 mb-1">
          <span class="text-[11px] uppercase tracking-wider text-[#0071e3] font-semibold">Logbook Siswa</span>
          <span class="w-1 h-1 rounded-full bg-[#86868b]"></span>
          <span class="text-[11px] text-[#86868b]">Sesi Semester Ganjil 2024 • SMKN 71 Jakarta</span>
        </div>
        <h1 class="text-2xl sm:text-3xl text-[#1d1d1f] font-bold tracking-tight">Catatan Jurnal Harian</h1>
        <p class="text-[13px] text-[#86868b] mt-1 max-w-2xl leading-relaxed">
          Dokumentasikan aktivitas harian, pembelajaran, kendala, dan bukti hasil pengerjaan magang secara terstruktur untuk validasi berkala mentor.
        </p>
      </div>

      <div class="flex items-center gap-2.5 self-start md:self-auto shrink-0">
        <button
          @click="exportPdf"
          class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white text-[#1d1d1f] hover:bg-black/[0.03] border border-black/[0.08] transition-all shadow-xs text-[12px] font-semibold apple-press"
          type="button"
        >
          <span class="material-symbols-outlined text-[18px] text-[#0071e3]">picture_as_pdf</span>
          <span>Export Rekap PDF</span>
        </button>
        <button
          @click="focusForm"
          class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#0071e3] text-white hover:bg-[#0077ed] transition-all shadow-[0_2px_8px_rgba(0,113,227,0.25)] text-[12px] font-semibold apple-press"
          type="button"
        >
          <span class="material-symbols-outlined text-[18px]">add_circle</span>
          <span>+ Tulis Entri Jurnal</span>
        </button>
      </div>
    </div>

    <!-- 4 Stats Cards (Apple HIG Design) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="bg-white p-4 rounded-2xl shadow-[0_2px_12px_rgba(0,0,0,0.03)] border border-black/[0.05] flex items-center justify-between apple-press">
        <div class="flex flex-col">
          <span class="text-[11px] text-[#86868b] font-medium">Total Jam Tercatat</span>
          <span class="text-2xl text-[#1d1d1f] font-bold mt-0.5">328 Jam</span>
          <span class="text-[11px] text-[#0071e3] mt-0.5 font-medium">Target: 640 Jam (51.2%)</span>
        </div>
        <div class="w-10 h-10 rounded-xl bg-[#0071e3]/10 flex items-center justify-center text-[#0071e3]">
          <span class="material-symbols-outlined text-[22px]">schedule</span>
        </div>
      </div>

      <div class="bg-white p-4 rounded-2xl shadow-[0_2px_12px_rgba(0,0,0,0.03)] border border-black/[0.05] flex items-center justify-between apple-press">
        <div class="flex flex-col">
          <span class="text-[11px] text-[#86868b] font-medium">Entri Disetujui</span>
          <span class="text-2xl text-[#1d1d1f] font-bold mt-0.5">39 Hari</span>
          <span class="text-[11px] text-[#34c759] mt-0.5 font-medium">100% dari terverifikasi</span>
        </div>
        <div class="w-10 h-10 rounded-xl bg-[#34c759]/10 flex items-center justify-center text-[#248a3d]">
          <span class="material-symbols-outlined text-[22px]">verified</span>
        </div>
      </div>

      <div class="bg-white p-4 rounded-2xl shadow-[0_2px_12px_rgba(0,0,0,0.03)] border border-black/[0.05] flex items-center justify-between apple-press">
        <div class="flex flex-col">
          <span class="text-[11px] text-[#86868b] font-medium">Menunggu Evaluasi</span>
          <span class="text-2xl text-[#1d1d1f] font-bold mt-0.5">2 Entri</span>
          <span class="text-[11px] text-[#ff9500] mt-0.5 font-medium">Review: Sdr. Dimas</span>
        </div>
        <div class="w-10 h-10 rounded-xl bg-[#ff9500]/10 flex items-center justify-center text-[#b26a00]">
          <span class="material-symbols-outlined text-[22px]">pending_actions</span>
        </div>
      </div>

      <div class="bg-white p-4 rounded-2xl shadow-[0_2px_12px_rgba(0,0,0,0.03)] border border-black/[0.05] flex items-center justify-between apple-press">
        <div class="flex flex-col">
          <span class="text-[11px] text-[#86868b] font-medium">Status Draf Tersimpan</span>
          <span class="text-2xl text-[#1d1d1f] font-bold mt-0.5">1 Draf</span>
          <span class="text-[11px] text-[#86868b] mt-0.5">Update: Hari ini 11:20</span>
        </div>
        <div class="w-10 h-10 rounded-xl bg-black/[0.04] flex items-center justify-center text-[#86868b]">
          <span class="material-symbols-outlined text-[22px]">draft</span>
        </div>
      </div>
    </div>

    <!-- Filter & Search Toolbar (Apple HIG Design) -->
    <div class="bg-white p-3 rounded-2xl shadow-[0_2px_12px_rgba(0,0,0,0.03)] border border-black/[0.05] flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-3">
      <div class="flex-1 flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5">
        <!-- Search Input -->
        <div class="relative flex-1">
          <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-[18px] text-[#86868b]">search</span>
          <input
            v-model="searchQuery"
            class="w-full pl-9 pr-4 py-2 text-[13px] text-[#1d1d1f] bg-[#f5f5f7] rounded-xl placeholder-[#86868b] focus:bg-white focus:ring-4 focus:ring-[#0071e3]/15 focus:border-[#0071e3] outline-none transition-all border border-black/[0.06]"
            placeholder="Cari aktivitas, modul fitur, tiket, atau kendala..."
            type="text"
          />
        </div>

        <!-- Filter Dropdowns -->
        <div class="flex items-center gap-2">
          <div class="relative min-w-[160px]">
            <select
              v-model="statusFilter"
              class="w-full appearance-none pl-3.5 pr-8 py-2 text-[12px] font-medium text-[#1d1d1f] bg-[#f5f5f7] rounded-xl focus:bg-white focus:ring-4 focus:ring-[#0071e3]/15 outline-none cursor-pointer border border-black/[0.06]"
            >
              <option value="all">Semua Status</option>
              <option value="approved">Disetujui Mentor</option>
              <option value="pending">Menunggu Review</option>
              <option value="draft">Draf Mandiri</option>
            </select>
            <span class="material-symbols-outlined absolute right-2.5 top-1/2 -translate-y-1/2 text-[17px] text-[#86868b] pointer-events-none">expand_more</span>
          </div>

          <div class="relative min-w-[150px]">
            <div class="w-full flex items-center justify-between px-3.5 py-2 text-[12px] font-medium text-[#1d1d1f] bg-[#f5f5f7] rounded-xl cursor-pointer border border-black/[0.06]">
              <div class="flex items-center gap-1.5 truncate">
                <span class="material-symbols-outlined text-[16px] text-[#0071e3]">date_range</span>
                <span class="truncate">Oktober 2024</span>
              </div>
              <span class="material-symbols-outlined text-[16px] text-[#86868b]">calendar_today</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Apple Segmented View Switcher -->
      <div class="flex items-center gap-2 pt-2 lg:pt-0 justify-end">
        <span class="text-[11px] text-[#86868b] hidden xl:inline">Tampilan:</span>
        <div class="apple-segmented-container">
          <button
            @click="currentView = 'split'"
            :class="currentView === 'split' ? 'active' : ''"
            class="apple-segmented-item flex items-center gap-1.5 apple-press cursor-pointer"
            type="button"
          >
            <span class="material-symbols-outlined text-[15px]">view_agenda</span>
            <span>Split Kerja</span>
          </button>
          <button
            @click="currentView = 'calendar'"
            :class="currentView === 'calendar' ? 'active' : ''"
            class="apple-segmented-item flex items-center gap-1.5 apple-press cursor-pointer"
            type="button"
          >
            <span class="material-symbols-outlined text-[15px]">calendar_view_week</span>
            <span>Kalender</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Split Workspace (7:5 Desktop Grid) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
      <!-- Left Column: Form Entri (7 cols) -->
      <section
        ref="formContainer"
        class="lg:col-span-7 flex flex-col bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant p-6 lg:p-7 relative overflow-hidden"
      >
        <div class="flex items-start justify-between pb-5 border-b border-outline-variant/60">
          <div class="flex flex-col">
            <div class="inline-flex items-center gap-2 mb-1">
              <span class="w-2 h-2 rounded-full bg-secondary"></span>
              <span class="font-label-sm text-label-sm uppercase tracking-wide text-secondary font-semibold">Entri Hari Kerja Terjadwal</span>
            </div>
            <h2 class="font-headline-lg text-headline-lg text-primary font-bold tracking-tight">Tulis Catatan Harian</h2>
            <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">Rabu, 23 Oktober 2024 • Pekan ke-8 Tahap Implementasi</p>
          </div>
          <div class="px-3 py-1 rounded-full bg-surface-container text-primary font-label-md text-label-md font-semibold border border-outline-variant">
            Wajib Dilaporkan
          </div>
        </div>

        <!-- Urgency Alert Banner in Logbook Page -->
        <div
          v-if="journalUrgency !== 'none'"
          class="mt-4 p-4 rounded-xl border flex items-start gap-3 transition-all"
          :class="{
            'bg-amber-500/10 border-amber-500/40 text-amber-950': journalUrgency === 'warning',
            'bg-red-500/15 border-red-500/50 text-red-950 animate-glow-danger': journalUrgency === 'danger'
          }"
        >
          <div
            class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0"
            :class="journalUrgency === 'danger' ? 'bg-red-600 text-white animate-pulse-danger' : 'bg-amber-500 text-white'"
          >
            <span class="material-symbols-outlined text-[20px]">
              {{ journalUrgency === 'danger' ? 'crisis_alert' : 'priority_high' }}
            </span>
          </div>
          <div class="flex flex-col gap-0.5 min-w-0">
            <span class="text-xs font-bold uppercase tracking-wider">
              {{ journalUrgency === 'danger' ? '🚨 PERINGATAN DARURAT: Tap-Out Terancam Dianulir' : '⚠️ PERINGATAN: Selesaikan Jurnal Pasca Tap-Out' }}
            </span>
            <p class="text-[12px] leading-relaxed">
              {{ journalUrgency === 'danger'
                ? `Anda telah Tap-Out ${effectiveMinutesSinceTapOut} menit yang lalu (pukul ${attendanceState.checkOutTime || '17:00'} WIB) tanpa mengirimkan jurnal. Segera isi dan kirimkan formulir ini agar kehadiran Anda diverifikasi.`
                : `Anda telah melakukan presensi pulang (Tap-Out) pada pukul ${attendanceState.checkOutTime || '17:00'} WIB. Lengkapi detail pengerjaan magang hari ini di bawah ini.`
              }}
            </p>
          </div>
        </div>

        <form @submit.prevent="handleSubmitEntry" class="flex flex-col gap-5 mt-5">
          <!-- Row 1: Tanggal & Jam Kerja -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex flex-col gap-1.5">
              <label class="font-label-md text-label-md text-primary font-semibold flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px] text-secondary">event</span>
                Tanggal Kegiatan
              </label>
              <input
                v-model="form.date"
                class="w-full px-3.5 py-2.5 bg-surface-container-low text-on-surface font-body-sm text-body-sm rounded-lg outline-none cursor-default font-medium border border-outline-variant/60"
                readonly
                type="text"
              />
            </div>

            <div class="flex flex-col gap-1.5">
              <label class="font-label-md text-label-md text-primary font-semibold flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px] text-secondary">timelapse</span>
                Jam Kerja Efektif
              </label>
              <div class="flex items-center gap-2">
                <input
                  v-model="form.startTime"
                  class="w-full px-3 py-2.5 bg-surface-container-low text-on-surface text-center font-body-sm text-body-sm rounded-lg focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary/25 outline-none font-medium border border-outline-variant/60"
                  type="text"
                />
                <span class="text-on-surface-variant font-label-sm text-label-sm">s/d</span>
                <input
                  v-model="form.endTime"
                  class="w-full px-3 py-2.5 bg-surface-container-low text-on-surface text-center font-body-sm text-body-sm rounded-lg focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary/25 outline-none font-medium border border-outline-variant/60"
                  type="text"
                />
                <span class="font-label-sm text-label-sm px-2.5 py-2 rounded-lg bg-surface-container text-primary font-semibold whitespace-nowrap border border-outline-variant">8 Jam</span>
              </div>
            </div>
          </div>

          <!-- Row 2: Kategori & Lokasi -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex flex-col gap-1.5">
              <label class="font-label-md text-label-md text-primary font-semibold flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px] text-secondary">category</span>
                Kategori Pekerjaan
              </label>
              <div class="relative">
                <select
                  v-model="form.category"
                  class="w-full appearance-none px-3.5 py-2.5 bg-surface-container-low text-on-surface font-body-sm text-body-sm rounded-lg focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary/25 outline-none cursor-pointer border border-outline-variant/60"
                >
                  <option value="dev">Development &amp; Coding</option>
                  <option value="research">Research &amp; Technical Discovery</option>
                  <option value="meeting">Meeting &amp; Sprint Discussion</option>
                  <option value="doc">Documentation &amp; Reporting</option>
                </select>
                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-[18px] text-outline pointer-events-none">expand_more</span>
              </div>
            </div>

            <div class="flex flex-col gap-1.5">
              <label class="font-label-md text-label-md text-primary font-semibold flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px] text-secondary">share_location</span>
                Lokasi / Moda Kerja
              </label>
              <div class="relative">
                <select
                  v-model="form.location"
                  class="w-full appearance-none px-3.5 py-2.5 bg-surface-container-low text-on-surface font-body-sm text-body-sm rounded-lg focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary/25 outline-none cursor-pointer border border-outline-variant/60"
                >
                  <option value="wfo">WFO (Head Office - Lantai 4)</option>
                  <option value="wfh">WFH (Remote Mandiri)</option>
                  <option value="field">Kunjungan Lapangan / Mitra</option>
                </select>
                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-[18px] text-outline pointer-events-none">expand_more</span>
              </div>
            </div>
          </div>

          <!-- Judul Ringkas Pekerjaan -->
          <div class="flex flex-col gap-1.5">
            <label class="font-label-md text-label-md text-primary font-semibold flex items-center justify-between">
              <span class="flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px] text-secondary">title</span>
                Judul Ringkas Pekerjaan
              </span>
              <span class="font-label-sm text-label-sm text-on-surface-variant font-normal">Maks. 80 karakter</span>
            </label>
            <input
              ref="titleInput"
              v-model="form.title"
              maxlength="80"
              class="w-full px-3.5 py-2.5 bg-surface-container-low text-on-surface font-body-md text-body-md rounded-lg focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary/25 outline-none transition-all font-medium border border-outline-variant/60"
              placeholder="Contoh: Integrasi Payment Gateway Sandbox & Error Handling"
              type="text"
              required
            />
          </div>

          <!-- Deskripsi Detail Aktivitas & Capaian (STAR Format) -->
          <div class="flex flex-col gap-1.5">
            <div class="flex items-center justify-between">
              <label class="font-label-md text-label-md text-primary font-semibold flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px] text-secondary">subject</span>
                Deskripsi Detail Aktivitas &amp; Capaian
              </label>
              <span class="font-label-sm text-label-sm text-secondary bg-surface-container px-2 py-0.5 rounded font-semibold border border-outline-variant">
                Format STAR Disarankan
              </span>
            </div>
            <textarea
              v-model="form.description"
              rows="6"
              required
              class="w-full px-3.5 py-3 bg-surface-container-low text-on-surface font-body-sm text-body-sm leading-relaxed rounded-lg focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary/25 outline-none transition-all resize-y border border-outline-variant/60 font-body"
              placeholder="Jelaskan secara runtut:
1. Apa yang dikerjakan hari ini?
2. Progres dan capaian konkret yang diselesaikan?
3. Kendala teknis yang dihadapi dan solusi penanganannya?"
            ></textarea>
            <div class="flex items-center justify-between pt-1">
              <span class="font-label-sm text-label-sm text-on-surface-variant">Tips: Sertakan ID tiket Jira atau tautan merge request jika ada</span>
              <span class="font-label-sm text-label-sm text-on-surface-variant font-mono">{{ charCount }} Karakter • {{ wordCount }} Kata</span>
            </div>
          </div>

          <!-- Bukti Pengerjaan / Lampiran Pendukung -->
          <div class="flex flex-col gap-2">
            <label class="font-label-md text-label-md text-primary font-semibold flex items-center justify-between">
              <span class="flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px] text-secondary">attachment</span>
                Bukti Pengerjaan / Lampiran Pendukung
              </span>
              <span class="font-label-sm text-label-sm text-on-surface-variant font-normal">PNG, JPG, PDF (Maks. 5 MB)</span>
            </label>

            <!-- Dropzone -->
            <div
              @click="triggerFileInput"
              class="p-4 bg-surface-container-low rounded-xl border border-dashed border-outline-variant flex flex-col sm:flex-row items-center justify-between gap-4 cursor-pointer hover:bg-surface-container transition-colors"
            >
              <div class="flex items-center gap-3 w-full sm:w-auto">
                <div class="w-12 h-12 rounded-lg bg-surface-container-lowest flex items-center justify-center text-secondary shadow-xs shrink-0 border border-outline-variant">
                  <span class="material-symbols-outlined text-[24px]">cloud_upload</span>
                </div>
                <div class="flex flex-col">
                  <span class="font-headline-sm text-body-sm text-on-surface font-semibold">Tarik &amp; letakkan file di sini</span>
                  <span class="font-label-sm text-label-sm text-on-surface-variant">atau klik untuk menelusuri dari komputer</span>
                </div>
              </div>
              <input
                ref="fileInputRef"
                type="file"
                class="hidden"
                accept="image/png,image/jpeg,application/pdf"
                @change="handleFileUpload"
              />
              <button
                type="button"
                class="w-full sm:w-auto px-3.5 py-2 bg-surface-container-lowest text-primary hover:bg-surface-container text-body-sm font-body-sm font-semibold rounded-lg shadow-xs transition-colors shrink-0 border border-outline-variant"
              >
                Pilih File Dokumen
              </button>
            </div>

            <!-- Uploaded Files List -->
            <div v-if="attachments.length > 0" class="flex flex-col gap-2 mt-1">
              <div
                v-for="(file, idx) in attachments"
                :key="idx"
                class="flex items-center justify-between p-2.5 bg-surface-container-low rounded-lg border border-outline-variant/60"
              >
                <div class="flex items-center gap-3 min-w-0">
                  <div class="w-8 h-8 rounded bg-surface-container-lowest text-secondary flex items-center justify-center shrink-0 border border-outline-variant">
                    <span class="material-symbols-outlined text-[18px]">image</span>
                  </div>
                  <div class="flex flex-col min-w-0">
                    <span class="font-body-sm text-body-sm font-medium text-on-surface truncate">{{ file.name }}</span>
                    <span class="font-label-sm text-label-sm text-on-surface-variant">{{ file.size }} • Berhasil diunggah</span>
                  </div>
                </div>
                <div class="flex items-center gap-1 shrink-0">
                  <button
                    @click="previewFile(file)"
                    class="p-1.5 text-on-surface-variant hover:text-primary rounded transition-colors"
                    title="Pratinjau File"
                    type="button"
                  >
                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                  </button>
                  <button
                    @click="removeFile(idx)"
                    class="p-1.5 text-error hover:bg-error-container/20 rounded transition-colors"
                    title="Hapus File"
                    type="button"
                  >
                    <span class="material-symbols-outlined text-[18px]">delete</span>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Bottom Action Bar -->
          <div class="pt-4 mt-2 flex flex-col sm:flex-row items-center justify-between gap-3 bg-[#f5f5f7] -mx-6 -mb-6 p-6 rounded-b-2xl border-t border-black/[0.05]">
            <div class="flex items-center gap-2 self-start sm:self-auto text-[#86868b]">
              <span class="material-symbols-outlined text-[16px] text-[#34c759]">check_circle</span>
              <span class="text-[11px]">Draf otomatis tersimpan pada {{ lastAutoSaveTime }} WIB</span>
            </div>
            <div class="flex items-center gap-2.5 w-full sm:w-auto justify-end">
              <button
                @click="saveAsDraft"
                class="flex-1 sm:flex-initial px-4 py-2.5 rounded-xl bg-white text-[#1d1d1f] hover:bg-black/[0.04] text-[12px] font-semibold transition-all shadow-xs border border-black/[0.08] apple-press"
                type="button"
              >
                Simpan sebagai Draf
              </button>
              <button
                class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-white text-[12px] font-semibold transition-all apple-press cursor-pointer"
                :class="{
                  'bg-[#0071e3] hover:bg-[#0077ed] shadow-[0_2px_8px_rgba(0,113,227,0.25)]': journalUrgency === 'none',
                  'bg-amber-500 hover:bg-amber-600 shadow-[0_4px_14px_rgba(245,158,11,0.35)] font-bold': journalUrgency === 'warning',
                  'bg-red-600 hover:bg-red-700 shadow-[0_4px_20px_rgba(239,68,68,0.55)] animate-pulse-danger ring-2 ring-red-400 font-extrabold': journalUrgency === 'danger'
                }"
                type="submit"
              >
                <span class="material-symbols-outlined text-[17px]">
                  {{ journalUrgency === 'danger' ? 'warning' : (journalUrgency === 'warning' ? 'priority_high' : 'send') }}
                </span>
                <span>
                  {{ journalUrgency === 'danger' ? '⚠️ SEGERA KIRIM JURNAL (DARURAT)' : (journalUrgency === 'warning' ? 'Kirim Jurnal Hari Ini !' : 'Kirim untuk Review') }}
                </span>
              </button>
            </div>
          </div>
        </form>
      </section>

      <!-- Right Column: Riwayat Logbook (5 cols) -->
      <section class="lg:col-span-5 flex flex-col gap-4">
        <div class="flex items-center justify-between pb-1">
          <div class="flex items-center gap-2">
            <h2 class="text-base font-bold text-[#1d1d1f]">Riwayat Logbook</h2>
            <span class="px-2 py-0.5 rounded-full bg-[#0071e3]/10 text-[#0071e3] text-[11px] font-semibold">
              Pekan 8
            </span>
          </div>
          <span class="text-[11px] text-[#86868b]">{{ filteredLogs.length }} entri pekan ini</span>
        </div>

        <div class="flex flex-col gap-3">
          <article
            v-for="log in filteredLogs"
            :key="log.id"
            @click="selectLog(log)"
            class="bg-white rounded-2xl p-4.5 shadow-[0_2px_12px_rgba(0,0,0,0.03)] border border-black/[0.05] hover:shadow-[0_4px_20px_rgba(0,0,0,0.06)] transition-all cursor-pointer flex flex-col gap-2.5 apple-press"
          >
            <div class="flex items-start justify-between gap-2">
              <div class="flex flex-col">
                <span class="text-[11px] text-[#86868b] font-medium">{{ log.date }}</span>
                <h3 class="text-[13px] text-[#1d1d1f] font-semibold mt-0.5 line-clamp-1">
                  {{ log.title }}
                </h3>
              </div>
              <div
                class="shrink-0 flex items-center gap-1.5 px-2.5 py-1 rounded-full font-label-sm text-label-sm font-semibold border"
                :class="log.status === 'approved' ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : (log.status === 'pending' ? 'bg-amber-50 text-amber-800 border-amber-200' : 'bg-surface-container text-on-surface-variant border-outline-variant')"
              >
                <span
                  class="w-1.5 h-1.5 rounded-full"
                  :class="log.status === 'approved' ? 'bg-emerald-600' : (log.status === 'pending' ? 'bg-amber-600' : 'bg-outline')"
                ></span>
                <span>{{ log.statusLabel }}</span>
              </div>
            </div>

            <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-2 leading-relaxed">
              {{ log.desc }}
            </p>

            <div class="flex items-center justify-between pt-2 border-t border-outline-variant/50">
              <div class="flex items-center gap-3">
                <span class="font-label-sm text-label-sm text-on-surface-variant flex items-center gap-1">
                  <span class="material-symbols-outlined text-[15px] text-outline">timelapse</span>
                  {{ log.hours }}
                </span>
                <span class="font-label-sm text-label-sm text-on-surface-variant flex items-center gap-1">
                  <span class="material-symbols-outlined text-[15px] text-outline">attach_file</span>
                  {{ log.attachmentsCount }} Dokumen
                </span>
              </div>
              <div class="flex items-center gap-1.5">
                <div class="w-6 h-6 rounded-full bg-surface-container flex items-center justify-center text-[10px] font-bold text-primary border border-outline-variant">
                  {{ log.mentorInitials }}
                </div>
                <span class="font-label-sm text-label-sm text-on-surface font-medium">{{ log.mentorName }}</span>
              </div>
            </div>
          </article>
        </div>

        <!-- Pagination Bar -->
        <div class="bg-surface-container-lowest rounded-xl p-4 shadow-sm border border-outline-variant flex items-center justify-between mt-1">
          <span class="font-label-sm text-label-sm text-on-surface-variant">Menampilkan {{ filteredLogs.length }} dari 32 entri bulan ini</span>
          <div class="flex items-center gap-1.5">
            <button
              class="w-8 h-8 rounded-lg bg-surface-container-low flex items-center justify-center text-outline hover:text-primary hover:bg-surface-container disabled:opacity-40 transition-colors border border-outline-variant/60"
              disabled
              type="button"
            >
              <span class="material-symbols-outlined text-[18px]">chevron_left</span>
            </button>
            <span class="font-label-md text-label-md text-primary font-semibold px-2">Halaman 1 dari 8</span>
            <button
              class="w-8 h-8 rounded-lg bg-surface-container-low flex items-center justify-center text-on-surface hover:text-primary hover:bg-surface-container transition-colors border border-outline-variant/60"
              type="button"
            >
              <span class="material-symbols-outlined text-[18px]">chevron_right</span>
            </button>
          </div>
        </div>

        <!-- Weekly Locked Note -->
        <div class="p-4 rounded-xl bg-surface-container-low border border-outline-variant flex items-start gap-3">
          <span class="material-symbols-outlined text-[20px] text-secondary shrink-0 mt-0.5">verified_user</span>
          <div class="flex flex-col text-on-surface">
            <span class="font-headline-sm text-body-sm font-semibold">Tanda Tangan &amp; Validasi Mingguan</span>
            <p class="font-label-sm text-label-sm text-on-surface-variant mt-0.5 leading-relaxed">
              Seluruh catatan pada pekan berjalan akan dikunci otomatis pada hari Jumat pukul 23:59 WIB untuk ditinjau oleh Mentor Pembimbing Industri.
            </p>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useAppStore } from '~/composables/useAppStore'

const {
  showToast,
  authToken,
  attendanceState,
  isTodayLogged,
  journalUrgency,
  effectiveMinutesSinceTapOut,
  recordJournalSubmitted
} = useAppStore()

const formContainer = ref<HTMLElement | null>(null)
const titleInput = ref<HTMLInputElement | null>(null)
const fileInputRef = ref<HTMLInputElement | null>(null)

const searchQuery = ref('')
const statusFilter = ref('all')
const currentView = ref<'split' | 'calendar'>('split')
const lastAutoSaveTime = ref('11:20:14')

const form = ref({
  date: '23 Oktober 2024',
  startTime: '08:30',
  endTime: '17:30',
  category: 'dev',
  location: 'wfo',
  title: 'Integrasi Payment Gateway Sandbox & Error Handling',
  description: `1. Mengimplementasikan webhook handler payment gateway (Midtrans Sandbox) untuk skema Virtual Account dan QRIS.
2. Menyusun validasi payload signature key untuk mengantisipasi tampering response status transaksi.
3. Kendala: Callback webhook lokal sempat tertahan firewall staging; berhasil diatasi menggunakan tunnel reversproxy internal sesuai panduan tim DevOps.`
})

const attachments = ref([
  {
    name: 'screenshot_sandbox_test.png',
    size: '842 KB'
  }
])

const charCount = computed(() => form.value.description.length)
const wordCount = computed(() => {
  const trimmed = form.value.description.trim()
  return trimmed ? trimmed.split(/\s+/).length : 0
})

const initialLogs = [
  {
    id: 1,
    date: 'Selasa, 22 Okt 2024',
    title: 'Unit Testing & Optimasi Endpoint Checkout',
    desc: 'Menulis skenario pengujian automated jest untuk memvalidasi alur kalkulasi diskon kupon, ongkir dinamis, dan verifikasi stok reservasi.',
    hours: '8 Jam Kerja',
    attachmentsCount: 2,
    status: 'approved',
    statusLabel: 'Disetujui',
    mentorName: 'Bpk. Dimas Ardiansyah',
    mentorInitials: 'DA'
  },
  {
    id: 2,
    date: 'Senin, 21 Okt 2024',
    title: 'Sprint Planning & Review Backlog Q4',
    desc: 'Mengikuti rapat mingguan bersama tim Product Management, melakukan estimasi story point untuk modul transaksi dan refund saldo pengguna.',
    hours: '8 Jam Kerja',
    attachmentsCount: 1,
    status: 'approved',
    statusLabel: 'Disetujui',
    mentorName: 'Ibu Maya R.',
    mentorInitials: 'MR'
  },
  {
    id: 3,
    date: 'Jumat, 18 Okt 2024',
    title: 'Dokumentasi API Swagger & Deployment Staging',
    desc: 'Menyinkronkan spesifikasi OpenAPI 3.0 dengan route backend terkini serta melakukan build container Docker untuk lingkungan testing.',
    hours: '8 Jam Kerja',
    attachmentsCount: 3,
    status: 'approved',
    statusLabel: 'Disetujui',
    mentorName: 'Bpk. Dimas Ardiansyah',
    mentorInitials: 'DA'
  },
  {
    id: 4,
    date: 'Kamis, 17 Okt 2024',
    title: 'Penyelesaian Bug Validasi Form Pelanggan',
    desc: 'Memperbaiki parsing regex nomor telepon internasional pada modul input checkout dan sinkronisasi mask otomatis pada form registrasi.',
    hours: '8 Jam Kerja',
    attachmentsCount: 1,
    status: 'approved',
    statusLabel: 'Disetujui',
    mentorName: 'Bpk. Dimas Ardiansyah',
    mentorInitials: 'DA'
  }
]

const logsList = ref(initialLogs)

const filteredLogs = computed(() => {
  return logsList.value.filter(log => {
    const matchSearch = !searchQuery.value ||
      log.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      log.desc.toLowerCase().includes(searchQuery.value.toLowerCase())
    const matchStatus = statusFilter.value === 'all' || log.status === statusFilter.value
    return matchSearch && matchStatus
  })
})

const focusForm = () => {
  if (formContainer.value) {
    formContainer.value.scrollIntoView({ behavior: 'smooth', block: 'start' })
  }
  if (titleInput.value) {
    titleInput.value.focus()
  }
}

const triggerFileInput = () => {
  if (fileInputRef.value) {
    fileInputRef.value.click()
  }
}

const handleFileUpload = (e: Event) => {
  const target = e.target as HTMLInputElement
  if (target.files && target.files[0]) {
    const f = target.files[0]
    attachments.value.push({
      name: f.name,
      size: `${(f.size / 1024).toFixed(0)} KB`
    })
    showToast(`File ${f.name} berhasil diunggah!`, 'success')
  }
}

const removeFile = (idx: number) => {
  attachments.value.splice(idx, 1)
  showToast('File lampiran dihapus.', 'info')
}

const previewFile = (file: { name: string; size: string }) => {
  showToast(`Membuka pratinjau dokumen: ${file.name}`, 'info')
}

const saveAsDraft = () => {
  const now = new Date()
  lastAutoSaveTime.value = `${now.getHours().toString().padStart(2, '0')}:${now.getMinutes().toString().padStart(2, '0')}:${now.getSeconds().toString().padStart(2, '0')}`
  showToast('Draf jurnal harian berhasil disimpan di perangkat!', 'success')
}

const handleSubmitEntry = async () => {
  try {
    const todayIso = new Date().toISOString().substring(0, 10)
    await fetch('http://127.0.0.1:8000/api/siswa/logbooks', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${authToken.value}`
      },
      body: JSON.stringify({
        date: todayIso,
        title: form.value.title,
        activity_description: form.value.description
      })
    })
  } catch (e) {
    // fallback
  }

  logsList.value.unshift({
    id: Date.now(),
    date: 'Rabu, 23 Okt 2024',
    title: form.value.title,
    desc: form.value.description,
    hours: '8 Jam Kerja',
    attachmentsCount: attachments.value.length,
    status: 'pending',
    statusLabel: 'Menunggu Review',
    mentorName: 'Bpk. Dimas Ardiansyah',
    mentorInitials: 'DA'
  })

  recordJournalSubmitted()
}

const selectLog = (log: typeof initialLogs[0]) => {
  showToast(`Melihat riwayat: "${log.title}"`, 'info')
}

const exportPdf = () => {
  showToast('Mempersiapkan berkas rekapitulasi PDF Jurnal Magang SMKN 71...', 'success')
}
</script>