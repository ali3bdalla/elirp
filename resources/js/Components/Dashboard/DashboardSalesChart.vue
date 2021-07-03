<template>
  <vue3-chart-js v-bind="{ ...lineChart }"/>
</template>

<script>
import Vue3ChartJs from "@j-t-mcc/vue3-chartjs";
import zoomPlugin from "chartjs-plugin-zoom";
import dataLabels from "chartjs-plugin-datalabels";

// globally registered and available for all charts
Vue3ChartJs.registerGlobalPlugins([zoomPlugin]);
import {useQuery, useResult} from "@vue/apollo-composable";
import gql from "graphql-tag";

export default {
  name: "App",
  components: {
    Vue3ChartJs,
  },
  setup(props) {

    return {
      lineChart: {
        type: "line",
        plugins: [dataLabels],
        data: {
          labels: props.labels,
          datasets: props.datasets,
        },
        options: {
          plugins: {
            zoom: {
              zoom: {
                wheel: {
                  enabled: true,
                },
                pinch: {
                  enabled: true,
                },
                mode: "x",
              },
            },
            datalabels: {
              backgroundColor: function (context) {
                return context.dataset.backgroundColor;
              },
              borderRadius: 4,
              color: "white",
              font: {
                weight: "bold",
              },
              formatter: Math.round,
              padding: 6,
            },
          },
        },
      },
    };
  },
};
</script>
