<script setup>
import { onMounted, ref, computed } from 'vue';
import ChartCard from './ChartCard.vue';
import axios from '@/utilities/axios.js';
import { getAccessToken } from '@/utilities/utils.js' ;

const errorMessage = ref('');
const PieChartDataQuestion6 = ref([]);
const PieChartDataQuestion7 = ref([]);
const PieChartDataQuestion10 = ref([]);
const RadarChartData = ref([]);

const fetchDataChart = async () => {
  try {
    const response = await axios.get('/admin/dashboard/datacharts',{
      headers: { Authorization: 'Bearer ' + getAccessToken() }
    });
    
    PieChartDataQuestion6.value = Object.entries(response.data.PieChartData.question_6).map(([key, value]) => ({
      value: key,
      count: value
    }));
    PieChartDataQuestion7.value = Object.entries(response.data.PieChartData.question_7).map(([key, value]) => ({
      value: key,
      count: value
    }));
    PieChartDataQuestion10.value = Object.entries(response.data.PieChartData.question_10).map(([key, value]) => ({
      value: key,
      count: value
    }));
    RadarChartData.value = response.data.RadarChartData;
  } catch (e) {
    console.error('Erreur des données des graphiques', e);
    errorMessage.value = 'Erreur survenue lors de la récupération des données du graphique';
    alert(errorMessage.value);
  }
}

var PieChartOptionsQ6 = computed(() => ({
  series: PieChartDataQuestion6.value.map(obj => Number(obj.count)),
  chart: {
    width: 500,
    type: 'pie',
  },
  labels: PieChartDataQuestion6.value.map(obj => obj.value),
  responsive: [{
    breakpoint: 380,
    options: {
      chart: {
        width: 0
      },
      legend: {
        position: 'left'
      }
    }
  }],
 })
);

var PieChartOptionsQ7 = computed(() => ({
  series: PieChartDataQuestion7.value.map(obj => Number(obj.count)),
  chart: {
    width: 455,
    type: 'pie',
  },
  labels: PieChartDataQuestion7.value.map(obj => obj.value),
  responsive: [{
    breakpoint: 380,
    options: {
      chart: {
        width: 0
      },
      legend: {
        position: 'left'
      }
    }
  }],
 })
);

var PieChartOptionsQ10 = computed(() => ({
  series: PieChartDataQuestion10.value.map(obj => Number(obj.count)),
  chart: {
    width: 500,
    type: 'pie',
  },
  labels: PieChartDataQuestion10.value.map(obj => obj.value),
  responsive: [{
    breakpoint: 380,
    options: {
      chart: {
        width: 0
      },
      legend: {
        position: 'left'
      }
    }
  }],
 })
);

const RadarDataOptions = computed(() => ({
  series: [{
    name: 'Series 1',
    data: RadarChartData.value.map(obj => Number(obj.count))
  }],
  options: {
    chart: {
      height: 350,
      type: 'radar',
    },
    xaxis: {
      categories: RadarChartData.value.map(obj => obj.value)
    }
  }
}));

onMounted(fetchDataChart);
</script>

<template>
<section class="Dashboard">
  <article class="DashboardTitle">
    <h2>Statistiques du Sondage</h2>
    <hr>
  </article>
  <article class="DashboardContent">
    <ChartCard
      :ChartType="PieChartOptionsQ6.chart.type"
      :ChartOptions="PieChartOptionsQ6"
      :ChartSeries="PieChartOptionsQ6.series"
      ChartTitle="Casques VR utilisés (Q6)"
    />
    <ChartCard
      :ChartType="PieChartOptionsQ7.chart.type"
      :ChartOptions="PieChartOptionsQ7"
      :ChartSeries="PieChartOptionsQ7.series"
      ChartTitle="Magasins d'applications (Q7)"
    />
    <ChartCard
      :ChartType="PieChartOptionsQ10.chart.type"
      :ChartOptions="PieChartOptionsQ10"
      :ChartSeries="PieChartOptionsQ10.series"
      ChartTitle="Utilisation principale (Q10)"
    />
    <ChartCard
      :ChartType="RadarDataOptions.options.chart.type"
      :ChartOptions="RadarDataOptions.options"
      :ChartSeries="RadarDataOptions.series"
      ChartTitle="Pour les questions (Q11-Q15)"
    />
  </article>
</section>
</template>

<style scoped>
.Dashboard {
  /*border: 1px solid white;*/
  width: 68vw;
  padding: 40px 0px;
}

.DashboardTitle h2 {
  color: #00b8ff;
  font-weight: bold;
  margin-bottom: 10px;
  font-size: 1.8rem;
}

.DashboardTitle hr {
  border: 1px solid #00b8ff;
  width: 100%;
}

.DashboardContent {
  /*border: 1px solid #fff;*/
  height:auto;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}
</style>
