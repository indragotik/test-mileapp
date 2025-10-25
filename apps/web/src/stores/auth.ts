import { defineStore } from 'pinia'
import { loginUser } from '@/api/auth'

interface User {
  name: string
  email: string
}

interface AuthState {
  token: string
  user: User | null
}

export const useAuthStore = defineStore('auth', {
  state: (): AuthState => ({
    token: localStorage.getItem('token') || '',
    user: JSON.parse(localStorage.getItem('user') || 'null'),
  }),
  getters: {
    isAuthenticated: (state): boolean => !!state.token,
  },
  actions: {
    async login(email: string, password: string) {
      const { data } = await loginUser(email, password)
      this.token = data.token
      this.user = data.user
      localStorage.setItem('token', this.token)
      localStorage.setItem('user', JSON.stringify(this.user))
    },
    logout() {
      this.token = ''
      this.user = null
      localStorage.clear()
    },
  },
})
