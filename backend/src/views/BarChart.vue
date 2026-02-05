<template>
    <Doughnut
      id="my-chart-id"
      :data="chartData"
      :options="chartOptions"
    />
  </template>

  <script setup>
  import { ref } from 'vue'
  import { Doughnut } from 'vue-chartjs'
  import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js'


  ChartJS.register(ArcElement, Tooltip, Legend)

  // Reactive references for chart data and options
  const chartData = ref({
    labels: ['January', 'February', 'March'],
    datasets: [{ data: [40, 20, 12] }]
  })

  const chartOptions = ref({
    responsive: true
  })
  </script>
