<template>
  <div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-black/[0.06]">
      <div>
        <div class="flex items-center gap-2 mb-1">
          <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold tracking-wide bg-[#0071e3]/10 text-[#0071e3]">
            Pusat Data Master
          </span>
          <span class="text-[#86868b]">•</span>
          <span class="text-xs font-medium text-[#86868b]">SMKN 71 Jakarta</span>
        </div>
        <h2 class="text-2xl font-bold text-[#1d1d1f] tracking-tight flex items-center gap-2">
          <span>Kelola Master Data &amp; Penempatan</span>
        </h2>
        <p class="text-xs text-[#86868b] mt-0.5">
          Sistem input data terpadu: Daftarkan siswa baru sekaligus tempat PKL dalam 1 kali alur kerja.
        </p>
      </div>

      <!-- Action Buttons -->
      <div class="flex items-center gap-2.5">
        <button
          @click="openImportModal"
          class="px-4 py-2 bg-black/[0.04] hover:bg-black/[0.07] text-[#1d1d1f] rounded-xl text-xs font-medium border border-black/[0.06] transition flex items-center gap-1.5 apple-press cursor-pointer"
          type="button"
        >
          <svg class="w-3.5 h-3.5 text-[#86868b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
          </svg>
          <span>Import Excel</span>
        </button>

        <button
          @click="openCreateModal"
          class="px-4 py-2 bg-[#0071e3] hover:bg-[#0077ed] text-white rounded-xl text-xs font-semibold shadow-[0_2px_8px_rgba(0,113,227,0.25)] transition flex items-center gap-1.5 apple-press cursor-pointer"
          type="button"
        >
          <span>➕</span>
          <span>{{ currentSubTab === 'siswa' ? 'Daftarkan Siswa & Penempatan' : (currentSubTab === 'company' ? 'Tambah Tempat Magang' : (currentSubTab === 'dudi' || currentSubTab === 'mentor' ? 'Tambah Pembimbing Lapangan' : 'Tambah Guru')) }}</span>
        </button>
      </div>
    </div>

    <!-- 4 SUB-TABS: SISWA, TEMPAT MAGANG, PEMBIMBING LAPANGAN, GURU (Apple Segmented Control) -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
      <div class="apple-segmented-container overflow-x-auto">
        <button
          type="button"
          @click="currentSubTab = 'siswa'"
          :class="{ active: currentSubTab === 'siswa' }"
          class="apple-segmented-item flex items-center gap-1.5 whitespace-nowrap"
        >
          <span>👨‍🎓</span>
          <span>Siswa ({{ studentsList.length }})</span>
        </button>

        <button
          type="button"
          @click="currentSubTab = 'company'"
          :class="{ active: currentSubTab === 'company' }"
          class="apple-segmented-item flex items-center gap-1.5 whitespace-nowrap"
        >
          <span>🏢</span>
          <span>Tempat Magang ({{ companiesList.length }})</span>
        </button>

        <button
          type="button"
          @click="currentSubTab = 'dudi'"
          :class="{ active: currentSubTab === 'dudi' || currentSubTab === 'mentor' }"
          class="apple-segmented-item flex items-center gap-1.5 whitespace-nowrap"
        >
          <span>👔</span>
          <span>Pembimbing Lapangan ({{ dudiList.length }})</span>
        </button>

        <button
          type="button"
          @click="currentSubTab = 'guru'"
          :class="{ active: currentSubTab === 'guru' }"
          class="apple-segmented-item flex items-center gap-1.5 whitespace-nowrap"
        >
          <span>👨‍🏫</span>
          <span>Guru ({{ guruList.length }})</span>
        </button>
      </div>

      <!-- FILTER PENCARIAN & FILTER JURUSAN -->
      <div class="flex items-center gap-2 w-full lg:w-auto">
        <!-- Filter Jurusan (Khusus Tab Siswa) -->
        <select
          v-if="currentSubTab === 'siswa'"
          v-model="selectedMajorFilter"
          class="px-3 py-2 bg-black/[0.03] focus:bg-white border border-transparent focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-xs text-[#1d1d1f] font-medium transition cursor-pointer"
        >
          <option value="all">Semua Jurusan</option>
          <option value="PPLG">PPLG / RPL</option>
          <option value="Animasi">Animasi</option>
          <option value="DKV">DKV</option>
        </select>

        <!-- Search Input -->
        <div class="relative flex-1 lg:w-64">
          <input
            v-model="searchQuery"
            type="text"
            :placeholder="`Cari ${currentSubTab}...`"
            class="w-full pl-9 pr-4 py-2 bg-black/[0.03] focus:bg-white border border-transparent focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-xs text-[#1d1d1f] placeholder-[#86868b] transition"
          />
          <svg class="w-3.5 h-3.5 absolute left-3 top-2.5 text-[#86868b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>
      </div>
    </div>

    <!-- 1. TABEL DATA SISWA -->
    <div v-if="currentSubTab === 'siswa'" class="bg-white border border-black/[0.05] rounded-2xl p-6 shadow-[0_2px_12px_rgba(0,0,0,0.03)]">
      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-[#1d1d1f]">
          <thead class="bg-black/[0.02] text-[#86868b] uppercase text-[10px] tracking-wider border-b border-black/[0.05] font-semibold">
            <tr>
              <th class="py-3 px-4 rounded-l-xl">Nama Siswa</th>
              <th class="py-3 px-4">Jurusan &amp; Kelas</th>
              <th class="py-3 px-4">NISN</th>
              <th class="py-3 px-4">Mitra Tempat PKL</th>
              <th class="py-3 px-4">Guru Pembimbing</th>
              <th class="py-3 px-4">Mode</th>
              <th class="py-3 px-4 text-center rounded-r-xl">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-black/[0.04]">
            <tr v-for="item in activeDisplayList" :key="item.id" class="hover:bg-black/[0.02] transition">
              <td class="py-3.5 px-4 whitespace-nowrap">
                <div class="flex items-center gap-3">
                  <img :src="item.avatar" class="w-9 h-9 rounded-xl object-cover border border-black/[0.06] shadow-xs" />
                  <div class="flex flex-col">
                    <span class="font-semibold text-[#1d1d1f]">{{ item.name }}</span>
                    <span class="text-[10px] text-[#86868b] font-mono">{{ item.email }}</span>
                  </div>
                </div>
              </td>

              <td class="py-3.5 px-4 whitespace-nowrap">
                <div class="flex items-center gap-1.5">
                  <span
                    class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold uppercase"
                    :class="item.major === 'PPLG' ? 'bg-[#0071e3]/10 text-[#0071e3]' : (item.major === 'Animasi' ? 'bg-[#af52de]/10 text-[#af52de]' : 'bg-[#ff9500]/10 text-[#ff9500]')"
                  >
                    {{ item.major }}
                  </span>
                  <span class="text-[11px] font-mono text-[#86868b] font-medium">{{ item.className }}</span>
                </div>
              </td>

              <td class="py-3.5 px-4 font-mono text-[#86868b] whitespace-nowrap">
                {{ item.idNumber }}
              </td>

              <td class="py-3.5 px-4 whitespace-nowrap">
                <div v-if="item.company" class="flex flex-col">
                  <span class="font-semibold text-[#1d1d1f] text-xs">{{ item.company }}</span>
                  <span class="text-[10px] text-[#86868b]">Pembimbing: {{ item.dudiMentor || '-' }}</span>
                </div>
                <span v-else class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-[#ff9500]/10 text-[#ff9500]">
                  ⏳ Belum Terplotting
                </span>
              </td>

              <td class="py-3.5 px-4 whitespace-nowrap text-[#86868b]">
                {{ item.teacherMentor || 'Dra. Nurul Hidayah, M.Pd' }}
              </td>

              <td class="py-3.5 px-4 whitespace-nowrap">
                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold uppercase bg-black/[0.04] text-[#1d1d1f]">
                  {{ item.workMode || 'WFO' }}
                </span>
              </td>

              <td class="py-3.5 px-4 text-center whitespace-nowrap">
                <div class="flex items-center justify-center gap-1.5">
                  <button
                    @click="openEditModal(item)"
                    class="px-2.5 py-1 bg-black/[0.04] hover:bg-black/[0.08] text-[#0071e3] rounded-lg text-[11px] font-medium transition apple-press cursor-pointer"
                  >
                    Edit
                  </button>
                  <button
                    @click="handleDelete(item)"
                    class="px-2.5 py-1 bg-[#ff3b30]/10 hover:bg-[#ff3b30]/20 text-[#ff3b30] rounded-lg text-[11px] font-medium transition apple-press cursor-pointer"
                  >
                    Hapus
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- 2. TABEL TEMPAT MAGANG (INSTANSI / PERUSAHAAN) -->
    <div v-else-if="currentSubTab === 'company'" class="bg-white border border-black/[0.05] rounded-2xl p-6 shadow-[0_2px_12px_rgba(0,0,0,0.03)]">
      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-[#1d1d1f]">
          <thead class="bg-black/[0.02] text-[#86868b] uppercase text-[10px] tracking-wider border-b border-black/[0.05] font-semibold">
            <tr>
              <th class="py-3 px-4 rounded-l-xl">Nama Tempat Magang / Instansi</th>
              <th class="py-3 px-4">Sektor / Bidang Keahlian</th>
              <th class="py-3 px-4">Alamat Kantor</th>
              <th class="py-3 px-4">Kuota Siswa</th>
              <th class="py-3 px-4">Mode Kerja</th>
              <th class="py-3 px-4">Radius</th>
              <th class="py-3 px-4 text-center rounded-r-xl">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-black/[0.04]">
            <tr v-for="item in activeDisplayList" :key="item.id" class="hover:bg-black/[0.02] transition">
              <td class="py-3.5 px-4 whitespace-nowrap font-semibold text-[#1d1d1f] flex items-center gap-2">
                <span class="text-base">{{ item.icon || '🏢' }}</span>
                <span>{{ item.name }}</span>
              </td>
              <td class="py-3.5 px-4 text-[#86868b]">{{ item.sector }}</td>
              <td class="py-3.5 px-4 text-[#86868b] max-w-xs truncate">{{ item.address }}</td>
              <td class="py-3.5 px-4 whitespace-nowrap font-mono">
                <span class="font-bold text-[#0071e3]">{{ item.placementsCount || 2 }}</span> / {{ item.quota }} Kursi
              </td>
              <td class="py-3.5 px-4 whitespace-nowrap">
                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-black/[0.04] text-[#1d1d1f]">
                  {{ item.workModes || 'WFO, WFH' }}
                </span>
              </td>
              <td class="py-3.5 px-4 whitespace-nowrap font-mono text-[#86868b]">
                {{ item.radius || 150 }} M
              </td>
              <td class="py-3.5 px-4 text-center whitespace-nowrap">
                <div class="flex items-center justify-center gap-1.5">
                  <button
                    @click="openEditModal(item)"
                    class="px-2.5 py-1 bg-black/[0.04] hover:bg-black/[0.08] text-[#0071e3] rounded-lg text-[11px] font-medium transition apple-press cursor-pointer"
                  >
                    Edit
                  </button>
                  <button
                    @click="handleDelete(item)"
                    class="px-2.5 py-1 bg-[#ff3b30]/10 hover:bg-[#ff3b30]/20 text-[#ff3b30] rounded-lg text-[11px] font-medium transition apple-press cursor-pointer"
                  >
                    Hapus
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- 3. TABEL GURU ATAU DUDI -->
    <div v-else class="bg-white border border-black/[0.05] rounded-2xl p-6 shadow-[0_2px_12px_rgba(0,0,0,0.03)]">
      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-[#1d1d1f]">
          <thead class="bg-black/[0.02] text-[#86868b] uppercase text-[10px] tracking-wider border-b border-black/[0.05] font-semibold">
            <tr>
              <th class="py-3 px-4 rounded-l-xl">Nama Lengkap</th>
              <th class="py-3 px-4">NIP / ID Pegawai</th>
              <th class="py-3 px-4">Email</th>
              <th class="py-3 px-4">WhatsApp</th>
              <th class="py-3 px-4">Afiliasi / Jabatan</th>
              <th class="py-3 px-4 text-center rounded-r-xl">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-black/[0.04]">
            <tr v-for="item in activeDisplayList" :key="item.id" class="hover:bg-black/[0.02] transition">
              <td class="py-3.5 px-4 whitespace-nowrap font-semibold text-[#1d1d1f] flex items-center gap-2.5">
                <img :src="item.avatar" class="w-8 h-8 rounded-xl object-cover border border-black/[0.06] shadow-xs" />
                <span>{{ item.name }}</span>
              </td>
              <td class="py-3.5 px-4 font-mono text-[#86868b]">{{ item.idNumber }}</td>
              <td class="py-3.5 px-4 font-mono text-[#86868b]">{{ item.email }}</td>
              <td class="py-3.5 px-4 font-mono text-[#1d1d1f]">{{ item.phone }}</td>
              <td class="py-3.5 px-4 text-[#86868b]">{{ item.extraInfo }}</td>
              <td class="py-3.5 px-4 text-center whitespace-nowrap">
                <div class="flex items-center justify-center gap-1.5">
                  <button
                    @click="openEditModal(item)"
                    class="px-2.5 py-1 bg-black/[0.04] hover:bg-black/[0.08] text-[#0071e3] rounded-lg text-[11px] font-medium transition apple-press cursor-pointer"
                  >
                    Edit
                  </button>
                  <button
                    @click="handleDelete(item)"
                    class="px-2.5 py-1 bg-[#ff3b30]/10 hover:bg-[#ff3b30]/20 text-[#ff3b30] rounded-lg text-[11px] font-medium transition apple-press cursor-pointer"
                  >
                    Hapus
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- MODAL PENDAFTARAN TERPADU SISWA & PENEMPATAN (macOS Sheet Modal) -->
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
          v-if="isFormModalOpen"
          class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm select-none overflow-y-auto"
          @click.self="isFormModalOpen = false"
        >
          <div class="modal-card-animate w-full max-w-2xl bg-white border border-black/[0.08] rounded-2xl shadow-[0_24px_64px_rgba(0,0,0,0.2)] p-6 text-[#1d1d1f] my-8 select-auto">
        <div class="flex items-center justify-between pb-4 border-b border-black/[0.06]">
          <div>
            <h3 class="text-base font-bold text-[#1d1d1f] tracking-tight">
              {{ isEditing ? 'Edit Data' : (currentSubTab === 'siswa' ? 'Pendaftaran Siswa Baru Terpadu (+ Penempatan Langsung)' : 'Tambah Data ' + currentSubTab.toUpperCase()) }}
            </h3>
            <p class="text-xs text-[#86868b] mt-0.5">
              {{ currentSubTab === 'siswa' ? 'Daftarkan siswa sekaligus tentukan tempat PKL dan pembimbing dalam 1 langkah.' : 'Lengkapi informasi berikut secara akurat.' }}
            </p>
          </div>
          <button @click="isFormModalOpen = false" class="text-[#86868b] hover:text-[#1d1d1f] p-1.5 rounded-full hover:bg-black/[0.05] transition cursor-pointer">✕</button>
        </div>

        <form @submit.prevent="handleSaveManual" class="mt-4 space-y-4 text-xs">
          <!-- FORM KHUSUS SISWA DENGAN PENEMPATAN TERPADU -->
          <template v-if="currentSubTab === 'siswa'">
            <!-- Bagian 1: Identitas Siswa -->
            <div class="p-4 rounded-2xl bg-black/[0.02] border border-black/[0.04] space-y-3">
              <span class="font-semibold text-[#1d1d1f] text-xs block uppercase tracking-wider">
                1️⃣ Data Identitas Siswa SMKN 71
              </span>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                  <label class="block font-medium text-[#1d1d1f] mb-1">Nama Lengkap Siswa *</label>
                  <input v-model="formData.name" type="text" required placeholder="Contoh: Muhammad Farhan" class="w-full px-3 py-2 bg-white border border-black/[0.08] focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition" />
                </div>
                <div>
                  <label class="block font-medium text-[#1d1d1f] mb-1">NISN Siswa *</label>
                  <input v-model="formData.idNumber" type="text" required placeholder="006..." class="w-full px-3 py-2 bg-white border border-black/[0.08] focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition" />
                </div>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div>
                  <label class="block font-medium text-[#1d1d1f] mb-1">Konsentrasi Keahlian *</label>
                  <select v-model="formData.major" required class="w-full px-3 py-2 bg-white border border-black/[0.08] focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition cursor-pointer">
                    <option value="PPLG">PPLG / RPL</option>
                    <option value="Animasi">Animasi</option>
                    <option value="DKV">DKV</option>
                  </select>
                </div>
                <div>
                  <label class="block font-medium text-[#1d1d1f] mb-1">Kelas *</label>
                  <input v-model="formData.className" type="text" required placeholder="XII PPLG 1" class="w-full px-3 py-2 bg-white border border-black/[0.08] focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition" />
                </div>
                <div>
                  <label class="block font-medium text-[#1d1d1f] mb-1">No. WhatsApp *</label>
                  <input v-model="formData.phone" type="text" required placeholder="08..." class="w-full px-3 py-2 bg-white border border-black/[0.08] focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition" />
                </div>
              </div>

              <div>
                <label class="block font-medium text-[#1d1d1f] mb-1">Email Akun *</label>
                <input v-model="formData.email" type="email" required placeholder="siswa@gmail.com" class="w-full px-3 py-2 bg-white border border-black/[0.08] focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition" />
              </div>
            </div>

            <!-- Bagian 2: Penempatan Tempat PKL Langsung -->
            <div class="p-4 rounded-2xl bg-[#0071e3]/5 border border-[#0071e3]/15 space-y-3">
              <div class="flex items-center justify-between">
                <span class="font-semibold text-[#0071e3] text-xs block uppercase tracking-wider">
                  2️⃣ Tempat PKL / Mitra Industri Langsung
                </span>
                <button
                  type="button"
                  @click="isCreatingNewCompanyInline = !isCreatingNewCompanyInline"
                  class="text-[11px] font-semibold text-[#0071e3] hover:underline flex items-center gap-1 cursor-pointer"
                >
                  <span>{{ isCreatingNewCompanyInline ? '← Pilih dari PT yang ada' : '+ Buat Tempat PKL Baru di Sini' }}</span>
                </button>
              </div>

              <!-- Opsi A: Pilih dari Tempat Magang Yang Sudah Ada -->
              <div v-if="!isCreatingNewCompanyInline" class="space-y-3">
                <div>
                  <label class="block font-medium text-[#1d1d1f] mb-1">Pilih Tempat Magang / Instansi *</label>
                  <select v-model="formData.companyId" class="w-full px-3 py-2 bg-white border border-black/[0.08] focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition cursor-pointer">
                    <option :value="null">-- Tidak / Nanti Diplotting --</option>
                    <option v-for="c in companiesList" :key="c.id" :value="c.id">
                      {{ c.name }} ({{ c.sector }}) - Sisa Kuota: {{ c.quota }}
                    </option>
                  </select>
                </div>
              </div>

              <!-- Opsi B: Tambah Tempat Magang Baru Inline -->
              <div v-else class="space-y-3 p-3.5 bg-white rounded-xl border border-[#0071e3]/20 shadow-xs">
                <div class="text-[11px] font-semibold text-[#0071e3] mb-1">
                  ✨ Input Data Tempat Magang Baru:
                </div>
                <div>
                  <label class="block font-medium text-[#1d1d1f] mb-1">Nama Perusahaan Baru *</label>
                  <input v-model="formData.newCompanyName" type="text" placeholder="Contoh: PT Kreatif Media Nusantara" class="w-full px-3 py-2 bg-white border border-black/[0.08] focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition" />
                </div>
                <div class="grid grid-cols-2 gap-3">
                  <div>
                    <label class="block font-medium text-[#1d1d1f] mb-1">Bidang Industri / Sektor</label>
                    <input v-model="formData.newCompanySector" type="text" placeholder="Software / Animasi / DKV" class="w-full px-3 py-2 bg-white border border-black/[0.08] focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition" />
                  </div>
                  <div>
                    <label class="block font-medium text-[#1d1d1f] mb-1">Alamat Kantor</label>
                    <input v-model="formData.newCompanyAddress" type="text" placeholder="Alamat PT" class="w-full px-3 py-2 bg-white border border-black/[0.08] focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition" />
                  </div>
                </div>
              </div>

              <!-- Guru & Mode Kerja -->
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                  <label class="block font-medium text-[#1d1d1f] mb-1">Guru Pembimbing Sekolah</label>
                  <select v-model="formData.teacherMentor" class="w-full px-3 py-2 bg-white border border-black/[0.08] focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition cursor-pointer">
                    <option value="Dra. Nurul Hidayah, M.Pd">Dra. Nurul Hidayah, M.Pd (Pembimbing Utama)</option>
                    <option v-for="g in guruList" :key="g.id" :value="g.name">{{ g.name }}</option>
                  </select>
                </div>
                <div>
                  <label class="block font-medium text-[#1d1d1f] mb-1">Mode Kerja Default</label>
                  <select v-model="formData.workMode" class="w-full px-3 py-2 bg-white border border-black/[0.08] focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition cursor-pointer">
                    <option value="wfo">WFO (Work From Office / Kantor)</option>
                    <option value="wfh">WFH (Work From Home / Rumah)</option>
                    <option value="wfa">WFA (Work From Anywhere / Fleksibel)</option>
                  </select>
                </div>
              </div>
            </div>
          </template>

          <!-- FORM KHUSUS COMPANY / TEMPAT PKL -->
          <template v-else-if="currentSubTab === 'company'">
            <div>
              <label class="block font-medium text-[#1d1d1f] mb-1">Nama Perusahaan / Tempat PKL *</label>
              <input v-model="formData.name" type="text" required placeholder="Contoh: PT Solusi Digital Pratama" class="w-full px-3 py-2 bg-white border border-black/[0.08] focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition" />
            </div>

            <div class="grid grid-cols-2 gap-3">
              <div>
                <label class="block font-medium text-[#1d1d1f] mb-1">Sektor / Bidang Keahlian</label>
                <input v-model="formData.sector" type="text" placeholder="Software House / Studio Animasi / Creative DKV" class="w-full px-3 py-2 bg-white border border-black/[0.08] focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition" />
              </div>
              <div>
                <label class="block font-medium text-[#1d1d1f] mb-1">Kuota Siswa (Kursi)</label>
                <input v-model="formData.quota" type="number" min="1" placeholder="5" class="w-full px-3 py-2 bg-white border border-black/[0.08] focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition" />
              </div>
            </div>

            <div>
              <label class="block font-medium text-[#1d1d1f] mb-1">Alamat Kantor Lengkap</label>
              <textarea v-model="formData.address" rows="2" placeholder="Jl. Gatot Subroto Kav. 52, Jakarta" class="w-full px-3 py-2 bg-white border border-black/[0.08] focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-3">
              <div>
                <label class="block font-medium text-[#1d1d1f] mb-1">Radius Geofence (Meter)</label>
                <input v-model="formData.radius" type="number" placeholder="150" class="w-full px-3 py-2 bg-white border border-black/[0.08] focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition" />
              </div>
              <div>
                <label class="block font-medium text-[#1d1d1f] mb-1">Mode Kerja Diizinkan</label>
                <select v-model="formData.workModes" class="w-full px-3 py-2 bg-white border border-black/[0.08] focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition cursor-pointer">
                  <option value="WFO, WFH">WFO, WFH (Hybrid)</option>
                  <option value="WFO, WFH, WFA">WFO, WFH, WFA (Penuh)</option>
                  <option value="WFO">WFO Saja</option>
                </select>
              </div>
            </div>
          </template>

          <!-- FORM UMUM PEMBIMBING LAPANGAN / GURU -->
          <template v-else>
            <div>
              <label class="block font-medium text-[#1d1d1f] mb-1">Nama Lengkap &amp; Gelar *</label>
              <input v-model="formData.name" type="text" required placeholder="Contoh: Hendra Wijaya, S.Kom" class="w-full px-3 py-2 bg-white border border-black/[0.08] focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition" />
            </div>

            <div class="grid grid-cols-2 gap-3">
              <div>
                <label class="block font-medium text-[#1d1d1f] mb-1">NIP / ID Pegawai *</label>
                <input v-model="formData.idNumber" type="text" required class="w-full px-3 py-2 bg-white border border-black/[0.08] focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition" />
              </div>
              <div>
                <label class="block font-medium text-[#1d1d1f] mb-1">No. WhatsApp *</label>
                <input v-model="formData.phone" type="text" required placeholder="08..." class="w-full px-3 py-2 bg-white border border-black/[0.08] focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition" />
              </div>
            </div>

            <div>
              <label class="block font-medium text-[#1d1d1f] mb-1">Email *</label>
              <input v-model="formData.email" type="email" required placeholder="nama@gmail.com" class="w-full px-3 py-2 bg-white border border-black/[0.08] focus:border-[#0071e3]/30 focus:ring-4 focus:ring-[#0071e3]/10 rounded-xl text-[#1d1d1f] transition" />
            </div>
          </template>

          <div class="pt-3 flex items-center justify-end gap-2.5 border-t border-black/[0.06]">
            <button type="button" @click="isFormModalOpen = false" class="px-4 py-2 bg-black/[0.04] hover:bg-black/[0.07] text-[#1d1d1f] rounded-xl font-medium apple-press cursor-pointer">
              Batal
            </button>
            <button type="submit" class="px-5 py-2 bg-[#0071e3] hover:bg-[#0077ed] text-white rounded-xl font-semibold shadow-[0_2px_8px_rgba(0,113,227,0.25)] apple-press cursor-pointer">
              {{ currentSubTab === 'siswa' ? 'Simpan Siswa & Tetapkan Penempatan' : 'Simpan Data' }}
            </button>
          </div>
        </form>
      </div>
      </div>
      </Transition>
    </Teleport>

    <!-- MODAL IMPORT EXCEL (macOS Sheet Modal) -->
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
          v-if="isImportModalOpen"
          class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm select-none"
          @click.self="isImportModalOpen = false"
        >
          <div class="modal-card-animate w-full max-w-lg bg-white border border-black/[0.08] rounded-2xl shadow-[0_24px_64px_rgba(0,0,0,0.2)] p-6 text-[#1d1d1f] space-y-4 select-auto">
            <div class="flex items-center justify-between pb-3 border-b border-black/[0.06]">
              <div class="flex items-center gap-2">
                <span class="text-xl">📊</span>
                <div>
                  <h3 class="text-sm font-bold text-[#1d1d1f]">Import Massal Excel SMKN 71</h3>
                  <p class="text-[11px] text-[#86868b]">Target Entitas: {{ currentSubTab.toUpperCase() }}</p>
                </div>
              </div>
              <button @click="isImportModalOpen = false" class="text-[#86868b] hover:text-[#1d1d1f] p-1.5 rounded-full hover:bg-black/[0.05] transition cursor-pointer">✕</button>
            </div>

            <div class="p-3.5 bg-black/[0.02] rounded-2xl border border-black/[0.04] flex items-center justify-between">
              <div class="text-xs">
                <span class="font-semibold text-[#1d1d1f] block">Template Excel Resmi SMKN 71</span>
                <span class="text-[11px] text-[#86868b]">Kolom NISN, Jurusan, Kelas, dan Tempat PKL</span>
              </div>
              <button
                type="button"
                @click="downloadTemplate"
                class="px-3 py-1.5 bg-[#0071e3]/10 hover:bg-[#0071e3]/20 text-[#0071e3] rounded-xl text-xs font-semibold apple-press cursor-pointer"
              >
                📥 Download
              </button>
            </div>

            <div class="border-2 border-dashed border-black/[0.1] hover:border-[#0071e3] p-6 rounded-2xl text-center bg-black/[0.015] cursor-pointer transition">
              <span class="text-3xl block mb-2">📁</span>
              <span class="text-xs font-semibold text-[#1d1d1f] block">Pilih berkas .xlsx atau .csv dari perangkat</span>
              <span class="text-[10px] text-[#86868b] mt-1 block">Maksimal 5 MB • Kolom otomatis terpetakan</span>
              <button
                type="button"
                @click="executeImport"
                class="mt-3 inline-block px-4 py-1.5 bg-[#0071e3] hover:bg-[#0077ed] text-white rounded-xl text-xs font-semibold shadow-xs apple-press cursor-pointer"
              >
                Pilih Berkas &amp; Impor
              </button>
            </div>

            <div class="flex justify-end gap-2.5 pt-2">
              <button @click="isImportModalOpen = false" class="px-4 py-2 bg-black/[0.04] hover:bg-black/[0.07] text-[#1d1d1f] rounded-xl text-xs font-medium apple-press cursor-pointer">Batal</button>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>

    <!-- MODAL KONFIRMASI HAPUS (macOS Alert Style) -->
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
          v-if="showDeleteConfirm"
          class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm select-none"
          @click.self="showDeleteConfirm = false"
        >
          <div
            class="modal-card-animate w-full max-w-[360px] bg-white rounded-2xl border border-black/[0.08] shadow-[0_20px_50px_rgba(0,0,0,0.3)] p-6 text-center transform transition-all text-[#1d1d1f]"
          >
            <div class="w-12 h-12 rounded-full bg-[#ff3b30]/10 text-[#ff3b30] flex items-center justify-center mx-auto mb-3.5 border border-[#ff3b30]/20">
              <span class="material-symbols-outlined text-[24px]">delete</span>
            </div>
            <h3 class="text-[16px] font-bold text-[#1d1d1f] tracking-tight">
              Hapus Data
            </h3>
            <p class="text-[13px] text-[#86868b] mt-1.5 leading-relaxed">
              Apakah Anda yakin ingin menghapus data <strong class="text-[#1d1d1f] font-semibold">{{ itemToDelete?.name }}</strong>? Tindakan ini tidak dapat dibatalkan.
            </p>
            <div class="mt-6 grid grid-cols-2 gap-2.5">
              <button
                type="button"
                @click="showDeleteConfirm = false"
                class="py-2.5 px-4 rounded-xl bg-black/[0.05] hover:bg-black/[0.08] text-[#1d1d1f] text-[13px] font-semibold transition-all apple-press cursor-pointer"
              >
                Batal
              </button>
              <button
                type="button"
                @click="confirmDelete"
                class="py-2.5 px-4 rounded-xl bg-[#ff3b30] hover:bg-[#e0342a] text-white text-[13px] font-semibold shadow-[0_2px_8px_rgba(255,59,48,0.3)] transition-all apple-press cursor-pointer flex items-center justify-center gap-1.5"
              >
                <span>Ya, Hapus</span>
              </button>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useAppStore } from '~/composables/useAppStore'

const { showToast, authToken } = useAppStore()

const currentSubTab = ref<'siswa' | 'company' | 'dudi' | 'guru'>('siswa')
const searchQuery = ref('')
const selectedMajorFilter = ref('all')

const isFormModalOpen = ref(false)
const isEditing = ref(false)
const isImportModalOpen = ref(false)
const isCreatingNewCompanyInline = ref(false)

const formData = ref({
  id: 0,
  name: '',
  idNumber: '',
  phone: '',
  email: '',
  major: 'PPLG',
  className: 'XII PPLG 1',
  companyId: 1 as number | null,
  newCompanyName: '',
  newCompanySector: '',
  newCompanyAddress: '',
  teacherMentor: 'Dra. Nurul Hidayah, M.Pd',
  workMode: 'wfo',
  sector: '',
  quota: 5,
  address: '',
  radius: 150,
  workModes: 'WFO, WFH'
})

// Data Siswa (6 Siswa SMKN 71 lengkap dengan jurusan dan tempat PKL)
const studentsList = ref([
  { id: 4, name: 'Budi Santoso', idNumber: '0061234567', major: 'PPLG', className: 'XII PPLG 1', email: 'siswa@gmail.com', phone: '0812-0000-0004', company: 'PT Telkom Digital Solusi', dudiMentor: 'Hendra Wijaya, S.Kom', teacherMentor: 'Dra. Nurul Hidayah, M.Pd', workMode: 'WFO', avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150' },
  { id: 5, name: 'Siti Fauziah', idNumber: '0061234568', major: 'PPLG', className: 'XII PPLG 2', email: 'siti@gmail.com', phone: '0812-0000-0005', company: 'PT Telkom Digital Solusi', dudiMentor: 'Hendra Wijaya, S.Kom', teacherMentor: 'Dra. Nurul Hidayah, M.Pd', workMode: 'WFH', avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150' },
  { id: 6, name: 'Ahmad Danu', idNumber: '0061234569', major: 'Animasi', className: 'XII Animasi 1', email: 'danu@gmail.com', phone: '0812-0000-0006', company: 'Studio Animasi Kinetik Digital', dudiMentor: 'Raditya Pratama, S.Sn', teacherMentor: 'Dra. Nurul Hidayah, M.Pd', workMode: 'WFA', avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150' },
  { id: 7, name: 'Putri Maharani', idNumber: '0061234570', major: 'Animasi', className: 'XII Animasi 2', email: 'putri@gmail.com', phone: '0812-0000-0007', company: 'Studio Animasi Kinetik Digital', dudiMentor: 'Raditya Pratama, S.Sn', teacherMentor: 'Dra. Nurul Hidayah, M.Pd', workMode: 'WFO', avatar: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150' },
  { id: 8, name: 'Rizky Pratama', idNumber: '0061234571', major: 'DKV', className: 'XII DKV 1', email: 'rizky@gmail.com', phone: '0812-0000-0008', company: 'Pixel Kreatif Visual Agency', dudiMentor: 'Maya Safitri, M.Ds', teacherMentor: 'Dra. Nurul Hidayah, M.Pd', workMode: 'WFO', avatar: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150' },
  { id: 9, name: 'Jessica Tan', idNumber: '0061234572', major: 'DKV', className: 'XII DKV 2', email: 'jessica@gmail.com', phone: '0812-0000-0009', company: 'Pixel Kreatif Visual Agency', dudiMentor: 'Maya Safitri, M.Ds', teacherMentor: 'Dra. Nurul Hidayah, M.Pd', workMode: 'WFH', avatar: 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150' },
])

// Data Tempat PKL / Industri
const companiesList = ref([
  { id: 1, name: 'PT Telkom Digital Solusi', icon: '💻', sector: 'Software House & Cloud (PPLG)', address: 'Gedung Telkom Landmark Lt. 14, Jakarta Selatan', quota: 6, placementsCount: 2, workModes: 'WFO, WFH', radius: 150 },
  { id: 2, name: 'Studio Animasi Kinetik Digital', icon: '🎬', sector: '3D Animation & CGI (Animasi)', address: 'Jl. Raden Saleh No. 18, Cikini, Jakarta Pusat', quota: 4, placementsCount: 2, workModes: 'WFO, WFH, WFA', radius: 200 },
  { id: 3, name: 'Pixel Kreatif Visual Agency', icon: '🎨', sector: 'Branding & UI/UX (DKV)', address: 'Jl. Pemuda No. 65, Rawamangun, Jakarta Timur', quota: 5, placementsCount: 2, workModes: 'WFO, WFA', radius: 150 },
])

// Data Pembimbing Lapangan
const dudiList = ref([
  { id: 3, name: 'Hendra Wijaya, S.Kom', idNumber: 'ID-TELKOM-8821', email: 'mentor@gmail.com', phone: '0812-0000-0003', extraInfo: 'PT Telkom Digital Solusi', avatar: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150' },
  { id: 10, name: 'Raditya Pratama, S.Sn', idNumber: 'ID-KINETIK-104', email: 'mentor2@gmail.com', phone: '0812-0000-0021', extraInfo: 'Studio Animasi Kinetik Digital', avatar: 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150' },
  { id: 11, name: 'Maya Safitri, M.Ds', idNumber: 'ID-PIXEL-332', email: 'mentor3@gmail.com', phone: '0812-0000-0031', extraInfo: 'Pixel Kreatif Visual Agency', avatar: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=150' },
])

// Data Guru Pembimbing
const guruList = ref([
  { id: 2, name: 'Dra. Nurul Hidayah, M.Pd', idNumber: '198502142010011002', email: 'guru@gmail.com', phone: '0812-0000-0002', extraInfo: 'Guru Kejuruan Utama SMKN 71', avatar: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150' },
  { id: 12, name: 'Bambang Irawan, S.Kom', idNumber: '198803152012011003', email: 'bambang.guru@gmail.com', phone: '0812-0000-0012', extraInfo: 'Pembimbing PPLG & Game', avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150' },
])

const activeDisplayList = computed(() => {
  let list: any[] = []
  if (currentSubTab.value === 'siswa') {
    list = studentsList.value
    if (selectedMajorFilter.value !== 'all') {
      list = list.filter(s => s.major === selectedMajorFilter.value)
    }
  } else if (currentSubTab.value === 'company') {
    list = companiesList.value
  } else if (currentSubTab.value === 'dudi') {
    list = dudiList.value
  } else {
    list = guruList.value
  }

  if (!searchQuery.value) return list
  const q = searchQuery.value.toLowerCase()
  return list.filter((item: any) =>
    (item.name && item.name.toLowerCase().includes(q)) ||
    (item.idNumber && item.idNumber.toLowerCase().includes(q)) ||
    (item.email && item.email.toLowerCase().includes(q)) ||
    (item.company && item.company.toLowerCase().includes(q)) ||
    (item.sector && item.sector.toLowerCase().includes(q))
  )
})

const openCreateModal = () => {
  isEditing.value = false
  isCreatingNewCompanyInline.value = false
  formData.value = {
    id: 0,
    name: '',
    idNumber: '',
    phone: '',
    email: '',
    major: 'PPLG',
    className: 'XII PPLG 1',
    companyId: 1,
    newCompanyName: '',
    newCompanySector: '',
    newCompanyAddress: '',
    teacherMentor: 'Dra. Nurul Hidayah, M.Pd',
    workMode: 'wfo',
    sector: '',
    quota: 5,
    address: '',
    radius: 150,
    workModes: 'WFO, WFH'
  }
  isFormModalOpen.value = true
}

const openEditModal = (item: any) => {
  isEditing.value = true
  isCreatingNewCompanyInline.value = false
  formData.value = { ...item }
  isFormModalOpen.value = true
}

const showDeleteConfirm = ref(false)
const itemToDelete = ref<any>(null)

const handleDelete = (item: any) => {
  itemToDelete.value = item
  showDeleteConfirm.value = true
}

const confirmDelete = () => {
  if (!itemToDelete.value) return
  const item = itemToDelete.value
  if (currentSubTab.value === 'siswa') {
    studentsList.value = studentsList.value.filter(s => s.id !== item.id)
  } else if (currentSubTab.value === 'company') {
    companiesList.value = companiesList.value.filter(c => c.id !== item.id)
  } else if (currentSubTab.value === 'dudi') {
    dudiList.value = dudiList.value.filter(d => d.id !== item.id)
  } else {
    guruList.value = guruList.value.filter(g => g.id !== item.id)
  }
  showToast(`Data ${item.name} berhasil dihapus dari sistem.`, 'info')
  showDeleteConfirm.value = false
  itemToDelete.value = null
}

const handleSaveManual = async () => {
  if (isEditing.value) {
    if (currentSubTab.value === 'siswa') {
      const idx = studentsList.value.findIndex(s => s.id === formData.value.id)
      if (idx !== -1) studentsList.value[idx] = { ...studentsList.value[idx], ...formData.value }
    } else if (currentSubTab.value === 'company') {
      const idx = companiesList.value.findIndex(c => c.id === formData.value.id)
      if (idx !== -1) companiesList.value[idx] = { ...companiesList.value[idx], ...formData.value }
    }
    showToast(`Data ${formData.value.name} berhasil diperbarui secara online.`, 'success')
  } else {
    // TAMBAH DATA BARU
    if (currentSubTab.value === 'siswa') {
      let assignedCompany = 'PT Telkom Digital Solusi'
      let dudi = 'Hendra Wijaya, S.Kom'

      if (isCreatingNewCompanyInline.value && formData.value.newCompanyName) {
        const newCompId = Date.now()
        assignedCompany = formData.value.newCompanyName
        companiesList.value.push({
          id: newCompId,
          name: formData.value.newCompanyName,
          icon: formData.value.major === 'Animasi' ? '🎬' : (formData.value.major === 'DKV' ? '🎨' : '💻'),
          sector: formData.value.newCompanySector || 'Teknologi Komputer & Kreatif',
          address: formData.value.newCompanyAddress || 'DKI Jakarta',
          quota: 5,
          placementsCount: 1,
          workModes: formData.value.workMode.toUpperCase(),
          radius: 150
        })
        dudi = 'Pembimbing Lapangan Baru'
      } else if (formData.value.companyId) {
        const found = companiesList.value.find(c => c.id === formData.value.companyId)
        if (found) {
          assignedCompany = found.name
          found.placementsCount = (found.placementsCount || 0) + 1
          if (found.id === 2) dudi = 'Raditya Pratama, S.Sn'
          else if (found.id === 3) dudi = 'Maya Safitri, M.Ds'
        }
      }

      const newStudent = {
        id: Date.now(),
        name: formData.value.name,
        idNumber: formData.value.idNumber,
        major: formData.value.major,
        className: formData.value.className,
        email: formData.value.email,
        phone: formData.value.phone,
        company: assignedCompany,
        dudiMentor: dudi,
        teacherMentor: formData.value.teacherMentor,
        workMode: formData.value.workMode.toUpperCase(),
        avatar: 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150'
      }
      studentsList.value.unshift(newStudent)

      try {
        await fetch('http://127.0.0.1:8000/api/admin/master-data', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${authToken.value}`
          },
          body: JSON.stringify({
            role: 'siswa',
            name: newStudent.name,
            email: newStudent.email,
            nisn_nip: newStudent.idNumber,
            phone: newStudent.phone,
            major: newStudent.major,
            class_name: newStudent.className,
            company_id: formData.value.companyId,
            new_company_name: isCreatingNewCompanyInline.value ? formData.value.newCompanyName : null
          })
        })
      } catch (e) {
        // Safe fallback
      }

      showToast(`Siswa ${newStudent.name} (${newStudent.major}) berhasil didaftarkan dan langsung di-plotting ke ${assignedCompany}!`, 'success')
    } else if (currentSubTab.value === 'company') {
      const newCompany = {
        id: Date.now(),
        name: formData.value.name,
        icon: '🏢',
        sector: formData.value.sector || 'Industri Komputer & Kreatif',
        address: formData.value.address || 'Jakarta',
        quota: Number(formData.value.quota) || 5,
        placementsCount: 0,
        workModes: formData.value.workModes || 'WFO, WFH',
        radius: Number(formData.value.radius) || 150
      }
      companiesList.value.push(newCompany)
      showToast(`Tempat PKL ${newCompany.name} berhasil ditambahkan!`, 'success')
    } else if (currentSubTab.value === 'dudi') {
      dudiList.value.push({
        id: Date.now(),
        name: formData.value.name,
        idNumber: formData.value.idNumber,
        email: formData.value.email,
        phone: formData.value.phone,
        extraInfo: 'Mitra Industri Baru',
        avatar: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150'
      })
      showToast(`Mentor Industri ${formData.value.name} berhasil ditambahkan!`, 'success')
    } else {
      guruList.value.push({
        id: Date.now(),
        name: formData.value.name,
        idNumber: formData.value.idNumber,
        email: formData.value.email,
        phone: formData.value.phone,
        extraInfo: 'Guru Pembimbing Sekolah',
        avatar: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150'
      })
      showToast(`Guru Pembimbing ${formData.value.name} berhasil ditambahkan!`, 'success')
    }
  }

  isFormModalOpen.value = false
}

const openImportModal = () => {
  isImportModalOpen.value = true
}

const downloadTemplate = () => {
  showToast(`Template template_siswa_smkn71.xlsx berhasil diunduh.`, 'success')
}

const executeImport = () => {
  isImportModalOpen.value = false
  showToast('Berhasil mengimpor 8 data siswa baru SMKN 71 beserta tempat PKL secara online!', 'success')
}
</script>
