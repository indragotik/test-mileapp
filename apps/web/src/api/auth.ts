import api from './axios'

export const loginUser = (email: string, password: string) => api.post('/login', { email, password })