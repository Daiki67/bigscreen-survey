<script setup>
import { onMounted, ref } from 'vue';
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
    PieChartDataQuestion6.value = response.data.PieChartData.question_6;
    PieChartDataQuestion7.value = response.data.PieChartData.question_7;
    PieChartDataQuestion10.value = response.data.PieChartData.question_10;
    RadarChartData.value = response.data.RadarChartData;

    /* console.log(PieChartDataQuestion6.value);
    console.log(PieChartDataQuestion7.value);
    console.log(PieChartDataQuestion6.value); */
    console.log(RadarChartData.value);
  } catch (e) {
    console.error('Erreur des données des graphiques', e);
    errorMessage.value = 'Erreur survenue lors de la récupération des données du graphique';
    alert(errorMessage.value);
  }
}

/* var options = {
            series: [5, 5, 2, 3],
            chart: {
            width: 700,
            type: 'pie',
          },
          labels: ['Ordinateur', 'Smartphone', 'Tablette', 'Télévision'],
          responsive: [{
            breakpoint: 380,
            options: {
              chart: {
                width: 500
              },
              legend: {
                position: 'bottom'
              }
            }
          }]
        }; */

const RadarDataOptions = ref({
        series: [{
          name: 'Series 1',
          data: /* [3.75, 4.5, 3.5, 4.5, 4.5] */
            RadarChartData.value.forEach((value, count) => {
              [ count ]
            })
          ,
        }],
        options:{
          chart: {
            height: 850,
            width: 500,
            type: 'radar',
          },
          /* title: {
            text: 'Quality Aspects of Bigscreen'
          }, */
          xaxis: {
            categories: ['Image Quality', 'Interface Comfort', 'Network Connection', '3D Graphics Quality', 'Audio Quality']
          }
      },
});

onMounted(fetchDataChart);
</script>

<template>
<section class="Dashboard">
  <article class="DashboardTitle">
    <h2>Statistiques du Sondage</h2>
    <hr>
  </article>
  <article class="DashboardContent">
    <!-- <ChartCard
      ChartType="pie"
      ChartOptions="d"
      ChartSeries="d"
      ChartTitle="Casques VR utilisés (Q6)"
    />
    <ChartCard
      ChartType="pie"
      ChartOptions="d"
      ChartSeries="d"
      ChartTitle="Magasins d'applications (Q7)"
    />
    <ChartCard
      ChartType="pie"
      ChartOptions="d"
      ChartSeries="d"
      ChartTitle="Utilisation principale (Q10)"
    /> -->
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
