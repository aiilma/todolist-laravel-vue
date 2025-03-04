<script setup lang="ts">

withDefaults(defineProps<{
  modelValue: string | undefined;
  options: { value: string; label: string }[];
  placeholder: string;
  disabled?: boolean;
}>(), {
  disabled: false,
  modelValue: '',
});

const emit = defineEmits(['update:modelValue']);

const updateValue = (event: Event) => {
  emit('update:modelValue', (event.target as HTMLSelectElement).value);
};
</script>

<template>
  <div class="mb-4">
    <select
        :value="modelValue"
        @input="updateValue"
        required
        :class="{
          'w-full p-2 border border-gray-300 rounded': true,
          'bg-gray-200 text-gray-500 cursor-not-allowed': disabled
        }"
        :disabled="disabled"
    >
      <option disabled value="">{{ placeholder }}</option>
      <option v-for="option in options" :key="option.value" :value="option.value">{{ option.label }}</option>
    </select>
  </div>
</template>

<style scoped>
</style>