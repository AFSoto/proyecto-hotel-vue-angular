// Importa ref y computed para manejar estado reactivo en Composition API
import { ref, computed } from 'vue'

// Define el store de Pinia
import { defineStore } from 'pinia'

// Instancia de Axios configurada (API backend)
import api from '@/lib/axios'

// Router de Vue para redirecciones
import router from '@/router'

/**
 * 🧠 STORE DE AUTENTICACIÓN
 * Maneja login, logout, usuario y token JWT
 */
export const useAuthStore = defineStore('auth', () => {

  // =========================
  // 📦 ESTADO (STATE)
  // =========================

  // Token guardado en localStorage (persistencia)
  const token = ref(localStorage.getItem('token') || null)

  // Usuario guardado en localStorage (persistencia)
  const user = ref(JSON.parse(localStorage.getItem('user')) || null)

  // =========================
  // ⚙️ COMPUTED (DERIVADOS)
  // =========================

  // Verifica si está autenticado (booleano)
  const isAuthenticated = computed(() => !!token.value)

  // Verifica si el usuario es admin
  const isAdmin = computed(() => user.value?.role?.slug === 'admin')

  // Verifica si el usuario es recepcionista
  const isReceptionist = computed(() => user.value?.role?.slug === 'receptionist')

  // Retorna el rol actual del usuario
  const userRole = computed(() => user.value?.role?.slug || null)

  // =========================
  // 🚀 ACCIONES (ACTIONS)
  // =========================

  /**
   * 🔐 LOGIN
   * Envía credenciales al backend y guarda token + user
   */
  async function login(credentials) {
    const { data } = await api.post('/auth/login', credentials)

    // Guarda token en estado reactivo
    token.value = data.token

    // Guarda usuario en estado reactivo
    user.value = data.data

    // Persistencia en localStorage
    localStorage.setItem('token', data.token)
    localStorage.setItem('user', JSON.stringify(data.data))

    // 🔀 Redirección según rol del usuario
    if (isAdmin.value || isReceptionist.value) {
      router.push('/app/dashboard')
  }
}

  /**
   * 🚪 LOGOUT
   * Cierra sesión tanto en backend como en frontend
   */
  async function logout() {
    try {
      // Intenta cerrar sesión en backend
      await api.post('/auth/logout')
    } catch (error) {
      // Si falla el backend, igual se limpia el frontend
      console.warn('Logout request failed:', error)
    } finally {
      // Limpieza total del estado
      token.value = null
      user.value = null

      // Limpieza de localStorage
      localStorage.removeItem('token')
      localStorage.removeItem('user')

      // Redirección a login
      router.push('/login')
    }
  }

  /**
   * 👤 OBTENER USUARIO ACTUAL (/me)
   * Sincroniza el usuario desde el backend
   */
  async function fetchMe() {
    try {
      const { data } = await api.get('/auth/me')

      // Actualiza estado con datos del backend
      user.value = data.data

      // Sincroniza en localStorage
      localStorage.setItem('user', JSON.stringify(data.data))
    } catch (error) {
      // ❌ Token inválido o expirado
      token.value = null
      user.value = null
      localStorage.removeItem('token')
      localStorage.removeItem('user')
    }
  }

  /**
   * 🔄 REFRESH TOKEN
   * Solicita un nuevo JWT al backend
   */
  async function refreshToken() {
    try {
      const { data } = await api.post('/auth/refresh')

      // Actualiza token en estado
      token.value = data.token

      // Persistencia
      localStorage.setItem('token', data.token)
    } catch (error) {
      // ❌ Si falla, se cierra sesión completamente
      token.value = null
      user.value = null
      localStorage.removeItem('token')
      localStorage.removeItem('user')
    }
  }

  // =========================
  // 📤 EXPORT DEL STORE
  // =========================
  return {
    // Estado
    token,
    user,

    // Computed
    isAuthenticated,
    isAdmin,
    isReceptionist,
    userRole,

    // Acciones
    login,
    logout,
    fetchMe,
    refreshToken
  }
})
