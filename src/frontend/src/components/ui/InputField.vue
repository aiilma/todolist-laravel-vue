<script setup lang="ts">
import {defineProps, defineEmits, withDefaults} from 'vue';

withDefaults(defineProps<{
  modelValue: string | null | undefined;
  type: string | undefined;
  placeholder: string;
  disabled?: boolean;
  required?: boolean;
}>(), {
  disabled: false,
  required: false,
  type: 'text',
  modelValue: '',
});

const emit = defineEmits(['update:modelValue']);

const updateValue = (event: Event) => {
  emit('update:modelValue', (event.target as HTMLInputElement).value);
};
</script>

<template>
  <div class="mb-4">
    <input
        :type="type"
        :placeholder="placeholder"
        :value="modelValue"
        @input="updateValue"
        :disabled="disabled"
        :required="required"
        :class="{
          'w-full p-2 border border-gray-300 rounded': true,
          'bg-gray-200 text-gray-500 cursor-not-allowed': disabled
        }"
    />
  </div>
</template>

<style scoped>
</style>