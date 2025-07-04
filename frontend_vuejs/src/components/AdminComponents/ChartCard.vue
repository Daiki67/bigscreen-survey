<script setup>
import VueApexCharts from 'vue3-apexcharts';

const props = defineProps({
  ChartTitle: {
    type: String,
    required: true
  },
  ChartType: {
    type: String,
    required: true
  },
  ChartOptions: {
    type: Object,
    required: true
  },
  ChartSeries: {
    type: Array,
    required: true
  },
});
</script>

<template>
<div class="ChartCard">
  <div class="ChartTitle">
    <h3> {{ props.ChartTitle }} </h3>
  </div>
  <div class="ChartBlock">
    <vue-apex-charts
      width = "100%"
      height = "100%"
      :type = 'props.ChartType'
      :options = "props.ChartOptions"
      :series = "props.ChartSeries"
    >
    </vue-apex-charts>
  </div>
</div>
</template>

<style scoped>
.ChartCard {
  border: 1px solid #2c2c2c;
  background-color: #1e1e1e;
  width: 42%;
  padding: 35px 25px;
  margin-top: 50px;
  border-radius: 12px;
  transform: translateY(0px);
  transition: transform 0.4s ease-in-out;
}

.ChartCard:hover {
  cursor: pointer;
  transform: translateY(-10px);
  transition: transform 0.4s ease-in-out;
}

.ChartTitle {
  text-align: center;
  color: #b3b3b3;
  /*border: 1px solid #fff;*/
  margin-bottom: 40px;
  font-weight: bold;
}

.ChartBlock {
  /*border: 1px solid #fff;*/
  width: 90%;
  height: 330px;
  margin: auto;
  border-radius: 12px;
}
</style>

