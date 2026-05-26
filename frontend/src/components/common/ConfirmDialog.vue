<template>
  <AppModal
    :open="open"
    :title="title"
    size="sm"
    :close-on-overlay="false"
    @close="$emit('cancel')"
  >
    <div class="flex flex-col items-center text-center py-2">
      <div
        :class="[
          'w-12 h-12 rounded-full flex items-center justify-center mb-4',
          danger ? 'bg-red-100' : 'bg-blue-100'
        ]"
      >
        <AlertTriangle v-if="danger" class="w-6 h-6 text-red-600" />
        <HelpCircle v-else class="w-6 h-6 text-blue-600" />
      </div>

      <p class="text-sm text-gray-600 leading-relaxed">{{ message }}</p>
    </div>

    <template #footer>
      <div class="flex items-center justify-end gap-3">
        <AppButton
          variant="secondary"
          @click="$emit('cancel')"
          :disabled="loading"
        >
          Cancelar
        </AppButton>
        <AppButton
          :variant="danger ? 'danger' : 'primary'"
          :loading="loading"
          @click="$emit('confirm')"
        >
          {{ confirmLabel }}
        </AppButton>
      </div>
    </template>
  </AppModal>
</template>

<script setup>
import { AlertTriangle, HelpCircle } from 'lucide-vue-next'
import AppModal from '@/components/common/AppModal.vue'
import AppButton from '@/components/common/AppButton.vue'

defineProps({
  open: {
    type: Boolean,
    default: false
  },
  title: {
    type: String,
    default: '¿Estás seguro?'
  },
  message: {
    type: String,
    default: 'Esta acción no se puede deshacer.'
  },
  confirmLabel: {
    type: String,
    default: 'Confirmar'
  },
  danger: {
    type: Boolean,
    default: false
  },
  loading: {
    type: Boolean,
    default: false
  }
})

defineEmits(['confirm', 'cancel'])
</script>
