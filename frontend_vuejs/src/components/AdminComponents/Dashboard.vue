<script setup>
import ChartCard from './ChartCard.vue';
</script>

<template>
<section class="Dashboard">
  <article class="DashboardTitle">
    <h2>Statistiques du Sondage</h2>
    <hr>
  </article>
  <article class="DashboardContent">
    <ChartCard
      ChartTitle="Casques VR utilisés (Q6)"
    />
    <ChartCard
      ChartTitle="Magasins d'applications (Q7)"
    />
    <ChartCard
      ChartTitle="Utilisation principale (Q10)"
    />
    <ChartCard
      ChartTitle="Qualité de l'expérience (Q11-15)"
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
