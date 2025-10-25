<script setup lang="ts">
const model = defineModel<string>()
defineEmits(['search'])
</script>

<template>
  <div class="flex justify-end mb-4">
    <input
      v-model="model"
      @input="$emit('search')"
      type="text"
      placeholder="Search tasks..."
      class="border border-gray-300 rounded-lg px-3 py-2 w-1/3 focus:outline-none focus:ring focus:border-blue-400"
    />
  </div>
</template>
