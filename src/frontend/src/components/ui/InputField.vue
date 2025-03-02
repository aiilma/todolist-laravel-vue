<script setup lang="ts">
import {defineProps, defineEmits} from 'vue';

defineProps({
  modelValue: String,
  type: {
    type: String,
    default: 'text'
  },
  placeholder: String
});

const emit = defineEmits(['update:modelValue']);

const updateValue = (event: Event) => {
  emit('update:modelValue', (event.target as HTMLInputElement).value);
};
</script>

<template>
  <div class="mb-4">
    <input :type="type" :placeholder="placeholder" :value="modelValue" @input="updateValue" required
           class="w-full p-2 border border-gray-300 rounded"/>
  </div>
</template>

<style scoped>
</style>