<template>
  <div v-if="isSettingsModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm animate-fade-in">
    <div class="w-full max-w-md bg-white border border-slate-200 rounded-2xl shadow-2xl p-6 text-slate-800 relative">
      <div class="flex items-center justify-between pb-4 border-b border-slate-200">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center text-lg border border-indigo-200">
            ⚙️
          </div>
          <div>
            <h3 class="text-base font-bold text-slate-900">Pengaturan Akun</h3>
            <p class="text-xs text-slate-500">Ganti kata sandi &amp; preferensi desktop</p>
          </div>
        </div>
        <button
          @click="isSettingsModalOpen = false"
          class="text-slate-400 hover:text-slate-700 p-1.5 rounded-lg hover:bg-slate-100 text-sm font-bold"
        >
          ✕
        </button>
      </div>

      <form @submit.prevent="handleSubmit" class="mt-5 space-y-4">
        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1">Password Saat Ini</label>
          <input
            v-model="currentPassword"
            type="password"
            placeholder="Masukkan kata sandi lama"
            required
            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white transition"
          />
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1">Password Baru</label>
          <input
            v-model="newPassword"
            type="password"
            placeholder="Minimal 6 karakter"
            required
            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white transition"
          />
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1">Konfirmasi Password Baru</label>
          <input
            v-model="confirmPassword"
            type="password"
            placeholder="Ulangi password baru"
            required
            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white transition"
          />
        </div>

        <div class="pt-2 flex items-center justify-end gap-2.5">
          <button
            type="button"
            @click="isSettingsModalOpen = false"
            class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition"
          >
            Batal
          </button>
          <button
            type="submit"
            :disabled="isSubmitting"
            class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-sm transition flex items-center gap-1.5"
          >
            <span v-if="isSubmitting" class="animate-spin inline-block">⏳</span>
            <span>Simpan Perubahan</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useAppStore } from '~/composables/useAppStore'

const { isSettingsModalOpen, showToast } = useAppStore()

const currentPassword = ref('')
const newPassword = ref('')
const confirmPassword = ref('')
const isSubmitting = ref(false)

const handleSubmit = async () => {
  if (newPassword.value !== confirmPassword.value) {
    showToast('Konfirmasi password tidak cocok!', 'error')
    return
  }

  isSubmitting.value = true
  setTimeout(() => {
    isSubmitting.value = false
    isSettingsModalOpen.value = false
    currentPassword.value = ''
    newPassword.value = ''
    confirmPassword.value = ''
    showToast('Password akun Anda berhasil diperbarui!', 'success')
  }, 800)
}
</script>
