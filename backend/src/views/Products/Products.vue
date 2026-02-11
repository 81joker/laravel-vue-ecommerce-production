<template>
  <div>
    <!-- <pre>{{ products.links }}</pre> -->
    <div class="flex items-center justify-between mb-3">
      <h1 class="text-3xl font-semibold">Products</h1>
      <router-link
        :to="{ name: 'app.products.create' }"
        class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
      >
        Add new Product Wiht Page
      </router-link>
    </div>
    <ProductsTable @clickEdit="editProduct" />
  </div>
</template>
<script setup>
import { ref } from 'vue'
import ProductsTable from './ProductsTable.vue'
import store from '../../store'

// const productModel = ref({
//   id: '',
//   title: "",
//   image: '',
//   description: "",
//   price: '',
// });

const showModal = ref(false)
function editProduct(p) {
  store.dispatch('getProduct', p.id).then(({ data }) => {
    productModel.value = data
    // showAddNewModal();
  })
}
</script>
