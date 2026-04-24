// Importa funciones para crear el router de Vue
import { createRouter, createWebHistory } from 'vue-router'

// Store de autenticación (Pinia)
import { useAuthStore } from '@/stores/auth'

// =========================
// 📄 VISTAS (PÁGINAS)
// =========================

// Vista de login
import LoginView from '@/views/auth/LoginView.vue'

// Dashboard del admin
import DashboardView from '@/views/admin/DashboardView.vue'

// Home del recepcionista
import ReceptionistHomeView from '@/views/receptionist/ReceptionistHomeView.vue'

import HomeView from '@/views/HomeView.vue'

/**
 *  DEFINICIÓN DE RUTAS
 */
const routes = [

  // 🔐 LOGIN (pública)
  {
    path: '/login',
    name: 'login',
    component: LoginView,
    meta: { requiresAuth: false } // no requiere autenticación
  },

  // ─────────────────────────────
  // 🧑‍💼 ADMIN
  // ─────────────────────────────
  {
    path: '/admin/dashboard',
    name: 'admin.dashboard',
    component: DashboardView,
    meta: {
      requiresAuth: true,  // requiere login
      role: 'admin',       // solo admin puede acceder
      title: 'Dashboard'
    }
  },

  // ─────────────────────────────
  // 🧑‍💻 RECEPTIONIST
  // ─────────────────────────────
  {
    path: '/receptionist/home',
    name: 'receptionist.home',
    component: ReceptionistHomeView,
    meta: {
      requiresAuth: true,
      role: 'receptionist',
      title: 'Inicio'
    }
  },

  // ─────────────────────────────
  //  RUTA RAÍZ
  // ─────────────────────────────
    {
    path: '/',
    name: 'home',
    component: HomeView,
    meta: { requiresAuth: false }
  },

  // ─────────────────────────────
  // ❌ 404 NOT FOUND
  // ─────────────────────────────
  {
    path: '/:pathMatch(.*)*',
    name: 'not-found',
    redirect: '/'
  }
]

/**
 * 🚀 CREACIÓN DEL ROUTER
 */
const router = createRouter({
  // Usa historial limpio (sin #)
  history: createWebHistory(import.meta.env.BASE_URL),

  // Rutas definidas arriba
  routes
})

/**
 * 🛡️ GUARD GLOBAL (AUTH + ROLES)
 * Se ejecuta antes de cada navegación
 */
router.beforeEach(async (to, from, next) => {
  const auth = useAuthStore()

  // ─────────────────────────────
  // 🔓 RUTAS PÚBLICAS
  // ─────────────────────────────
  if (!to.meta.requiresAuth) {

    // Si ya está logueado y entra a login → redirigir home
    if (to.name === 'login' && auth.isAuthenticated) {
      return next(
        auth.isAdmin
          ? '/admin/dashboard'
          : '/receptionist/home'
      )
    }

    return next()
  }

  // ─────────────────────────────
  // 🔐 REQUIERE AUTENTICACIÓN
  // ─────────────────────────────
  if (!auth.isAuthenticated) {
    return next('/login')
  }

  // ─────────────────────────────
  // 👤 CARGA DE USUARIO
  // ─────────────────────────────
  if (!auth.user) {
    await auth.fetchMe()

    // Si sigue sin usuario → token inválido
    if (!auth.user) {
      return next('/login')
    }
  }

  // ─────────────────────────────
  // 🎭 VALIDACIÓN DE ROLES
  // ─────────────────────────────
  if (to.meta.role && to.meta.role !== auth.userRole) {

    // Si no tiene el rol correcto → redirigir a su home
    return next(
      auth.isAdmin
        ? '/admin/dashboard'
        : '/receptionist/home'
    )
  }

  // Permitir acceso
  next()
})

// Exporta el router para usarlo en la app
export default router
