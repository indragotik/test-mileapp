import { createRouter, createWebHistory, type RouteRecordRaw } from 'vue-router'
import UserLogin from '@/views/UserLogin.vue'
import TasksView from '@/views/TasksView.vue'
import { useAuthStore } from '@/stores/auth'

const routes: RouteRecordRaw[] = [
  { path: '/login', name: 'login', component: UserLogin },
  { path: '/tasks', name: 'tasks', component: TasksView, meta: { requiresAuth: true } },
  { path: '/', redirect: '/login' },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach((to, from, next) => {
  const auth = useAuthStore()
  
  // Jika belum login dan menuju halaman yang butuh auth → redirect ke login
  if (to.meta.requiresAuth && !auth.isAuthenticated) {
    next('/login')
  }
  // Jika SUDAH login dan menuju login/register → redirect ke tasks
  else if ((to.name === 'login' || to.name === 'register') && auth.isAuthenticated) {
    next('/tasks')
  }
  else {
    next()
  }
})

export default router
