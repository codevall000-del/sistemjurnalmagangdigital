import { reactive, ref, computed } from 'vue'

export interface UserProfile {
  id: number
  name: string
  email: string
  role: 'siswa' | 'mentor' | 'dudi' | 'guru' | 'admin'
  nisn_nip?: string
  phone?: string
  avatar?: string
  major?: 'PPLG' | 'DKV' | 'Animasi' | string
  class_name?: string
  company_name?: string
  company_address?: string
  mentor_name?: string
  division?: string
  status?: string
  academic_year?: string
  department?: string
  roleLabel: string
}

const mentorProfile: UserProfile = {
  id: 3,
  name: 'Hendra Wijaya, S.Kom',
  email: 'mentor@gmail.com',
  role: 'mentor',
  nisn_nip: 'ID-TELKOM-8821',
  phone: '0812-0000-0003',
  major: 'PPLG',
  class_name: 'Lead Software Engineer',
  company_name: 'PT Telkom Digital Solusi',
  company_address: 'Jl. Gatot Subroto Kav. 52, Gedung Telkom Landmark Lt. 14, Jakarta Selatan',
  mentor_name: 'Hendra Wijaya, S.Kom',
  division: 'Software Engineering & Cloud Platform',
  status: 'Pembimbing Lapangan Aktif',
  academic_year: 'Tempat Magang Aktif 2024/2025',
  department: 'Divisi IT Enterprise Solution',
  avatar: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150',
  roleLabel: 'Hendra Wijaya - Pembimbing Lapangan (Instansi / Perusahaan)'
}

const defaultProfiles: Record<string, UserProfile> = {
  siswa: {
    id: 4,
    name: 'Budi Santoso',
    email: 'siswa@gmail.com',
    role: 'siswa',
    nisn_nip: '0061234567',
    phone: '0812-0000-0004',
    major: 'PPLG (Pengembangan Perangkat Lunak dan Gim)',
    class_name: 'XII PPLG 1',
    company_name: 'PT Telkom Digital Solusi',
    company_address: 'Jl. Gatot Subroto Kav. 52, Gedung Telkom Landmark Lt. 14, Jakarta Selatan',
    mentor_name: 'Hendra Wijaya, S.Kom',
    division: 'Divisi Frontend & Web Platform',
    status: 'Siswa PKL Aktif',
    academic_year: '2024/2025 (Semester Ganjil)',
    department: 'Rekayasa Perangkat Lunak (RPL)',
    avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150',
    roleLabel: 'Budi Santoso - Siswa PPLG'
  },
  mentor: mentorProfile,
  dudi: mentorProfile,
  guru: {
    id: 2,
    name: 'Dra. Nurul Hidayah, M.Pd',
    email: 'guru@gmail.com',
    role: 'guru',
    nisn_nip: '198502142010011002',
    phone: '0812-0000-0002',
    major: 'PPLG',
    class_name: 'Guru Pembimbing Utama',
    company_name: 'SMKN 71 Jakarta',
    company_address: 'Jl. Raden Saleh No. 45, Senen, Jakarta Pusat',
    mentor_name: 'Dra. Nurul Hidayah, M.Pd',
    division: 'Konsentrasi Keahlian PPLG',
    status: 'Guru Pembimbing Aktif',
    academic_year: 'Tahun Ajaran 2024/2025',
    department: 'Jurusan Teknik Komputer & Informatika',
    avatar: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150',
    roleLabel: 'Dra. Nurul Hidayah - Guru Pembimbing'
  },
  admin: {
    id: 1,
    name: 'Ir. Bambang Hermanto, M.T',
    email: 'admin@gmail.com',
    role: 'admin',
    nisn_nip: '198001012005011001',
    phone: '0812-0000-0001',
    major: 'PPLG',
    class_name: 'Kaprog Vokasi / Super Admin',
    company_name: 'SMKN 71 Jakarta',
    company_address: 'Jl. Raden Saleh No. 45, Senen, Jakarta Pusat',
    mentor_name: 'Ir. Bambang Hermanto, M.T',
    division: 'Program Keahlian Pengembangan Perangkat Lunak',
    status: 'Administrator Utama Sistem',
    academic_year: 'Tahun Ajaran 2024/2025',
    department: 'Ketua Program Keahlian (Kaprog)',
    avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150',
    roleLabel: 'Ir. Bambang Hermanto - Admin / Kaprog'
  }
}

// Global reactive state
const isLoggedIn = ref<boolean>(false)
const currentRole = ref<'siswa' | 'mentor' | 'dudi' | 'guru' | 'admin'>('siswa')
const currentUser = ref<UserProfile>(defaultProfiles.siswa)
const activeMenu = ref<string>('dashboard')
const authToken = ref<string>('')

// Theme Mode (Appearance / Display): 'light' | 'dark' | 'system'
export type ThemeMode = 'light' | 'dark' | 'system'
const themeMode = ref<ThemeMode>('light')
const isDarkMode = ref<boolean>(false)

// Function to resolve and apply theme with fluid Apple-style transition
let isThemeInitialized = false

const applyTheme = (mode: ThemeMode, animate = true) => {
  themeMode.value = mode
  if (typeof window === 'undefined') return

  try {
    localStorage.setItem('eduaccess_theme', mode)
  } catch (e) {}

  let dark = false
  if (mode === 'dark') {
    dark = true
  } else if (mode === 'system') {
    dark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches
  } else {
    dark = false
  }

  const updateDOM = () => {
    isDarkMode.value = dark
    if (dark) {
      document.documentElement.classList.add('dark')
      document.documentElement.setAttribute('data-theme', 'dark')
    } else {
      document.documentElement.classList.remove('dark')
      document.documentElement.setAttribute('data-theme', 'light')
    }
  }

  // Skip animation on initial page boot
  if (!isThemeInitialized || !animate) {
    updateDOM()
    isThemeInitialized = true
    return
  }

  // Smooth View Transition API (Chrome, Edge, Safari 18+)
  if (typeof document !== 'undefined' && 'startViewTransition' in document && typeof (document as any).startViewTransition === 'function') {
    document.documentElement.classList.add('view-transitioning')
    try {
      const transition = (document as any).startViewTransition(() => {
        updateDOM()
      })
      if (transition && transition.finished) {
        transition.finished.finally(() => {
          document.documentElement.classList.remove('view-transitioning')
        })
      } else {
        setTimeout(() => {
          document.documentElement.classList.remove('view-transitioning')
        }, 400)
      }
    } catch (e) {
      updateDOM()
      document.documentElement.classList.remove('view-transitioning')
    }
  } else if (typeof document !== 'undefined') {
    // Universal CSS fallback: enable temporary 350ms smooth transition
    document.documentElement.classList.add('theme-transition')
    updateDOM()
    setTimeout(() => {
      document.documentElement.classList.remove('theme-transition')
    }, 400)
  } else {
    updateDOM()
  }
}

// Client-side initialization for theme
if (typeof window !== 'undefined') {
  let savedMode: ThemeMode = 'light'
  try {
    const stored = localStorage.getItem('eduaccess_theme') as ThemeMode | null
    if (stored === 'light' || stored === 'dark' || stored === 'system') {
      savedMode = stored
    }
  } catch (e) {}
  
  applyTheme(savedMode, false)

  if (window.matchMedia) {
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
      if (themeMode.value === 'system') {
        const dark = e.matches
        isDarkMode.value = dark
        if (dark) {
          document.documentElement.classList.add('dark')
          document.documentElement.setAttribute('data-theme', 'dark')
        } else {
          document.documentElement.classList.remove('dark')
          document.documentElement.setAttribute('data-theme', 'light')
        }
      }
    })
  }
}

// Real-time Cloud Online State (Full Online Architecture, no sync push needed)
const isOnline = ref<boolean>(true)
const isSettingsModalOpen = ref<boolean>(false)
const isIdCardModalOpen = ref<boolean>(false)
const notificationToast = ref<{ show: boolean; message: string; type: 'success' | 'info' | 'warning' | 'error' }>({
  show: false,
  message: '',
  type: 'info'
})

// Siswa Attendance & Daily Journal Tracking State
export interface SiswaAttendanceState {
  hasCheckedIn: boolean
  hasCheckedOut: boolean
  checkInTime: string
  checkOutTime: string
  checkOutTimestamp: number | null
  workMode: 'wfo' | 'wfh' | 'wfa'
}

const attendanceState = reactive<SiswaAttendanceState>({
  hasCheckedIn: true,
  hasCheckedOut: false,
  checkInTime: '07:35',
  checkOutTime: '',
  checkOutTimestamp: null,
  workMode: 'wfo'
})

const isTodayLogged = ref<boolean>(false)
const simulatedElapsedMinutes = ref<number | null>(null)
const nowTick = ref<number>(Date.now())

// Periodic interval to keep elapsed time updated
if (typeof window !== 'undefined') {
  setInterval(() => {
    nowTick.value = Date.now()
  }, 10000)
}

// Elapsed minutes since Tap Out (real or simulated)
const effectiveMinutesSinceTapOut = computed<number>(() => {
  if (simulatedElapsedMinutes.value !== null) {
    return Math.max(0, simulatedElapsedMinutes.value)
  }
  if (!attendanceState.hasCheckedOut || !attendanceState.checkOutTimestamp) {
    return 0
  }
  const diffMs = Math.max(0, nowTick.value - attendanceState.checkOutTimestamp)
  return Math.floor(diffMs / 60000)
})

export type JournalUrgencyLevel = 'none' | 'warning' | 'danger'

const journalUrgency = computed<JournalUrgencyLevel>(() => {
  if (!attendanceState.hasCheckedOut || isTodayLogged.value) {
    return 'none'
  }
  if (effectiveMinutesSinceTapOut.value >= 15) {
    return 'danger'
  }
  return 'warning'
})

export function useAppStore() {
  const showToast = (message: string, type: 'success' | 'info' | 'warning' | 'error' = 'info') => {
    notificationToast.value = { show: true, message, type }
    setTimeout(() => {
      notificationToast.value.show = false
    }, 4000)
  }

  // Login function with direct online API call & fallback
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
        const rawRole = data.user.role as string
        const role = (rawRole === 'dudi' ? 'mentor' : rawRole) as 'siswa' | 'mentor' | 'dudi' | 'guru' | 'admin'
        currentRole.value = role
        currentUser.value = {
          ...data.user,
          role,
          roleLabel: `${data.user.name} - ${role === 'mentor' ? 'Pembimbing Lapangan' : role.toUpperCase()}`
        }
        isLoggedIn.value = true
        setDefaultMenu(role)
        showToast(`Selamat datang di Portal Magang SMKN 71, ${data.user.name}!`, 'success')
        return true
      }
    } catch (e) {
      // Offline fallback handling
    }

    // Match demo profile
    const matchedRole = Object.keys(defaultProfiles).find(
      key => defaultProfiles[key].email.toLowerCase() === email.toLowerCase()
    ) as 'siswa' | 'mentor' | 'dudi' | 'guru' | 'admin' | undefined

    if (matchedRole && password === '12345678') {
      currentRole.value = matchedRole
      currentUser.value = defaultProfiles[matchedRole]
      authToken.value = 'token-' + matchedRole
      isLoggedIn.value = true
      setDefaultMenu(matchedRole)
      showToast(`Login berhasil sebagai ${currentUser.value.name}! (SMKN 71 Jakarta)`, 'success')
      return true
    }

    showToast('Email atau password tidak sesuai.', 'error')
    return false
  }

  // Quick 1-click login for testing
  const loginAs = (role: 'siswa' | 'mentor' | 'dudi' | 'guru' | 'admin') => {
    currentRole.value = role
    currentUser.value = defaultProfiles[role]
    authToken.value = 'token-' + role
    isLoggedIn.value = true
    setDefaultMenu(role)
    showToast(`Masuk sebagai ${currentUser.value.name} (${role === 'mentor' || role === 'dudi' ? 'PEMBIMBING LAPANGAN' : role.toUpperCase()})`, 'success')
  }

  const logout = () => {
    isLoggedIn.value = false
    authToken.value = ''
    showToast('Sesi telah diakhiri. Silakan login kembali.', 'info')
  }

  const setDefaultMenu = (role: 'siswa' | 'mentor' | 'dudi' | 'guru' | 'admin') => {
    if (role === 'siswa') activeMenu.value = 'dashboard'
    else if (role === 'mentor' || role === 'dudi') activeMenu.value = 'dashboard_dudi'
    else if (role === 'guru') activeMenu.value = 'dashboard_guru'
    else if (role === 'admin') activeMenu.value = 'dashboard_admin'
  }

  const switchRole = (role: 'siswa' | 'mentor' | 'dudi' | 'guru' | 'admin') => {
    currentRole.value = role
    currentUser.value = defaultProfiles[role]
    setDefaultMenu(role)
    showToast(`Beralih ke peran: ${currentUser.value.roleLabel}`, 'success')
  }

  // Siswa Attendance & Urgency Helper Actions
  const recordCheckIn = (timeStr?: string, mode: 'wfo' | 'wfh' | 'wfa' = 'wfo') => {
    attendanceState.hasCheckedIn = true
    attendanceState.hasCheckedOut = false
    attendanceState.checkInTime = timeStr || new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }).replace('.', ':')
    attendanceState.workMode = mode
    showToast(`Presensi masuk (Tap In) berhasil dicatat: ${attendanceState.checkInTime} WIB`, 'success')
  }

  const recordCheckOut = (timeStr?: string, timestamp?: number) => {
    const now = new Date()
    const formattedTime = timeStr || [
      now.getHours().toString().padStart(2, '0'),
      now.getMinutes().toString().padStart(2, '0')
    ].join(':')

    attendanceState.hasCheckedIn = true
    attendanceState.hasCheckedOut = true
    attendanceState.checkOutTime = formattedTime
    attendanceState.checkOutTimestamp = timestamp || Date.now()
    simulatedElapsedMinutes.value = null // follow real-time by default

    if (!isTodayLogged.value) {
      showToast('⚠️ Presensi Tap Out berhasil! PERHATIAN: Anda belum mengisi Jurnal Harian hari ini.', 'warning')
    } else {
      showToast(`Tap Out selesai pada ${formattedTime} WIB. Jurnal harian sudah terisi lengkap.`, 'success')
    }
  }

  const recordJournalSubmitted = () => {
    isTodayLogged.value = true
    showToast('✓ Catatan jurnal harian berhasil dikirim! Status kehadiran hari ini lengkap.', 'success')
  }

  const setSimulatedMinutes = (minutes: number | null) => {
    simulatedElapsedMinutes.value = minutes
    if (minutes !== null && minutes >= 15) {
      showToast(`Simulasi Waktu: ${minutes} Menit setelah Tap Out (Status BAHAYA/MERAH BERDENYUT aktif)`, 'error')
    } else if (minutes !== null) {
      showToast(`Simulasi Waktu: ${minutes} Menit setelah Tap Out (Status PERINGATAN/KUNING aktif)`, 'warning')
    } else {
      showToast('Simulasi waktu dinonaktifkan (kembali ke perhitungan jam riil)', 'info')
    }
  }

  const resetAttendanceDemo = () => {
    attendanceState.hasCheckedIn = true
    attendanceState.hasCheckedOut = false
    attendanceState.checkInTime = '07:35'
    attendanceState.checkOutTime = ''
    attendanceState.checkOutTimestamp = null
    isTodayLogged.value = false
    simulatedElapsedMinutes.value = null
    showToast('Status presensi direset: Masuk pagi (Belum Tap Out).', 'info')
  }

  const triggerTapOutDemo = (mode: 'immediate' | 'delayed') => {
    attendanceState.hasCheckedIn = true
    attendanceState.hasCheckedOut = true
    isTodayLogged.value = false

    if (mode === 'immediate') {
      attendanceState.checkOutTime = '17:05'
      attendanceState.checkOutTimestamp = Date.now() - 3 * 60 * 1000 // 3 min ago
      simulatedElapsedMinutes.value = 3
      showToast('Demo: Tap Out baru saja (3 mnt lalu). Tombol jadi KUNING dengan tanda seru (!).', 'warning')
    } else {
      attendanceState.checkOutTime = '16:15'
      attendanceState.checkOutTimestamp = Date.now() - 45 * 60 * 1000 // 45 min ago
      simulatedElapsedMinutes.value = 45
      showToast('Demo: Tap Out sudah 45 menit lalu! Tombol jadi MERAH & BERDENYUT (BAHAYA)!', 'error')
    }
  }

  const toggleTheme = () => {
    const nextMode: ThemeMode = isDarkMode.value ? 'light' : 'dark'
    applyTheme(nextMode)
    showToast(nextMode === 'dark' ? 'Mode Gelap Apple aktif 🌙' : 'Mode Terang aktif ☀️', 'info')
  }

  const updateUserProfile = (updatedFields: Partial<UserProfile>) => {
    currentUser.value = {
      ...currentUser.value,
      ...updatedFields
    }
    showToast('Profil akun berhasil diperbarui!', 'success')
  }

  return {
    isLoggedIn,
    currentRole,
    currentUser,
    activeMenu,
    authToken,
    isOnline,
    isSettingsModalOpen,
    isIdCardModalOpen,
    notificationToast,
    showToast,
    login,
    loginAs,
    logout,
    switchRole,
    // Theme & Appearance
    themeMode,
    isDarkMode,
    applyTheme,
    toggleTheme,
    updateUserProfile,
    // Siswa Attendance & Journal Urgency States
    attendanceState,
    isTodayLogged,
    simulatedElapsedMinutes,
    effectiveMinutesSinceTapOut,
    journalUrgency,
    recordCheckIn,
    recordCheckOut,
    recordJournalSubmitted,
    setSimulatedMinutes,
    resetAttendanceDemo,
    triggerTapOutDemo
  }
}
