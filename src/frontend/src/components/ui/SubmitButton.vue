<script setup lang="ts">
import {defineProps, defineEmits} from 'vue';

defineProps({
  label: String,
});

const emit = defineEmits(['click']);

const handleClick = () => {
  emit('click');
};
</script>

<template>
  <button type="submit" @click="handleClick"
          class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition">
    {{ label }}
  </button>
</template>

<style scoped>
</style>