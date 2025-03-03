<script setup lang="ts">
import {onMounted, watch} from "vue";
import TaskItem from "./TaskItem.vue";
import {useTaskStore} from "../stores/useTaskStore.ts";
import {storeToRefs} from "pinia";
import {useRoute} from "vue-router";

const route = useRoute();
const taskStore = useTaskStore();
const {tasks} = storeToRefs(taskStore);

const fetchTasks = () => {
  const filters = {
    status: route.query.status || null,
    deadline: route.query.deadline || null,
  };
  taskStore.fetchTasks(filters);
};

onMounted(() => {
  fetchTasks();
});

watch(route, fetchTasks);
</script>

<template>
  <ul v-if="tasks.length > 0">
    <TaskItem v-for="task in tasks" :key="task.id" :task="task"/>
  </ul>
  <div v-else class="text-center p-8">
    <p class="text-gray-500">Tasks list is empty</p>
  </div>
</template>