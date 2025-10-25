<script setup lang="ts">
import { reactive, watch } from 'vue'
import type { Task } from '@/types/task'

const props = defineProps<{
  editingTask: Task | null
  loading: boolean,
  form: { title: string; status: number; priority: number }
}>()

const emit = defineEmits(['close', 'save', 'update:form'])

const localForm = reactive({ ...props.form })

const errors = reactive({
  title: '',
  status: '',
  priority: '',
})

watch(
  () => props.form,
  (newVal) => {
    if (newVal) Object.assign(localForm, newVal)
  },
  { deep: true }
)

watch(
  () => localForm,
  (newVal) => {
    emit('update:form', { ...newVal })
  },
  { deep: true }
)

const clearErrors = () => {
  errors.title = ''
  errors.status = ''
  errors.priority = ''
}

const validate = () => {
  let valid = true
  clearErrors()

  if (!localForm.title.trim()) {
    errors.title = 'Title cannot be empty'
    valid = false
  }

  if (!localForm.status) {
    errors.status = 'Status must be selected'
    valid = false
  }

  if (localForm.priority === 0 || localForm.priority === null) {
    errors.priority = 'Prioritas must be selected'
    valid = false
  }

  return valid
}

const handleSave = () => {
  if (!validate()) return
  emit('save', { ...localForm })
}
</script>

<template>
  <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex justify-center items-center p-4 z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md overflow-hidden">
      <div class="p-6 border-b">
        <h2 class="text-lg font-semibold">
          {{ editingTask ? 'Edit Task' : 'Create Task' }}
        </h2>
      </div>

      <div class="p-6 space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 required">Title</label>
          <input
            v-model="localForm.title"
            type="text"
            placeholder="Enter the title of the assignment"
            class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2"
          />
          <p v-if="errors.title" class="text-sm text-red-600 mt-1">{{ errors.title }}</p>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 required">Status</label>
          <select
            v-model="localForm.status"
            class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2"
          >
            <option disabled :value="0">Please select status</option>
            <option :value="1">Open</option>
            <option :value="2">In Progress</option>
            <option :value="3">Pending</option>
            <option :value="4">Done</option>
            <option :value="5">Hold</option>
          </select>
          <p v-if="errors.status" class="text-sm text-red-600 mt-1">{{ errors.status }}</p>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 required">Priority</label>
          <select
            v-model="localForm.priority"
            class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2"
          >
            <option disabled :value="0">Please select priority</option>
            <option :value="1">Low</option>
            <option :value="2">Medium</option>
            <option :value="3">Hard</option>
          </select>
          <p v-if="errors.priority" class="text-sm text-red-600 mt-1">{{ errors.priority }}</p>
        </div>
      </div>

      <div class="p-6 flex justify-end gap-2 bg-gray-50 border-t">
        <button
          @click="emit('close')"
          class="px-4 py-2 text-gray-700 hover:text-gray-900 rounded-lg"
        >
          Close
        </button>
        <button
          @click="handleSave"
          class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
        >
          Submit
        </button>
      </div>

       <div v-if="loading" class="absolute inset-0 bg-white/50 flex justify-center items-center">
        <svg class="animate-spin h-10 w-10 text-blue-600" viewBox="0 0 24 24">
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
      </div>
    </div>
  </div>
</template>

<style scoped>
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: scale(0.95);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}
.animate-fadeIn {
  animation: fadeIn 0.2s ease-out;
}
</style>