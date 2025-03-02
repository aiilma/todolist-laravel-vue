<script setup lang="ts">
import {useAuthStore} from '../stores/useAuthStore.ts';
import {ref} from "vue";

const authStore = useAuthStore();
const credentials = ref({email: '', password: ''});

const loginUser = async () => {
  await authStore.login(credentials.value);
};
</script>

<template>
  <div>
    <form @submit.prevent="loginUser">
      <input v-model="credentials.email" type="email" placeholder="Email" required/>
      <input v-model="credentials.password" type="password" placeholder="Password" required/>
      <button type="submit">Login</button>
    </form>
  </div>
</template>

<style scoped>
</style>