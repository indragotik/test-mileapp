<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const email = ref('')
const password = ref('')
const auth = useAuthStore()
const router = useRouter()
const error = ref('')
const loading = ref(false)

interface AxiosErrorLike {
  response?: {
    data?: {
      message?: string
    }
  }
}

const handleLogin = async (e?: Event) => {
  if (e) e.preventDefault()
  error.value = ''
  loading.value = true

  try {
    await auth.login(email.value, password.value)
    router.replace('/tasks')
  } catch (err: unknown) {
    let message = 'An unexpected error occurred during login.'
    if (typeof err === 'object' && err !== null && 'response' in err) {
      const e = err as AxiosErrorLike
      if (e.response?.data?.message) {
        message = e.response.data.message
      }
    }
    error.value = message
    // console.error(err)
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-br from-blue-50 to-indigo-100 px-4">
    <!-- Card -->
    <div
      class="w-full max-w-md bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/30 overflow-hidden transition-all hover:shadow-2xl"
    >
      <!-- Header -->
      <div class="p-8 text-center">
        <div class="flex justify-center mb-4">
          <div
            class="h-16 w-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center shadow-inner"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-8 w-8"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"
              />
            </svg>
          </div>
        </div>

        <h1 class="text-2xl font-bold text-gray-800">Wellcome to Maliapp Test</h1>
        <p class="text-sm text-gray-500 mt-1">Sign in to your account to continue</p>
      </div>

      <!-- Form -->
      <form @submit.prevent="handleLogin" class="px-8 pb-8 space-y-5">
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
          <input
            v-model="email"
            type="email"
            placeholder="user@exampe.com"
            class="w-full px-4 py-2 border border-gray-200 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out"
            required
          />
        </div>

        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
          <input
            v-model="password"
            type="password"
            placeholder="••••••••"
            class="w-full px-4 py-2 border border-gray-200 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out"
            required
          />
        </div>

        <button
          :disabled="loading"
          type="submit"
          class="w-full flex justify-center items-center gap-2 py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md transition disabled:opacity-60"
        >
          <svg
            v-if="loading"
            class="animate-spin h-5 w-5 text-white"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
          >
            <circle
              class="opacity-25"
              cx="12"
              cy="12"
              r="10"
              stroke="currentColor"
              stroke-width="4"
            ></circle>
            <path
              class="opacity-75"
              fill="currentColor"
              d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
            ></path>
          </svg>
          <span>{{ loading ? 'Loading...' : 'Sig In' }}</span>
        </button>

        <p
          v-if="error"
          class="text-sm text-red-600 bg-red-50 border border-red-100 rounded-md text-center py-2 mt-2"
        >
          {{ error }}
        </p>
      </form>
    </div>

    <!-- Decorative Background -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
      <div
        class="absolute -top-40 -right-40 w-80 h-80 bg-blue-200 rounded-full blur-3xl opacity-40 animate-pulse"
      ></div>
      <div
        class="absolute -bottom-40 -left-40 w-96 h-96 bg-indigo-200 rounded-full blur-3xl opacity-40 animate-pulse delay-1000"
      ></div>
    </div>
  </div>
</template>
