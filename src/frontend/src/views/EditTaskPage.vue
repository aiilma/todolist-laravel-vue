<script setup lang="ts">
import {onMounted, ref} from 'vue';
import {useRouter} from 'vue-router';
import {useTaskStore} from '../stores/useTaskStore';
import UserLayout from "../components/layout/UserLayout.vue";
import TasksLayout from "../components/layout/TasksLayout.vue";
import type {Task} from "../types/task.ts";

const router = useRouter();
const taskStore = useTaskStore();

const props = defineProps<{ id: string }>();

const task = ref<Partial<Task>>({
  title: '',
  description: '',
  status: '',
  deadline: ''
});

const fetchTask = async () => {
  try {
    const fetchedTask = await taskStore.fetchTask(props.id);
    task.value = { ...fetchedTask };
  } catch (error) {
    console.error('Failed to fetch task:', error);
  }
};

const updateTask = async () => {
  await taskStore.updateTask(props.id, task.value);
  router.push('/');
};

onMounted(fetchTask);
</script>

<template>
  <UserLayout>
    <TasksLayout :title="'Edit Task ' + props.id">
      <form @submit.prevent="updateTask">
        <div>
          <label for="title">Title</label>
          <input v-model="task.title" id="title" type="text" required />
        </div>
        <div>
          <label for="description">Description</label>
          <textarea v-model="task.description" id="description"></textarea>
        </div>
        <div>
          <label for="status">Status</label>
          <select v-model="task.status" id="status" required>
            <option value="new">New</option>
            <option value="in_progress">In Progress</option>
            <option value="completed">Completed</option>
          </select>
        </div>
        <div>
          <label for="deadline">Deadline</label>
          <input v-model="task.deadline" id="deadline" type="date" />
        </div>
        <div class="flex justify-end">
          <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition">
            Update Task
          </button>
        </div>
      </form>
    </TasksLayout>
  </UserLayout>
</template>