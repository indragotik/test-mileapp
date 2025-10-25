<script setup lang="ts">
import { computed } from 'vue'
import type { Task } from '@/types/task'

const props = defineProps<{
  tasks: Task[]
  meta: { total: number; page: number; perPage: number }
  loading: boolean
  sort: { column: string; direction: 'asc' | 'desc' }
}>()

defineEmits(['edit', 'delete', 'paginate', 'sortBy'])

const totalPages = computed(() =>
  Math.ceil(props.meta.total / props.meta.perPage)
)

const formatStatus = (status: number) => {
  switch (status) {
    case 1:
      return 'Open'
    case 2:
      return 'In Progress'
    case 3:
      return 'Pending'
    case 4:
      return 'Done'
    case 5:
      return 'Hold'
    default:
      return 'Unknown'
  }
}

const formatPriority = (priority: number) => {
  switch (priority) {
    case 1:
      return 'Low'
    case 2:
      return 'Medium'
    case 3:
      return 'High'
    default:
      return 'Tidak Diketahui'
  }
}
</script>

<template>
  <div class="bg-white shadow rounded-lg p-4 mt-4">
    <div v-if="loading" class="text-center py-4 text-gray-500">Loading...</div>

    <div v-else>      
      <table class="border-collapse border border-gray-200 min-w-full ">
        <thead>
          <tr>
            <th
              class="border px-4 py-2 cursor-pointer"
              @click="$emit('sortBy', { field: 'title' })"
            >
              Title
              <span v-if="sort.column === 'title'">
                {{ sort.direction === 'asc' ? '▲' : '▼' }}
              </span>
            </th>
            <th
              class="border px-4 py-2 cursor-pointer"
              @click="$emit('sortBy', { field: 'status' })"
            >
              Status
              <span v-if="sort.column === 'status'">
                {{ sort.direction === 'asc' ? '▲' : '▼' }}
              </span>
            </th>
            <th
              class="border px-4 py-2 cursor-pointer"
              @click="$emit('sortBy', { field: 'priority' })"
            >
              Priority
              <span v-if="sort.column === 'priority'">
                {{ sort.direction === 'asc' ? '▲' : '▼' }}
              </span>
            </th>
            <th class="border px-4 py-2 text-center">Actions</th>
          </tr>
        </thead>
        <tbody v-if="tasks.length > 0">
          <tr
            v-for="task in tasks"
            :key="task.id"
            class="hover:bg-gray-50 transition"
          >
            <td class="px-6 py-4 border border-gray-200">{{ task.title }}</td>
            <td class="px-6 py-4 text-center border border-gray-200">
              <span
                class="inline-block text-xs font-semibold px-2 py-1 rounded-full"
                :class="{
                  'bg-gray-100 text-gray-700': task.status === 1,
                  'bg-blue-100 text-blue-700': task.status === 2,
                  'bg-yellow-100 text-yellow-700': task.status === 3,
                  'bg-green-100 text-green-700': task.status === 4,
                  'bg-red-100 text-red-700': task.status === 4,
                }"
              >
                {{ formatStatus(task.status) }}
              </span>
            </td>
            <td class="px-6 py-4 text-center border border-gray-200">
              <span
                class="inline-block text-xs font-semibold px-2 py-1 rounded-full"
                :class="{
                  'bg-gray-100 text-gray-700': task.priority === 1,
                  'bg-orange-100 text-orange-700': task.priority === 2,
                  'bg-red-100 text-red-700': task.priority === 3,
                }"
              >
                {{ formatPriority(task.priority) }}
              </span>
            </td>
            <td class="px-6 py-4 text-center border border-gray-200">
              <button
                @click="$emit('edit', task)"
                class="text-blue-600 hover:text-blue-800 mr-3"
              >
                Edit
              </button>
              <button
                @click="$emit('delete', task)"
                class="text-red-600 hover:text-red-800"
              >
                Delete
              </button>
            </td>
          </tr>
        </tbody>
        <tbody v-else>
          <tr>
            <td colspan="4" class="text-center py-4 text-gray-500">
              No tasks found.
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-between items-center mt-4">
      <div class="text-sm text-gray-600">
        Showing page {{ meta.page }} of {{ totalPages }}
      </div>
      <div class="flex gap-2">
        <button
          @click="$emit('paginate', { page: meta.page - 1 })"
          :disabled="meta.page <= 1"
          class="px-3 py-1 border rounded text-sm hover:bg-gray-100 disabled:opacity-50"
        >
          Prev
        </button>
        <button
          @click="$emit('paginate', { page: meta.page + 1 })"
          :disabled="meta.page >= totalPages"
          class="px-3 py-1 border rounded text-sm hover:bg-gray-100 disabled:opacity-50"
        >
          Next
        </button>
      </div>
    </div>
  </div>
</template>
