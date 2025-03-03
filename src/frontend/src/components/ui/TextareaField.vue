<script setup lang="ts">
import {defineProps, defineEmits} from 'vue';

defineProps<{
  modelValue: string | null | undefined;
  placeholder: string;
}>();

const emit = defineEmits(['update:modelValue']);

const updateValue = (event: Event) => {
  emit('update:modelValue', (event.target as HTMLTextAreaElement).value);
};
</script>

<template>
  <div class="mb-4">
    <textarea :placeholder="placeholder" :value="modelValue ?? ''" @input="updateValue"
              class="w-full p-2 border border-gray-300 rounded"></textarea>
  </div>
</template>

<style scoped>
</style>