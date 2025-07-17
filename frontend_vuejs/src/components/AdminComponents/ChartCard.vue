<!-- -----------------------------------------------------------------------------
Composant : ChartCard
Type : Composant Vue 3 (fonctionnel, carte graphique)
Rôle : Affiche une carte contenant un graphique ApexCharts avec titre et options dynamiques
Props :
  - ChartTitle : String (obligatoire) - Titre du graphique
  - ChartType : String (obligatoire) - Type de graphique (bar, line, pie, etc.)
  - ChartOptions : Object (obligatoire) - Options de configuration ApexCharts
  - ChartSeries : Array (obligatoire) - Données à afficher dans le graphique
Librairies tierces utilisées :
  - vue3-apexcharts : Composant <vue-apex-charts> pour l’affichage des graphiques interactifs
----------------------------------------------------------------------------- -->
<script setup>
import VueApexCharts from 'vue3-apexcharts'; // Composant graphique tiers

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
  <!-- ------------------------------------------------------------------------ -->
  <!-- Composant : ChartCard                                                    -->
  <!-- Rôle : Affiche une carte stylisée contenant un graphique ApexCharts       -->
  <!-- Props : ChartTitle, ChartType, ChartOptions, ChartSeries                 -->
  <!-- Librairie tierce : <vue-apex-charts> (vue3-apexcharts)                   -->
  <!-- ------------------------------------------------------------------------ -->
  <div class="ChartCard">
    <div class="ChartTitle">
      <!-- Affiche le titre du graphique -->
      <h3> {{ props.ChartTitle }} </h3>
    </div>
    <div class="ChartBlock">
      <!--
        Composant : vue-apex-charts
        - Type : Composant graphique tiers
        - Props :
          - width : String (100%)
          - height : String (100%)
          - type : String (type de graphique)
          - options : Object (options ApexCharts)
          - series : Array (données)
      -->
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

