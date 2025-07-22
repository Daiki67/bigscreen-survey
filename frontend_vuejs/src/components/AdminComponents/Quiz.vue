<script setup>
import QuizTable from './QuizTable.vue';
</script>

<template>
<section class="Quiz">
  <article class="QuizTitle">
    <h2>Liste des Questions du Sondage</h2>
    <hr>
  </article>
  <article class="QuizContent">
    <div class="QuizNote">
      <p>Note : Les questions ne sont pas administrables.</p>
    </div>
    <QuizTable />
  </article>
</section>
</template>

<style scoped>
.Quiz {
  /*border: 1px solid white;*/
  width: 68vw;
  padding: 40px 0px;
}

.QuizTitle h2 {
  color: #00b8ff;
  font-weight: bold;
  margin-bottom: 10px;
  font-size: 1.8rem;
}

.QuizTitle hr {
  border: 1px solid #00b8ff;
  width: 100%;
}

.QuizContent {
  /*border: 1px solid #fff;*/
  height:auto;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}

.QuizNote {
  margin-top: 30px;
  color: #b3b3b3;
  font-size: 1.1rem;
}

@media (max-width: 480px) {

  .Quiz {
    /*border: 1px solid white;*/
    width: 80vw;
    padding: 40px 0px;
  }
  
}
</style>
