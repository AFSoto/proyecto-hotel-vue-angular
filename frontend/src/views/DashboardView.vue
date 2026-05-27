<template>
  <div class="space-y-8">
    <h1 class="text-2xl font-bold text-gray-800">Test AppTable</h1>

    <!-- Controles -->
    <div class="flex gap-3">
      <AppButton @click="state = 'loading'">Loading</AppButton>
      <AppButton variant="secondary" @click="state = 'data'">Con datos</AppButton>
      <AppButton variant="ghost" @click="state = 'empty'">Vacío</AppButton>
    </div>

    <!-- Tabla -->
    <AppTable
      :columns="columns"
      :rows="state === 'data' ? rows : []"
      :loading="state === 'loading'"
      :pagination="state === 'data' ? pagination : null"
      @page-change="handlePageChange"
    >
      <template #cell-role="{ row }">
        <AppBadge :variant="row.role === 'Admin' ? 'admin' : 'receptionist'">
          {{ row.role }}
        </AppBadge>
      </template>

      <template #cell-status="{ row }">
        <AppBadge :variant="row.active ? 'active' : 'inactive'">
          {{ row.active ? 'Activo' : 'Inactivo' }}
        </AppBadge>
      </template>

      <template #cell-actions>
        <div class="flex gap-2">
          <AppButton size="sm" variant="ghost">Editar</AppButton>
          <AppButton size="sm" variant="danger">Eliminar</AppButton>
        </div>
      </template>
    </AppTable>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import AppTable from '@/components/common/AppTable.vue'
import AppBadge from '@/components/common/AppBadge.vue'
import AppButton from '@/components/common/AppButton.vue'

const state = ref('data')

const columns = [
  { key: 'name', label: 'Nombre' },
  { key: 'email', label: 'Email' },
  { key: 'role', label: 'Rol', width: '120px' },
  { key: 'status', label: 'Estado', width: '100px' },
  { key: 'actions', label: 'Acciones', width: '180px' }
]

const rows = [
  { id: 1, name: 'Carlos Admin', email: 'admin@hotel.com', role: 'Admin', active: true },
  { id: 2, name: 'María Recepción', email: 'recep@hotel.com', role: 'Recepcionista', active: true },
  { id: 3, name: 'Juan López', email: 'juan@hotel.com', role: 'Recepcionista', active: false }
]

const pagination = ref({
  current_page: 1,
  last_page: 3,
  total: 45
})

function handlePageChange(page) {
  pagination.value.current_page = page
}
</script>
