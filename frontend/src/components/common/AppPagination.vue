<template>
  <!--
    Contenedor principal de la paginación.

    Solo se renderiza si existe más de una página.
    Esto evita mostrar controles innecesarios cuando
    todos los registros caben en una sola página.
  -->
  <div
    v-if="lastPage > 1"
    class="flex items-center justify-between px-4 py-3"
  >

    <!--
      Información actual de la paginación.

      Muestra:
      - Página actual
      - Total de páginas
      - Total de registros (si existe)
    -->
    <p class="text-sm text-gray-500">
      Página {{ currentPage }} de {{ lastPage }}

      <!--
        El total de registros solo se muestra en pantallas
        pequeñas hacia arriba (sm:inline).

        Además, solo se renderiza si la prop "total"
        tiene un valor válido.
      -->
      <span v-if="total" class="hidden sm:inline">
        — {{ total }} registros
      </span>
    </p>

    <!--
      Contenedor de botones de navegación.
    -->
    <div class="flex items-center gap-2">

      <!--
        Botón para ir a la página anterior.

        - Se deshabilita automáticamente si el usuario
          ya se encuentra en la primera página.
        - Emite el evento "change" enviando
          la página anterior.
      -->
      <button
        :disabled="currentPage <= 1"
        @click="$emit('change', currentPage - 1)"
        class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-40 disabled:cursor-not-allowed cursor-pointer transition-colors"
      >
        <!-- Icono de flecha izquierda -->
        <ChevronLeft class="w-4 h-4" />

        Anterior
      </button>

      <!--
        Botón para ir a la siguiente página.

        - Se deshabilita automáticamente si el usuario
          ya se encuentra en la última página.
        - Emite el evento "change" enviando
          la siguiente página.
      -->
      <button
        :disabled="currentPage >= lastPage"
        @click="$emit('change', currentPage + 1)"
        class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-40 disabled:cursor-not-allowed cursor-pointer transition-colors"
      >
        Siguiente

        <!-- Icono de flecha derecha -->
        <ChevronRight class="w-4 h-4" />
      </button>
    </div>
  </div>
</template>

<script setup>

/*
|--------------------------------------------------------------------------
| Imports
|--------------------------------------------------------------------------
|
| Se importan los íconos utilizados en los botones de navegación
| desde la librería lucide-vue-next.
|
*/

import { ChevronLeft, ChevronRight } from 'lucide-vue-next'

/*
|--------------------------------------------------------------------------
| Props
|--------------------------------------------------------------------------
|
| Define las propiedades que recibe el componente desde el padre.
|
| currentPage:
| Página actual de la paginación.
|
| lastPage:
| Última página disponible.
|
| total:
| Total de registros encontrados.
| Es opcional y por defecto será null.
|
*/

defineProps({
  currentPage: {
    type: Number,
    required: true
  },

  lastPage: {
    type: Number,
    required: true
  },

  total: {
    type: Number,
    default: null
  }
})

/*
|--------------------------------------------------------------------------
| Emits
|--------------------------------------------------------------------------
|
| Define los eventos personalizados emitidos por el componente.
|
| change:
| Se emite cuando el usuario cambia de página.
| El valor emitido corresponde al nuevo número de página.
|
*/

defineEmits(['change'])

</script>
