<template>
  <div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between pb-4 border-b border-slate-200">
      <div>
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
          <span>🏢 Informasi Penempatan Magang</span>
        </h2>
        <p class="text-xs text-slate-500 mt-1">
          Rincian mitra industri penempatan, kontak pembimbing lapangan, dan dosen/guru pamong.
        </p>
      </div>

      <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-300">
        Status: Aktif Magang (SK No: 421.5/PKL/2026/088)
      </span>
    </div>

    <!-- 1. DETAIL PROFIL PERUSAHAAN (DUDI) - LIGHT FLAT DESIGN -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm relative">
      <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 pb-6 border-b border-slate-200">
        <div class="flex items-center gap-4">
          <!-- Solid Logo TDS (No Gradient) -->
          <div class="w-16 h-16 rounded-2xl bg-rose-600 flex items-center justify-center text-white text-2xl font-black shadow-sm shrink-0">
            TDS
          </div>
          <div>
            <div class="flex items-center gap-2">
              <h3 class="text-xl font-bold text-slate-900">PT Telkom Digital Solusi</h3>
              <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">Mitra Industri Utama</span>
            </div>
            <p class="text-xs text-slate-500 mt-0.5">Software Engineering, Cloud Infrastructure &amp; Microservices Architecture</p>
          </div>
        </div>

        <div class="flex items-center gap-2">
          <a
            href="https://telkomdigital.co.id"
            target="_blank"
            class="px-4 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-xl text-xs font-bold border border-indigo-200 transition flex items-center gap-1.5 shadow-sm"
          >
            <span>🌐</span> Kunjungi Website Perusahaan
          </a>
        </div>
      </div>

      <!-- Detail Grid Perusahaan -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 text-xs">
        <div>
          <span class="text-slate-500 font-bold block uppercase text-[10px] tracking-wider">Alamat Kantor Magang</span>
          <p class="text-slate-800 mt-1.5 leading-relaxed font-medium">
            Gedung Telkom Landmark Tower Lt. 14<br />
            Jl. Gatot Subroto Kav. 52, Kuningan Barat, Mampang Prapatan, Jakarta Selatan 12710
          </p>
        </div>

        <div>
          <span class="text-slate-500 font-bold block uppercase text-[10px] tracking-wider">Kontak &amp; Departemen</span>
          <p class="text-slate-800 mt-1.5 space-y-1 font-medium">
            <span class="block">📞 Telepon: (021) 5299-1000</span>
            <span class="block">✉️ Email: internship@telkomdigital.co.id</span>
            <span class="block">🏢 Divisi: Core Engineering &amp; Platform SDK</span>
          </p>
        </div>

        <div>
          <span class="text-slate-500 font-bold block uppercase text-[10px] tracking-wider">Periode &amp; Jam Kerja</span>
          <p class="text-slate-800 mt-1.5 space-y-1 font-medium">
            <span class="block">📅 Durasi: 1 Juli 2026 – 27 November 2026 (5 Bulan)</span>
            <span class="block">⏰ Jam Operasional: Senin – Jumat, 08:00 – 17:00 WIB</span>
            <span class="block">👥 Kuota Siswa: 6 Siswa Terplotting</span>
          </p>
        </div>
      </div>
    </div>

    <!-- 2. KONTAK PEMBIMBING DUDI & GURU PEMBIMBING -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Kontak Pembimbing Industri (DUDI) -->
      <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
        <div>
          <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-200">
            <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700">Pembimbing Industri (DUDI)</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">Penilai Utama</span>
          </div>

          <div class="flex items-center gap-4">
            <img
              src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150"
              alt="Hendra Wijaya"
              class="w-14 h-14 rounded-2xl object-cover border-2 border-emerald-500 shadow-sm"
            />
            <div>
              <h4 class="text-base font-bold text-slate-900">Hendra Wijaya, S.Kom</h4>
              <p class="text-xs text-slate-500">Senior Engineering Lead &amp; Mentor PKL</p>
              <span class="inline-block mt-1 font-mono text-[11px] text-emerald-700 font-bold">ID Pegawai: ID-TELKOM-8821</span>
            </div>
          </div>

          <div class="mt-5 space-y-2 text-xs text-slate-800 bg-slate-50 p-4 rounded-xl border border-slate-200">
            <div class="flex items-center justify-between">
              <span class="text-slate-500 font-medium">WhatsApp / HP:</span>
              <span class="font-mono font-bold text-slate-900">0811-2233-4455</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-slate-500 font-medium">Email Kerja:</span>
              <span class="font-mono text-slate-900 font-medium">hendra.w@telkomdigital.co.id</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-slate-500 font-medium">Hari Bimbingan:</span>
              <span class="text-slate-800 font-semibold">Setiap Jumat (Review Sprint)</span>
            </div>
          </div>
        </div>

        <div class="mt-5 pt-3">
          <a
            href="https://wa.me/6281122334455"
            target="_blank"
            class="w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition flex items-center justify-center gap-2 shadow-sm"
          >
            <span>💬</span> Hubungi Pembimbing DUDI via WhatsApp
          </a>
        </div>
      </div>

      <!-- Kontak Guru Pembimbing (Sekolah) -->
      <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
        <div>
          <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-200">
            <span class="text-[11px] font-bold uppercase tracking-wider text-amber-700">Guru Pembimbing Sekolah</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200">Fasilitator Akademik</span>
          </div>

          <div class="flex items-center gap-4">
            <img
              src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150"
              alt="Nurul Hidayah"
              class="w-14 h-14 rounded-2xl object-cover border-2 border-amber-500 shadow-sm"
            />
            <div>
              <h4 class="text-base font-bold text-slate-900">Dra. Nurul Hidayah, M.Pd</h4>
              <p class="text-xs text-slate-500">Guru Kejuruan Rekayasa Perangkat Lunak</p>
              <span class="inline-block mt-1 font-mono text-[11px] text-amber-700 font-bold">NIP: 198005122005012003</span>
            </div>
          </div>

          <div class="mt-5 space-y-2 text-xs text-slate-800 bg-slate-50 p-4 rounded-xl border border-slate-200">
            <div class="flex items-center justify-between">
              <span class="text-slate-500 font-medium">WhatsApp / HP:</span>
              <span class="font-mono font-bold text-slate-900">0813-9876-5432</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-slate-500 font-medium">Email Sekolah:</span>
              <span class="font-mono text-slate-900 font-medium">nurul.hidayah@smkn1industri.sch.id</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-slate-500 font-medium">Jadwal Monitoring:</span>
              <span class="text-slate-800 font-semibold">Minggu ke-2 &amp; ke-4 setiap bulan</span>
            </div>
          </div>
        </div>

        <div class="mt-5 pt-3">
          <a
            href="https://wa.me/6281398765432"
            target="_blank"
            class="w-full py-2.5 px-4 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold transition flex items-center justify-center gap-2 shadow-sm"
          >
            <span>💬</span> Konsultasi Guru Pembimbing
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
// Information Placement component
</script>
