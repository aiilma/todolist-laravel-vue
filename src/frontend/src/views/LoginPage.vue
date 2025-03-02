<script setup lang="ts">
import {useAuthStore} from '../stores/useAuthStore.ts';
import {ref} from "vue";
import AuthForm from "../components/forms/AuthForm.vue";
import InputField from "../components/ui/InputField.vue";

const authStore = useAuthStore();
const credentials = ref({email: '', password: ''});

const loginUser = async () => {
  await authStore.login(credentials.value);
};
</script>

<template>
  <AuthForm title="Login" buttonText="Login" @submit="loginUser">
    <InputField v-model="credentials.email" type="email" placeholder="Email"/>
    <InputField v-model="credentials.password" type="password" placeholder="Password"/>

    <template #link>
      Don't have an account?
      <router-link to="/register" class="text-blue-500">Register</router-link>
    </template>
  </AuthForm>
</template>

<style scoped>
</style>