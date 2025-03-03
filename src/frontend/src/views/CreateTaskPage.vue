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
import {toast} from "vue3-toastify";

const taskStore = useTaskStore();
const router = useRouter();

const title = ref('');
const description = ref('');
const status = ref<Task["status"]>('new');
const deadline = ref('');
const formDisabled = ref(false);

const createTask = async () => {
  formDisabled.value = true;
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
    toast.error('Failed to create task!');
  } finally {
    formDisabled.value = false;
  }
};
</script>

<template>
  <UserLayout>
    <TasksLayout title="Create Task">
      <form @submit.prevent="createTask">
        <InputField v-model="title" type="text" placeholder="Title" :disabled="formDisabled" required/>
        <TextareaField v-model="description" placeholder="Description" :disabled="formDisabled"/>
        <SelectField v-model="status" :options="TASK_STATUSES" placeholder="Select Status" :disabled="formDisabled"/>
        <InputField v-model="deadline" type="date" placeholder="Deadline" :disabled="formDisabled"/>
        <div class="flex justify-end">
          <SubmitButton :label="'Create Task'" :disabled="formDisabled"/>
        </div>
      </form>
    </TasksLayout>
  </UserLayout>
</template>