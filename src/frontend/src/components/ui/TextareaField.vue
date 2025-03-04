<script setup lang="ts">

withDefaults(defineProps<{
  modelValue: string | null | undefined;
  placeholder: string;
  disabled?: boolean;
}>(), {
  disabled: false,
  modelValue: '',
});

const emit = defineEmits(['update:modelValue']);

const updateValue = (event: Event) => {
  emit('update:modelValue', (event.target as HTMLTextAreaElement).value);
};
</script>

<template>
  <div class="mb-4">
    <textarea
        :placeholder="placeholder"
        :value="modelValue"
        @input="updateValue"
        :class="{
          'w-full p-2 border border-gray-300 rounded': true,
          'bg-gray-200 text-gray-500 cursor-not-allowed': disabled
        }"
        :disabled="disabled"
    ></textarea>
  </div>
</template>

<style scoped>
</style>