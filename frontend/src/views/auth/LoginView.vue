<template>
  <div class="p-8 max-w-sm mx-auto space-y-6 mt-20">
    <h1 class="text-2xl font-bold">Test de componentes</h1>

    <AppInput
      v-model="email"
      label="Email"
      type="email"
      placeholder="admin@hotel.com"
    />

    <AppInput
      v-model="password"
      label="Contraseña"
      type="password"
      placeholder="Tu contraseña"
      error="La contraseña es obligatoria"
    />

    <div class="flex gap-3">
      <AppButton>Primary</AppButton>
      <AppButton variant="secondary">Secondary</AppButton>
      <AppButton variant="danger">Danger</AppButton>
      <AppButton variant="ghost">Ghost</AppButton>
    </div>

    <AppButton loading>Cargando...</AppButton>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import AppInput from '@/components/common/AppInput.vue'
import AppButton from '@/components/common/AppButton.vue'

const email = ref('')
const password = ref('')
</script>
