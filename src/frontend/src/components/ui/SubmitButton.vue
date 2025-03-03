<script setup lang="ts">
import {defineProps, defineEmits, withDefaults} from 'vue';

withDefaults(defineProps<{
  disabled?: boolean;
  label: string;
}>(), {
  disabled: false,
  label: '',
});

const emit = defineEmits(['click']);

const handleClick = () => {
  emit('click');
};
</script>

<template>
  <button
      type="submit"
      @click="handleClick"
      class="py-2 px-4 rounded transition"
      :class="{
        'bg-blue-500 text-white hover:bg-blue-600 cursor-pointer': !disabled,
        'bg-gray-400 text-gray-700 cursor-not-allowed': disabled
      }"
      :disabled="disabled"
  >
    {{ label }}
  </button>
</template>

<style scoped>
</style>