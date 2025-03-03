<script setup lang="ts">
import { defineProps, defineEmits } from 'vue';

defineProps({
  title: String,
  buttonText: String
});

const emit = defineEmits(['submit']);

const onSubmit = () => {
  emit('submit');
};
</script>

<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
      <h2 class="text-2xl font-bold mb-6">{{ title }}</h2>
      <form @submit.prevent="onSubmit">
        <slot></slot>
        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">{{ buttonText }}</button>
      </form>
      <p class="mt-4 text-center">
        <slot name="link"></slot>
      </p>
    </div>
  </div>
</template>

<style scoped>
</style>