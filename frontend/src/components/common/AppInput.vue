<template>
  <div>
    <!-- 🏷️ Label del input (opcional) -->
    <label
      v-if="label"
      :for="inputId"
      class="block text-sm font-medium text-gray-700 mb-1"
    >
      {{ label }}
    </label>

    <!-- 📦 Contenedor del input -->
    <div class="relative">
      <!-- 🔤 Input principal -->
      <input
        :id="inputId"
        :type="currentType"
        :value="modelValue"
        :placeholder="placeholder"
        :disabled="disabled"
        @input="$emit('update:modelValue', $event.target.value)"
        :class="[
          // Clases base
          'w-full rounded-lg border px-3 py-2 text-sm outline-none transition-colors',

          // Estilo del placeholder
          'placeholder:text-gray-400',

          // Estado disabled
          'disabled:bg-gray-50 disabled:text-gray-400 disabled:cursor-not-allowed',

          // Estado error vs normal
          error
            ? 'border-red-400 focus:border-red-500 focus:ring-2 focus:ring-red-100'
            : 'border-gray-300 focus:border-[#1A2B4A] focus:ring-2 focus:ring-blue-100'
        ]"
      />

      <!-- 👁️ Toggle para mostrar/ocultar contraseña -->
      <button
        v-if="type === 'password'"
        type="button"
        @click="togglePassword"
        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 cursor-pointer"
      >
        <!-- Icono cuando la contraseña está visible -->
        <EyeOff v-if="showPassword" class="w-4 h-4" />

        <!-- Icono cuando la contraseña está oculta -->
        <Eye v-else class="w-4 h-4" />
      </button>
    </div>

    <!-- ⚠️ Mensaje de error con animación -->
    <Transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0 -translate-y-1"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 -translate-y-1"
    >
      <p v-if="error" class="mt-1 text-sm text-red-500">
        {{ error }}
      </p>
    </Transition>
  </div>
</template>

<script setup>
// Importa utilidades reactivas
import { ref, computed } from 'vue'

// Iconos para mostrar/ocultar contraseña
import { Eye, EyeOff } from 'lucide-vue-next'

/**
 * 📥 Props del componente
 */
const props = defineProps({
  // Valor del input (v-model)
  modelValue: {
    type: [String, Number],
    default: ''
  },

  // Texto del label
  label: {
    type: String,
    default: ''
  },

  // Tipo de input (text, password, etc.)
  type: {
    type: String,
    default: 'text'
  },

  // Placeholder
  placeholder: {
    type: String,
    default: ''
  },

  // Mensaje de error
  error: {
    type: String,
    default: ''
  },

  // Estado disabled
  disabled: {
    type: Boolean,
    default: false
  }
})

/**
 * 📡 Emite actualización del v-model
 */
defineEmits(['update:modelValue'])

/**
 * 👁️ Estado para mostrar/ocultar contraseña
 */
const showPassword = ref(false)

/**
 * 🆔 Genera un ID único para el input
 */
const inputId = computed(() => {
  return `input-${props.label?.toLowerCase().replace(/\s+/g, '-') || Math.random().toString(36).substr(2, 9)}`
})

/**
 * 🔐 Tipo actual del input
 * Cambia dinámicamente si es password
 */
const currentType = computed(() => {
  if (props.type === 'password') {
    return showPassword.value ? 'text' : 'password'
  }
  return props.type
})

/**
 * 🔁 Alterna visibilidad de contraseña
 */
function togglePassword() {
  showPassword.value = !showPassword.value
}
</script>
