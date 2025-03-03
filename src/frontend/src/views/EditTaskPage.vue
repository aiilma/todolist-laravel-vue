<script setup lang="ts">
import {onMounted, ref} from 'vue';
import {useRouter} from 'vue-router';
import {useTaskStore} from '../stores/useTaskStore';
import UserLayout from "../components/layout/UserLayout.vue";
import TasksLayout from "../components/layout/TasksLayout.vue";
import type {Task} from "../types/task.ts";
import SelectField from "../components/ui/SelectField.vue";
import {TASK_STATUSES} from "../constants/tasks-constants.ts";
import TextareaField from "../components/ui/TextareaField.vue";
import InputField from "../components/ui/InputField.vue";
import SubmitButton from "../components/ui/SubmitButton.vue";

const router = useRouter();
const taskStore = useTaskStore();

const props = defineProps<{ id: string }>();

const task = ref<Partial<Task>>({
  title: '',
  description: '',
  status: undefined,
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
        <InputField v-model="task.title" type="text" placeholder="Title"/>
        <TextareaField v-model="task.description" placeholder="Description"/>
        <SelectField v-model="task.status" :options="TASK_STATUSES" placeholder="Select Status"/>
        <InputField v-model="task.deadline" type="date" placeholder="Deadline"/>
        <div class="flex justify-end">
          <SubmitButton label="Update Task"/>
        </div>
      </form>
    </TasksLayout>
  </UserLayout>
</template>