<script setup>
// Import du composant AnswerForm (affichage des réponses d'un utilisateur)
import AnswerForm from '@/components/AnswerForm.vue';
// Récupère la prop 'token' transmise par le routeur (paramètre dynamique de l'URL)
const props = defineProps(['token']);
</script>

<template>
  <!-- Conteneur principal pour l'affichage des réponses -->
  <div class="Answerbody">
    <!-- Composant AnswerForm, reçoit le token en prop -->
    <AnswerForm :token="props.token" />
  </div>
</template>

<style scoped>
/* Style du conteneur principal de la page de réponses */
.Answerbody{
  width: 100%;
  height: auto;
  display: flex;
  justify-content: center;
  padding: 40px 0px;
  background-color: #121212;
}
</style>
