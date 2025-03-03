<script setup lang="ts">
import {ref} from 'vue';
import {useTaskStore} from '../stores/useTaskStore.ts';
import {useRouter} from 'vue-router';
import TasksLayout from "../components/layout/TasksLayout.vue";
import type {Task} from "../types/task.ts";
import UserLayout from "../components/layout/UserLayout.vue";

const taskStore = useTaskStore();
const router = useRouter();

const title = ref('');
const description = ref('');
const status = ref<Task["status"]>('new');
const deadline = ref('');

const taskStatuses = ['new', 'in_progress', 'completed'];

const createTask = async () => {
  try {
    await taskStore.createTask({
      title: title.value,
      description: description.value,
      status: status.value,
      deadline: deadline.value,
    });
    router.push('/');
  } catch (error) {
    console.error('Failed to create task:', error);
  }
};
</script>

<template>
  <UserLayout>
    <TasksLayout title="Create Task">
      <form @submit.prevent="createTask">
        <div class="mb-4">
          <label for="title" class="block text-gray-700">Title</label>
          <input v-model="title" id="title" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                 required/>
        </div>
        <div class="mb-4">
          <label for="description" class="block text-gray-700">Description</label>
          <textarea v-model="description" id="description"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
        </div>
        <div class="mb-4">
          <label for="status" class="block text-gray-700">Status</label>
          <select v-model="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            <option v-for="statusOption in taskStatuses" :key="statusOption" :value="statusOption">{{
                statusOption
              }}
            </option>
          </select>
        </div>
        <div class="mb-4">
          <label for="deadline" class="block text-gray-700">Deadline</label>
          <input v-model="deadline" id="deadline" type="date"
                 class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"/>
        </div>
        <div class="flex justify-end">
          <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition">
            Create Task
          </button>
        </div>
      </form>
    </TasksLayout>
  </UserLayout>
</template>