// Importa ref para crear estado reactivo en Vue
import { ref } from 'vue'

// Array reactivo que almacena todos los toasts activos
const toasts = ref([])

// Contador incremental para asignar IDs únicos a cada toast
let toastId = 0

/**
 * ➕ Crea y agrega un nuevo toast
 * @param {string} type - Tipo de notificación (success, error, warning, info)
 * @param {string} message - Mensaje a mostrar
 * @param {number} duration - Duración en ms antes de desaparecer (default: 3000)
 */
function addToast(type, message, duration = 3000) {
  // Genera un ID único
  const id = ++toastId

  // Agrega el toast al estado reactivo
  toasts.value.push({ id, type, message })

  // Elimina automáticamente el toast después del tiempo indicado
  setTimeout(() => {
    removeToast(id)
  }, duration)
}

/**
 * ❌ Elimina un toast por su ID
 * @param {number} id
 */
function removeToast(id) {
  // Filtra el array eliminando el toast correspondiente
  toasts.value = toasts.value.filter(t => t.id !== id)
}

/**
 * 🧠 Composable para manejar toasts en toda la aplicación
 */
export function useToast() {
  return {
    // Estado reactivo de toasts
    toasts,

    // Método para eliminar manualmente un toast
    removeToast,

    // Métodos de conveniencia por tipo
    success: (message) => addToast('success', message),
    error: (message) => addToast('error', message),
    warning: (message) => addToast('warning', message),
    info: (message) => addToast('info', message)
  }
}
