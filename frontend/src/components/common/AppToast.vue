<template>
  <!-- 📍 Contenedor de toasts (posición fija en la pantalla) -->
  <div class="fixed bottom-4 right-4 z-50 flex flex-col gap-3 max-w-sm">

    <!-- 🎞️ Grupo de transición para animar entrada/salida -->
    <TransitionGroup
      enter-active-class="transition duration-300 ease-out"
      enter-from-class="opacity-0 translate-x-8"
      enter-to-class="opacity-100 translate-x-0"
      leave-active-class="transition duration-200 ease-in"
      leave-from-class="opacity-100 translate-x-0"
      leave-to-class="opacity-0 translate-x-8"
    >
      <!-- 🔔 Renderiza cada toast -->
      <div
        v-for="toast in toasts"
        :key="toast.id"
        :class="[
          // Clases base del toast
          'flex items-start gap-3 px-4 py-3 rounded-lg shadow-lg border',

          // Clases dinámicas según tipo (success, error, etc.)
          toastClasses[toast.type]
        ]"
      >
        <!-- 🎨 Icono dinámico según tipo -->
        <component
          :is="toastIcons[toast.type]"
          class="w-5 h-5 flex-shrink-0 mt-0.5"
        />

        <!-- 📝 Mensaje del toast -->
        <p class="text-sm font-medium flex-1">
          {{ toast.message }}
        </p>

        <!-- ❌ Botón para cerrar manualmente -->
        <button
          @click="removeToast(toast.id)"
          class="text-current opacity-50 hover:opacity-100 transition-opacity cursor-pointer flex-shrink-0"
        >
          <X class="w-4 h-4" />
        </button>
      </div>
    </TransitionGroup>
  </div>
</template>

<script setup>
// Iconos usados para los diferentes tipos de toast
import {
  CheckCircle,
  XCircle,
  AlertTriangle,
  Info,
  X
} from 'lucide-vue-next'

// Composable que maneja el estado de los toasts
import { useToast } from '@/composables/useToast'

// Obtiene estado y acciones
const { toasts, removeToast } = useToast()

/**
 * 🎨 Clases por tipo de toast
 */
const toastClasses = {
  success: 'bg-green-50 text-green-800 border-green-200',
  error: 'bg-red-50 text-red-800 border-red-200',
  warning: 'bg-amber-50 text-amber-800 border-amber-200',
  info: 'bg-blue-50 text-blue-800 border-blue-200'
}

/**
 * 🎯 Iconos por tipo de toast
 */
const toastIcons = {
  success: CheckCircle,
  error: XCircle,
  warning: AlertTriangle,
  info: Info
}
</script>
