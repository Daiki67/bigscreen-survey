<script setup>
/*
Composant : Dashboard
Type : Vue 3 - Composant de page/statistiques (Composition API, <script setup>)
Rôle : Affiche les statistiques du sondage sous forme de graphiques (ApexCharts)
Librairies tierces utilisées :
  vue : ref, computed, onMounted (gestion de la réactivité et des hooks)
  axios : client HTTP personnalisé (requêtes API)
  ChartCard : composant enfant pour l’affichage des graphiques
  @/utilities/utils.js : getAccessToken (gestion du token d’authentification)
*/
import { onMounted, ref, computed } from 'vue'; // onMounted : hook, ref : réactivité, computed : propriétés calculées
import ChartCard from './ChartCard.vue'; // Composant graphique réutilisable
import axios from '@/utilities/axios.js'; // AxiosInstance personnalisé
import { getAccessToken } from '@/utilities/utils.js' ; // Fonction utilitaire pour récupérer le token

// -----------------------------------------------------------------------------
// État local (variables réactives)
// -----------------------------------------------------------------------------
// errorMessage : Ref<string> - Message d’erreur affiché à l’utilisateur
const errorMessage = ref('');
// PieChartDataQuestion6/7/10 : Ref<Array<{value: string, count: number|string}>>
// Données pour les graphiques camembert (Q6, Q7, Q10)
const PieChartDataQuestion6 = ref([]);
const PieChartDataQuestion7 = ref([]);
const PieChartDataQuestion10 = ref([]);
// RadarChartData : Ref<Array<{value: string, count: number|string}>>
// Données pour le graphique radar (Q11-Q15)
const RadarChartData = ref([]);

// -----------------------------------------------------------------------------
// Méthode : fetchDataChart
// Type : Fonction asynchrone
// Rôle : Récupère les données statistiques via l’API et les formate pour les graphiques
// Utilise : axios.get (requête API), getAccessToken (authentification)
// -----------------------------------------------------------------------------
const fetchDataChart = async () => {
  try {
    const response = await axios.get('/admin/dashboard/datacharts',{
      headers: { Authorization: 'Bearer ' + getAccessToken() }
    });
    // Transformation des objets de réponses en tableaux d’objets pour ApexCharts
    // Chaque entrée : { value: clé (String), count: valeur (Number/String) }
    PieChartDataQuestion6.value = Object.entries(response.data.PieChartData.question_6).map(([key, value]) => ({
      value: key,   // value : String - Catégorie (ex : casque VR)
      count: value  // count : Number/String - Nombre d’occurrences
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

// -----------------------------------------------------------------------------
// Propriétés calculées pour les options et séries des graphiques ApexCharts
// -----------------------------------------------------------------------------
// PieChartOptionsQ6 : Options pour le graphique camembert Q6
const PieChartOptionsQ6 = computed(() => ({
  series: PieChartDataQuestion6.value.map(obj => Number(obj.count)),
  chart: {
    width: 500,
    type: 'pie',
  },
  labels: PieChartDataQuestion6.value.map(obj => obj.value),
  legend: {
    position: 'bottom',
    horizontalAlign: 'center',
    fontSize: '14px',
    fontFamily: 'Arial, sans-serif',
    labels: {
      colors: ['#ffffff'],
      useSeriesColors: true
    },
    markers: {
      width: 12,
      height: 12,
      radius: 12
    },
    itemMargin: {
      horizontal: 10,
      vertical: 5
    }
  },
  responsive: [{
    breakpoint: 380,
    options: {
      chart: {
        width: 300
      },
      legend: {
        position: 'bottom'
      }
    }
  }]
}));

// PieChartOptionsQ7 : Options pour le graphique camembert Q7
const PieChartOptionsQ7 = computed(() => ({
  series: PieChartDataQuestion7.value.map(obj => Number(obj.count)),
  chart: {
    width: 455,
    type: 'pie',
  },
  labels: PieChartDataQuestion7.value.map(obj => obj.value),
  legend: {
    position: 'bottom',
    horizontalAlign: 'center',
    fontSize: '14px',
    fontFamily: 'Arial, sans-serif',
    labels: {
      colors: ['#ffffff'],
      useSeriesColors: true
    },
    markers: {
      width: 12,
      height: 12,
      radius: 12
    },
    itemMargin: {
      horizontal: 10,
      vertical: 5
    }
  },
  responsive: [{
    breakpoint: 380,
    options: {
      chart: {
        width: 300
      },
      legend: {
        position: 'bottom'
      }
    }
  }]
}));

// PieChartOptionsQ10 : Options pour le graphique camembert Q10
const PieChartOptionsQ10 = computed(() => ({
  series: PieChartDataQuestion10.value.map(obj => Number(obj.count)),
  chart: {
    width: 500,
    type: 'pie',
  },
  labels: PieChartDataQuestion10.value.map(obj => obj.value),
  legend: {
    position: 'bottom',
    horizontalAlign: 'center',
    fontSize: '14px',
    fontFamily: 'Arial, sans-serif',
    labels: {
      colors: ['#ffffff'],
      useSeriesColors: true
    }
  },
  responsive: [
    {
      breakpoint: 380,
      options: {
        chart: {
          width: 300
        },
        legend: {
          position: 'bottom'
        }
      }
    }
  ]
}));

// RadarDataOptions : Options pour le graphique radar (Q11-Q15)
const RadarDataOptions = computed(() => ({
  series: [{
    name: 'Value',
    data: RadarChartData.value.map(obj => Number(obj.count))
  }],
  options: {
    chart: {
      height: 350,
      type: 'radar',
      toolbar: {
        show: false
      }
    },
    xaxis: {
      categories: RadarChartData.value.map(obj => obj.value),
      labels: {
        style: {
          colors: '#ffffff', 
          fontSize: '14px'
        }
      }
    },
    yaxis: {
      labels: {
        style: {
          colors: 'none'
        }
      }
    },
    stroke: {
      show: true,
      width: 2,
      colors: ['#00E396']
    },
    fill: {
      opacity: 0.1,
      colors: ['#00E396']
    }
  }
}));


// Hook d’exécution au montage du composant
onMounted(fetchDataChart);
</script>

<template>
<!-- -------------------------------------------------------------------------- -->
<!-- Composant : Dashboard                                                      -->
<!-- Type : Vue 3 (template)                                                    -->
<!-- Rôle : Affiche la page de statistiques avec 4 graphiques principaux        -->
<!-- Composants enfants : ChartCard (affichage graphique)                       -->
<!-- -------------------------------------------------------------------------- -->
<section class="Dashboard">
  <article class="DashboardTitle">
    <h2>Statistiques du Sondage</h2>
    <hr>
  </article>
  <article class="DashboardContent">
    <!--
      Composant : ChartCard
      - Type : Composant graphique réutilisable
      - Props :
        - ChartType : String - Type de graphique (ex : 'pie', 'radar')
        - ChartOptions : Object - Options de configuration ApexCharts (labels, chart, responsive...)
        - ChartSeries : Array - Données numériques à afficher
        - ChartTitle : String - Titre affiché sur la carte
      - Source des props :
        - PieChartOptionsQ6 : options et séries pour la question 6
    -->
    <ChartCard
      :ChartType="PieChartOptionsQ6.chart.type"
      :ChartOptions="PieChartOptionsQ6"
      :ChartSeries="PieChartOptionsQ6.series"
      ChartTitle="Casques VR utilisés (Q6)"
    />
    <!--
      Composant : ChartCard
      - Props :
        - ChartType : String (type de graphique)
        - ChartOptions : Object (options ApexCharts)
        - ChartSeries : Array (données)
        - ChartTitle : String (titre)
      - Source des props : PieChartOptionsQ7
    -->
    <ChartCard
      :ChartType="PieChartOptionsQ7.chart.type"
      :ChartOptions="PieChartOptionsQ7"
      :ChartSeries="PieChartOptionsQ7.series"
      ChartTitle="Magasins d'applications (Q7)"
    />
    <!--
      Composant : ChartCard
      - Props :
        - ChartType : String
        - ChartOptions : Object
        - ChartSeries : Array
        - ChartTitle : String
      - Source des props : PieChartOptionsQ10
    -->
    <ChartCard
      :ChartType="PieChartOptionsQ10.chart.type"
      :ChartOptions="PieChartOptionsQ10"
      :ChartSeries="PieChartOptionsQ10.series"
      ChartTitle="Utilisation principale (Q10)"
    />
    <!--
      Composant : ChartCard
      - Props :
        - ChartType : String (type de graphique)
        - ChartOptions : Object (options ApexCharts)
        - ChartSeries : Array (données)
        - ChartTitle : String (titre)
      - Source des props : RadarDataOptions
    -->
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

@media (max-width: 768px) {

  .DashboardContent {
    flex-direction: column;
    align-items: center;
  }
  
}

@media (max-width: 480px) {

  .Dashboard {
    /*border: 1px solid white;*/
    width: 80vw;
    padding: 40px 0px;
  }
  
}
</style>
