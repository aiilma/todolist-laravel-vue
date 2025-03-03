<script setup lang="ts">
import {defineProps, defineEmits} from 'vue';

const props = defineProps<{
  modelValue: string | undefined;
  options: string[];
  placeholder: string;
}>();

const emit = defineEmits(['update:modelValue']);

const updateValue = (event: Event) => {
  emit('update:modelValue', (event.target as HTMLSelectElement).value);
};
</script>

<template>
  <div class="mb-4">
    <select :value="modelValue ?? ''" @input="updateValue" required class="w-full p-2 border border-gray-300 rounded">
      <option disabled value="">{{ placeholder }}</option>
      <option v-for="option in props.options" :key="option" :value="option">{{ option }}</option>
    </select>
  </div>
</template>

<style scoped>
</style>