import api from './axios'
import type { Task } from '@/types/task'
import type { ParamList } from '@/types/paramList'

export const fetchTasks = (params?: Partial<ParamList>) => api.get('/tasks', { params })
export const createTask = (data: Task) => api.post('/tasks', data)
export const updateTask = (id: number, data: Partial<Task>) => api.put(`/tasks/${id}`, data)
export const deleteTask = (id: number) => api.delete(`/tasks/${id}`)
