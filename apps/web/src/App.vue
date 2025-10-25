<template>
  <div id="app" class="min-h-screen bg-white">
    <header v-if="auth.isAuthenticated" class="bg-blue-600 text-white">
      <div class="mx-auto px-4 py-3 flex items-center justify-between">
        <h1 class="text-lg font-semibold">MileApp</h1>
        <div class="flex items-center gap-3">
          <!-- <span class="text-sm opacity-90">{{ auth.user?.email }}</span> -->
          <span class="text-sm opacity-90">Admin</span>
          <button @click="logout" class="text-sm bg-blue-700 hover:bg-blue-800 px-3 py-1 rounded">Logout</button>
        </div>
      </div>
    </header>

    <main class="bg-white min-h-[calc(100vh-64px)]">
      <div class="">
        <router-view />
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
const router = useRouter()

function logout() {
  auth.logout?.()
  router.push('/login')
}
</script>

<style>
/* Pastikan body/app background putih di level global */
html, body, #app {
  background: #ffffff;
}
</style>