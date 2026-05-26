<template>
  <span
    :class="[
      'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
      variantClasses
    ]"
  >
    <slot />
  </span>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  variant: {
    type: String,
    default: 'default',
    validator: (value) => [
      'available', 'occupied', 'maintenance',
      'confirmed', 'checked_in', 'checked_out', 'cancelled',
      'admin', 'receptionist',
      'active', 'inactive',
      'success', 'danger', 'warning', 'info', 'default'
    ].includes(value)
  }
})

const variantClasses = computed(() => {
  const variants = {
    // Estados de habitación
    available: 'bg-green-50 text-green-700 border border-green-200',
    occupied: 'bg-red-50 text-red-700 border border-red-200',
    maintenance: 'bg-amber-50 text-amber-700 border border-amber-200',

    // Estados de reserva
    confirmed: 'bg-blue-50 text-blue-700 border border-blue-200',
    checked_in: 'bg-purple-50 text-purple-700 border border-purple-200',
    checked_out: 'bg-gray-50 text-gray-600 border border-gray-200',
    cancelled: 'bg-gray-50 text-gray-500 border border-gray-200',

    // Roles
    admin: 'bg-blue-50 text-blue-700 border border-blue-200',
    receptionist: 'bg-gray-50 text-gray-600 border border-gray-200',

    // Estado activo/inactivo
    active: 'bg-green-50 text-green-700 border border-green-200',
    inactive: 'bg-red-50 text-red-700 border border-red-200',

    // Genéricos
    success: 'bg-green-50 text-green-700 border border-green-200',
    danger: 'bg-red-50 text-red-700 border border-red-200',
    warning: 'bg-amber-50 text-amber-700 border border-amber-200',
    info: 'bg-blue-50 text-blue-700 border border-blue-200',
    default: 'bg-gray-50 text-gray-600 border border-gray-200'
  }
  return variants[props.variant]
})
</script>
