<template>
  <!-- Header principal -->
  <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6">

    <!-- Lado izquierdo -->
    <div class="flex items-center gap-4">

      <!-- Botón hamburguesa (solo mobile) -->
      <button
        @click="$emit('toggle-sidebar')"
        class="lg:hidden text-gray-500 hover:text-gray-700 cursor-pointer"
      >
        <Menu class="w-6 h-6" />
      </button>

      <!-- Título de la página -->
      <div>
        <h1 class="text-lg font-semibold text-gray-900">
          {{ pageTitle }}
        </h1>
      </div>
    </div>

    <!-- Lado derecho -->
    <div class="flex items-center gap-3">

      <!-- Nombre del usuario (oculto en pantallas pequeñas) -->
      <span class="hidden sm:block text-sm text-gray-500">
        {{ authStore.user?.name }}
      </span>

      <!-- Avatar con iniciales -->
      <div class="w-8 h-8 bg-[#1A2B4A] rounded-full flex items-center justify-center">
        <span class="text-xs font-semibold text-white">
          {{ userInitials }}
        </span>
      </div>
    </div>
  </header>
</template>

<script setup>
// Importa utilidades reactivas
import { computed } from 'vue'

// Permite acceder a la ruta actual
import { useRoute } from 'vue-router'

// Store de autenticación
import { useAuthStore } from '@/stores/auth'

// Icono del menú hamburguesa
import { Menu } from 'lucide-vue-next'

/**
 * Eventos emitidos por el componente
 */
defineEmits(['toggle-sidebar'])

// Instancia de la ruta actual
const route = useRoute()

// Instancia del store
const authStore = useAuthStore()

/**
 * Título dinámico de la página
 * Se obtiene desde el meta de la ruta
 */
const pageTitle = computed(() => route.meta?.title || 'HotelOS')

/**
 * Iniciales del usuario
 */
const userInitials = computed(() => {
  const name = authStore.user?.name || ''

  return name
    .split(' ')
    .map(w => w[0])
    .join('')
    .toUpperCase()
    .slice(0, 2)
})
</script>
