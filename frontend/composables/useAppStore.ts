import { reactive, ref, computed } from 'vue'

export interface UserProfile {
  id: number
  name: string
  email: string
  role: 'siswa' | 'dudi' | 'guru' | 'admin'
  nisn_nip?: string
  phone?: string
  avatar?: string
  roleLabel: string
}

const defaultProfiles: Record<string, UserProfile> = {
  siswa: {
    id: 6,
    name: 'Budi Santoso',
    email: 'siswa@magang.id',
    role: 'siswa',
    nisn_nip: '0061234567',
    phone: '085712345678',
    avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150',
    roleLabel: 'Budi - Siswa'
  },
  dudi: {
    id: 4,
    name: 'Hendra Wijaya, S.Kom',
    email: 'dudi@magang.id',
    role: 'dudi',
    nisn_nip: 'ID-TELKOM-8821',
    phone: '081122334455',
    avatar: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150',
    roleLabel: 'Hendra - Pembimbing DUDI'
  },
  guru: {
    id: 2,
    name: 'Dra. Nurul Hidayah, M.Pd',
    email: 'guru@magang.id',
    role: 'guru',
    nisn_nip: '198005122005012003',
    phone: '081398765432',
    avatar: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150',
    roleLabel: 'Nurul - Guru Pembimbing'
  },
  admin: {
    id: 1,
    name: 'Ir. Bambang Hermanto, M.T',
    email: 'admin@magang.id',
    role: 'admin',
    nisn_nip: '197508101999031002',
    phone: '081234567890',
    avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150',
    roleLabel: 'Bambang - Admin / Kaprog'
  }
}

// Global reactive state
const isLoggedIn = ref<boolean>(false) // Default: Main page is Login
const currentRole = ref<'siswa' | 'dudi' | 'guru' | 'admin'>('siswa')
const currentUser = ref<UserProfile>(defaultProfiles.siswa)
const activeMenu = ref<string>('dashboard')
const authToken = ref<string>('')

// Network State (Desktop Indicator)
const isOnline = ref<boolean>(true)
const isSyncing = ref<boolean>(false)
const pendingSyncCount = ref<number>(0)
const lastSyncTime = ref<string>('Baru saja (13:25)')
const isSettingsModalOpen = ref<boolean>(false)
const notificationToast = ref<{ show: boolean; message: string; type: 'success' | 'info' | 'warning' | 'error' }>({
  show: false,
  message: '',
  type: 'info'
})

export function useAppStore() {
  const showToast = (message: string, type: 'success' | 'info' | 'warning' | 'error' = 'info') => {
    notificationToast.value = { show: true, message, type }
    setTimeout(() => {
      notificationToast.value.show = false
    }, 4000)
  }

  // Login function with API call & demo fallback
  const login = async (email: string, password: string): Promise<boolean> => {
    try {
      const res = await fetch('http://127.0.0.1:8000/api/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify({ email, password })
      })

      if (res.ok) {
        const data = await res.json()
        authToken.value = data.token
        const role = data.user.role as 'siswa' | 'dudi' | 'guru' | 'admin'
        currentRole.value = role
        currentUser.value = {
          ...data.user,
          roleLabel: `${data.user.name} - ${role.toUpperCase()}`
        }
        isLoggedIn.value = true
        setDefaultMenu(role)
        showToast(`Selamat datang kembali, ${data.user.name}!`, 'success')
        return true
      }
    } catch (e) {
      // If offline or network issue, fallback to mock credentials
    }

    // Fallback authentication for offline / demo mode
    const matchedRole = Object.keys(defaultProfiles).find(
      key => defaultProfiles[key].email.toLowerCase() === email.toLowerCase()
    ) as 'siswa' | 'dudi' | 'guru' | 'admin' | undefined

    if (matchedRole && password === 'password123') {
      currentRole.value = matchedRole
      currentUser.value = defaultProfiles[matchedRole]
      authToken.value = 'mock-bearer-token-' + Date.now()
      isLoggedIn.value = true
      setDefaultMenu(matchedRole)
      showToast(`Login berhasil sebagai ${currentUser.value.name}! (Mode Lokal)`, 'success')
      return true
    }

    showToast('Email atau password tidak sesuai. Coba gunakan akun demo.', 'error')
    return false
  }

  // Quick 1-click login for testing
  const loginAs = (role: 'siswa' | 'dudi' | 'guru' | 'admin') => {
    currentRole.value = role
    currentUser.value = defaultProfiles[role]
    authToken.value = 'token-' + role
    isLoggedIn.value = true
    setDefaultMenu(role)
    showToast(`Masuk sebagai ${currentUser.value.name} (${role.toUpperCase()})`, 'success')
  }

  // Logout function
  const logout = () => {
    isLoggedIn.value = false
    authToken.value = ''
    showToast('Sesi telah diakhiri. Silakan login kembali.', 'info')
  }

  const setDefaultMenu = (role: 'siswa' | 'dudi' | 'guru' | 'admin') => {
    if (role === 'siswa') activeMenu.value = 'dashboard'
    else if (role === 'dudi') activeMenu.value = 'dashboard_dudi'
    else if (role === 'guru') activeMenu.value = 'dashboard_guru'
    else if (role === 'admin') activeMenu.value = 'dashboard_admin'
  }

  // Switch role inside app
  const switchRole = (role: 'siswa' | 'dudi' | 'guru' | 'admin') => {
    currentRole.value = role
    currentUser.value = defaultProfiles[role]
    setDefaultMenu(role)
    showToast(`Beralih ke peran: ${currentUser.value.roleLabel}`, 'success')
  }

  // Manual Trigger Sync
  const triggerSync = async () => {
    isSyncing.value = true
    try {
      await new Promise(r => setTimeout(r, 1200))
      pendingSyncCount.value = 0
      const now = new Date()
      lastSyncTime.value = `${now.getHours().toString().padStart(2, '0')}:${now.getMinutes().toString().padStart(2, '0')}`
      showToast('Sinkronisasi data ke server pusat berhasil!', 'success')
    } catch (err) {
      showToast('Gagal sinkronisasi dengan server.', 'error')
    } finally {
      isSyncing.value = false
    }
  }

  // Toggle offline/online simulation
  const toggleNetworkStatus = () => {
    isOnline.value = !isOnline.value
    if (!isOnline.value) {
      pendingSyncCount.value = 3
      showToast('Mode Offline aktif: Data akan disimpan di IndexedDB lokal.', 'warning')
    } else {
      showToast('Terhubung kembali ke jaringan!', 'success')
      triggerSync()
    }
  }

  return {
    isLoggedIn,
    currentRole,
    currentUser,
    activeMenu,
    authToken,
    isOnline,
    isSyncing,
    pendingSyncCount,
    lastSyncTime,
    isSettingsModalOpen,
    notificationToast,
    showToast,
    login,
    loginAs,
    logout,
    switchRole,
    triggerSync,
    toggleNetworkStatus
  }
}
