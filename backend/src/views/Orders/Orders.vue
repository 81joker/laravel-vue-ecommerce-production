<template>
    <div>
      <!-- <pre>{{ products.links }}</pre> -->
      <div class="flex items-center justify-between mb-3">
        <h1 class="text-3xl font-semibold">Orders</h1>
      </div>
      <OrdersTable @clickView="viewOrder" />
    </div>
  </template>
  <script setup>
  import { ref ,computed } from "vue";
  import OrdersTable from "./OrdersTable.vue";
  import store from "../../store";


   const orders = computed(() => store.state.orders)

    function viewOrder(p) {
    // store.dispatch('getProduct', p.id)
    //   .then(({data}) => {
    //     productModel.value = data
    //     showOrder()
    //     // showAddNewModal();
    //   })
  }

  </script>
