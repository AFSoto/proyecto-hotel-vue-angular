// Importa la función defineConfig de Vite
import { defineConfig } from 'vite'

// Plugin oficial de Vue para Vite
import vue from '@vitejs/plugin-vue'

// Plugin de Tailwind CSS para Vite
import tailwindcss from '@tailwindcss/vite'

// Utilidades de Node.js para manejar rutas de forma compatible con ES Modules
import { fileURLToPath, URL } from 'node:url'

// Exporta la configuración de Vite
export default defineConfig({
  // Lista de plugins que usará Vite
  plugins: [
    vue(),          // Habilita soporte para Vue 3
    tailwindcss(),  // Integra Tailwind CSS en el build
  ],

  // Configuración de resolución de módulos
  resolve: {
    alias: {
      // Define '@' como acceso directo a la carpeta 'src'
      // Ejemplo: '@/components/Hello.vue'
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  }
})
