<script setup lang="ts">
import {useRouter, useRoute} from "vue-router";

defineProps({
  title: String
});

const router = useRouter();
const route = useRoute();

const goBack = () => {
  router.back();
};
</script>

<template>
  <div class="bg-background min-h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-4xl mx-auto mt-8">
      <h1 class="text-2xl font-bold mb-6 text-primary">{{ title }}</h1>
      <div class="mb-6 p-4 bg-gray-100 rounded shadow">
        <div class="flex justify-between" v-if="route.name !== 'TasksPage'">
          <button @click="goBack" class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600 transition cursor-pointer">
            Back
          </button>
        </div>
        <div class="flex justify-end" v-if="route.name !== 'CreateTaskPage' && route.name !== 'EditTaskPage'">
          <router-link to="/create" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition">
            Create Task
          </router-link>
        </div>
        <slot name="extra"></slot>
      </div>
      <slot></slot>
    </div>
  </div>
</template>