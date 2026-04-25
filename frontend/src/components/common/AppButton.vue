


<template>
  <!-- 🔘 Botón reutilizable -->
  <button
    :type="type"
    :disabled="disabled || loading"
    :class="[
      // Clases base del botón
      'inline-flex items-center justify-center gap-2 font-medium rounded-lg transition-colors cursor-pointer',

      // Estilos cuando está deshabilitado
      'disabled:opacity-50 disabled:cursor-not-allowed',

      // Clases dinámicas
      sizeClasses,
      variantClasses
    ]"
  >
    <!-- 🔄 Spinner de carga (solo si loading = true) -->
    <svg
      v-if="loading"
      class="animate-spin h-4 w-4"
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 24 24"
    >
      <!-- Círculo base del spinner -->
      <circle
        class="opacity-25"
        cx="12"
        cy="12"
        r="10"
        stroke="currentColor"
        stroke-width="4"
      />

      <!-- Parte animada del spinner -->
      <path
        class="opacity-75"
        fill="currentColor"
        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"
      />
    </svg>

    <!-- 📦 Contenido del botón (texto, iconos, etc.) -->
    <slot />
  </button>
</template>



<script setup>
// Importa computed para propiedades reactivas derivadas
import { computed } from 'vue'

/**
 * 📥 Props del componente
 */
const props = defineProps({
  // Variante visual del botón
  variant: {
    type: String,
    default: 'primary',
    // Solo permite valores definidos
    validator: (v) => ['primary', 'secondary', 'danger', 'ghost'].includes(v)
  },

  // Tamaño del botón
  size: {
    type: String,
    default: 'md',
    validator: (v) => ['sm', 'md', 'lg'].includes(v)
  },

  // Tipo HTML del botón
  type: {
    type: String,
    default: 'button'
  },

  // Estado de carga
  loading: {
    type: Boolean,
    default: false
  },

  // Estado deshabilitado
  disabled: {
    type: Boolean,
    default: false
  }
})

/**
 * 🎨 Clases según variante
 */
const variantClasses = computed(() => {
  const variants = {
    primary: 'bg-[#1A2B4A] text-white hover:bg-[#243a5e]',
    secondary: 'bg-gray-100 text-gray-700 hover:bg-gray-200 border border-gray-300',
    danger: 'bg-red-600 text-white hover:bg-red-700',
    ghost: 'bg-transparent text-gray-600 hover:bg-gray-100'
  }

  // Retorna la clase correspondiente a la variante
  return variants[props.variant]
})

/**
 * 📏 Clases según tamaño
 */
const sizeClasses = computed(() => {
  const sizes = {
    sm: 'px-3 py-1.5 text-sm',
    md: 'px-4 py-2 text-sm',
    lg: 'px-6 py-3 text-base'
  }

  // Retorna la clase correspondiente al tamaño
  return sizes[props.size]
})
</script>
