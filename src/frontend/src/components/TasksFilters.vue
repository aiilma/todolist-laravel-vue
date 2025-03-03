<script setup lang="ts">
import {onMounted, ref, watch} from "vue";
import {useRoute, useRouter} from "vue-router";

const statusFilter = ref<string | null>('All');
const deadlineFilter = ref<string | null>(null);

const route = useRoute();
const router = useRouter();

const updateFilters = () => {
  const query = {...route.query};

  if (statusFilter.value !== 'All') {
    query.status = statusFilter.value;
  } else {
    delete query.status;
  }

  if (deadlineFilter.value) {
    query.deadline = deadlineFilter.value;
  } else {
    delete query.deadline;
  }

  router.push({query});
};

watch([statusFilter, deadlineFilter], updateFilters);

onMounted(() => {
  if (route.query.status) {
    statusFilter.value = route.query.status as string;
  }
  if (route.query.deadline) {
    deadlineFilter.value = route.query.deadline as string;
  }
});
</script>

<template>
  <div class="mt-4 flex space-x-4">
    <div>
      <label for="status" class="block text-sm font-medium text-gray-700">Filter by Status</label>
      <select id="status" v-model="statusFilter"
              class="mt-1 block pl-3 pr-10 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
        <option value="All">All</option>
        <option value="new">New</option>
        <option value="in_progress">In Progress</option>
        <option value="completed">Completed</option>
      </select>
    </div>
    <div>
      <label for="deadline" class="block text-sm font-medium text-gray-700">Filter by Deadline</label>
      <input type="date" id="deadline" v-model="deadlineFilter"
             class="mt-1 block pl-3 pr-10 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
    </div>
  </div>
</template>