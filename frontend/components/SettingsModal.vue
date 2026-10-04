<template>
  <Teleport to="body">
    <Transition
      enter-active-class="transition-opacity duration-200 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition-opacity duration-150 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="isSettingsModalOpen"
        class="fixed inset-0 z-[999] flex items-center justify-center p-3 sm:p-4 bg-black/40 backdrop-blur-md select-none overflow-y-auto"
        @click.self="isSettingsModalOpen = false"
      >
        <div
          class="modal-card-animate w-full max-w-2xl bg-white dark:bg-[#1c1c1e] rounded-2xl sm:rounded-3xl border border-black/[0.08] dark:border-white/[0.12] shadow-[0_24px_70px_rgba(0,0,0,0.25)] p-5 sm:p-7 text-[#1d1d1f] dark:text-[#f5f5f7] relative my-auto max-h-[90vh] flex flex-col"
        >
          <!-- 1. MODAL HEADER (macOS Style) -->
          <div class="flex items-center justify-between pb-4 border-b border-black/[0.06] dark:border-white/[0.08] shrink-0">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-2xl bg-[#0071e3]/10 dark:bg-[#0071e3]/20 text-[#0071e3] flex items-center justify-center border border-[#0071e3]/20 shadow-xs">
                <span class="material-symbols-outlined text-[20px]">tune</span>
              </div>
              <div>
                <h3 class="text-[16px] font-bold text-[#1d1d1f] dark:text-[#f5f5f7] tracking-tight font-headline">
                  Pengaturan &amp; Preferensi Akun
                </h3>
                <p class="text-[12px] text-[#86868b] dark:text-[#98989f]">
                  Informasi identitas (NISN/NIP), tampilan antarmuka, dan keamanan
                </p>
              </div>
            </div>

            <!-- Close Button -->
            <button
              @click="isSettingsModalOpen = false"
              type="button"
              class="w-8 h-8 rounded-full bg-black/[0.04] hover:bg-black/[0.08] dark:bg-white/[0.08] dark:hover:bg-white/[0.14] text-[#86868b] hover:text-[#1d1d1f] dark:text-[#98989f] dark:hover:text-white flex items-center justify-center text-xs font-bold transition-all apple-press cursor-pointer"
              title="Tutup (Esc)"
            >
              ✕
            </button>
          </div>

          <!-- 2. APPLE SEGMENTED TAB NAVIGATION -->
          <div class="pt-4 pb-2 shrink-0">
            <div class="grid grid-cols-3 gap-1 p-1 bg-black/[0.04] dark:bg-white/[0.06] rounded-xl border border-black/[0.05] dark:border-white/[0.08] text-[12px] font-medium text-center">
              <button
                type="button"
                @click="activeTab = 'profile'"
                :class="activeTab === 'profile' ? 'bg-white dark:bg-[#2c2c2e] text-[#1d1d1f] dark:text-[#f5f5f7] shadow-xs font-bold' : 'text-[#86868b] hover:text-[#1d1d1f] dark:hover:text-white'"
                class="py-2 px-2 rounded-lg transition-all apple-press flex items-center justify-center gap-1.5 cursor-pointer truncate"
              >
                <span class="material-symbols-outlined text-[17px]">account_circle</span>
                <span class="truncate">Identitas Akun</span>
              </button>

              <button
                type="button"
                @click="activeTab = 'appearance'"
                :class="activeTab === 'appearance' ? 'bg-white dark:bg-[#2c2c2e] text-[#1d1d1f] dark:text-[#f5f5f7] shadow-xs font-bold' : 'text-[#86868b] hover:text-[#1d1d1f] dark:hover:text-white'"
                class="py-2 px-2 rounded-lg transition-all apple-press flex items-center justify-center gap-1.5 cursor-pointer truncate"
              >
                <span class="material-symbols-outlined text-[17px]">palette</span>
                <span class="truncate">Tampilan (Display)</span>
              </button>

              <button
                type="button"
                @click="activeTab = 'security'"
                :class="activeTab === 'security' ? 'bg-white dark:bg-[#2c2c2e] text-[#1d1d1f] dark:text-[#f5f5f7] shadow-xs font-bold' : 'text-[#86868b] hover:text-[#1d1d1f] dark:hover:text-white'"
                class="py-2 px-2 rounded-lg transition-all apple-press flex items-center justify-center gap-1.5 cursor-pointer truncate"
              >
                <span class="material-symbols-outlined text-[17px]">lock</span>
                <span class="truncate">Kata Sandi</span>
              </button>
            </div>
          </div>

          <!-- 3. TAB CONTENTS (SCROLLABLE BODY) -->
          <div class="flex-1 overflow-y-auto pr-1 py-3 space-y-4">
            <!-- ========================================== -->
            <!-- TAB 1: IDENTITAS AKUN & NISN / NIP          -->
            <!-- ========================================== -->
            <div v-if="activeTab === 'profile'" class="space-y-4">
              <!-- User Profile Header Card -->
              <div class="p-4 rounded-2xl bg-[#f5f5f7] dark:bg-[#242427] border border-black/[0.05] dark:border-white/[0.08] flex flex-col sm:flex-row items-center sm:items-start gap-4">
                <div class="relative shrink-0">
                  <img
                    :src="currentUser.avatar || '/images/avatar-student.png'"
                    :alt="currentUser.name"
                    class="w-16 h-16 rounded-2xl object-cover border-2 border-white dark:border-[#3a3a3c] shadow-md"
                  />
                  <span
                    class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-[#34c759] border-2 border-white dark:border-[#1c1c1e] flex items-center justify-center text-white"
                    title="Akun Terverifikasi & Aktif"
                  >
                    <span class="material-symbols-outlined text-[12px] font-bold">check</span>
                  </span>
                </div>

                <div class="flex-1 text-center sm:text-left min-w-0">
                  <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mb-1">
                    <h4 class="text-[17px] font-bold text-[#1d1d1f] dark:text-[#f5f5f7] tracking-tight">
                      {{ currentUser.name }}
                    </h4>
                    <span
                      class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-xs"
                      :class="{
                        'bg-[#0071e3]/10 text-[#0071e3] border border-[#0071e3]/20': currentRole === 'siswa',
                        'bg-[#af52de]/10 text-[#af52de] border border-[#af52de]/20': currentRole === 'dudi' || currentRole === 'mentor',
                        'bg-[#34c759]/10 text-[#248a3d] dark:text-[#34c759] border border-[#34c759]/20': currentRole === 'guru',
                        'bg-[#ff9500]/10 text-[#b26a00] dark:text-[#ff9500] border border-[#ff9500]/20': currentRole === 'admin'
                      }"
                    >
                      {{ currentRoleLabel }}
                    </span>
                  </div>

                  <p class="text-[12px] text-[#86868b] dark:text-[#98989f]">
                    {{ currentUser.email }} • SMKN 71 Jakarta
                  </p>

                  <div class="mt-2.5 flex flex-wrap items-center justify-center sm:justify-start gap-2 text-[11px]">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-black/[0.04] dark:bg-white/[0.08] text-[#1d1d1f] dark:text-[#f5f5f7] font-medium">
                      <span class="material-symbols-outlined text-[13px] text-[#0071e3]">school</span>
                      <span>{{ currentUser.class_name || 'Vokasi SMKN 71' }}</span>
                    </span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-black/[0.04] dark:bg-white/[0.08] text-[#1d1d1f] dark:text-[#f5f5f7] font-medium">
                      <span class="material-symbols-outlined text-[13px] text-[#34c759]">verified</span>
                      <span>{{ currentUser.status || 'Status: Aktif' }}</span>
                    </span>
                  </div>
                </div>
              </div>

              <!-- HIGHLIGHT CARD: NISN / NIP RESMI (DENGAN TOMBOL SALIN) -->
              <div class="p-4 rounded-2xl bg-gradient-to-br from-[#0071e3]/10 via-[#0071e3]/5 to-transparent dark:from-[#0071e3]/20 dark:via-[#0071e3]/10 dark:to-transparent border border-[#0071e3]/25 shadow-xs">
                <div class="flex items-center justify-between">
                  <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-[#0071e3] text-white flex items-center justify-center shadow-xs">
                      <span class="material-symbols-outlined text-[18px]">badge</span>
                    </div>
                    <div>
                      <span class="text-[11px] font-bold uppercase tracking-wider text-[#0071e3]">
                        {{ idLabelTitle }}
                      </span>
                      <div class="text-[18px] font-mono font-bold text-[#1d1d1f] dark:text-white tracking-wide">
                        {{ currentUser.nisn_nip || '-' }}
                      </div>
                    </div>
                  </div>

                  <button
                    type="button"
                    @click="copyIdToClipboard"
                    class="px-3 py-1.5 rounded-xl bg-white dark:bg-[#2c2c2e] hover:bg-[#0071e3] hover:text-white dark:hover:bg-[#0071e3] text-[#0071e3] border border-[#0071e3]/30 text-[11px] font-semibold transition-all apple-press flex items-center gap-1 shadow-xs cursor-pointer"
                    :title="'Salin ' + idLabelTitle"
                  >
                    <span class="material-symbols-outlined text-[15px]">{{ isCopied ? 'check' : 'content_copy' }}</span>
                    <span>{{ isCopied ? 'Tersalin!' : 'Salin' }}</span>
                  </button>
                </div>
                <p class="text-[11px] text-[#86868b] dark:text-[#98989f] mt-2 leading-relaxed">
                  {{ idLabelDescription }}
                </p>
              </div>

              <!-- DETAILS GRID BY ROLE -->
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <!-- Field 1: Jurusan / Konsentrasi Keahlian -->
                <div class="p-3.5 rounded-xl bg-[#f5f5f7] dark:bg-[#242427] border border-black/[0.05] dark:border-white/[0.08]">
                  <span class="text-[10px] uppercase font-bold tracking-wider text-[#86868b] dark:text-[#98989f] block mb-1">
                    {{ (currentRole === 'dudi' || currentRole === 'mentor') ? 'Bidang Usaha / Instansi' : 'Konsentrasi Keahlian' }}
                  </span>
                  <p class="text-[13px] font-semibold text-[#1d1d1f] dark:text-[#f5f5f7]">
                    {{ currentUser.major || 'PPLG (Pengembangan Perangkat Lunak dan Gim)' }}
                  </p>
                </div>

                <!-- Field 2: Tempat Magang / Instansi / Sekolah -->
                <div class="p-3.5 rounded-xl bg-[#f5f5f7] dark:bg-[#242427] border border-black/[0.05] dark:border-white/[0.08]">
                  <span class="text-[10px] uppercase font-bold tracking-wider text-[#86868b] dark:text-[#98989f] block mb-1">
                    {{ currentRole === 'siswa' ? 'Tempat Magang' : ((currentRole === 'dudi' || currentRole === 'mentor') ? 'Nama Instansi / Perusahaan' : 'Unit Kerja / Sekolah') }}
                  </span>
                  <p class="text-[13px] font-semibold text-[#1d1d1f] dark:text-[#f5f5f7] truncate">
                    {{ currentUser.company_name || 'PT Telkom Digital Solusi' }}
                  </p>
                </div>

                <!-- Field 3: Pembimbing Lapangan / Divisi -->
                <div class="p-3.5 rounded-xl bg-[#f5f5f7] dark:bg-[#242427] border border-black/[0.05] dark:border-white/[0.08]">
                  <span class="text-[10px] uppercase font-bold tracking-wider text-[#86868b] dark:text-[#98989f] block mb-1">
                    {{ currentRole === 'siswa' ? 'Pembimbing Lapangan' : ((currentRole === 'dudi' || currentRole === 'mentor') ? 'Divisi / Unit Kerja' : 'Peran Penugasan') }}
                  </span>
                  <p class="text-[13px] font-semibold text-[#1d1d1f] dark:text-[#f5f5f7]">
                    {{ currentRole === 'siswa' ? (currentUser.mentor_name || 'Hendra Wijaya, S.Kom') : (currentUser.division || currentUser.class_name || '-') }}
                  </p>
                </div>

                <!-- Field 4: Periode Akademik -->
                <div class="p-3.5 rounded-xl bg-[#f5f5f7] dark:bg-[#242427] border border-black/[0.05] dark:border-white/[0.08]">
                  <span class="text-[10px] uppercase font-bold tracking-wider text-[#86868b] dark:text-[#98989f] block mb-1">
                    Tahun Ajaran / Periode
                  </span>
                  <p class="text-[13px] font-semibold text-[#1d1d1f] dark:text-[#f5f5f7]">
                    {{ currentUser.academic_year || '2024/2025 (Semester Ganjil)' }}
                  </p>
                </div>
              </div>

              <!-- EDITABLE CONTACT INFORMATION ROW -->
              <div class="p-4 rounded-2xl bg-[#f5f5f7] dark:bg-[#242427] border border-black/[0.05] dark:border-white/[0.08] space-y-3">
                <div class="flex items-center justify-between">
                  <h5 class="text-[13px] font-bold text-[#1d1d1f] dark:text-[#f5f5f7] flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[17px] text-[#0071e3]">call</span>
                    <span>Kontak &amp; WhatsApp Terdaftar</span>
                  </h5>
                  <span class="text-[10px] text-[#86868b] dark:text-[#98989f]">Dapat diubah mandiri</span>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                  <div class="relative flex-1">
                    <span class="absolute left-3 top-2.5 text-[#86868b] dark:text-[#98989f] text-[13px]">📞</span>
                    <input
                      v-model="editablePhone"
                      type="tel"
                      placeholder="0812-xxxx-xxxx"
                      class="w-full pl-8 pr-3 py-2 bg-white dark:bg-[#1c1c1e] border border-black/[0.08] dark:border-white/[0.12] rounded-xl text-[13px] text-[#1d1d1f] dark:text-[#f5f5f7] focus:outline-none focus:border-[#0071e3] transition-all"
                    />
                  </div>
                  <button
                    type="button"
                    @click="savePhoneContact"
                    class="px-4 py-2 bg-[#0071e3] hover:bg-[#0077ed] text-white rounded-xl text-[12px] font-semibold transition-all apple-press shadow-xs cursor-pointer flex items-center justify-center gap-1"
                  >
                    <span class="material-symbols-outlined text-[15px]">save</span>
                    <span>Simpan Kontak</span>
                  </button>
                </div>
              </div>
            </div>

            <!-- ========================================== -->
            <!-- TAB 2: TAMPILAN & TEMA (DISPLAY / APPEARANCE) -->
            <!-- ========================================== -->
            <div v-else-if="activeTab === 'appearance'" class="space-y-4">
              <div>
                <h4 class="text-[15px] font-bold text-[#1d1d1f] dark:text-[#f5f5f7] tracking-tight">
                  Pengaturan Mode Tampilan (Appearance)
                </h4>
                <p class="text-[12px] text-[#86868b] dark:text-[#98989f] mt-0.5">
                  Sesuaikan kenyamanan visual Anda saat memantau jurnal, absensi, dan data magang SMKN 71.
                </p>
              </div>

              <!-- 3 APPLE APPEARANCE SELECTION CARDS -->
              <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 pt-1">
                <!-- 1. LIGHT MODE CARD -->
                <div
                  @click="handleSelectTheme('light')"
                  class="p-3.5 rounded-2xl border-2 transition-all cursor-pointer apple-press flex flex-col justify-between"
                  :class="themeMode === 'light'
                    ? 'border-[#0071e3] bg-[#0071e3]/5 dark:bg-[#0071e3]/10 shadow-[0_4px_16px_rgba(0,113,227,0.15)] ring-2 ring-[#0071e3]/20'
                    : 'border-black/[0.08] dark:border-white/[0.1] bg-[#f5f5f7] dark:bg-[#242427] hover:border-black/[0.15] dark:hover:border-white/[0.2]'"
                >
                  <!-- Visual UI Mockup for Light -->
                  <div class="w-full h-24 rounded-xl bg-[#f5f5f7] border border-black/[0.08] p-2 flex flex-col justify-between overflow-hidden shadow-inner mb-3">
                    <!-- Mini Window Title Bar -->
                    <div class="flex items-center justify-between pb-1 border-b border-black/[0.06]">
                      <div class="flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-[#ff5f57]"></span>
                        <span class="w-2 h-2 rounded-full bg-[#febc2e]"></span>
                        <span class="w-2 h-2 rounded-full bg-[#28c840]"></span>
                      </div>
                      <span class="w-12 h-1.5 rounded-full bg-black/10"></span>
                    </div>

                    <!-- Mini Content Area -->
                    <div class="flex gap-2 flex-1 pt-1.5">
                      <div class="w-1/3 bg-white rounded-lg p-1 border border-black/[0.04] flex flex-col gap-1">
                        <span class="w-full h-1.5 rounded bg-black/15"></span>
                        <span class="w-3/4 h-1 rounded bg-black/10"></span>
                        <span class="w-1/2 h-1 rounded bg-black/10"></span>
                      </div>
                      <div class="flex-1 bg-white rounded-lg p-1 border border-black/[0.04] flex flex-col gap-1.5">
                        <span class="w-3/4 h-2 rounded bg-[#0071e3]"></span>
                        <span class="w-full h-1.5 rounded bg-black/10"></span>
                        <span class="w-4/5 h-1.5 rounded bg-black/10"></span>
                      </div>
                    </div>
                  </div>

                  <!-- Label & Selector -->
                  <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                      <span class="text-base">☀️</span>
                      <div>
                        <div class="text-[13px] font-bold text-[#1d1d1f] dark:text-[#f5f5f7]">
                          Mode Terang
                        </div>
                        <div class="text-[10px] text-[#86868b] dark:text-[#98989f]">
                          Light Canvas
                        </div>
                      </div>
                    </div>

                    <!-- Radio Indicator -->
                    <div
                      class="w-4 h-4 rounded-full border-2 flex items-center justify-center transition-all"
                      :class="themeMode === 'light' ? 'border-[#0071e3] bg-[#0071e3]' : 'border-black/30 dark:border-white/30'"
                    >
                      <span v-if="themeMode === 'light'" class="w-1.5 h-1.5 rounded-full bg-white"></span>
                    </div>
                  </div>
                </div>

                <!-- 2. DARK MODE CARD -->
                <div
                  @click="handleSelectTheme('dark')"
                  class="p-3.5 rounded-2xl border-2 transition-all cursor-pointer apple-press flex flex-col justify-between"
                  :class="themeMode === 'dark'
                    ? 'border-[#0071e3] bg-[#0071e3]/5 dark:bg-[#0071e3]/10 shadow-[0_4px_16px_rgba(0,113,227,0.15)] ring-2 ring-[#0071e3]/20'
                    : 'border-black/[0.08] dark:border-white/[0.1] bg-[#f5f5f7] dark:bg-[#242427] hover:border-black/[0.15] dark:hover:border-white/[0.2]'"
                >
                  <!-- Visual UI Mockup for Dark -->
                  <div class="w-full h-24 rounded-xl bg-[#121214] border border-white/[0.1] p-2 flex flex-col justify-between overflow-hidden shadow-inner mb-3">
                    <!-- Mini Window Title Bar -->
                    <div class="flex items-center justify-between pb-1 border-b border-white/[0.08]">
                      <div class="flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-[#ff5f57]"></span>
                        <span class="w-2 h-2 rounded-full bg-[#febc2e]"></span>
                        <span class="w-2 h-2 rounded-full bg-[#28c840]"></span>
                      </div>
                      <span class="w-12 h-1.5 rounded-full bg-white/20"></span>
                    </div>

                    <!-- Mini Content Area -->
                    <div class="flex gap-2 flex-1 pt-1.5">
                      <div class="w-1/3 bg-[#1c1c1e] rounded-lg p-1 border border-white/[0.08] flex flex-col gap-1">
                        <span class="w-full h-1.5 rounded bg-white/30"></span>
                        <span class="w-3/4 h-1 rounded bg-white/15"></span>
                        <span class="w-1/2 h-1 rounded bg-white/15"></span>
                      </div>
                      <div class="flex-1 bg-[#1c1c1e] rounded-lg p-1 border border-white/[0.08] flex flex-col gap-1.5">
                        <span class="w-3/4 h-2 rounded bg-[#0a84ff]"></span>
                        <span class="w-full h-1.5 rounded bg-white/20"></span>
                        <span class="w-4/5 h-1.5 rounded bg-white/15"></span>
                      </div>
                    </div>
                  </div>

                  <!-- Label & Selector -->
                  <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                      <span class="text-base">🌙</span>
                      <div>
                        <div class="text-[13px] font-bold text-[#1d1d1f] dark:text-[#f5f5f7]">
                          Mode Gelap
                        </div>
                        <div class="text-[10px] text-[#86868b] dark:text-[#98989f]">
                          Apple Dark Obsidian
                        </div>
                      </div>
                    </div>

                    <!-- Radio Indicator -->
                    <div
                      class="w-4 h-4 rounded-full border-2 flex items-center justify-center transition-all"
                      :class="themeMode === 'dark' ? 'border-[#0071e3] bg-[#0071e3]' : 'border-black/30 dark:border-white/30'"
                    >
                      <span v-if="themeMode === 'dark'" class="w-1.5 h-1.5 rounded-full bg-white"></span>
                    </div>
                  </div>
                </div>

                <!-- 3. SYSTEM MODE CARD -->
                <div
                  @click="handleSelectTheme('system')"
                  class="p-3.5 rounded-2xl border-2 transition-all cursor-pointer apple-press flex flex-col justify-between"
                  :class="themeMode === 'system'
                    ? 'border-[#0071e3] bg-[#0071e3]/5 dark:bg-[#0071e3]/10 shadow-[0_4px_16px_rgba(0,113,227,0.15)] ring-2 ring-[#0071e3]/20'
                    : 'border-black/[0.08] dark:border-white/[0.1] bg-[#f5f5f7] dark:bg-[#242427] hover:border-black/[0.15] dark:hover:border-white/[0.2]'"
                >
                  <!-- Visual UI Mockup for System (Half Light / Half Dark) -->
                  <div class="w-full h-24 rounded-xl border border-black/[0.08] dark:border-white/[0.1] flex overflow-hidden shadow-inner mb-3">
                    <!-- Left Half: Light -->
                    <div class="w-1/2 bg-[#f5f5f7] p-2 flex flex-col justify-between border-r border-black/[0.06]">
                      <div class="flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-[#ff5f57]"></span>
                        <span class="w-2 h-2 rounded-full bg-[#febc2e]"></span>
                      </div>
                      <div class="bg-white rounded p-1 flex flex-col gap-1">
                        <span class="w-full h-1.5 rounded bg-[#0071e3]"></span>
                        <span class="w-2/3 h-1 rounded bg-black/10"></span>
                      </div>
                    </div>
                    <!-- Right Half: Dark -->
                    <div class="w-1/2 bg-[#121214] p-2 flex flex-col justify-between">
                      <div class="flex items-center justify-end">
                        <span class="w-2 h-2 rounded-full bg-[#28c840]"></span>
                      </div>
                      <div class="bg-[#1c1c1e] rounded p-1 flex flex-col gap-1">
                        <span class="w-full h-1.5 rounded bg-[#0a84ff]"></span>
                        <span class="w-2/3 h-1 rounded bg-white/20"></span>
                      </div>
                    </div>
                  </div>

                  <!-- Label & Selector -->
                  <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                      <span class="text-base">💻</span>
                      <div>
                        <div class="text-[13px] font-bold text-[#1d1d1f] dark:text-[#f5f5f7]">
                          Otomatis
                        </div>
                        <div class="text-[10px] text-[#86868b] dark:text-[#98989f]">
                          Ikuti Sistem OS
                        </div>
                      </div>
                    </div>

                    <!-- Radio Indicator -->
                    <div
                      class="w-4 h-4 rounded-full border-2 flex items-center justify-center transition-all"
                      :class="themeMode === 'system' ? 'border-[#0071e3] bg-[#0071e3]' : 'border-black/30 dark:border-white/30'"
                    >
                      <span v-if="themeMode === 'system'" class="w-1.5 h-1.5 rounded-full bg-white"></span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- NOTICE HIG: NON-INVERSION CRAFT GUARANTEE -->
              <div class="p-3.5 rounded-xl bg-[#0071e3]/5 dark:bg-[#0071e3]/10 border border-[#0071e3]/20 flex items-start gap-3">
                <span class="material-symbols-outlined text-[18px] text-[#0071e3] shrink-0 mt-0.5">verified_user</span>
                <div class="text-[11px] leading-relaxed text-[#1d1d1f] dark:text-[#f5f5f7]">
                  <span class="font-bold text-[#0071e3]">Desain Mode Gelap Asli (Non-Inversion):</span>
                  Mode gelap ini dirancang secara proporsional sesuai kaidah *Apple Human Interface Guidelines* dengan palet warna obsidian, kontras teks terkalibrasi, dan permukaan kartu bertingkat (elevation hierarchy). Bukan sekadar inversi CSS biasa.
                </div>
              </div>
            </div>

            <!-- ========================================== -->
            <!-- TAB 3: KEAMANAN KATA SANDI                 -->
            <!-- ========================================== -->
            <div v-else-if="activeTab === 'security'" class="space-y-4">
              <div>
                <h4 class="text-[15px] font-bold text-[#1d1d1f] dark:text-[#f5f5f7] tracking-tight">
                  Perbarui Kata Sandi Akun
                </h4>
                <p class="text-[12px] text-[#86868b] dark:text-[#98989f] mt-0.5">
                  Gunakan kombinasi kata sandi yang aman untuk melindungi data jurnal dan presensi Anda.
                </p>
              </div>

              <form @submit.prevent="handlePasswordSubmit" class="space-y-3.5">
                <div>
                  <label class="block text-[12px] font-semibold text-[#1d1d1f] dark:text-[#f5f5f7] mb-1.5">Kata Sandi Saat Ini</label>
                  <input
                    v-model="currentPassword"
                    type="password"
                    placeholder="Masukkan kata sandi lama Anda"
                    required
                    class="w-full px-3.5 py-2.5 bg-[#f5f5f7] dark:bg-[#242427] border border-black/[0.08] dark:border-white/[0.12] rounded-xl text-[13px] text-[#1d1d1f] dark:text-[#f5f5f7] placeholder-[#86868b] focus:outline-none focus:bg-white dark:focus:bg-[#2c2c30] focus:ring-4 focus:ring-[#0071e3]/15 focus:border-[#0071e3] transition-all"
                  />
                </div>

                <div>
                  <label class="block text-[12px] font-semibold text-[#1d1d1f] dark:text-[#f5f5f7] mb-1.5">Kata Sandi Baru</label>
                  <input
                    v-model="newPassword"
                    type="password"
                    placeholder="Minimal 6 karakter"
                    required
                    class="w-full px-3.5 py-2.5 bg-[#f5f5f7] dark:bg-[#242427] border border-black/[0.08] dark:border-white/[0.12] rounded-xl text-[13px] text-[#1d1d1f] dark:text-[#f5f5f7] placeholder-[#86868b] focus:outline-none focus:bg-white dark:focus:bg-[#2c2c30] focus:ring-4 focus:ring-[#0071e3]/15 focus:border-[#0071e3] transition-all"
                  />
                </div>

                <div>
                  <label class="block text-[12px] font-semibold text-[#1d1d1f] dark:text-[#f5f5f7] mb-1.5">Konfirmasi Kata Sandi Baru</label>
                  <input
                    v-model="confirmPassword"
                    type="password"
                    placeholder="Ulangi kata sandi baru"
                    required
                    class="w-full px-3.5 py-2.5 bg-[#f5f5f7] dark:bg-[#242427] border border-black/[0.08] dark:border-white/[0.12] rounded-xl text-[13px] text-[#1d1d1f] dark:text-[#f5f5f7] placeholder-[#86868b] focus:outline-none focus:bg-white dark:focus:bg-[#2c2c30] focus:ring-4 focus:ring-[#0071e3]/15 focus:border-[#0071e3] transition-all"
                  />
                </div>

                <div class="pt-2 flex items-center justify-end gap-2.5">
                  <button
                    type="submit"
                    :disabled="isSubmitting"
                    class="px-5 py-2.5 bg-[#0071e3] hover:bg-[#0077ed] text-white rounded-xl text-[12px] font-semibold shadow-[0_2px_8px_rgba(0,113,227,0.3)] transition-all apple-press flex items-center gap-1.5 cursor-pointer"
                  >
                    <span v-if="isSubmitting" class="animate-spin inline-block text-xs">⏳</span>
                    <span>Simpan Kata Sandi Baru</span>
                  </button>
                </div>
              </form>
            </div>
          </div>

          <!-- 4. MODAL FOOTER -->
          <div class="pt-3 border-t border-black/[0.06] dark:border-white/[0.08] flex items-center justify-between shrink-0 text-[11px] text-[#86868b] dark:text-[#98989f]">
            <div class="flex items-center gap-1.5">
              <span class="w-1.5 h-1.5 rounded-full bg-[#34c759]"></span>
              <span>EduAccess PKL SMKN 71 Jakarta</span>
            </div>
            <button
              type="button"
              @click="isSettingsModalOpen = false"
              class="px-4 py-1.5 bg-black/[0.05] hover:bg-black/[0.08] dark:bg-white/[0.08] dark:hover:bg-white/[0.14] text-[#1d1d1f] dark:text-[#f5f5f7] rounded-xl text-[12px] font-medium transition-all apple-press cursor-pointer"
            >
              Selesai
            </button>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useAppStore, type ThemeMode } from '~/composables/useAppStore'

const {
  isSettingsModalOpen,
  currentUser,
  currentRole,
  showToast,
  themeMode,
  applyTheme,
  updateUserProfile
} = useAppStore()

const activeTab = ref<'profile' | 'appearance' | 'security'>('profile')

// Editable Phone
const editablePhone = ref(currentUser.value.phone || '')

const savePhoneContact = () => {
  if (!editablePhone.value.trim()) {
    showToast('Nomor kontak tidak boleh kosong', 'warning')
    return
  }
  updateUserProfile({ phone: editablePhone.value.trim() })
}

// Copy NISN / NIP helper
const isCopied = ref(false)
const copyIdToClipboard = async () => {
  const text = currentUser.value.nisn_nip || ''
  if (!text) return

  try {
    if (navigator.clipboard && navigator.clipboard.writeText) {
      await navigator.clipboard.writeText(text)
    } else {
      const textarea = document.createElement('textarea')
      textarea.value = text
      document.body.appendChild(textarea)
      textarea.select()
      document.execCommand('copy')
      document.body.removeChild(textarea)
    }
    isCopied.value = true
    showToast(`${idLabelTitle.value} (${text}) berhasil disalin ke papan klip!`, 'success')
    setTimeout(() => {
      isCopied.value = false
    }, 2000)
  } catch (err) {
    showToast('Gagal menyalin nomor identitas', 'error')
  }
}

// Dynamic Titles by Role
const currentRoleLabel = computed(() => {
  const map: Record<string, string> = {
    siswa: 'Siswa Praktik (PKL)',
    mentor: 'Pembimbing Lapangan (Instansi / Perusahaan)',
    dudi: 'Pembimbing Lapangan (Instansi / Perusahaan)',
    guru: 'Guru Pembimbing Sekolah',
    admin: 'Administrator / Kaprog'
  }
  return map[currentRole.value] || 'Pengguna EduAccess'
})

const idLabelTitle = computed(() => {
  if (currentRole.value === 'siswa') return 'NISN (Nomor Induk Siswa Nasional)'
  if (currentRole.value === 'guru') return 'NIP (Nomor Induk Pegawai)'
  if (currentRole.value === 'dudi' || currentRole.value === 'mentor') return 'ID Pegawai / NIP Pembimbing Lapangan'
  return 'NIP / ID Administrator Sistem'
})

const idLabelDescription = computed(() => {
  if (currentRole.value === 'siswa') {
    return 'Nomor unik identitas siswa terdaftar di Kemendikbudristek & pangkalan data SMKN 71 Jakarta.'
  }
  if (currentRole.value === 'guru') {
    return 'Nomor Induk Pegawai resmi tenaga pendidik dan guru pembimbing magang SMKN 71 Jakarta.'
  }
  if (currentRole.value === 'dudi' || currentRole.value === 'mentor') {
    return 'Identitas registrasi pembimbing lapangan yang bertugas membimbing siswa di tempat magang.'
  }
  return 'Nomor induk staf penanggung jawab dan kepala program keahlian vokasi SMKN 71 Jakarta.'
})

// Appearance Selection Handler
const handleSelectTheme = (mode: ThemeMode) => {
  applyTheme(mode)
  const labels: Record<ThemeMode, string> = {
    light: 'Mode Terang (Light) diaktifkan ☀️',
    dark: 'Mode Gelap (Dark) Apple diaktifkan 🌙',
    system: 'Mode Otomatis (mengikuti tema sistem OS) diaktifkan 💻'
  }
  showToast(labels[mode], 'info')
}

// Password Form
const currentPassword = ref('')
const newPassword = ref('')
const confirmPassword = ref('')
const isSubmitting = ref(false)

const handlePasswordSubmit = async () => {
  if (newPassword.value.length < 6) {
    showToast('Kata sandi baru minimal 6 karakter!', 'warning')
    return
  }
  if (newPassword.value !== confirmPassword.value) {
    showToast('Konfirmasi kata sandi tidak cocok!', 'error')
    return
  }

  isSubmitting.value = true
  setTimeout(() => {
    isSubmitting.value = false
    currentPassword.value = ''
    newPassword.value = ''
    confirmPassword.value = ''
    showToast('Kata sandi akun Anda berhasil diperbarui!', 'success')
  }, 750)
}
</script>
