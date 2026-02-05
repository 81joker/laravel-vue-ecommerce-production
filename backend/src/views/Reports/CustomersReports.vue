<template>
  <div>
    <h1 class="text-3xl font-semibold">Customer Reports</h1>
    <div>
      <BarChart :data="chartData" :height="240"/>
    </div>

  </div>
</template>

<script setup>
import axiosClient from "@/axios";
import { ref ,  watch } from "vue";
import BarChart from "@/components/Charts/BarChart.vue";
import { useRoute } from "vue-router";

const route = useRoute();
const chartData = ref([]);

watch(route, (rt) => {
  getData();
}, {immediate: true})

function getData() {
  axiosClient.get('reports/orders', {params: {d: route.params.date}})
    .then(({data}) => {
      chartData.value = data;
    })
}



</script>
<!-- SELECT 
    CAST(created_at AS DATE) AS day, 
    COUNT(id) AS total_orders
FROM orders
GROUP BY CAST(created_at AS DATE)
ORDER BY day ASC; -->

<!-- CAST ===>Convert a value to a DATE datatype: -->

