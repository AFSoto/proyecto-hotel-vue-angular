<template>
  <div class="p-8 max-w-sm mx-auto space-y-4 mt-20">
    <h1 class="text-2xl font-bold">Test de Toasts</h1>

    <div class="flex flex-wrap gap-3">
      <AppButton @click="toast.success('Operación exitosa')">Success</AppButton>
      <AppButton variant="danger" @click="toast.error('Algo salió mal')">Error</AppButton>
      <AppButton variant="secondary" @click="toast.warning('Ten cuidado')">Warning</AppButton>
      <AppButton variant="ghost" @click="toast.info('Información útil')">Info</AppButton>
    </div>
  </div>
</template>

<script setup>
import AppButton from '@/components/common/AppButton.vue'
import { useToast } from '@/composables/useToast'

const toast = useToast()
</script>
