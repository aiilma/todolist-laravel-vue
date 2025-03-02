<script setup lang="ts">
import {ref} from 'vue';
import {useAuthStore} from "../stores/useAuthStore.ts";

const authStore = useAuthStore();
const credentials = ref({ name: '', email: '', password: '', c_password: '' });

const registerUser = async () => {
  await authStore.register(credentials.value);
};

</script>

<template>
  <div>
    <form @submit.prevent="registerUser">
      <input v-model="credentials.name" type="text" placeholder="Name" required />
      <input v-model="credentials.email" type="email" placeholder="Email" required />
      <input v-model="credentials.password" type="password" placeholder="Password" required />
      <input v-model="credentials.c_password" type="password" placeholder="Confirm Password" required />
      <button type="submit">Register</button>
    </form>
  </div>
</template>

<style scoped>
</style>