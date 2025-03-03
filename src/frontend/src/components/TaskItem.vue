<script setup lang="ts">
import {defineProps} from "vue";
import {PencilIcon, TrashIcon} from '@heroicons/vue/24/outline';
import {useTaskStore} from "../stores/useTaskStore.ts";
import type {Task} from "../types/task.ts";

defineProps<{
  task: Task;
}>();

const taskStore = useTaskStore();

const deleteTask = async (id: number) => {
  try {
    await taskStore.deleteTask(id);
  } catch (error) {
    console.error(`Failed to delete task with id: ${id}`, error);
  }
};
</script>

<template>
  <li class="mb-4 p-4 border border-gray-300 rounded">
    <div class="flex justify-between items-center">
      <div>
        <h2 class="text-xl font-semibold">{{ task.title }}</h2>
        <p>{{ task.description }}</p>
        <p>Status: {{ task.status }}</p>
        <p v-if="task.deadline">Deadline: {{ task.deadline }}</p>
      </div>
    </div>
    <div class="mt-4 flex space-x-2 justify-end">
      <router-link :to="`/${task.id}/edit`" class="text-blue-500 underline">
        <PencilIcon class="h-5 w-5 text-blue-500"/>
      </router-link>
      <button @click="deleteTask(task.id)" class="text-red-500">
        <TrashIcon class="h-5 w-5 text-red-500"/>
      </button>
    </div>
  </li>
</template>