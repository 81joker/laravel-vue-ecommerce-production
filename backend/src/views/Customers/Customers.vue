<template>
  <div>
    <!-- <pre>{{ customers.links }}</pre> -->
    <div class="flex items-center justify-between mb-3">
      <h1 class="text-3xl font-semibold">Customers</h1>
      <button
        type="button"
        @click="showCustomerModal"
        class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
      >
        Add new Customer
      </button>
    </div>
    <CustomersTable @clickEdit="editCustomer" />
   <CustomerModal v-model="showModal"  :customer="customerModel" />
  </div>
</template>
<script setup>
import { ref } from "vue";
import CustomerModal from "./CustomerModal.vue";
import CustomersTable from "./CustomersTable.vue";
import store from "../../store";

const customerModel = ref({
  id: '',
  first_name: "",
  last_name: '',
  phone: "",
  status: '',
   email: "",
  // address: "",
});

// function showAddNewModal() {
//   showCustomerModal.value = true
// }
const showModal = ref(false)

  function showCustomerModal() {
    showModal.value = true
  }

//   function editCustomer(c) {

//       customerModel.value = c
//       showCustomerModal()
//       // showAddNewModal();
// }
  function editCustomer(c) {
  store.dispatch('getCustomer', c.id)
    .then(({data}) => {
    customerModel.value = data
      showCustomerModal()
      // showAddNewModal();
    })
}

</script>
