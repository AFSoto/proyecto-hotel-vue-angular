<template>
  <div class="space-y-8">
    <h1 class="text-2xl font-bold text-gray-800">Test de componentes</h1>

    <!-- Badges -->
    <div>
      <h2 class="text-sm font-semibold text-gray-500 mb-3">BADGES</h2>
      <div class="flex flex-wrap gap-2">
        <AppBadge variant="available">Disponible</AppBadge>
        <AppBadge variant="occupied">Ocupada</AppBadge>
        <AppBadge variant="maintenance">Mantenimiento</AppBadge>
        <AppBadge variant="confirmed">Confirmada</AppBadge>
        <AppBadge variant="cancelled">Cancelada</AppBadge>
        <AppBadge variant="admin">Admin</AppBadge>
        <AppBadge variant="receptionist">Recepcionista</AppBadge>
        <AppBadge variant="active">Activo</AppBadge>
        <AppBadge variant="inactive">Inactivo</AppBadge>
      </div>
    </div>

    <!-- Modal -->
    <div>
      <h2 class="text-sm font-semibold text-gray-500 mb-3">MODAL</h2>
      <AppButton @click="showModal = true">Abrir modal</AppButton>

      <AppModal :open="showModal" title="Crear usuario" @close="showModal = false">
        <p class="text-sm text-gray-600">Aquí iría el formulario de creación de usuario.</p>
        <template #footer>
          <div class="flex justify-end gap-3">
            <AppButton variant="secondary" @click="showModal = false">Cancelar</AppButton>
            <AppButton>Guardar</AppButton>
          </div>
        </template>
      </AppModal>
    </div>

    <!-- Confirm Dialog -->
    <div>
      <h2 class="text-sm font-semibold text-gray-500 mb-3">CONFIRM DIALOG</h2>
      <div class="flex gap-3">
        <AppButton variant="danger" @click="showConfirm = true">Eliminar usuario</AppButton>
        <AppButton @click="showConfirmSafe = true">Confirmar check-in</AppButton>
      </div>

      <ConfirmDialog
        :open="showConfirm"
        title="Eliminar usuario"
        message="Se eliminará el usuario permanentemente. Esta acción no se puede deshacer."
        confirm-label="Eliminar"
        danger
        @confirm="showConfirm = false"
        @cancel="showConfirm = false"
      />

      <ConfirmDialog
        :open="showConfirmSafe"
        title="Confirmar check-in"
        message="Se registrará el check-in y la habitación pasará a estado ocupada."
        confirm-label="Confirmar check-in"
        @confirm="showConfirmSafe = false"
        @cancel="showConfirmSafe = false"
      />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import AppButton from '@/components/common/AppButton.vue'
import AppBadge from '@/components/common/AppBadge.vue'
import AppModal from '@/components/common/AppModal.vue'
import ConfirmDialog from '@/components/common/ConfirmDialog.vue'

const showModal = ref(false)
const showConfirm = ref(false)
const showConfirmSafe = ref(false)
</script>
