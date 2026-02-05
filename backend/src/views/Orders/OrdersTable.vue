<template>
  <div class="bg-white p-4 rounded-lg shadow animate-fade-in-down">
    <div class="flex justify-between border-b-2 pb-3">
      <div class="flex items-center">
        <span class="whitespace-nowrap mr-3">Per Page</span>
        <select @change="getOrders(null)" v-model="perPage"
                class="appearance-none relative block w-24 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="20">20</option>
          <option value="50">50</option>
          <option value="100">100</option>
        </select>
        <span class="ml-3">Found {{orders.total}} orders</span>
      </div>
      <div>
        <input v-model="search" @change="getOrders(null)"
               class="appearance-none relative block w-48 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
               placeholder="Type to Search orders">
      </div>
    </div>

    <table class="table-auto w-full">
      <thead>
      <tr>
        <TableHeaderCell field="id" :sort-field="sortField" :sort-direction="sortDirection" @click="sortOrders('id')">
          ID
        </TableHeaderCell>
        <TableHeaderCell :sort-field="sortField" :sort-direction="sortDirection"
        @click="sortOrders('number_of_items')" >
          Customer
        </TableHeaderCell>
        <TableHeaderCell field="status" :sort-field="sortField" :sort-direction="sortDirection"  @click="sortOrders('status')">
          Status
        </TableHeaderCell>
        <TableHeaderCell field="total_price" :sort-field="sortField" :sort-direction="sortDirection"
                         @click="sortOrders('total_price')">
        Total Price
        </TableHeaderCell>
        <TableHeaderCell field="created_by" :sort-field="sortField" :sort-direction="sortDirection"
                         @click="sortOrders('created_by')">
        Date
        </TableHeaderCell>

        <TableHeaderCell field="actions">
          Actions
        </TableHeaderCell>
      </tr>
      </thead>
      <tbody v-if="orders.loading || !orders.data.length">
      <tr>
        <td colspan="6">
          <Spinner v-if="orders.loading"/>
          <p v-else class="text-center py-8 text-gray-700">
            There are no orders
          </p>
        </td>
      </tr>
      </tbody>
      <tbody v-else>
      <tr v-for="orders of orders.data">
        <!-- <tr v-for="(orders, index) of orders.data" class="animate-fade-in-down" :style="{'animation-delay': (index * 0.1) + 's'}"> -->
        <td class="border-b p-2 ">{{ orders.id }}</td>
        <td class="border-b p-2 ">
            <OrderStatus :order="orders" />

          <!-- <img class="w-16 h-16 object-cover" :src="orders.image" :alt="orders.title"> -->
        </td>
        <td class="border-b p-2 ">
          {{ orders.customer.first_name }} {{ orders.customer.last_name }}
        </td>
        <td class="border-b p-2">
          ${{ orders.total_price }}
        </td>
        <td class="border-b p-2 max-w-[200px] whitespace-nowrap overflow-hidden text-ellipsis">
          {{ orders.created_at }}
        </td>


        <td class="border-b p-2">
       <router-link :to="{name: 'app.orders.view', params: {id: orders.id}}" class="w-8 h-8 rounded-full flex items-center
        justify-center border text-indigo-700 border-indigo-700 hover:bg-indigo-700 hover:text-white">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
</svg>

      </router-link>
        </td>
      </tr>
      </tbody>
    </table>

    <div v-if="!orders.loading" class="flex justify-between items-center mt-5">
      <div v-if="orders.data.length">
        Showing from {{ orders.from }} to {{ orders.to }}
      </div>
      <nav
        v-if="orders.total > orders.limit"
        class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px"
        aria-label="Pagination"
      >
        <!-- Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->
        <a
          v-for="(link, i) of orders.links"
          :key="i"
          :disabled="!link.url"
          href="#"
          @click="getForPage($event, link)"
          aria-current="page"
          class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap"
          :class="[
              link.active
                ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
              i === 0 ? 'rounded-l-md' : '',
              i === orders.links.length - 1 ? 'rounded-r-md' : '',
              !link.url ? ' bg-gray-100 text-gray-700': ''
            ]"
          v-html="link.label"
        >
        </a>
      </nav>
    </div>
  </div>
</template>

<script setup>
import {computed, onMounted, ref} from "vue";
import store from "../../store";
import Spinner from "../../components/core/Spinner.vue";
import {PRODUCTS_PER_PAGE} from "../../constants";
import TableHeaderCell from "../../components/core/Table/TableHeaderCell.vue";
import {Menu, MenuButton, MenuItem, MenuItems} from "@headlessui/vue";
import {DotsVerticalIcon, PencilIcon, TrashIcon} from '@heroicons/vue/outline'
import OrderStatus from "./OrderStatus.vue";


const perPage = ref(PRODUCTS_PER_PAGE);
const search = ref('');
const orders = computed(() => store.state.orders);
const sortField = ref('status');
// const sortField = ref('updated_at');
const sortDirection = ref('desc')


const emit = defineEmits(['clickView'])
onMounted(() => {
  getOrders();
})

function getForPage(ev, link) {
  ev.preventDefault();
  if (!link.url || link.active) {
    return;
  }

  getOrders(link.url)
}

function getOrders(url = null) {
  store.dispatch("getOrders", {
    url,
    search: search.value,
    per_page: perPage.value,
    sort_field: sortField.value,
    sort_direction: sortDirection.value
  });
}

function sortOrders(field) {
  if (field === sortField.value) {
    if (sortDirection.value === 'desc') {
      sortDirection.value = 'asc'
    } else {
      sortDirection.value = 'desc'
    }
  } else {
    sortField.value = field;
    sortDirection.value = 'asc'
  }

  getOrders()
}

// function showAddNewModal() {
//   showProductModal.value = true
// }


// function deleteOrder(orders) {
//   if (!confirm(`Are you sure you want to delete the orders?`)) {
//     return
//   }
//   store.dispatch('deleteOrder', orders.id)
//     .then(res => {
//       // TODO Show notification
//       store.dispatch('getOrders')
//     })
// }

function showOrder(p) {
  emit('clickView', p)
}
</script>

<style scoped>

</style>
