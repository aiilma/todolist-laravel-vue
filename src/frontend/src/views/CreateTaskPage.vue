<script setup lang="ts">
import {ref} from 'vue';
import {useTaskStore} from '../stores/useTaskStore.ts';
import {useRouter} from 'vue-router';
import TasksLayout from "../components/layout/TasksLayout.vue";
import type {Task} from "../types/task.ts";
import UserLayout from "../components/layout/UserLayout.vue";
import InputField from "../components/ui/InputField.vue";
import TextareaField from "../components/ui/TextareaField.vue";
import SelectField from "../components/ui/SelectField.vue";
import SubmitButton from "../components/ui/SubmitButton.vue";
import {TASK_STATUSES} from "../constants/tasks-constants.ts";

const taskStore = useTaskStore();
const router = useRouter();

const title = ref('');
const description = ref('');
const status = ref<Task["status"]>('new');
const deadline = ref('');

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
        <InputField v-model="title" type="text" placeholder="Title"/>
        <TextareaField v-model="description" placeholder="Description"/>
        <SelectField v-model="status" :options="TASK_STATUSES" placeholder="Select Status"/>
        <InputField v-model="deadline" type="date" placeholder="Deadline"/>
        <div class="flex justify-end">
          <SubmitButton label="Create Task"/>
        </div>
      </form>
    </TasksLayout>
  </UserLayout>
</template>