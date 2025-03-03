<script setup lang="ts">
import {defineProps, defineEmits} from 'vue';

const props = defineProps<{
  modelValue: string | null | undefined;
  type: string | undefined;
  placeholder: string;
}>();

const emit = defineEmits(['update:modelValue']);

const updateValue = (event: Event) => {
  emit('update:modelValue', (event.target as HTMLInputElement).value);
};
</script>

<template>
  <div class="mb-4">
    <input :type="props.type ?? 'text'" :placeholder="props.placeholder" :value="props.modelValue ?? ''" @input="updateValue" required
           class="w-full p-2 border border-gray-300 rounded"/>
  </div>
</template>

<style scoped>
</style>