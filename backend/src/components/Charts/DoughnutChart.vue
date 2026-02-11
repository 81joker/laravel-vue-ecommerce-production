<template>
  <div>
    <Doughnut :data="chartData" :options="options" />
  </div>
</template>

<script setup>
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js'
import { Doughnut } from 'vue-chartjs'

ChartJS.register(ArcElement, Tooltip, Legend)
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

const options = {
  responsive: true,
  maintainAspectRatio: false,
}
</script>
