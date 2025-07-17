<script setup>
/*
Composant : QuizTable
Type : Vue 3 - Composant de tableau (Composition API, <script setup>)
Rôle : Affiche la liste des questions du quiz dans un tableau administrateur
Librairies tierces utilisées :
  axios : client HTTP personnalisé (requêtes API)
  vue : ref, onMounted (gestion de la réactivité et des hooks)
  @/utilities/utils : getAccessToken (gestion du token d’authentification)
*/
import axios from '@/utilities/axios.js' // AxiosInstance personnalisé
import { ref, onMounted } from 'vue'; // ref : réactivité, onMounted : hook
import { getAccessToken } from '@/utilities/utils'; // Fonction utilitaire pour récupérer le token

// Questions : Ref<Array<{id: number, body: string, type: string}>>
// Liste des questions du quiz
const Questions = ref([]);
// errorMessage : Ref<string> - Message d’erreur affiché à l’utilisateur
const errorMessage = ref('');

// fetchQuestions : Fonction asynchrone - Récupère les questions du quiz via l’API
const fetchQuestions = async () => {
  try {
    errorMessage.value = '';
    const response = await axios.get('/admin/survey/questions', {
      headers: { Authorization: 'Bearer ' + getAccessToken() }
    });
    Questions.value = response.data.data;
    //console.log(Questions.value);
  }catch(e){
    console.error('Erreur lors de la récupération des questions: ', e);
    errorMessage.value = 'Erreur lors de la récupération des questions:';
    alert(errorMessage.value);
  }
}

// Hook d’exécution au montage du composant
onMounted(fetchQuestions);
</script>

<template>
<!-- -------------------------------------------------------------------------- -->
<!-- Composant : QuizTable                                                      -->
<!-- Type : Tableau HTML                                                        -->
<!-- Rôle : Affiche la liste des questions du quiz pour l’admin                 -->
<!-- Données : Questions (Array<{id, body, type}>)                              -->
<!-- -------------------------------------------------------------------------- -->
<table>
  <thead>
    <tr>
      <!-- Colonne : N°
           - Nom : id
           - Type : Number
           - Rôle : Identifiant unique de la question -->
      <td>N°</td>
      <!-- Colonne : Corps de la question
           - Nom : body
           - Type : String
           - Rôle : Texte principal de la question -->
      <td>Corps de la question</td>
      <!-- Colonne : Type
           - Nom : type
           - Type : String
           - Rôle : Type de la question (A, B, C, etc.) -->
      <td>Type</td>
    </tr>
  </thead>
  <tbody v-if="Questions">
    <!-- Ligne pour chaque question Q -->
    <tr v-for="Q in Questions" :key="Q.id">
      <!-- Q.id : Number - Identifiant unique -->
      <td> {{ Q.id }} </td>
      <!-- Q.body : String - Corps de la question -->
      <td> {{ Q.body }} </td>
      <!-- Q.type : String - Type de la question (A, B, C, etc.) -->
      <td> {{ Q.type }} </td>
    </tr>
  </tbody>
</table>
</template>


<style scoped>
table {
  width: 100%;
  /*border: 1px solid white;*/
  margin-top: 20px;
  color: #b3b3b3;
  border-collapse: collapse;
}

thead {
  color: #00b8ff;
  border: 1px solid #2c2c2c;
}

thead td,tbody td {
  padding: 15px;
  background: #2c2c2c;
  font-weight: 700;
  font-size: 1.2rem;
}

tbody td {
  background: #1e1e1e;
  border-bottom: 1px solid #2c2c2c;
  font-weight: 500;
}

/*tbody td:nth-child(2) {
  background: #2c2c2c;
}*/
</style>

