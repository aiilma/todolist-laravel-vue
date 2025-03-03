<script setup lang="ts">
import {useAuthStore} from "../../stores/useAuthStore.ts";

const authStore = useAuthStore();

const handleLogout = async () => {
  await authStore.logout();
};
</script>

<template>
  <div class="min-h-screen flex flex-col">
    <header class="bg-white shadow p-4 flex justify-between items-center">
      <button @click="handleLogout" class="bg-red-500 text-white px-4 py-2 rounded ml-auto cursor-pointer">
        Logout
      </button>
    </header>
    <main class="flex-grow">
      <slot></slot>
    </main>
  </div>
</template>

<style scoped>
</style>