<template>
  <!-- 🧱 Layout principal dividido en dos columnas -->
  <div class="min-h-screen flex">

    <!-- 🎨 Columna izquierda (branding) -->
    <div class="hidden lg:flex lg:w-1/2 bg-[#1A2B4A] flex-col items-center justify-center p-12">
      <div class="max-w-md text-center">

        <!-- 🏨 Icono principal -->
        <div class="w-20 h-20 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-8">
          <Building2 class="w-10 h-10 text-white" />
        </div>

        <!-- 🏷️ Nombre del sistema -->
        <h1 class="text-4xl font-bold text-white mb-4">HotelOS</h1>

        <!-- 📄 Descripción -->
        <p class="text-blue-200 text-lg leading-relaxed">
          Sistema de gestión hotelera. Controla reservas, habitaciones y facturación desde un solo lugar.
        </p>

        <!-- ✅ Lista de beneficios -->
        <div class="mt-12 space-y-4 text-left">
          <div class="flex items-center gap-3 text-blue-200">
            <CheckCircle class="w-5 h-5 text-green-400 flex-shrink-0" />
            <span>Gestión de reservas en tiempo real</span>
          </div>
          <div class="flex items-center gap-3 text-blue-200">
            <CheckCircle class="w-5 h-5 text-green-400 flex-shrink-0" />
            <span>Check-in y check-out ágil</span>
          </div>
          <div class="flex items-center gap-3 text-blue-200">
            <CheckCircle class="w-5 h-5 text-green-400 flex-shrink-0" />
            <span>Facturación automática</span>
          </div>
          <div class="flex items-center gap-3 text-blue-200">
            <CheckCircle class="w-5 h-5 text-green-400 flex-shrink-0" />
            <span>Control de habitaciones por estado</span>
          </div>
        </div>
      </div>
    </div>

    <!-- 🧾 Columna derecha (formulario) -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6">
      <div class="w-full max-w-md">

        <!-- 📱 Logo en mobile -->
        <div class="lg:hidden flex items-center gap-3 mb-10">
          <div class="w-10 h-10 bg-[#1A2B4A] rounded-lg flex items-center justify-center">
            <Building2 class="w-5 h-5 text-white" />
          </div>
          <span class="text-xl font-bold text-gray-900">HotelOS</span>
        </div>

        <!-- 🔐 Título -->
        <h2 class="text-2xl font-bold text-gray-900">Iniciar sesión</h2>

        <!-- 📄 Subtítulo -->
        <p class="text-gray-500 mt-2 mb-8">
          Ingresa tus credenciales para acceder al sistema
        </p>

        <!-- ❌ Error general -->
        <Transition
          enter-active-class="transition duration-200 ease-out"
          enter-from-class="opacity-0 -translate-y-1"
          enter-to-class="opacity-100 translate-y-0"
          leave-active-class="transition duration-150 ease-in"
          leave-from-class="opacity-100 translate-y-0"
          leave-to-class="opacity-0 -translate-y-1"
        >
          <div
            v-if="errorMessage"
            class="mb-6 flex items-center gap-3 px-4 py-3 bg-red-50 border border-red-200 rounded-lg"
          >
            <AlertCircle class="w-5 h-5 text-red-500 flex-shrink-0" />
            <p class="text-sm text-red-700">{{ errorMessage }}</p>
          </div>
        </Transition>

        <!-- 📝 Formulario -->
        <form @submit.prevent="handleLogin" class="space-y-5">

          <!-- 📧 Input email -->
          <AppInput
            v-model="form.email"
            label="Correo electrónico"
            type="email"
            placeholder="admin@hotel.com"
            :error="errors.email"
            :disabled="loading"
          />

          <!-- 🔑 Input contraseña -->
          <AppInput
            v-model="form.password"
            label="Contraseña"
            type="password"
            placeholder="Ingresa tu contraseña"
            :error="errors.password"
            :disabled="loading"
          />

          <!-- 🚀 Botón login -->
          <AppButton
            type="submit"
            :loading="loading"
            :disabled="loading"
            class="w-full"
            size="lg"
          >
            Iniciar sesión
          </AppButton>
        </form>

        <!-- 📌 Footer -->
        <p class="mt-8 text-center text-sm text-gray-400">
          HotelOS v1.0 — Sistema de Gestión Hotelera
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
// Importa reactividad de Vue
import { ref, reactive } from 'vue'

// Iconos
import { Building2, CheckCircle, AlertCircle } from 'lucide-vue-next'

// Store de autenticación
import { useAuthStore } from '@/stores/auth'

// Componentes reutilizables
import AppInput from '@/components/common/AppInput.vue'
import AppButton from '@/components/common/AppButton.vue'

// Instancia del store
const authStore = useAuthStore()

// 📦 Estado del formulario
const form = reactive({
  email: '',
  password: ''
})

// ⚠️ Errores de validación
const errors = reactive({
  email: '',
  password: ''
})

// ❌ Error general del backend
const errorMessage = ref('')

// 🔄 Estado de carga
const loading = ref(false)

/**
 * ✅ Validación del formulario
 */
function validate() {
  let valid = true

  // Reset errores
  errors.email = ''
  errors.password = ''

  // Validación email
  if (!form.email) {
    errors.email = 'El correo electrónico es obligatorio'
    valid = false
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) {
    errors.email = 'Ingresa un correo electrónico válido'
    valid = false
  }

  // Validación password
  if (!form.password) {
    errors.password = 'La contraseña es obligatoria'
    valid = false
  }

  return valid
}

/**
 * 🔐 Manejo del login
 */
async function handleLogin() {
  // Limpia error general
  errorMessage.value = ''

  // Valida antes de enviar
  if (!validate()) return

  // Activa loading
  loading.value = true

  try {
    // Llama al store (API)
    await authStore.login({
      email: form.email,
      password: form.password
    })

  } catch (error) {
    const status = error.response?.status

    // Manejo de errores por código HTTP
    if (status === 401) {
      errorMessage.value = 'Credenciales incorrectas. Verifica tu email y contraseña.'
    } else if (status === 403) {
      errorMessage.value = 'Tu cuenta está desactivada. Contacta al administrador.'
    } else if (status === 422) {
      const serverErrors = error.response?.data?.errors || {}
      if (serverErrors.email) errors.email = serverErrors.email[0]
      if (serverErrors.password) errors.password = serverErrors.password[0]
    } else {
      errorMessage.value = 'Error de conexión. Verifica que el servidor esté activo.'
    }
  } finally {
    // Desactiva loading
    loading.value = false
  }
}
</script>
