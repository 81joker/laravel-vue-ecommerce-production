<template>
  <div v-if="data">
    <Bar v-if="data.datasets" :data="data" :options="chartOptions" />
    <p v-else>Error: Data is not in the correct format.</p>
  </div>
  <p v-else>Error: No data provided.</p>
</template>

<script setup>
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from 'chart.js'

import { Bar } from 'vue-chartjs'

ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend)

const props = defineProps({
  data: {
    type: Object,
    required: true,
  },
  options: {
    type: Object,
    required: true,
  },
})

const chartData = props.data

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
}
</script>
