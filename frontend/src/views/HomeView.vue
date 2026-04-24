<template>
  <div class="min-h-screen flex flex-col bg-white">
    <!-- Header -->
    <header class="border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 bg-[#1A2B4A] rounded-lg flex items-center justify-center">
            <Building2 class="w-5 h-5 text-white" />
          </div>
          <span class="text-xl font-bold text-gray-900">HotelOS</span>
        </div>

        <router-link
          to="/login"
          class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#1A2B4A] text-white text-sm font-medium rounded-lg hover:bg-[#243a5e] transition-colors"
        >
          <LogIn class="w-4 h-4" />
          Iniciar sesión
        </router-link>
      </div>
    </header>

    <!-- Hero -->
    <main class="flex-1 flex items-center">
      <div class="max-w-7xl mx-auto px-6 py-20 grid lg:grid-cols-2 gap-16 items-center">
        <div>
          <span class="inline-block px-3 py-1 bg-blue-50 text-[#1A2B4A] text-sm font-medium rounded-full mb-6">
            Sistema de Gestión Hotelera
          </span>
          <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 leading-tight">
            Gestiona tu hotel de forma
            <span class="text-[#1A2B4A]">simple y eficiente</span>
          </h1>
          <p class="mt-6 text-lg text-gray-600 leading-relaxed">
            HotelOS es el núcleo operativo que tu hotel necesita. Reservas, check-in, check-out y facturación en un solo lugar. Sin complicaciones.
          </p>

          <div class="mt-10 flex flex-col sm:flex-row gap-4">
            <router-link
              to="/login"
              class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-[#1A2B4A] text-white font-medium rounded-lg hover:bg-[#243a5e] transition-colors"
            >
              <LogIn class="w-4 h-4" />
              Acceder al sistema
            </router-link>
          </div>

          <!-- Features mini -->
          <div class="mt-14 grid grid-cols-2 gap-6">
            <div class="flex items-start gap-3">
              <div class="w-9 h-9 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                <CalendarCheck class="w-4 h-4 text-[#1A2B4A]" />
              </div>
              <div>
                <p class="text-sm font-semibold text-gray-900">Reservas</p>
                <p class="text-sm text-gray-500">Gestión completa de reservas con control de disponibilidad</p>
              </div>
            </div>

            <div class="flex items-start gap-3">
              <div class="w-9 h-9 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                <DoorOpen class="w-4 h-4 text-[#1A2B4A]" />
              </div>
              <div>
                <p class="text-sm font-semibold text-gray-900">Check-in / out</p>
                <p class="text-sm text-gray-500">Proceso ágil con facturación automática</p>
              </div>
            </div>

            <div class="flex items-start gap-3">
              <div class="w-9 h-9 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                <BedDouble class="w-4 h-4 text-[#1A2B4A]" />
              </div>
              <div>
                <p class="text-sm font-semibold text-gray-900">Habitaciones</p>
                <p class="text-sm text-gray-500">Control de estados, tipos y disponibilidad en tiempo real</p>
              </div>
            </div>

            <div class="flex items-start gap-3">
              <div class="w-9 h-9 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                <Receipt class="w-4 h-4 text-[#1A2B4A]" />
              </div>
              <div>
                <p class="text-sm font-semibold text-gray-900">Facturación</p>
                <p class="text-sm text-gray-500">Facturas generadas automáticamente al check-out</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Ilustración lado derecho -->
        <div class="hidden lg:flex items-center justify-center">
          <div class="w-full max-w-md bg-gradient-to-br from-[#1A2B4A] to-[#2d4a7a] rounded-2xl p-10 text-white">
            <Building2 class="w-16 h-16 mb-6 opacity-80" />
            <h2 class="text-2xl font-bold mb-3">HotelOS MVP</h2>
            <p class="text-blue-200 leading-relaxed">
              Todo lo que tu equipo necesita para operar el día a día. Diseñado para hoteles pequeños y medianos que quieren orden sin complejidad.
            </p>
            <div class="mt-8 space-y-3">
              <div class="flex items-center gap-3">
                <CheckCircle class="w-5 h-5 text-green-400" />
                <span class="text-sm">Autenticación por roles</span>
              </div>
              <div class="flex items-center gap-3">
                <CheckCircle class="w-5 h-5 text-green-400" />
                <span class="text-sm">Gestión de habitaciones</span>
              </div>
              <div class="flex items-center gap-3">
                <CheckCircle class="w-5 h-5 text-green-400" />
                <span class="text-sm">Reservas con anti-solapamiento</span>
              </div>
              <div class="flex items-center gap-3">
                <CheckCircle class="w-5 h-5 text-green-400" />
                <span class="text-sm">Facturación automática</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-gray-200 bg-gray-50">
      <div class="max-w-7xl mx-auto px-6 py-8 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-2">
          <Building2 class="w-4 h-4 text-gray-400" />
          <span class="text-sm text-gray-500">HotelOS © {{ currentYear }}. Sistema de gestión hotelera.</span>
        </div>
        <p class="text-sm text-gray-400">Versión 1.0 — MVP</p>
      </div>
    </footer>
  </div>
</template>

<script setup>
import {
  Building2,
  LogIn,
  CalendarCheck,
  DoorOpen,
  BedDouble,
  Receipt,
  CheckCircle
} from 'lucide-vue-next'

const currentYear = new Date().getFullYear()
</script>
