<template>
  <!--
    Contenedor principal de la tabla.

    - Fondo blanco
    - Bordes redondeados
    - Borde gris claro
    - overflow-hidden evita que elementos internos
      sobresalgan visualmente.
  -->
  <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">

    <!--
      Contenedor responsive.

      Permite scroll horizontal automáticamente
      cuando la tabla excede el ancho disponible.
    -->
    <div class="overflow-x-auto">

      <!-- Tabla principal -->
      <table class="w-full">

        <!-- =========================================================
             HEADER
        ========================================================== -->

        <thead>
          <tr class="border-b border-gray-200 bg-gray-50/50">

            <!--
              Genera dinámicamente las columnas
              usando la prop "columns".

              Cada columna debe contener:
              - key
              - label
              - width (opcional)
            -->
            <th
              v-for="col in columns"
              :key="col.key"
              :style="col.width ? { width: col.width } : {}"

              class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider"
            >
              {{ col.label }}
            </th>
          </tr>
        </thead>

        <!-- =========================================================
             BODY — LOADING
        ========================================================== -->

        <!--
          Se renderiza mientras loading sea true.

          Muestra filas skeleton animadas simulando
          la estructura de la tabla mientras llegan
          los datos del servidor.
        -->
        <tbody v-if="loading">

          <!--
            Genera la cantidad de filas skeleton
            definida en "skeletonRows".
          -->
          <tr
            v-for="row in skeletonRows"
            :key="row"
            class="border-b border-gray-100"
          >

            <!--
              Genera skeletons por cada columna.
            -->
            <td
              v-for="col in columns"
              :key="col.key"
              class="px-4 py-3.5"
            >

              <!--
                Barra animada simulando contenido.

                El ancho cambia aleatoriamente para
                que el skeleton se vea más natural.
              -->
              <div
                class="h-4 bg-gray-200 rounded animate-pulse"
                :style="{ width: randomWidth() }"
              />
            </td>
          </tr>
        </tbody>

        <!-- =========================================================
             BODY — DATA
        ========================================================== -->

        <!--
          Se renderiza cuando:
          - loading es false
          - rows contiene registros
        -->
        <tbody v-else-if="rows.length > 0">

          <!--
            Recorre cada fila de datos.
          -->
          <tr
            v-for="(row, rowIndex) in rows"


            :key="row.id || rowIndex"

            class="border-b border-gray-100 last:border-0 hover:bg-gray-50/50 transition-colors"
          >

            <!--
              Recorre las columnas para mostrar
              cada celda correspondiente.
            -->
            <td
              v-for="col in columns"
              :key="col.key"
              class="px-4 py-3.5 text-sm text-gray-700"
            >

              <!--
                Slot dinámico por columna.

                Permite personalizar el renderizado
                de cualquier celda desde el componente padre.

                Ejemplo:
                <template #cell-status="{ value }">
                  ...
                </template>

                Props enviadas:
                - row   → fila completa
                - value → valor específico de la columna
              -->
              <slot
                :name="`cell-${col.key}`"
                :row="row"
                :value="row[col.key]"
              >

                <!--
                  Render por defecto.

                  Si el padre no proporciona slot,
                  simplemente se muestra el valor.
                -->
                {{ row[col.key] }}
              </slot>
            </td>
          </tr>
        </tbody>

        <!-- =========================================================
             BODY — EMPTY STATE
        ========================================================== -->

        <!--
          Se renderiza cuando:
          - loading es false
          - no existen registros
        -->
        <tbody v-else>
          <tr>

            <!--
              colspan ocupa todas las columnas
              para centrar correctamente el mensaje vacío.
            -->
            <td
              :colspan="columns.length"
              class="px-4 py-16 text-center"
            >

              <!--
                Slot opcional para personalizar
                el estado vacío.
              -->
              <slot name="empty">

                <!-- Estado vacío por defecto -->
                <div class="flex flex-col items-center">

                  <!-- Icono -->
                  <Inbox class="w-10 h-10 text-gray-300 mb-3" />

                  <!-- Mensaje -->
                  <p class="text-sm font-medium text-gray-400">
                    No hay registros aún
                  </p>
                </div>
              </slot>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- =========================================================
         PAGINACIÓN
    ========================================================== -->

    <!--
      La paginación solo se muestra
      si existe la prop "pagination".
    -->
    <div
      v-if="pagination"
      class="border-t border-gray-200 bg-gray-50/30"
    >

      <!--
        Componente reutilizable de paginación.

        Se le envían:
        - página actual
        - última página
        - total de registros

        Además, re-emite el evento change
        como page-change hacia el componente padre.
      -->
      <AppPagination
        :current-page="pagination.current_page"
        :last-page="pagination.last_page"
        :total="pagination.total"
        @change="$emit('page-change', $event)"
      />
    </div>
  </div>
</template>

<script setup>

/*
|--------------------------------------------------------------------------
| Imports
|--------------------------------------------------------------------------
|
| Inbox:
| Icono utilizado para el estado vacío.
|
| AppPagination:
| Componente reutilizable de paginación.
|
*/

import { Inbox } from 'lucide-vue-next'
import AppPagination from '@/components/common/AppPagination.vue'

/*
|--------------------------------------------------------------------------
| Props
|--------------------------------------------------------------------------
|
| columns:
| Define las columnas de la tabla.
|
| rows:
| Registros que serán renderizados.
|
| loading:
| Indica si la tabla está cargando información.
|
| pagination:
| Información de paginación proveniente del backend.
|
*/

defineProps({

  /*
    Configuración de columnas.

    Ejemplo:
    [
      { key: 'name', label: 'Nombre' },
      { key: 'email', label: 'Correo' }
    ]
  */
  columns: {
    type: Array,
    required: true
  },

  /*
    Filas de datos.
  */
  rows: {
    type: Array,
    default: () => []
  },

  /*
    Estado de carga.
  */
  loading: {
    type: Boolean,
    default: false
  },

  /*
    Objeto de paginación.

    Ejemplo:
    {
      current_page: 1,
      last_page: 5,
      total: 100
    }
  */
  pagination: {
    type: Object,
    default: null
  }
})

/*
|--------------------------------------------------------------------------
| Emits
|--------------------------------------------------------------------------
|
| page-change:
| Se emite cuando el usuario cambia de página.
|
*/

defineEmits(['page-change'])

/*
|--------------------------------------------------------------------------
| Skeleton Rows
|--------------------------------------------------------------------------
|
| Cantidad de filas skeleton que se mostrarán
| mientras loading sea true.
|
*/

const skeletonRows = 5

/*
|--------------------------------------------------------------------------
| randomWidth
|--------------------------------------------------------------------------
|
| Genera un ancho aleatorio para los skeletons.
|
| Esto hace que la animación visual
| se vea más natural y menos repetitiva.
|
*/

function randomWidth() {
  const widths = ['40%', '55%', '70%', '85%', '60%']

  return widths[
    Math.floor(Math.random() * widths.length)
  ]
}

</script>
