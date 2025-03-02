<script setup lang="ts">
import {useAuthStore} from "./stores/useAuthStore.ts";

useAuthStore();
</script>

<template>
  <router-view></router-view>
</template>

<style scoped>
</style>
