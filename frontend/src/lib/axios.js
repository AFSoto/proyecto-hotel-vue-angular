// Importa axios para hacer peticiones HTTP
import axios from 'axios'

// Importa el router de Vue para poder redirigir en caso de errores (ej: logout)
import router from '@/router'

// Crea una instancia personalizada de Axios
const api = axios.create({
  // URL base de la API tomada desde variables de entorno (.env)
  baseURL: import.meta.env.VITE_API_URL,

  // Headers por defecto para todas las peticiones
  headers: {
    'Content-Type': 'application/json', // formato de envío
    'Accept': 'application/json'        // formato esperado de respuesta
  }
})

/**
 * 🔐 INTERCEPTOR DE REQUEST
 * Se ejecuta antes de cada petición HTTP
 * Sirve para inyectar automáticamente el token JWT
 */
api.interceptors.request.use(
  (config) => {
    // Obtiene el token desde localStorage
    const token = localStorage.getItem('token')

    // Si existe token, lo agrega al header Authorization
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }

    // Retorna la configuración modificada
    return config
  },
  (error) => Promise.reject(error) // maneja errores de configuración
)

/**
 * 🚨 INTERCEPTOR DE RESPONSE
 * Maneja respuestas de la API, especialmente errores como 401
 */
api.interceptors.response.use(
  (response) => response, // si todo va bien, retorna la respuesta normal

  async (error) => {
    const originalRequest = error.config

    // Verifica si la petición es login (no debe intentar refresh)
    const isLoginRequest = originalRequest.url.includes('/auth/login')

    // Evita bucles infinitos de reintento
    const alreadyRetried = originalRequest._retry

    /**
     * 🔄 Manejo de token expirado (401 Unauthorized)
     */
    if (error.response?.status === 401 && !isLoginRequest && !alreadyRetried) {
      originalRequest._retry = true

      try {
        // Intenta refrescar el token
        const { data } = await api.post('/auth/refresh')
        const newToken = data.token

        // Guarda el nuevo token
        localStorage.setItem('token', newToken)

        // Actualiza el header de la petición original
        originalRequest.headers.Authorization = `Bearer ${newToken}`

        // Reintenta la petición original con el nuevo token
        return api(originalRequest)
      } catch (refreshError) {
        // ❌ Si falla el refresh, la sesión ya expiró completamente

        // Limpia datos de autenticación
        localStorage.removeItem('token')
        localStorage.removeItem('user')

        // Redirige al login
        router.push('/login')

        return Promise.reject(refreshError)
      }
    }

    // Si no es 401 o no aplica refresh, rechaza el error normalmente
    return Promise.reject(error)
  }
)

// Exporta la instancia configurada de Axios
export default api
