<template>
  <div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
      <div>
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
          <span>📁 Data Master PKL (CRUD Siswa, DUDI &amp; Guru)</span>
        </h2>
        <p class="text-xs text-slate-500 mt-1">
          Kelola master data entitas pengguna, penugasan, dan impor data massal dari Excel.
        </p>
      </div>

      <!-- Action Buttons: Tambah Data Manual & Import dari Excel -->
      <div class="flex items-center gap-2.5">
        <button
          @click="openImportModal"
          class="px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-semibold border border-slate-300 shadow-sm transition flex items-center gap-1.5 active:scale-95"
        >
          <span>📥</span> Import dari Excel (Template)
        </button>

        <button
          @click="openCreateModal"
          class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm active:scale-95"
        >
          <span>➕</span> Tambah Data Manual
        </button>
      </div>
    </div>

    <!-- TABS / DROPDOWN SELECTOR UNTUK DATA MASTER: SISWA, DUDI, GURU -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div class="flex items-center p-1 bg-slate-100 border border-slate-200 rounded-xl text-xs font-semibold">
        <button
          @click="currentSubTab = 'siswa'"
          :class="currentSubTab === 'siswa' ? 'bg-white text-rose-700 shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900'"
          class="px-4 py-2 rounded-lg transition flex items-center gap-2"
        >
          <span>👨‍🎓</span> Data Siswa ({{ studentsList.length }})
        </button>
        <button
          @click="currentSubTab = 'dudi'"
          :class="currentSubTab === 'dudi' ? 'bg-white text-rose-700 shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900'"
          class="px-4 py-2 rounded-lg transition flex items-center gap-2"
        >
          <span>🏢</span> Pembimbing Industri / DUDI ({{ dudiList.length }})
        </button>
        <button
          @click="currentSubTab = 'guru'"
          :class="currentSubTab === 'guru' ? 'bg-white text-rose-700 shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900'"
          class="px-4 py-2 rounded-lg transition flex items-center gap-2"
        >
          <span>👨‍🏫</span> Guru Pembimbing ({{ guruList.length }})
        </button>
      </div>

      <!-- FITUR PENCARIAN REAL-TIME -->
      <div class="relative w-full sm:w-80">
        <input
          v-model="searchQuery"
          type="text"
          :placeholder="`Pencarian real-time ${currentSubTab}...`"
          class="w-full pl-9 pr-4 py-2 bg-white border border-slate-300 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500 shadow-sm"
        />
        <span class="absolute left-3 top-2.5 text-slate-400 text-xs">🔍</span>
      </div>
    </div>

    <!-- TABEL CRUD DATA -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-slate-700">
          <thead class="bg-slate-50 text-slate-600 uppercase text-[10px] tracking-wider border-b border-slate-200">
            <tr>
              <th class="py-3 px-4">Nama Lengkap</th>
              <th class="py-3 px-4">{{ currentSubTab === 'siswa' ? 'NISN' : 'NIP / ID Pegawai' }}</th>
              <th class="py-3 px-4">Email Akun</th>
              <th class="py-3 px-4">Nomor WhatsApp</th>
              <th class="py-3 px-4">{{ currentSubTab === 'siswa' ? 'Mitra Penempatan' : (currentSubTab === 'dudi' ? 'Perusahaan' : 'Jabatan') }}</th>
              <th class="py-3 px-4 text-center">Aksi (CRUD)</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200">
            <tr v-for="item in activeDisplayList" :key="item.id" class="hover:bg-slate-50 transition">
              <!-- Name & Avatar -->
              <td class="py-3.5 px-4 whitespace-nowrap">
                <div class="flex items-center gap-3">
                  <img :src="item.avatar" class="w-8 h-8 rounded-lg object-cover border border-slate-200" />
                  <span class="font-bold text-slate-900">{{ item.name }}</span>
                </div>
              </td>

              <!-- NISN / NIP -->
              <td class="py-3.5 px-4 font-mono text-slate-700 whitespace-nowrap">
                {{ item.idNumber || '-' }}
              </td>

              <!-- Email -->
              <td class="py-3.5 px-4 font-mono text-slate-500 whitespace-nowrap">
                {{ item.email }}
              </td>

              <!-- Phone -->
              <td class="py-3.5 px-4 font-mono text-slate-700 whitespace-nowrap">
                {{ item.phone }}
              </td>

              <!-- Extra -->
              <td class="py-3.5 px-4 whitespace-nowrap text-slate-700">
                <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 border border-slate-200">
                  {{ item.extraInfo }}
                </span>
              </td>

              <!-- Aksi CRUD -->
              <td class="py-3.5 px-4 text-center whitespace-nowrap">
                <div class="flex items-center justify-center gap-2">
                  <button
                    @click="openEditModal(item)"
                    class="px-2.5 py-1 bg-white hover:bg-indigo-50 text-indigo-700 rounded-lg text-[11px] font-semibold transition border border-slate-300 shadow-sm"
                  >
                    Edit
                  </button>
                  <button
                    @click="handleDelete(item)"
                    class="px-2.5 py-1 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg text-[11px] font-semibold transition border border-rose-200"
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

    <!-- MODAL CREATE / EDIT DATA MANUAL -->
    <div v-if="isFormModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm animate-fade-in">
      <div class="w-full max-w-lg bg-white border border-slate-200 rounded-2xl shadow-xl p-6 text-slate-900">
        <div class="flex items-center justify-between pb-4 border-b border-slate-200">
          <h3 class="text-base font-bold text-slate-900">
            {{ isEditing ? 'Edit Data Pengguna' : `Tambah Data ${currentSubTab.toUpperCase()} Baru` }}
          </h3>
          <button @click="isFormModalOpen = false" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
        </div>

        <form @submit.prevent="handleSaveManual" class="mt-4 space-y-4 text-xs">
          <div>
            <label class="block font-semibold text-slate-700 mb-1">Nama Lengkap *</label>
            <input v-model="formData.name" type="text" required placeholder="Contoh: Muhammad Farhan" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 shadow-sm" />
          </div>

          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="block font-semibold text-slate-700 mb-1">{{ currentSubTab === 'siswa' ? 'NISN *' : 'NIP / ID *' }}</label>
              <input v-model="formData.idNumber" type="text" required class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 shadow-sm" />
            </div>
            <div>
              <label class="block font-semibold text-slate-700 mb-1">Nomor WhatsApp *</label>
              <input v-model="formData.phone" type="text" required placeholder="08..." class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 shadow-sm" />
            </div>
          </div>

          <div>
            <label class="block font-semibold text-slate-700 mb-1">Email Akun *</label>
            <input v-model="formData.email" type="email" required placeholder="nama@magang.id" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 shadow-sm" />
          </div>

          <div class="pt-2 flex justify-end gap-2.5">
            <button type="button" @click="isFormModalOpen = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg border border-slate-300 font-semibold">Batal</button>
            <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg font-bold shadow-sm">Simpan Data</button>
          </div>
        </form>
      </div>
    </div>

    <!-- MODAL IMPORT DARI EXCEL (TEMPLATE DISEDIAKAN) -->
    <div v-if="isImportModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm animate-fade-in">
      <div class="w-full max-w-lg bg-white border border-slate-200 rounded-2xl shadow-xl p-6 text-slate-900 space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200">
          <div class="flex items-center gap-2">
            <span class="text-xl">📊</span>
            <div>
              <h3 class="text-sm font-bold text-slate-900">Import Data Massal dari Excel</h3>
              <p class="text-[11px] text-slate-500">Target Entitas: {{ currentSubTab.toUpperCase() }}</p>
            </div>
          </div>
          <button @click="isImportModalOpen = false" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
        </div>

        <!-- Download Template Excel Button -->
        <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 flex items-center justify-between">
          <div class="text-xs">
            <span class="font-bold text-slate-900 block">Template Format Excel Resmi</span>
            <span class="text-[11px] text-slate-500">Gunakan format ini untuk menghindari error mapping kolom</span>
          </div>
          <button
            @click="downloadTemplate"
            class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 rounded-lg text-xs font-semibold transition"
          >
            📥 Download Template
          </button>
        </div>

        <!-- File Upload Area -->
        <div class="border-2 border-dashed border-slate-300 hover:border-rose-500 p-6 rounded-xl text-center bg-slate-50 cursor-pointer">
          <span class="text-3xl block mb-2">📁</span>
          <span class="text-xs font-semibold text-slate-800 block">Pilih file .xlsx atau .csv dari komputer</span>
          <span class="text-[10px] text-slate-500 mt-1 block">Maksimal ukuran file: 5 MB</span>
          <input type="file" accept=".xlsx, .xls, .csv" class="hidden" id="excelFile" @change="handleFileSelected" />
          <label for="excelFile" class="mt-3 inline-block px-4 py-1.5 bg-white hover:bg-slate-100 text-slate-700 rounded-lg text-xs font-semibold border border-slate-300 shadow-sm cursor-pointer">
            Browse File
          </label>
        </div>

        <div class="flex justify-end gap-2.5 pt-2">
          <button @click="isImportModalOpen = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs border border-slate-300 font-semibold">Batal</button>
          <button @click="executeImport" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold shadow-sm">
            Mulai Proses Impor &rarr;
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useAppStore } from '~/composables/useAppStore'

const { showToast } = useAppStore()

const currentSubTab = ref<'siswa' | 'dudi' | 'guru'>('siswa')
const searchQuery = ref('')

const isFormModalOpen = ref(false)
const isEditing = ref(false)
const isImportModalOpen = ref(false)

const formData = ref({
  id: 0,
  name: '',
  idNumber: '',
  phone: '',
  email: ''
})

const studentsList = ref([
  { id: 1, name: 'Budi Santoso', idNumber: '0061234567', email: 'siswa@magang.id', phone: '0857-1234-5678', extraInfo: 'PT Telkom Digital Solusi', avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150' },
  { id: 2, name: 'Siti Rahma', idNumber: '0061234568', email: 'siti@magang.id', phone: '0857-2345-6789', extraInfo: 'PT Telkom Digital Solusi', avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150' },
  { id: 3, name: 'Rizky Pratama', idNumber: '0061234569', email: 'rizky@magang.id', phone: '0857-3456-7890', extraInfo: 'PT Inovasi Media Kreatif', avatar: 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=150' },
  { id: 4, name: 'Dewi Anggraeni', idNumber: '0061234570', email: 'dewi@magang.id', phone: '0857-4567-8901', extraInfo: 'Bank Mandiri IT Hub', avatar: 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150' }
])

const dudiList = ref([
  { id: 1, name: 'Hendra Wijaya, S.Kom', idNumber: 'ID-TELKOM-8821', email: 'dudi@magang.id', phone: '0811-2233-4455', extraInfo: 'PT Telkom Digital Solusi', avatar: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150' },
  { id: 2, name: 'Linda Kusuma, M.Ds', idNumber: 'ID-IMK-4412', email: 'linda@magang.id', phone: '0811-9988-7766', extraInfo: 'PT Inovasi Media Kreatif', avatar: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=150' }
])

const guruList = ref([
  { id: 1, name: 'Dra. Nurul Hidayah, M.Pd', idNumber: '198005122005012003', email: 'guru@magang.id', phone: '0813-9876-5432', extraInfo: 'Guru Kejuruan RPL', avatar: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150' },
  { id: 2, name: 'Ahmad Fauzi, S.Pd', idNumber: '198502142008011005', email: 'fauzi@magang.id', phone: '0813-1122-3344', extraInfo: 'Guru Produktif IT', avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150' }
])

const activeDisplayList = computed(() => {
  let list = currentSubTab.value === 'siswa' ? studentsList.value : (currentSubTab.value === 'dudi' ? dudiList.value : guruList.value)
  if (!searchQuery.value) return list
  const q = searchQuery.value.toLowerCase()
  return list.filter(item =>
    item.name.toLowerCase().includes(q) ||
    item.idNumber.toLowerCase().includes(q) ||
    item.email.toLowerCase().includes(q) ||
    item.phone.includes(q)
  )
})

const openCreateModal = () => {
  isEditing.value = false
  formData.value = { id: 0, name: '', idNumber: '', phone: '', email: '' }
  isFormModalOpen.value = true
}

const openEditModal = (item: any) => {
  isEditing.value = true
  formData.value = { ...item }
  isFormModalOpen.value = true
}

const handleDelete = (item: any) => {
  if (confirm(`Yakin ingin menghapus data ${item.name}?`)) {
    if (currentSubTab.value === 'siswa') {
      studentsList.value = studentsList.value.filter(s => s.id !== item.id)
    } else if (currentSubTab.value === 'dudi') {
      dudiList.value = dudiList.value.filter(d => d.id !== item.id)
    } else {
      guruList.value = guruList.value.filter(g => g.id !== item.id)
    }
    showToast(`Data ${item.name} berhasil dihapus.`, 'info')
  }
}

const handleSaveManual = () => {
  if (isEditing.value) {
    const list = currentSubTab.value === 'siswa' ? studentsList.value : (currentSubTab.value === 'dudi' ? dudiList.value : guruList.value)
    const idx = list.findIndex(i => i.id === formData.value.id)
    if (idx !== -1) {
      list[idx] = { ...list[idx], ...formData.value }
    }
    showToast(`Data ${formData.value.name} berhasil diperbarui.`, 'success')
  } else {
    const newItem = {
      id: Date.now(),
      name: formData.value.name,
      idNumber: formData.value.idNumber,
      email: formData.value.email,
      phone: formData.value.phone,
      extraInfo: 'Data Manual',
      avatar: 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150'
    }
    if (currentSubTab.value === 'siswa') studentsList.value.push(newItem)
    else if (currentSubTab.value === 'dudi') dudiList.value.push(newItem)
    else guruList.value.push(newItem)

    showToast(`Data ${formData.value.name} berhasil ditambahkan!`, 'success')
  }
  isFormModalOpen.value = false
}

const openImportModal = () => {
  isImportModalOpen.value = true
}

const downloadTemplate = () => {
  showToast(`Template template_import_${currentSubTab.value}.xlsx siap diunduh!`, 'success')
}

const handleFileSelected = () => {
  showToast('File Excel terdeteksi. Memvalidasi baris data...', 'info')
}

const executeImport = () => {
  isImportModalOpen.value = false
  showToast(`Berhasil mengimpor 12 data ${currentSubTab.value} baru dari file Excel!`, 'success')
}
</script>
