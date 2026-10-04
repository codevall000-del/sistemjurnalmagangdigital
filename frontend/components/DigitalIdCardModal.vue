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
        v-if="isIdCardModalOpen"
        class="fixed inset-0 z-[999] flex items-center justify-center p-3 sm:p-4 bg-black/50 backdrop-blur-md select-none overflow-y-auto"
        @click.self="isIdCardModalOpen = false"
      >
        <div
          class="idcard-animate w-full max-w-xl bg-white dark:bg-[#1c1c1e] rounded-3xl border border-black/[0.08] dark:border-white/[0.12] shadow-[0_25px_60px_rgba(0,0,0,0.3)] overflow-hidden text-[#1d1d1f] dark:text-[#f5f5f7] relative my-auto flex flex-col"
        >
          <!-- Top Modal Action Bar -->
          <div class="flex items-center justify-between px-5 pt-4 pb-3 border-b border-black/[0.05] dark:border-white/[0.08] bg-[#fbfbfd] dark:bg-[#242427] shrink-0 no-print">
            <div class="flex items-center gap-2">
              <span class="material-symbols-outlined text-[19px] text-[#0071e3]">badge</span>
              <span class="text-[13px] font-bold text-[#1d1d1f] dark:text-[#f5f5f7] tracking-tight">
                {{ currentRole === 'siswa' ? 'Kartu Tanda Peserta PKL' : 'Kartu Identitas Resmi' }}
              </span>
              <span class="text-[10px] px-2 py-0.5 rounded-full bg-[#0071e3]/10 text-[#0071e3] font-bold uppercase tracking-wider">
                Digital Pass
              </span>
            </div>

            <button
              @click="isIdCardModalOpen = false"
              type="button"
              class="w-7 h-7 rounded-full bg-black/[0.05] hover:bg-black/[0.1] dark:bg-white/[0.08] dark:hover:bg-white/[0.15] text-[#86868b] hover:text-[#1d1d1f] dark:text-[#98989f] dark:hover:text-white flex items-center justify-center transition-all apple-press cursor-pointer"
              title="Tutup (Esc)"
              aria-label="Tutup Dialog"
            >
              <span class="material-symbols-outlined text-[17px]">close</span>
            </button>
          </div>

          <!-- THE PRINTABLE & DISPLAYABLE ID CARD PASS CONTAINER -->
          <div class="p-5 sm:p-6 bg-gradient-to-b from-[#fbfbfd] to-white dark:from-[#242427] dark:to-[#1c1c1e] printable-id-card">
            <div class="w-full rounded-2xl bg-white dark:bg-[#2c2c2e] border border-black/[0.08] dark:border-white/[0.1] shadow-[0_8px_30px_rgba(0,0,0,0.06)] overflow-hidden relative">
              <!-- Top Ribbon SMKN 71 & Company Dual Header -->
              <div class="bg-gradient-to-r from-[#005bb5] via-[#0071e3] to-[#42a5f5] text-white p-4 relative overflow-hidden">
                <!-- Background Geometric Watermark Pattern -->
                <div class="absolute -right-6 -bottom-8 opacity-10 pointer-events-none">
                  <span class="material-symbols-outlined text-[130px]">school</span>
                </div>

                <div class="flex items-center justify-between relative z-10">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white p-1 flex items-center justify-center shadow-md shrink-0">
                      <img
                        src="/images/logo-smkn71.png"
                        alt="Logo SMKN 71"
                        class="w-8 h-8 object-contain"
                      />
                    </div>
                    <div>
                      <h4 class="text-[13px] font-extrabold tracking-tight leading-snug">
                        SMK NEGERI 71 JAKARTA
                      </h4>
                      <p class="text-[10px] text-white/85 font-medium tracking-wide">
                        PRAKTIK KERJA LAPANGAN (PKL) • T.A. 2024/2025
                      </p>
                    </div>
                  </div>

                  <!-- Verified Status Pill -->
                  <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-[10px] font-bold text-white shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-[#34c759] shadow-[0_0_6px_#34c759]"></span>
                    <span>RESMI AKTIF</span>
                  </div>
                </div>
              </div>

              <!-- Main Card Body: Profile Info & QR Verification -->
              <div class="p-5 flex flex-col md:flex-row gap-5">
                <!-- Left: Official Photo & NISN Pill -->
                <div class="flex flex-col items-center shrink-0">
                  <div class="relative">
                    <img
                      :src="currentUser.avatar || '/images/avatar-student.png'"
                      :alt="currentUser.name"
                      class="w-28 h-32 rounded-xl object-cover border-2 border-[#0071e3]/30 shadow-md"
                    />
                    <div class="absolute -bottom-2 -right-2 w-6 h-6 rounded-full bg-[#34c759] text-white flex items-center justify-center shadow-xs border-2 border-white dark:border-[#2c2c2e]">
                      <span class="material-symbols-outlined text-[14px] font-bold">verified</span>
                    </div>
                  </div>

                  <span class="mt-3 text-[10px] font-bold uppercase tracking-wider text-[#86868b] dark:text-[#98989f]">
                    {{ currentRole === 'siswa' ? 'Pas Foto Peserta' : 'Foto Resmi' }}
                  </span>
                </div>

                <!-- Center & Right: Detailed Identity Fields -->
                <div class="flex-1 flex flex-col justify-between min-w-0">
                  <div class="space-y-2.5">
                    <div>
                      <span class="text-[10px] text-[#86868b] dark:text-[#98989f] uppercase tracking-wider font-semibold">
                        Nama Lengkap
                      </span>
                      <h3 class="text-[17px] font-bold text-[#1d1d1f] dark:text-[#f5f5f7] tracking-tight leading-snug">
                        {{ currentUser.name }}
                      </h3>
                    </div>

                    <div class="grid grid-cols-2 gap-2 text-[11px]">
                      <div class="p-2 rounded-xl bg-black/[0.03] dark:bg-white/[0.04] border border-black/[0.04] dark:border-white/[0.06]">
                        <span class="text-[10px] text-[#86868b] dark:text-[#98989f] block font-medium">
                          {{ currentRole === 'siswa' ? 'NISN Siswa' : (currentRole === 'dudi' || currentRole === 'mentor' ? 'ID Pembimbing Lapangan' : 'NIP Pendidik') }}
                        </span>
                        <div class="flex items-center justify-between mt-0.5">
                          <span class="font-mono font-bold text-[#0071e3] text-[12px]">
                            {{ currentUser.nisn_nip || '0061234567' }}
                          </span>
                          <div class="relative group/mini flex items-center">
                            <button
                              disabled
                              type="button"
                              class="text-[10px] text-[#86868b]/40 dark:text-[#98989f]/30 cursor-not-allowed flex items-center p-0.5"
                              :title="`Fitur Salin ${currentRole === 'siswa' ? 'NISN' : 'ID'} Sementara Belum Tersedia (Tahap Integrasi Keamanan)`"
                            >
                              <span class="material-symbols-outlined text-[14px]">content_copy</span>
                            </button>
                            <div class="absolute bottom-full right-0 mb-1.5 hidden group-hover/mini:flex items-center gap-1 px-2 py-0.5 rounded-md bg-[#1d1d1f]/95 dark:bg-[#2c2c2e]/95 text-white text-[10px] font-medium whitespace-nowrap shadow-md pointer-events-none z-50 border border-white/10">
                              <span class="material-symbols-outlined text-[11px] text-[#ff9500]">info</span>
                              <span>Fitur sementara belum tersedia</span>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="p-2 rounded-xl bg-black/[0.03] dark:bg-white/[0.04] border border-black/[0.04] dark:border-white/[0.06]">
                        <span class="text-[10px] text-[#86868b] dark:text-[#98989f] block font-medium">
                          {{ currentRole === 'siswa' ? 'Kelas & Konsentrasi' : 'Jabatan / Unit' }}
                        </span>
                        <span class="font-semibold text-[#1d1d1f] dark:text-[#f5f5f7] text-[11px] block mt-0.5 truncate">
                          {{ currentUser.class_name || 'XII RPL 1' }}
                        </span>
                      </div>
                    </div>

                    <!-- Placement Details -->
                    <div class="p-2.5 rounded-xl bg-[#0071e3]/5 dark:bg-[#0071e3]/10 border border-[#0071e3]/15">
                      <div class="flex items-center gap-1.5 text-[#0071e3] font-semibold text-[11px] mb-1">
                        <span class="material-symbols-outlined text-[15px]">domain</span>
                        <span>Tempat Magang: {{ currentUser.company_name || 'PT Telkom Digital Solusi' }}</span>
                      </div>
                      <div class="flex items-center justify-between text-[10px] text-[#86868b] dark:text-[#98989f]">
                        <span>Pembimbing: <strong class="text-[#1d1d1f] dark:text-[#f5f5f7]">{{ currentUser.mentor_name || 'Hendra Wijaya, S.Kom' }}</strong></span>
                        <span class="font-mono">RPL Vokasi</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Card Bottom Bar: Hologram Security Barcode & QR Verification -->
              <div class="px-5 py-3 bg-[#f5f5f7] dark:bg-[#242427] border-t border-black/[0.06] dark:border-white/[0.08] flex items-center justify-between">
                <div class="flex items-center gap-3">
                  <!-- Simulated Security QR Code -->
                  <div class="w-12 h-12 bg-white p-1 rounded-lg border border-black/[0.1] shadow-xs shrink-0 flex items-center justify-center">
                    <svg viewBox="0 0 24 24" class="w-full h-full text-black">
                      <path fill="currentColor" d="M3,3H9V9H3V3M5,5V7H7V5H5M15,3H21V9H15V3M17,5V7H19V5H17M3,15H9V21H3V15M5,17V19H7V17H5M15,15H17V17H15V15M17,17H19V19H17V17M19,15H21V17H19V15M19,19H21V21H19V19M17,19H15V21H17V19M11,3H13V7H11V3M11,9H13V11H11V9M11,13H13V15H11V13M11,17H13V21H11V17M7,11H9V13H7V11M3,11H5V13H3V11M15,11H19V13H15V11Z" />
                    </svg>
                  </div>
                  <div class="flex flex-col">
                    <span class="text-[10px] font-bold text-[#1d1d1f] dark:text-[#f5f5f7] tracking-tight">
                      Verifikasi Keaslian PKL Kemendikbudristek
                    </span>
                    <span class="text-[9px] text-[#86868b] dark:text-[#98989f]">
                      ID Pass: SMKN71-PKL-{{ currentUser.nisn_nip || '0061234567' }}-2024
                    </span>
                  </div>
                </div>

                <div class="text-right">
                  <span class="text-[9px] uppercase font-bold text-[#34c759] bg-[#34c759]/10 px-2 py-0.5 rounded-full border border-[#34c759]/20 inline-block">
                    Valid s/d Jan 2025
                  </span>
                </div>
              </div>
            </div>
          </div>

          <!-- Bottom Actions (Non-Printable) -->
          <div class="p-4 border-t border-black/[0.06] dark:border-white/[0.08] bg-[#fbfbfd] dark:bg-[#242427] flex flex-wrap items-center justify-between gap-2.5 no-print shrink-0">
            <div class="flex items-center gap-2">
              <!-- Disabled Button: Salin ID / NISN -->
              <div class="relative group/copy">
                <button
                  disabled
                  type="button"
                  class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-black/[0.04] dark:bg-white/[0.05] border border-black/[0.06] dark:border-white/[0.08] text-[#86868b]/70 dark:text-[#98989f]/50 text-[12px] font-medium cursor-not-allowed select-none transition-all shadow-none"
                  :title="`Fitur Salin ${currentRole === 'siswa' ? 'NISN' : 'ID'} Sementara Belum Tersedia (Tahap Integrasi Keamanan)`"
                >
                  <span class="material-symbols-outlined text-[16px] text-[#86868b]/50 dark:text-[#98989f]/40">content_copy</span>
                  <span>Salin {{ currentRole === 'siswa' ? 'NISN' : 'ID' }}</span>
                </button>

                <!-- Floating Apple Tooltip on Hover -->
                <div class="absolute bottom-full left-0 mb-2 hidden group-hover/copy:flex flex-col items-start pointer-events-none z-50">
                  <div class="px-2.5 py-1.5 rounded-xl bg-[#1d1d1f]/95 dark:bg-[#2c2c2e]/95 backdrop-blur-md text-white text-[11px] font-medium shadow-[0_4px_16px_rgba(0,0,0,0.25)] border border-white/10 whitespace-nowrap flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[13px] text-[#ff9500]">info</span>
                    <span>Fitur Salin {{ currentRole === 'siswa' ? 'NISN' : 'ID' }} Sedang Dalam Tahap Integrasi Keamanan Sistem</span>
                  </div>
                  <div class="w-2 h-2 bg-[#1d1d1f]/95 dark:bg-[#2c2c2e]/95 rotate-45 -mt-1 ml-4 border-r border-b border-white/10"></div>
                </div>
              </div>

              <!-- Disabled Button: Cetak Kartu -->
              <div class="relative group/print">
                <button
                  disabled
                  type="button"
                  class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-black/[0.04] dark:bg-white/[0.05] border border-black/[0.06] dark:border-white/[0.08] text-[#86868b]/70 dark:text-[#98989f]/50 text-[12px] font-medium cursor-not-allowed select-none transition-all shadow-none"
                  title="Fitur Cetak Kartu Sementara Belum Tersedia (Tahap Sinkronisasi Blanko Cetak Resmi)"
                >
                  <span class="material-symbols-outlined text-[16px] text-[#86868b]/50 dark:text-[#98989f]/40">print</span>
                  <span>Cetak Kartu</span>
                </button>

                <!-- Floating Apple Tooltip on Hover -->
                <div class="absolute bottom-full left-0 mb-2 hidden group-hover/print:flex flex-col items-start pointer-events-none z-50">
                  <div class="px-2.5 py-1.5 rounded-xl bg-[#1d1d1f]/95 dark:bg-[#2c2c2e]/95 backdrop-blur-md text-white text-[11px] font-medium shadow-[0_4px_16px_rgba(0,0,0,0.25)] border border-white/10 whitespace-nowrap flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[13px] text-[#ff9500]">info</span>
                    <span>Fitur Cetak Kartu Sedang Dalam Proses Sinkronisasi Blanko Resmi SMKN 71</span>
                  </div>
                  <div class="w-2 h-2 bg-[#1d1d1f]/95 dark:bg-[#2c2c2e]/95 rotate-45 -mt-1 ml-4 border-r border-b border-white/10"></div>
                </div>
              </div>
            </div>

            <div v-if="currentRole === 'siswa'" class="flex items-center gap-2">
              <button
                @click="goToPenempatan"
                type="button"
                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#0071e3] hover:bg-[#0077ed] text-white text-[12px] font-semibold shadow-[0_2px_8px_rgba(0,113,227,0.25)] transition-all apple-press cursor-pointer"
              >
                <span class="material-symbols-outlined text-[16px]">supervised_user_circle</span>
                <span>Buka Detail Penempatan</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup lang="ts">
import { useAppStore } from '~/composables/useAppStore'

const {
  isIdCardModalOpen,
  currentUser,
  currentRole,
  activeMenu,
  showToast
} = useAppStore()

const copyNisn = () => {
  const text = currentUser.value.nisn_nip || '0061234567'
  if (navigator.clipboard) {
    navigator.clipboard.writeText(text)
  }
  showToast(`✓ Nomor ${currentRole.value === 'siswa' ? 'NISN' : 'Identitas'} (${text}) berhasil disalin ke clipboard!`, 'success')
}

const goToPenempatan = () => {
  isIdCardModalOpen.value = false
  activeMenu.value = 'penempatan'
  showToast('Membuka lembar detail Bimbingan & Penempatan PKL', 'info')
}

const printCard = () => {
  if (typeof window !== 'undefined') {
    window.print()
  }
}
</script>

<style scoped>
@keyframes cardPop {
  0% {
    opacity: 0;
    transform: scale(0.94) translateY(8px);
  }
  100% {
    opacity: 1;
    transform: scale(1) translateY(0);
  }
}

.idcard-animate {
  animation: cardPop 220ms cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

@media print {
  .no-print {
    display: none !important;
  }
  .printable-id-card {
    padding: 0 !important;
    background: transparent !important;
  }
}
</style>
