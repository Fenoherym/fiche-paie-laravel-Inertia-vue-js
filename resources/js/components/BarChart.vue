<template>
    <Bar
      :chart-options="chartOptions"
      :chart-data="chartData"
      :chart-id="chartId"
      :dataset-id-key="datasetIdKey"
      :plugins="plugins"
      :css-classes="cssClasses"
      :styles="styles"
      :width="width"
      :height="height"
    />
  </template>

  <script>
  import { Bar } from 'vue-chartjs'
  import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

  ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

  export default {
      name: 'BarChart',
      components: { Bar },
      props: {
        title:{
            type:String,
        },
        labels:{
            type: Array,
        },
        data:{
            type: Array
        },
        chartId: {
            type: String,
            default: 'bar-chart'
        },
        datasetIdKey: {
            type: String,
            default: 'label'
        },
        width: {
            type: Number,
            default: 400
        },
        height: {
            type: Number,
            default: 350
        },
        cssClasses: {
            default: '',
            type: String
        },
        styles: {
            type: Object,
            default: () => {}
        },
        plugins: {
            type: Object,
            default: () => {}
        }
    },
    data() {
      return {
        chartData: {
            labels: this.labels,
            datasets: [
            {
                label: this.title,
                backgroundColor: '#f87979',
                data: this.data
            }
            ]
        },
        chartOptions: {
          responsive: true
        }
      }
    },
  }
  </script>
