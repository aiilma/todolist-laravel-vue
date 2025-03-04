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
import {toast} from "vue3-toastify";

const router = useRouter();
const taskStore = useTaskStore();

const props = defineProps<{ id: string }>();

const task = ref<Partial<Task>>({
  title: '',
  description: '',
  status: undefined,
  deadline: ''
});
const formDisabled = ref(false);

const fetchTask = async () => {
  formDisabled.value = true;
  try {
    const fetchedTask = await taskStore.fetchTask(+props.id);
    task.value = { ...fetchedTask };
  } catch (error) {
    toast.error('Failed to fetch task!');
    console.error('Failed to fetch task:', error);
  } finally {
    formDisabled.value = false;
  }
};

const updateTask = async () => {
  formDisabled.value = true;
  try {
    await taskStore.updateTask(+props.id, task.value);
    router.push('/');
  } catch (error) {
    console.error('Failed to update task:', error);
    toast.error('Failed to update task!');
  } finally {
    formDisabled.value = false;
  }
};

onMounted(fetchTask);
</script>

<template>
  <UserLayout>
    <TasksLayout :title="'Edit Task ' + props.id">
      <form @submit.prevent="updateTask">
        <InputField v-model="task.title" type="text" placeholder="Title" :disabled="formDisabled" required/>
        <TextareaField v-model="task.description" placeholder="Description" :disabled="formDisabled"/>
        <SelectField v-model="task.status" :options="TASK_STATUSES" placeholder="Select Status" :disabled="formDisabled"/>
        <InputField v-model="task.deadline" type="date" placeholder="Deadline" :disabled="formDisabled"/>
        <div class="flex justify-end">
          <SubmitButton label="Update Task" :disabled="formDisabled"/>
        </div>
      </form>
    </TasksLayout>
  </UserLayout>
</template>