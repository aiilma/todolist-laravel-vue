<script setup lang="ts">
import {onMounted, ref, watch} from "vue";
import UserLayout from "../components/layout/UserLayout.vue";
import TasksFilters from "../components/TasksFilters.vue";
import TasksLayout from "../components/layout/TasksLayout.vue";
import TaskList from "../components/TaskList.vue";
import {storeToRefs} from "pinia";
import {useTaskStore} from "../stores/useTaskStore.ts";

const taskStore = useTaskStore();

const {totalTasksCount} = storeToRefs(taskStore);
const showFilters = ref(true);

watch(totalTasksCount, (newCount) => showFilters.value = newCount > 0);
onMounted(() => showFilters.value = totalTasksCount.value > 0);
</script>

<template>
  <UserLayout>
    <TasksLayout title="Tasks Page">
      <template #extra v-if="showFilters">
        <hr class="mt-4" >
        <TasksFilters/>
      </template>

      <TaskList/>
    </TasksLayout>
  </UserLayout>
</template>