<template>
  <div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-black/[0.06]">
      <div>
        <div class="flex items-center gap-2 mb-1">
          <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold tracking-wide bg-[#0071e3]/10 text-[#0071e3]">
            Portal Guru Pembimbing
          </span>
          <span class="text-[#86868b]">•</span>
          <span class="text-xs font-medium text-[#86868b]">SMKN 71 Jakarta</span>
        </div>
        <h2 class="text-2xl font-bold text-[#1d1d1f] tracking-tight flex items-center gap-2">
          <span>Monitoring Pembimbing PKL</span>
        </h2>
        <p class="text-xs text-[#86868b] mt-0.5">
          Pantau seluruh siswa binaan berdasarkan seksi tempat magang (Mitra PT), konsentrasi keahlian, dan deteksi dini kedisiplinan.
        </p>
      </div>

      <div class="flex items-center gap-2">
        <span class="px-3.5 py-1.5 rounded-full text-xs font-medium bg-black/[0.04] text-[#1d1d1f] border border-black/[0.06] flex items-center gap-1.5">
          <span>👨‍🏫</span>
          <span>Dra. Nurul Hidayah, M.Pd • 6 Siswa (3 Mitra PT)</span>
        </span>
      </div>
    </div>

    <!-- 4 RINGKASAN METRIK GURU -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="bg-white border border-black/[0.05] rounded-2xl p-5 shadow-[0_2px_12px_rgba(0,0,0,0.03)] apple-press transition-all">
        <div class="flex items-center justify-between">
          <span class="text-xs font-semibold text-[#86868b] uppercase tracking-wider">Total Siswa Binaan</span>
          <span class="text-base">👨‍🎓</span>
        </div>
        <div class="text-3xl font-bold text-[#1d1d1f] tracking-tight mt-2">6 <span class="text-sm font-normal text-[#86868b]">Siswa</span></div>
        <span class="text-[11px] text-[#34c759] font-medium block mt-1">Tersebar di 3 Mitra PT</span>
      </div>

      <div class="bg-white border border-black/[0.05] rounded-2xl p-5 shadow-[0_2px_12px_rgba(0,0,0,0.03)] apple-press transition-all">
        <div class="flex items-center justify-between">
          <span class="text-xs font-semibold text-[#86868b] uppercase tracking-wider">Mitra Industri (PT)</span>
          <span class="text-base">🏢</span>
        </div>
        <div class="text-3xl font-bold text-[#0071e3] tracking-tight mt-2">3 <span class="text-sm font-normal text-[#86868b]">Perusahaan</span></div>
        <span class="text-[11px] text-[#86868b] font-medium block mt-1">RPL, Animasi, DKV</span>
      </div>

      <div class="bg-white border border-black/[0.05] rounded-2xl p-5 shadow-[0_2px_12px_rgba(0,0,0,0.03)] apple-press transition-all">
        <div class="flex items-center justify-between">
          <span class="text-xs font-semibold text-[#86868b] uppercase tracking-wider">Rata-Rata Kehadiran</span>
          <span class="text-base">⏱️</span>
        </div>
        <div class="text-3xl font-bold text-[#34c759] tracking-tight mt-2">96.8%</div>
        <span class="text-[11px] text-[#34c759] font-medium block mt-1">5 Siswa Hadir Hari Ini</span>
      </div>

      <div class="bg-white border border-black/[0.05] rounded-2xl p-5 shadow-[0_2px_12px_rgba(0,0,0,0.03)] apple-press transition-all">
        <div class="flex items-center justify-between">
          <span class="text-xs font-semibold text-[#86868b] uppercase tracking-wider">Peringatan Kritis</span>
          <span class="text-base">⚠️</span>
        </div>
        <div class="text-3xl font-bold text-[#ff3b30] tracking-tight mt-2">1 <span class="text-sm font-normal text-[#86868b]">Siswa</span></div>
        <span class="text-[11px] text-[#ff3b30] font-medium block mt-1">Tidak aktif &gt; 3 hari</span>
      </div>
    </div>

    <!-- PERINGATAN SISTEM KRITIS (Apple System Red Alert) -->
    <div class="p-5 rounded-2xl bg-[#ff3b30]/5 border border-[#ff3b30]/20 shadow-[0_2px_12px_rgba(255,59,48,0.05)] relative overflow-hidden">
      <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="flex items-start gap-3.5">
          <div class="w-10 h-10 rounded-xl bg-[#ff3b30]/10 text-[#ff3b30] flex items-center justify-center text-lg shrink-0">
            ⚠️
          </div>
          <div>
            <div class="flex items-center gap-2">
              <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold uppercase tracking-wider bg-[#ff3b30]/10 text-[#ff3b30]">
                Peringatan Sistem
              </span>
              <span class="text-xs font-mono text-[#86868b]">Presensi &amp; Jurnal Kosong &gt; 3 Hari</span>
            </div>
            <h3 class="text-sm font-bold text-[#1d1d1f] mt-1">
              Siswa <span class="text-[#ff3b30] font-bold underline">Rizky Pratama</span> (XII DKV 1) tidak mengisi jurnal &amp; absen selama 4 hari berturut-turut!
            </h3>
            <p class="text-xs text-[#86868b] mt-0.5">
              Penempatan: <strong class="text-[#1d1d1f]">Pixel Kreatif Visual Agency (Rawamangun, Jaktim)</strong> • Terakhir aktif 4 hari lalu.
            </p>
          </div>
        </div>

        <!-- Quick actions -->
        <div class="flex items-center gap-2.5 shrink-0 w-full sm:w-auto">
          <a
            href="https://wa.me/6281200000008"
            target="_blank"
            class="flex-1 sm:flex-none px-4 py-2 bg-[#34c759] hover:bg-[#30b753] text-white rounded-xl text-xs font-semibold transition flex items-center justify-center gap-1.5 shadow-[0_2px_8px_rgba(52,199,89,0.25)] apple-press"
          >
            <span>💬</span> WhatsApp Siswa
          </a>
          <button
            @click="contactMentor('Maya Safitri, M.Ds (Pixel Kreatif Visual)', '0812-0000-0031')"
            class="flex-1 sm:flex-none px-4 py-2 bg-white hover:bg-black/[0.04] text-[#1d1d1f] rounded-xl text-xs font-medium border border-black/[0.08] shadow-xs transition apple-press cursor-pointer"
            type="button"
          >
            Hubungi Pembimbing Lapangan
          </button>
        </div>
      </div>
    </div>

    <!-- FILTER / SEKSI KELOMPOK MITRA INDUSTRI -->
    <div class="bg-white border border-black/[0.05] rounded-2xl p-6 shadow-[0_2px_12px_rgba(0,0,0,0.03)] space-y-4">
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 pb-3 border-b border-black/[0.06]">
        <div>
          <h3 class="text-base font-bold text-[#1d1d1f] tracking-tight">
            Pemantauan Siswa Berdasarkan Seksi Mitra PT
          </h3>
          <p class="text-xs text-[#86868b] mt-0.5">
            Pengelompokan siswa binaan berdasarkan perusahaan penempatan industri.
          </p>
        </div>

        <!-- Apple Segmented Switcher for Companies -->
        <div class="apple-segmented-container overflow-x-auto">
          <button
            type="button"
            @click="selectedCompanyFilter = 'all'"
            :class="{ active: selectedCompanyFilter === 'all' }"
            class="apple-segmented-item whitespace-nowrap"
          >
            Semua PT (6)
          </button>
          <button
            type="button"
            v-for="comp in companies"
            :key="comp.id"
            @click="selectedCompanyFilter = comp.id"
            :class="{ active: selectedCompanyFilter === comp.id }"
            class="apple-segmented-item whitespace-nowrap flex items-center gap-1.5"
          >
            <span>{{ comp.shortName }}</span>
            <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-black/[0.06] text-[#1d1d1f] font-mono font-semibold">
              {{ comp.students.length }}
            </span>
          </button>
        </div>
      </div>

      <!-- SEKSI-SEKSI PERUSAHAAN (COMPANY SECTIONS) -->
      <div class="space-y-6 pt-1">
        <div
          v-for="company in displayedCompanies"
          :key="company.id"
          class="rounded-2xl border border-black/[0.05] bg-black/[0.015] p-5 space-y-4 transition"
        >
          <!-- Header Seksi PT -->
          <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3 pb-3 border-b border-black/[0.05]">
            <div class="flex items-start gap-3.5">
              <div class="w-12 h-12 rounded-2xl bg-white border border-black/[0.06] flex items-center justify-center text-2xl shrink-0 shadow-xs">
                {{ company.icon }}
              </div>
              <div class="flex flex-col">
                <div class="flex items-center gap-2 flex-wrap">
                  <h4 class="text-base font-bold text-[#1d1d1f]">{{ company.name }}</h4>
                  <span
                    class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold uppercase tracking-wider"
                    :class="(company.major === 'RPL' || company.major === 'PPLG / RPL') ? 'bg-[#0071e3]/10 text-[#0071e3]' : (company.major === 'Animasi' ? 'bg-[#af52de]/10 text-[#af52de]' : 'bg-[#ff9500]/10 text-[#ff9500]')"
                  >
                    {{ company.major === 'PPLG / RPL' ? 'RPL' : company.major }}
                  </span>
                  <span class="px-2 py-0.5 rounded-full text-[10px] font-medium bg-black/[0.04] text-[#86868b]">
                    Mode: {{ company.workModes }}
                  </span>
                </div>
                <p class="text-xs text-[#86868b] mt-0.5">{{ company.sector }} • {{ company.address }}</p>
              </div>
            </div>

            <!-- Kontak Mentor PT -->
            <div class="flex items-center gap-3 self-start lg:self-auto bg-white px-3.5 py-2 rounded-xl border border-black/[0.06] text-xs shadow-xs">
              <div class="flex flex-col text-right">
                <span class="text-[10px] uppercase font-semibold text-[#86868b]">Mentor Industri</span>
                <span class="font-semibold text-[#1d1d1f]">{{ company.mentor.name }}</span>
              </div>
              <a
                :href="`https://wa.me/${company.mentor.phoneClean}`"
                target="_blank"
                class="p-2 rounded-lg bg-[#34c759]/10 text-[#34c759] hover:bg-[#34c759]/20 transition apple-press"
                title="Hubungi Mentor Industri via WhatsApp"
              >
                💬
              </a>
            </div>
          </div>

          <!-- Grid Siswa di PT Ini -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div
              v-for="student in company.students"
              :key="student.id"
              class="bg-white rounded-2xl p-4 border border-black/[0.05] shadow-[0_2px_8px_rgba(0,0,0,0.02)] flex flex-col justify-between hover:shadow-md transition"
            >
              <div>
                <!-- Top Student Row -->
                <div class="flex items-start justify-between gap-3">
                  <div class="flex items-center gap-3">
                    <img :src="student.avatar" class="w-11 h-11 rounded-xl object-cover border border-black/[0.06] shadow-xs" />
                    <div>
                      <h5 class="text-sm font-semibold text-[#1d1d1f]">{{ student.name }}</h5>
                      <span class="text-[11px] text-[#86868b] font-mono">NISN: {{ student.nisn }} • {{ student.className }}</span>
                    </div>
                  </div>

                  <!-- Status Aktif / Kritis -->
                  <div>
                    <span
                      v-if="student.status === 'Aktif'"
                      class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-[#34c759]/10 text-[#34c759]"
                    >
                      Aktif
                    </span>
                    <span
                      v-else
                      class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-[#ff3b30]/10 text-[#ff3b30]"
                    >
                      Kritis (&gt; 3 Hari)
                    </span>
                  </div>
                </div>

                <!-- Info Presensi Hari Ini & Logbook -->
                <div class="grid grid-cols-2 gap-2 mt-3 pt-3 border-t border-black/[0.04] text-xs">
                  <div class="p-2 rounded-xl bg-black/[0.02] border border-black/[0.03]">
                    <span class="text-[10px] text-[#86868b] uppercase font-semibold block">Presensi Hari Ini:</span>
                    <span class="font-semibold text-[#1d1d1f] text-[11px] flex items-center gap-1 mt-0.5">
                      <span>{{ student.todayAttendanceIcon }}</span>
                      <span>{{ student.todayAttendanceText }}</span>
                    </span>
                  </div>

                  <div class="p-2 rounded-xl bg-black/[0.02] border border-black/[0.03]">
                    <span class="text-[10px] text-[#86868b] uppercase font-semibold block">Jurnal Harian:</span>
                    <span class="font-semibold text-[#1d1d1f] text-[11px] mt-0.5 block">
                      {{ student.journalsAcc }} Di-ACC • {{ student.journalsPending }} Review
                    </span>
                  </div>
                </div>
              </div>

              <!-- Action Bottom Links -->
              <div class="flex items-center justify-between pt-3 mt-3 border-t border-black/[0.04] text-xs">
                <span class="text-[11px] text-[#86868b] font-mono">
                  Terakhir: {{ student.lastActiveText }}
                </span>
                <div class="flex items-center gap-2">
                  <a
                    :href="`https://wa.me/${student.phoneClean}`"
                    target="_blank"
                    class="px-2.5 py-1 bg-black/[0.04] hover:bg-black/[0.07] text-[#1d1d1f] rounded-lg text-[11px] font-medium transition apple-press"
                  >
                    WA Siswa
                  </a>
                  <button
                    type="button"
                    @click="viewStudentTimeline(student)"
                    class="px-3 py-1 bg-[#0071e3] hover:bg-[#0077ed] text-white rounded-lg text-[11px] font-semibold shadow-xs transition apple-press cursor-pointer"
                  >
                    Buka Jurnal &rarr;
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- GRAFIK KEAKTIFAN KOMPARASI MINGGUAN (Apple Health / Fitness Style) -->
    <div class="bg-white border border-black/[0.05] rounded-2xl p-6 shadow-[0_2px_12px_rgba(0,0,0,0.03)] space-y-4">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-3 border-b border-black/[0.06]">
        <div>
          <h3 class="text-sm font-bold text-[#1d1d1f] tracking-tight">Grafik Keaktifan Presensi &amp; Pengisian Logbook Siswa Binaan</h3>
          <p class="text-[11px] text-[#86868b]">Komparasi tingkat kehadiran vs ketuntasan jurnal harian mingguan (SMKN 71)</p>
        </div>
        <div class="flex items-center gap-3 text-xs">
          <span class="flex items-center gap-1.5 text-[#1d1d1f] font-medium">
            <span class="w-2.5 h-2.5 rounded-full bg-[#34c759]"></span> Presensi Hadir
          </span>
          <span class="flex items-center gap-1.5 text-[#1d1d1f] font-medium">
            <span class="w-2.5 h-2.5 rounded-full bg-[#0071e3]"></span> Jurnal Terisi
          </span>
        </div>
      </div>

      <!-- Activity Bar Chart -->
      <div class="space-y-4 pt-2">
        <div v-for="day in weekChart" :key="day.day" class="space-y-1.5">
          <div class="flex items-center justify-between text-xs">
            <span class="font-semibold text-[#1d1d1f] font-mono">{{ day.day }}</span>
            <span class="text-[#86868b] font-mono text-[11px]">Hadir: {{ day.att }}% | Jurnal: {{ day.log }}%</span>
          </div>
          <div class="space-y-1">
            <div class="w-full bg-black/[0.04] rounded-full h-2 overflow-hidden">
              <div class="bg-[#34c759] h-2 rounded-full transition-all duration-500" :style="{ width: day.att + '%' }"></div>
            </div>
            <div class="w-full bg-black/[0.04] rounded-full h-2 overflow-hidden">
              <div class="bg-[#0071e3] h-2 rounded-full transition-all duration-500" :style="{ width: day.log + '%' }"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useAppStore } from '~/composables/useAppStore'

const { activeMenu, authToken, showToast } = useAppStore()

const selectedCompanyFilter = ref<string | number>('all')

const weekChart = ref([
  { day: 'Senin', att: 100, log: 100 },
  { day: 'Selasa', att: 100, log: 95 },
  { day: 'Rabu', att: 100, log: 90 },
  { day: 'Kamis', att: 92, log: 88 },
  { day: 'Jumat', att: 85, log: 80 },
])

// 6 Siswa Binaan yang Tersebar di 3 PT berbeda di bawah bimbingan Guru Dra. Nurul Hidayah
const companies = ref([
  {
    id: 1,
    name: 'PT Telkom Digital Solusi',
    shortName: 'PT Telkom (RPL)',
    icon: '💻',
    major: 'RPL',
    badgeClass: 'bg-blue-50 text-blue-800 border border-blue-200',
    sector: 'Software House & Cloud Infrastructure',
    address: 'Telkom Landmark Lt. 14, Jakarta Selatan',
    workModes: 'WFO, WFH',
    mentor: {
      name: 'Hendra Wijaya, S.Kom',
      phoneClean: '6281200000003'
    },
    students: [
      {
        id: 4,
        name: 'Budi Santoso',
        nisn: '0061234567',
        className: 'XII RPL 1',
        avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150',
        phoneClean: '6281200000004',
        status: 'Aktif',
        todayAttendanceIcon: '🟢',
        todayAttendanceText: 'Hadir 07:35 WIB (WFO)',
        journalsAcc: 18,
        journalsPending: 1,
        lastActiveText: 'Hari ini 07:35 WIB'
      },
      {
        id: 5,
        name: 'Siti Fauziah',
        nisn: '0061234568',
        className: 'XII RPL 2',
        avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150',
        phoneClean: '6281200000005',
        status: 'Aktif',
        todayAttendanceIcon: '🏠',
        todayAttendanceText: 'Hadir 07:42 WIB (WFH)',
        journalsAcc: 16,
        journalsPending: 2,
        lastActiveText: 'Hari ini 07:42 WIB'
      }
    ]
  },
  {
    id: 2,
    name: 'Studio Animasi Kinetik Digital',
    shortName: 'Studio Kinetik (Animasi)',
    icon: '🎬',
    major: 'Animasi',
    badgeClass: 'bg-purple-50 text-purple-800 border border-purple-200',
    sector: '3D Animation & CGI Motion Picture',
    address: 'Jl. Raden Saleh No. 18, Cikini, Jakarta Pusat',
    workModes: 'WFO, WFH, WFA',
    mentor: {
      name: 'Raditya Pratama, S.Sn',
      phoneClean: '6281200000021'
    },
    students: [
      {
        id: 6,
        name: 'Ahmad Danu',
        nisn: '0061234569',
        className: 'XII Animasi 1',
        avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150',
        phoneClean: '6281200000006',
        status: 'Aktif',
        todayAttendanceIcon: '🌐',
        todayAttendanceText: 'Hadir 08:05 WIB (WFA Studio)',
        journalsAcc: 17,
        journalsPending: 0,
        lastActiveText: 'Hari ini 08:05 WIB'
      },
      {
        id: 7,
        name: 'Putri Maharani',
        nisn: '0061234570',
        className: 'XII Animasi 2',
        avatar: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150',
        phoneClean: '6281200000007',
        status: 'Aktif',
        todayAttendanceIcon: '🟢',
        todayAttendanceText: 'Hadir 07:50 WIB (WFO)',
        journalsAcc: 15,
        journalsPending: 1,
        lastActiveText: 'Hari ini 07:50 WIB'
      }
    ]
  },
  {
    id: 3,
    name: 'Pixel Kreatif Visual Agency',
    shortName: 'Pixel Kreatif (DKV)',
    icon: '🎨',
    major: 'DKV',
    badgeClass: 'bg-amber-50 text-amber-800 border border-amber-200',
    sector: 'Branding, Creative Media & UI/UX',
    address: 'Jl. Pemuda No. 65, Rawamangun, Jakarta Timur',
    workModes: 'WFO, WFA',
    mentor: {
      name: 'Maya Safitri, M.Ds',
      phoneClean: '6281200000031'
    },
    students: [
      {
        id: 8,
        name: 'Rizky Pratama',
        nisn: '0061234571',
        className: 'XII DKV 1',
        avatar: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150',
        phoneClean: '6281200000008',
        status: 'Kritis',
        todayAttendanceIcon: '⚠️',
        todayAttendanceText: '4 Hari Tidak Absen',
        journalsAcc: 10,
        journalsPending: 0,
        lastActiveText: '4 Hari yang lalu'
      },
      {
        id: 9,
        name: 'Jessica Tan',
        nisn: '0061234572',
        className: 'XII DKV 2',
        avatar: 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150',
        phoneClean: '6281200000009',
        status: 'Aktif',
        todayAttendanceIcon: '🏠',
        todayAttendanceText: 'Hadir 07:55 WIB (WFH)',
        journalsAcc: 14,
        journalsPending: 1,
        lastActiveText: 'Hari ini 07:55 WIB'
      }
    ]
  }
])

const displayedCompanies = computed(() => {
  if (selectedCompanyFilter.value === 'all') return companies.value
  return companies.value.filter(c => c.id === selectedCompanyFilter.value)
})

const contactMentor = (name: string, phone: string) => {
  showToast(`Membuka kontak Mentor Lapangan ${name} (${phone})`, 'info')
}

const viewStudentTimeline = (student: any) => {
  showToast(`Membuka lembar timeline jurnal dan rekap presensi untuk ${student.name}`, 'info')
  activeMenu.value = 'monitoring'
}

const fetchGuruDashboard = async () => {
  try {
    const res = await fetch('http://127.0.0.1:8000/api/guru/dashboard', {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${authToken.value}`
      }
    })
    if (res.ok) {
      const data = await res.json()
    }
  } catch (err) {
    // fallback
  }
}

onMounted(() => {
  fetchGuruDashboard()
})
</script>
