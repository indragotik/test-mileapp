<script setup lang="ts">
defineOptions({ name: 'TasksView' })
import { ref, onMounted } from 'vue'
import { fetchTasks, createTask, updateTask, deleteTask } from '@/api/tasks'
import type { Task } from '@/types/task'
import TaskTable from '@/components/tasks/TaskTable.vue'
import TaskModal from '@/components/tasks/TaskModal.vue'
import TaskSearch from '@/components/tasks/TaskSearch.vue'
import axios from 'axios'
import Swal from 'sweetalert2'

const tasks = ref<Task[]>([])
const meta = ref({ total: 0, page: 1, perPage: 5 })
const searchQuery = ref('')
const loading = ref(false)
const loadingModal = ref(false)
const showModal = ref(false)
const editingTask = ref<Task | null>(null)

// Sort state
const sort = ref<{ column: string; direction: 'asc' | 'desc' }>({ column: '', direction: 'asc' })

const form = ref({
  title: '',
  status: 0,
  priority: 0,
})

const getTasks = async () => {
  try {
    loading.value = true
    const { data } = await fetchTasks({
      search: searchQuery.value,
      page: meta.value.page,
      perPage: meta.value.perPage
    })
    tasks.value = data.data
    meta.value = data.meta
  } catch (err) {
    console.error('[GET TASKS ERROR]', err)
    const msg = axios.isAxiosError(err)
      ? err.response?.data?.message || 'Failed to load task data from server.'
      : 'An unexpected error occurred while loading task data.'

    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: msg,
      confirmButtonColor: '#2563eb'
    })
  } finally {
    loading.value = false
  }
}

const openModal = (task?: Task) => {
  editingTask.value = task || null
  form.value = task
    ? { title: task.title, status: task.status, priority: task.priority }
    : { title: '', status: 0, priority: 0 }
  showModal.value = true
}

const saveTask = async () => {
  if (!form.value.title.trim()) {
    Swal.fire({
      icon: 'warning',
      title: 'Validation Error',
      text: 'The task title cannot be empty',
      confirmButtonColor: '#2563eb'
    })
    return
  }

  loadingModal.value = true
  try {
    if (editingTask.value) {
      await updateTask(editingTask.value.id, form.value)
      Swal.fire({
        icon: 'success',
        title: 'Success',
        text: 'Task updated successfully!',
        timer: 1500,
        showConfirmButton: false
      })
    } else {
      await createTask(form.value as Task)
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Task added successfully!',
        timer: 1500,
        showConfirmButton: false
      })
    }
    await getTasks()
    showModal.value = false
  } catch (err) {
    console.error('[SAVE TASK ERROR]', err)
    const msg = axios.isAxiosError(err)
      ? err.response?.data?.message || 'Failed to save data to server.'
      : 'An unexpected error occurred while saving data.'

    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: msg,
      confirmButtonColor: '#2563eb'
    })
  } finally {
    loadingModal.value = false
  }
}

const confirmDelete = async (task: Task) => {
  const confirm = await Swal.fire({
    title: 'Are you sure you want to delete this task?',
    text: `Delete task "${task.title}"?`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes',
    cancelButtonText: 'No',
    confirmButtonColor: '#dc2626',
    cancelButtonColor: '#6b7280'
  })
  
  if (!confirm.isConfirmed) return

  try {
    loading.value = true
    await deleteTask(task.id)
    await getTasks()
    Swal.fire({
      icon: 'success',
      title: 'Success',
      text: 'Task successfully deleted!',
      timer: 1500,
      showConfirmButton: false
    })
  } catch (err) {
    console.error('[DELETE TASK ERROR]', err)
    const msg = axios.isAxiosError(err)
      ? err.response?.data?.message || 'Failed to delete task data.'
      : 'An unexpected error occurred while deleting the task.'

    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: msg,
      confirmButtonColor: '#2563eb'
    })
  } finally {
    loading.value = false
  }
}

// Sorting function
const sortBy = (column: string) => {
  if (sort.value.column === column) {
    sort.value.direction = sort.value.direction === 'asc' ? 'desc' : 'asc'
  } else {
    sort.value.column = column
    sort.value.direction = 'asc'
  }
}

onMounted(getTasks)
</script>

<template>
  <div class="p-6 max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-gray-800">📋 Task List</h1>
      <button
        @click="openModal()"
        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
      >
        + Create Task
      </button>
    </div>

    <TaskSearch v-model="searchQuery" @search="getTasks" />

    <TaskTable
      :tasks="tasks"
      :meta="meta"
      :loading="loading"
      @edit="openModal"
      @delete="confirmDelete"
      @paginate="(page) =>{
        meta.page = page.page;
        getTasks()
      }"
      @sortBy="sortBy"
      :sort="sort"
    />

    <TaskModal
      v-if="showModal"
      :editing-task="editingTask"
      :loading="loadingModal"
      v-model:form="form"
      @close="showModal = false"
      @save="saveTask"
    />
  </div>
</template>
