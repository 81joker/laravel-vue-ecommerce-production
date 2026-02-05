<template>
  <div>
    <!-- <pre>{{ users.links }}</pre> -->
    <div class="flex items-center justify-between mb-3">
      <h1 class="text-3xl font-semibold">Users</h1>
      <button
        type="button"
        @click="showUserModal"
        class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
      >
        Add new User
      </button>
    </div>
    <UsersTable @clickEdit="editUser" />
  <UserModal v-model="showModal"  :user="userModel" />
  </div>
</template>
<script setup>
import { ref } from "vue";
import UserModal from "./UserModal.vue";
import UsersTable from "./UsersTable.vue";
import store from "../../store";

const userModel = ref({
  id: '',
  title: "",
  image: '',
  description: "",
  price: '',
});

// function showAddNewModal() {
//   showUserModal.value = true
// }
const showModal = ref(false)

  function showUserModal() {
    showModal.value = true
  }
  
  function editUser(u) {
    
      userModel.value = u
      showUserModal()
      // showAddNewModal();
}
//   function editUser(p) {
//   store.dispatch('getUser', p.id)
//     .then(({data}) => {      
//       userModel.value = data
//       showUserModal()
//       // showAddNewModal();
//     })
// }

</script>
