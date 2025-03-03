<script setup lang="ts">
import {onMounted, ref, watch} from "vue";
import TaskItem from "./TaskItem.vue";
import {useTaskStore} from "../stores/useTaskStore.ts";
import {storeToRefs} from "pinia";
import {useRoute} from "vue-router";

const route = useRoute();
const taskStore = useTaskStore();
const {tasks} = storeToRefs(taskStore);
const loading = ref(false);

const fetchTasks = async () => {
  loading.value = true;
  const filters = {
    status: route.query.status || null,
    deadline: route.query.deadline || null,
  };
  await taskStore.fetchTasks(filters);
  loading.value = false;
};

onMounted(() => {
  fetchTasks();
});

watch(route, fetchTasks);
</script>

<template>
  <div v-if="loading" class="flex justify-center items-center p-8">
    <span>loading...</span>
  </div>
  <ul v-else-if="tasks.length > 0">
    <TaskItem v-for="task in tasks" :key="task.id" :task="task"/>
  </ul>
  <div v-else class="text-center p-8">
    <p class="text-gray-500">Tasks list is empty</p>
  </div>
</template>