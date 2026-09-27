<template>
  <div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
      <div>
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
          <span>📈 Dashboard Guru Pembimbing</span>
        </h2>
        <p class="text-xs text-slate-500 mt-1">
          Monitoring keaktifan, kedisiplinan jurnal, dan sistem deteksi dini siswa binaan PKL.
        </p>
      </div>

      <div class="flex items-center gap-2">
        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200">
          Pembimbing: Dra. Nurul Hidayah, M.Pd • 4 Siswa Binaan
        </span>
      </div>
    </div>

    <!-- PERINGATAN SISTEM (RED ALERT DETEKSI DINI TIDAK AKTIF > 3 HARI) -->
    <div class="p-5 rounded-2xl bg-rose-50 border-2 border-rose-300 shadow-sm relative overflow-hidden">
      <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="flex items-start gap-4">
          <div class="w-12 h-12 rounded-2xl bg-rose-600 text-white flex items-center justify-center text-2xl shrink-0 shadow-sm">
            🚨
          </div>
          <div>
            <div class="flex items-center gap-2">
              <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-rose-600 text-white">
                PERINGATAN SISTEM KRITIS
              </span>
              <span class="text-xs font-mono text-rose-700 font-semibold">Deteksi Absensi > 3 Hari</span>
            </div>
            <h3 class="text-base font-bold text-rose-950 mt-1">
              Siswa <span class="text-rose-700 underline font-extrabold">Rizky Pratama</span> Tidak Mengisi Jurnal &amp; Absen Selama 4 Hari Berturut-turut!
            </h3>
            <p class="text-xs text-rose-800 mt-0.5">
              Penempatan: <strong>PT Inovasi Media Kreatif (Bandung)</strong> • Terakhir aktif tercatat pada 21 September 2026.
            </p>
          </div>
        </div>

        <!-- Tombol Tindakan Cepat Guru -->
        <div class="flex items-center gap-2.5 shrink-0">
          <a
            href="https://wa.me/6285734567890"
            target="_blank"
            class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm active:scale-95"
          >
            <span>📞</span> Hubungi Siswa Segera
          </a>
          <button
            @click="openContactCompany"
            class="px-4 py-2 bg-white hover:bg-rose-100 text-rose-800 rounded-xl text-xs font-semibold border border-rose-300 transition active:scale-95"
          >
            Hubungi Mentor DUDI
          </button>
        </div>
      </div>
    </div>

    <!-- GRAFIK KEAKTIFAN SELURUH SISWA BINAAN -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
      <!-- Grafik Tren Mingguan (8 Cols) -->
      <div class="lg:col-span-8 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200">
          <div>
            <h3 class="text-sm font-bold text-slate-900">Grafik Keaktifan Presensi &amp; Pengisian Logbook Siswa</h3>
            <p class="text-[11px] text-slate-500">Komparasi tingkat kehadiran vs ketuntasan jurnal mingguan</p>
          </div>
          <div class="flex items-center gap-3 text-xs">
            <span class="flex items-center gap-1.5 text-slate-700">
              <span class="w-3 h-3 rounded-full bg-emerald-600"></span> Presensi Hadir
            </span>
            <span class="flex items-center gap-1.5 text-slate-700">
              <span class="w-3 h-3 rounded-full bg-indigo-600"></span> Jurnal Terisi
            </span>
          </div>
        </div>

        <!-- Simulated Bar Chart Visualizer -->
        <div class="space-y-4 pt-2">
          <div v-for="day in weekChart" :key="day.day" class="space-y-1.5">
            <div class="flex items-center justify-between text-xs">
              <span class="font-bold text-slate-800 font-mono">{{ day.day }}</span>
              <span class="text-slate-500 font-mono text-[11px]">Hadir: {{ day.att }}% | Jurnal: {{ day.log }}%</span>
            </div>
            <!-- Double Progress Bar -->
            <div class="space-y-1">
              <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                <div class="bg-emerald-600 h-2.5 rounded-full transition-all duration-500" :style="{ width: day.att + '%' }"></div>
              </div>
              <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                <div class="bg-indigo-600 h-2.5 rounded-full transition-all duration-500" :style="{ width: day.log + '%' }"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Ringkasan Status Siswa Binaan (4 Cols) -->
      <div class="lg:col-span-4 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
        <div>
          <h3 class="text-sm font-bold text-slate-900 pb-3 border-b border-slate-200">
            Status Keaktifan Siswa
          </h3>

          <div class="mt-4 space-y-3.5">
            <div
              v-for="s in studentsActivity"
              :key="s.name"
              class="p-3 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between"
            >
              <div class="flex items-center gap-3">
                <img :src="s.avatar" class="w-9 h-9 rounded-xl object-cover border border-slate-200" />
                <div>
                  <h4 class="text-xs font-bold text-slate-900">{{ s.name }}</h4>
                  <div class="text-[10px] text-slate-500">{{ s.company }}</div>
                </div>
              </div>

              <div class="text-right">
                <span
                  v-if="s.status === 'Aktif'"
                  class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200"
                >
                  🟢 Aktif
                </span>
                <span
                  v-else
                  class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200"
                >
                  🔴 Kritis
                </span>
                <span class="block text-[9px] text-slate-500 mt-0.5 font-mono">{{ s.lastActive }}</span>
              </div>
            </div>
          </div>
        </div>

        <div class="pt-4 border-t border-slate-200 mt-4">
          <button
            @click="goToMonitoring"
            class="w-full py-2.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold transition text-center shadow-sm"
          >
            Lihat Timeline Monitoring Lengkap &rarr;
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useAppStore } from '~/composables/useAppStore'

const { activeMenu, showToast } = useAppStore()

const weekChart = ref([
  { day: 'Senin, 22 Sep', att: 100, log: 95 },
  { day: 'Selasa, 23 Sep', att: 100, log: 100 },
  { day: 'Rabu, 24 Sep', att: 90, log: 85 },
  { day: 'Kamis, 25 Sep', att: 95, log: 90 },
  { day: 'Jumat, 26 Sep', att: 75, log: 70 },
])

const studentsActivity = ref([
  { name: 'Budi Santoso', company: 'PT Telkom Digital Solusi', status: 'Aktif', lastActive: 'Hari ini 07:35', avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150' },
  { name: 'Siti Rahma', company: 'PT Telkom Digital Solusi', status: 'Aktif', lastActive: 'Hari ini 07:42', avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150' },
  { name: 'Dewi Anggraeni', company: 'Bank Mandiri IT Hub', status: 'Aktif', lastActive: 'Hari ini 07:30', avatar: 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150' },
  { name: 'Rizky Pratama', company: 'PT Inovasi Media Kreatif', status: 'Kritis', lastActive: '4 hari lalu', avatar: 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=150' },
])

const openContactCompany = () => {
  showToast('Menghubungi PIC Industri Linda Kusuma (PT Inovasi Media Kreatif): 0811-9988-7766', 'info')
}

const goToMonitoring = () => {
  activeMenu.value = 'monitoring'
}
</script>
