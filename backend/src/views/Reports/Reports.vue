<template>
  <div>
    <h1 class="text-3xl font-semibold">Reports</h1>
    <div class="grid gap-3 grid-cols-1 md:grid-cols-2 text-center">
      <router-link
        :to="{ name: 'reports.orders' }"
        class="py-2 px-3 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 f ocus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
      >
        Order Report
      </router-link>
      <router-link
        :to="{ name: 'reports.customers' }"
        class="py-2 px-3 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
      >
        Customer Order
      </router-link>
    </div>
    <div class="bg-white p-3 rounded-md shadow-md mt-6">
      <router-view></router-view>
    </div>
  </div>
</template>
<script setup></script>
