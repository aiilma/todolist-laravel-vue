<script setup lang="ts">
import {ref} from 'vue';
import {useAuthStore} from "../stores/useAuthStore.ts";
import AuthForm from "../components/forms/AuthForm.vue";
import InputField from "../components/ui/InputField.vue";

const authStore = useAuthStore();
const credentials = ref({name: '', email: '', password: '', c_password: ''});

const registerUser = async () => {
  await authStore.register(credentials.value);
};

</script>

<template>
  <AuthForm title="Register" buttonText="Register" @submit="registerUser">
    <InputField v-model="credentials.name" type="text" placeholder="Name"/>
    <InputField v-model="credentials.email" type="email" placeholder="Email"/>
    <InputField v-model="credentials.password" type="password" placeholder="Password"/>
    <InputField v-model="credentials.c_password" type="password" placeholder="Confirm Password"/>

    <template #link>
      Already have an account?
      <router-link to="/login" class="text-blue-500">Login</router-link>
    </template>
  </AuthForm>
</template>

<style scoped>
</style>