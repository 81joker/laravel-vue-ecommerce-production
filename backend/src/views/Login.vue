<template>
  <guest-layout title="Sign in to your account">

    <p class="text-gray-500">User: admin@example.com</p>
    <p class="text-gray-500">Password: password</p>
    <form class="mt-8 space-y-6"  method="POST" @submit.prevent="login">
      <div v-if="errorMsg" class="flex items-center justify-between px-5 py-3 text-sm rounded text-white bg-red-400">
        {{errorMsg}}
        <span
          @click="errorMsg = ''"
          class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]"
        >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-6 w-6"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M6 18L18 6M6 6l12 12"
          />
        </svg>
      </span>
    </div>
    <input type="hidden" name="remember" value="true"/>

    <div>
      <label for="email" class="block text-sm/6 font-medium text-gray-900"
        >Email address</label
      >
      <div class="mt-2">
        <input
          type="email"
          name="email"
          v-model="user.email"
          id="email"
          autocomplete="email"
          required=""
          class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
        />
      </div>
    </div>

    <div>
      <div class="flex items-center justify-between">
        <label for="password" class="block text-sm/6 font-medium text-gray-900"
          >Password</label
        >
        <div class="text-sm">
          <a
            href="#"
            class="font-semibold text-indigo-600 hover:text-indigo-500"
            >Forgot password?</a
          >
        </div>
      </div>
      <div class="mt-2">
        <input
          type="password"
          name="password"
          v-model="user.password"
          id="password"
          autocomplete="current-password"
          required=""
          class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
        />
      </div>
    </div>
    <!-- Remmber me -->
    <div class="flex items-center justify-between">
      <div class="flex items-center">
        <input
          id="remember-me"
          name="remember-me"
          type="checkbox"
          v-model="user.remember"
          class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
        />
        <label for="remember-me" class="ml-2 block text-sm text-gray-900">
          Remember me
        </label>
      </div>
    </div>
    <!--/ Remmber me -->
    <div>
        <!-- <p class="mt-10 text-center text-sm/6 text-gray-500">
          Not a member?
          <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Start a 14 day free trial</a>
        </p> -->

      <button
      :disabled="loading"
        type="submit"
        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
        :class="{ 'courser-not-allowed': loading , 'hover:bg-indigo-500':loading ,'opacity-50 cursor-not-allowed': loading }"
        >
      <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
        Sign in
      </button>
    </div>
</form>
  </guest-layout>
</template>
  <script setup>
import { ref } from "vue";
import GuestLayout from "../components/GuestLayout.vue";
import store from '@/store'
import router from "../router";


const loading = ref(false);
const errorMsg = ref("");
const user = {
    email: "",
  password: "",
  remember: false,
};

function login() {
  loading.value = true;
  store.dispatch('login', user)
    .then(() => {
      loading.value = false;
      router.push({name: 'app.dashboard'})
    })
    .catch(({response}) => {
      loading.value = false;
      console.log("response.data.message" ,response.data.message);

      errorMsg.value = response.data.message;
    })
}
</script>
