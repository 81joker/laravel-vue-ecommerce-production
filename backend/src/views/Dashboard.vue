<template>
    <div class="mb-2 flex justify-between items-center">
        <h1 class="text-3xl font-semibold">Dashbboard</h1>
        <div class="flex items-center">
            <label for="" class="mr-2">Change Date Period</label>
            <CustomInput type="select" v-model="chosenDate" @change="onDatePickerChange" :select-options="dateOptions"/>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
        <!-- ACtivae Customers -->
        <div class="animate-fade-in-down  bg-white py-6 px-5 text-center shadow rounded-lg flex flex-col items-center justify-center">
            <label>Active Customers</label>
            <template v-if="!loading.cousomersCount">
                <span class="text-3xl font-semibold">{{ cousomersCount }}</span>
            </template>
            <Spinner v-else text="" class="" />
        </div>
        <!-- ACtivae Customers -->
        <!-- ACtivae Products -->
        <div class="animate-fade-in-down bg-white py-6 px-5 text-center shadow rounded-lg flex flex-col items-center justify-center" style="animation-delay: 0.1s;">
            <label>Active Products</label>
            <template v-if="!loading.productsCount">
                <span class="text-3xl font-semibold">{{ productsCount }}</span>
            </template>
            <Spinner v-else text="" class="" />
        </div>
        <!-- ACtivae Products -->
        <!--Paid Order -->
        <div class="animate-fade-in-down bg-white py-6 px-5 text-center shadow rounded-lg flex flex-col items-center justify-center" style="animation-delay: 0.2ms;">
            <label>Total Paid Order</label>
            <template v-if="!loading.paidOrders">
                <span class="text-3xl font-semibold">{{ paidOrders }}</span>
            </template>
            <Spinner v-else text="" class="" />
        </div>
        <!--Paid Order -->
        <!-- Total Income -->
        <div class="animate-fade-in-down bg-white py-6 px-5 text-center shadow rounded-lg flex flex-col items-center justify-center" style="animation-delay: 0.3s;">
            <label>Total Income</label>
            <template v-if="!loading.totalIncome">
                <span class="text-3xl font-semibold">{{ totalIncome }}</span>
            </template>
            <Spinner v-else text="" class="" />
        </div>
        <!-- Total Income -->
    </div>
    <div class="grid grid-rows-1 md:grid-rows-2 md:grid-flow-col grid-cols-1 md:grid-cols-3 gap-3 mt-3">
        <!-- Latest Orders  -->
        <div class="col-span-1 md:col-span-2 row-span-1 md:row-span-2 bg-white py-6 px-5 <shadow rounded-lg">
            <label class="text-lg font-semibold block mb-2">Latest Orders</label>
            <template v-if="!loading.latestOrders">
                <div v-for="o of latestOrders" :key="o.id" class="py-2 px-3 hover:bg-gray-50">
                    <p>
                        <router-link :to="{
                            name: 'app.orders.view',
                            params: { id: o.id },
                        }" class="text-indigo-700 font-semibold">
                            Order #{{ o.id }}
                        </router-link>
                        contains - {{ o.items }} items ,
                        {{ $filters.currencyEUR(o.total_price) }}
                    </p>
                    <p class="flex justify-between">
                        <span>{{ o.first_name }} {{ o.last_name }}</span>
                        <span>{{ o.created_at }}</span>
                    </p>
                </div>
            </template>
            <Spinner v-else text="" class=""/>
        </div>
        <!--/ Latest Orders  -->
        <!-- DoughnutChart  -->
        <div class="bg-white py-6 px-5 shadow rounded-lg flex flex-col items-center justify-center">
            <template v-if="!loading.orderByCountry">
            <DoughnutChart :width="140" :height="200" :data="orderByCountry" v-if="
                orderByCountry.datasets &&
                orderByCountry.datasets[0].data.length > 0
            " />
            </template>
            <Spinner v-else text="" class="" />
        </div>
        <!--/ DoughnutChart  -->
        <!-- Latest Customers -->
        <div class="bg-white py-6 px-5 rounded-lg shadow">
            <label class="text-lg font-semibold block mb-2">Latest Customers</label>
            <template v-if="!loading.latestCustomers">
                <router-link :to="{ name: 'app.customers.view', params: { id: c.id } }" v-for="c of latestCustomers"
                    :key="c.id" class="mb-3 flex">
                    <div class="w-12 h-12 bg-gray-200 flex items-center justify-center rounded-full mr-2">
                        <UserIcon class="w-5" />
                    </div>
                    <div>
                        <h3>{{ c.first_name }} {{ c.last_name }}</h3>
                        <p>{{ c.email }}</p>
                    </div>
                </router-link>
            </template>
            <Spinner v-else text="" class="" />
        </div>
        <!--/ Latest Customers -->
    </div>
</template>
<script setup>
import {UserIcon} from '@heroicons/vue/outline'
import axiosClient from "@/axios";
import DoughnutChart from "@/components/Charts/DoughnutChart.vue";
import CustomInput from "@/components/core/CustomInput.vue";
import Spinner from "@/components/core/Spinner.vue";
import { ref ,onMounted} from "vue";

const dateOptions = ref([
    { key: "1d", text: "Last Day" },
    { key: "1w", text: "Last Week" },
    { key: "2w", text: "Last 2 Weeks" },
    { key: "1m", text: "Last Month" },
    { key: "3m", text: "Last 3 Months" },
    { key: "6m", text: "Last 6 Months" },
    { key: "all", text: "All Time" },
])

const chosenDate = ref('all')

const loading = ref({
    cousomersCount: true,
    productsCount: true,
    paidOrders: true,
    totalIncome: true,
    orderByCountry: true,
    latestCustomers: true,
    latestOrders: true
  })

const cousomersCount = ref();
const productsCount = ref();
const paidOrders = ref();
const totalIncome = ref();
const latestCustomers = ref([]);
const latestOrders = ref([]);
const orderByCountry = ref([]);



function updateDashboard() {
    const d = chosenDate.value    
    loading.value = {
        cousomersCount: true,
        productsCount: true,
        paidOrders: true,
        totalIncome: true,
        orderByCountry: true,
        latestCustomers: true,
        latestOrders: true,
    }
    axiosClient.get(`/dashboard/customers-count`, {params: {d}}).then(({data}) => {
        cousomersCount.value = data
        loading.value.cousomersCount = false;
    })
    axiosClient.get(`/dashboard/products-count`, {params: {d}}).then(({data}) => {
        productsCount.value = data;
        loading.value.productsCount = false;
    })

    axiosClient.get(`/dashboard/orders-count`, {params: {d}}).then(({data}) => {
        paidOrders.value = data;
        loading.value.paidOrders = false;
    })
    axiosClient.get(`/dashboard/income-count`, {params: {d}}).then(({data}) => {
        (totalIncome.value = new Intl.NumberFormat("de-DE", {
            style: "currency",
            currency: "EUR",
            minimumFractionDigits: 0, 
        }).format(Math.random(data))),
        (loading.value.totalIncome = false);
    })
    axiosClient.get(`/dashboard/orders-by-country`, {params: {d}}).then(({data: countries}) => {
      loading.value.orderByCountry = false;
      const chartData = {
        labels: [],
        datasets: [{
          backgroundColor: ['#41B883', '#E46651', '#00D8FF', '#DD1B16'],
          data: []
        }]
      }
      countries.forEach(c => {
        chartData.labels.push(c.name);
        chartData.datasets[0].data.push(c.count);
      })
      orderByCountry.value = chartData
    })
    axiosClient.get(`/dashboard/latest-customers`, {params: {d}}).then(({data}) => {
        latestCustomers.value = data;
        loading.value.latestCustomers = false;
    })
    axiosClient.get(`/dashboard/latest-orders`, {params: {d}}).then(({data: ordres}) => {
        latestOrders.value = ordres.data;
        loading.value.latestOrders = false;
    })


}

const onDatePickerChange = () => {
    updateDashboard()
}
onMounted(() => {
    updateDashboard()
})
</script>
