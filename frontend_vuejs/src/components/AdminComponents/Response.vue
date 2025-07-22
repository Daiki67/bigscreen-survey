<script setup>
// -----------------------------------------------------------------------------
// Composant : Response
// -----------------------------------------------------------------------------
// Type : Fonctionnel (affichage des réponses utilisateurs sous forme de tableau paginé)
//
// Librairies tierces utilisées :
// - axios :
//     - Instance personnalisée pour les requêtes HTTP (récupération questions/réponses)
// - vue :
//     - ref : création de variables réactives
//     - onMounted : hook d'exécution au montage du composant
//     - computed : propriétés calculées pour la pagination
// - @/utilities/utils :
//     - getAccessToken : fonction pour récupérer le token d'accès
//
// État local :
// - Responses (ref<Array>) : liste des réponses utilisateurs
// - Questions (ref<Array>) : liste des questions du sondage
// - errorMessage (ref<string>) : message d'erreur affiché en cas d'échec API
// - currentPage (ref<number>) : page courante de la pagination
// - tablePerPage (ref<number>) : nombre de réponses par page
//
// Méthodes :
// - totalPages (computed) : nombre total de pages pour la pagination
// - paginatedTable (computed) : sous-ensemble des réponses à afficher sur la page courante
// - goToPage (fonction) : change la page courante si la page demandée est valide
// - fetchQuestions (async) : récupère la liste des questions via l'API
// - fetchResponses (async) : récupère la liste des réponses via l'API
// -----------------------------------------------------------------------------

// Importation des librairies tierces et utilitaires
import axios from '@/utilities/axios.js' // Instance Axios personnalisée
import { ref, onMounted, computed } from 'vue'; // API de réactivité et hooks Vue 3
import { getAccessToken } from '@/utilities/utils'; // Fonction utilitaire pour le token
//import Carousel from './Carousel.vue'; // (optionnel, non utilisé ici)

// Responses : ref<Array> - liste des réponses utilisateurs
const Responses = ref([]);
// Questions : ref<Array> - liste des questions du sondage
const Questions = ref([]);
// errorMessage : ref<string> - message d'erreur pour affichage utilisateur
const errorMessage = ref('');
// currentPage : ref<number> - page courante de la pagination
const currentPage = ref(1);
// tablePerPage : ref<number> - nombre de réponses par page
const tablePerPage = ref(3);

/*
// OpenDetail : ref<boolean> - état d'ouverture du détail d'une réponse
const OpenDetail = ref(false);
// selectedResponse : ref<object|null> - réponse sélectionnée pour le détail
const selectedResponse = ref(null);
// handleOpenDetail : fonction pour ouvrir le détail d'une réponse
function handleOpenDetail(response) {
  selectedResponse.value = response;
  OpenDetail.value = true;
}
*/

// totalPages : computed<number> - nombre total de pages pour la pagination
const totalPages = computed(() => {
  return Math.ceil(Responses.value.length/tablePerPage.value);
});

// paginatedTable : computed<Array> - sous-ensemble des réponses à afficher
const paginatedTable = computed(() => {
  const start = (currentPage.value - 1) * tablePerPage.value;
  const end = start + tablePerPage.value;
  return Responses.value.slice(start, end);
});

// goToPage : fonction pour changer de page
// - page : number - numéro de la page à afficher
const goToPage = (page) => {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page;
  }
}

/**
 * Récupère la liste des questions depuis l'API
 * et met à jour l'état local des Questions.
 */
const fetchQuestions = async () => {
  try {
    errorMessage.value = '';
    const res = await axios.get('/admin/survey/questions', {
      headers: { Authorization: 'Bearer ' + getAccessToken() }
    });
    Questions.value = res.data.data;
    //console.log(Questions.value);
  }catch(e){
    console.error('Erreur lors de la récupération des questions: ', e);
    errorMessage.value = 'Erreur lors de la récupération des questions:';
    alert(errorMessage.value);
  }
}

/**
 * Récupère la liste des réponses depuis l'API
 * et met à jour l'état local des Responses.
 */
const fetchResponses = async () => {
  try {
    errorMessage.value = '';
    const response = await axios.get('/admin/answers/all', {
      headers: { Authorization: 'Bearer ' + getAccessToken() }
    });
    Responses.value = Object.values(response.data.DataAnswersQuestion); //Object.value permet de transformer le proxyObject en tableau d'objets
    //console.log(Responses.value);
  }catch(e){
    console.error('Erreur lors de la récupération des réponses: ', e);
    errorMessage.value = 'Erreur lors de la récupération des réponses:';
    alert(errorMessage.value);
  }
}

// Récupération des questions et réponses au montage du composant
onMounted(fetchQuestions);
onMounted(fetchResponses);
</script>

<template>
<!-- -------------------------------------------------------------------------
    Composant : Response (template)
    - Type : Fonctionnel
    - Rôle : Affiche les réponses utilisateurs sous forme de tableau paginé
    - Librairies tierces utilisées :
      - v-for (Vue) : itération sur les réponses et questions
      - v-if (Vue) : affichage conditionnel du tableau
      - :disabled (Vue) : désactivation des boutons selon l'état
      - @click (Vue) : gestion des clics sur les boutons de pagination
  ------------------------------------------------------------------------- -->
  <section class="Response">
    <!--
      Composant : Article (ResponseTitle)
      - Type : Structurel
      - Rôle : Affiche le titre de la section et une séparation
    -->
    <article class="ResponseTitle">
      <h2>Réponses des Utilisateurs</h2>
      <hr>
    </article>

    <!--
      Bloc d'affichage du tableau paginé
      - v-if : Affiche le tableau seulement si paginatedTable contient des données
    -->
    <div v-if="paginatedTable.length > 0">
      <!--
        Composant : Article (ResponseContent)
        - Type : Structurel
        - v-for : Parcourt chaque objet réponse paginée (R)
        - Paramètres :
          - R : Objet - Réponses pour un utilisateur
          - i : Number - Index de la réponse dans la page
        - Rôle : Affiche un tableau des réponses pour chaque utilisateur
      -->
      <article class="ResponseContent" v-for="(R, i) in paginatedTable" :key="i">
        <!--
          Composant : Table
          - Type : Structurel
          - Rôle : Affiche les questions et réponses associées
        -->
        <table>
          <thead>
            <tr>
              <td>N°</td> <!-- Colonne : Numéro de la question (Q.id) -->
              <td>Corps de la question</td> <!-- Colonne : Texte de la question (Q.body) -->
              <td>Response</td> <!-- Colonne : Réponse de l'utilisateur (R[Q.id][0]) -->
            </tr>
          </thead>
          <tbody>
            <!--
              v-for : Parcourt chaque question (Q)
              - Q : Objet - Question du sondage
              - Q.id : Number - Identifiant unique de la question
              - Q.body : String - Texte de la question
              - R[Q.id][0] : String - Réponse de l'utilisateur à la question Q
            -->
            <tr v-for="Q in Questions" :key="Q.id">
              <td> {{ Q.id }} </td>
              <td> {{ Q.body }} </td>
              <td>
                {{
                  R[Q.id][0]
                }}
              </td>
            </tr>
          </tbody>
        </table>
      </article>

      <!--
        Section : ButtonSection
        - Type : Structurel
        - Rôle : Affiche les boutons de pagination
        - Composants enfants :
          - Bouton "Précédent"
            - Type : Bouton de navigation
            - Props :
              - :disabled : Boolean - désactivé si on est à la première page
              - @click : Fonction - appelle goToPage(currentPage - 1)
          - Bouton "Suivant"
            - Type : Bouton de navigation
            - Props :
              - :disabled : Boolean - désactivé si on est à la dernière page
              - @click : Fonction - appelle goToPage(currentPage + 1)
      -->
      <section class="ButtonSection">
        <button :disabled="currentPage === 1" type="button" @click="goToPage(currentPage - 1)">Précédent</button>
        <button :disabled="currentPage === totalPages" type="button" @click="goToPage(currentPage + 1)">Suivant</button>
      </section>
    </div>
  </section>
</template>

<style scoped>
.Response {
  /*border: 1px solid white;*/
  width: 68vw;
  padding: 40px 0px;
}

.ResponseTitle h2 {
  color: #00b8ff;
  font-weight: bold;
  margin-bottom: 10px;
  font-size: 1.8rem;
}

.ResponseTitle hr {
  border: 1px solid #00b8ff;
  width: 100%;
}

.DetailShadow {
  position: absolute;
  z-index: 100;
  background: rgba(0, 0, 0, 0.7);
  width: 100%;
  height: 100vh;
  left: 0;
  top: 0;
  display: flex;
  justify-content: center;
  align-items: center;
}

.DetailResponse{
  overflow-y: scroll;
  width: 60%;
  height: 500px;
  background: #1e1e1e;
  border: 1px solid #2c2c2c;
  border-radius: 12px;
  padding: 30px;
}

.DetailHeader {
  display: flex;
  justify-content: space-between;
}

.DetailHeader .DetailTitle h2 {
  color: #00b8ff;
  font-size: 1.7rem;
}

.DetailHeader .DetailTitle span {
  color: #fff;
}

.DetailHeader button {
  width: 20px;
  height: 20px;
  margin-right: 30px;
  font-size: 2rem;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  background: transparent;
  border: 0px;
  color: #bebebe;
  cursor: pointer;
}

.DetailHeader button:hover {
  color: #00b8ff;
}

/* Pour les détalls des réponses afficher en survol */

.DetailResponse hr {
  margin-top: 20px;
  border: 1px solid #2c2c2c;
}

.DetailResponse table {
  /*border: 1px solid #2c2c2c;*/
  margin-top: 30px;
  width: 100%;
}

.DetailResponse td {
  border-bottom: 1px solid #2c2c2c;
  padding: 10px 0px;
}

.DetailResponse td:nth-child(1) {
  color: #bebebe;
}

.DetailResponse td:nth-child(2) {
  color: #fff;
  font-weight: bold;
  text-align: end;
}

/* Pour le carousel */

.ResponseContent {
  /*border: 1px solid #fff;*/
  width: 100%;
  height:265px;
  display: flex;
  margin-top: 50px;
  overflow-y: scroll;
}

.ResponseCard {
  /*border: 1px solid white;*/
  width: 40%;
  padding: 70px 30px;
  text-align: center;
  color: #bebebe;
  background-color: #1e1e1e;
  border: 1px solid #2c2c2c;
  border-radius: 12px;
  cursor: pointer;
  transform: translateZ(-200px) rotateY(30deg);
  transition: transform 0.5s ease-out, box-shadow 0.3s;
}

.ResponseCard:hover {
  transform: translateZ(150px) rotateY(0deg) scale(1.05);
  box-shadow: 0 10px 20px rgba(0, 184, 255, 0.2);
}

.ResponseCardContainer {
  border: 1px solid #fff;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  overflow-x: hidden;
  perspective: 1000px;
  transform-style: preserve-3d;
}

.ResponseCardContainer:hover .ResponseCard {
  transform: translateZ(150px) rotateX(5deg) rotateY(-5deg) scale(1.05);
}

.ResponseCardEmail {
  font-size: 1.4rem;
  margin-bottom: 20px;
  color: #00b8ff;
  font-weight: bold;
}

.ResponseCardDate {
  font-size: 1.1rem;
  font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
}

.ResponseCardDate p {
  font-size: 1rem;
  margin-top: 15px;
  font-weight: bold;
}

.ResponseButtonNavigation button {
  position: absolute;
  z-index: 2;
  background: transparent;
  border: none;
  color: #00b8ff;
  font-weight: bold;
  font-size: 3rem;
  top: 48%;
  transition: all 0.3s;
}

.ResponseButtonNavigation button:hover {
  text-shadow: 0px 0px 10px rgba(10, 184, 255, 1);
  cursor: pointer;
  transform: scale(1.3);
}

.left-button {
  margin-left: -30%;
}

.right-button {
  right: 8%;
}

/* Style du tableau des sondés */

table {
  width: 100%;
  /*border: 1px solid white;*/
  margin-top: 0px;
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

tbody td:nth-child(3) {
  width: 35%;
}

/*tbody td:nth-child(2) {
  background: #2c2c2c;
}*/

/* Pour les boutons de navigation */
.ButtonSection {
  /*border: 1px solid white;*/
  width: 40%;
  margin: 45px auto 0px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.ButtonSection button {
  background-color: #2c2c2c;
  padding: 10px 10px;
  width: 40%;
  text-align: center;
  border: none;
  border-radius: 8px;
  font-weight: 700;
  font-size: 1rem;
  color: #b3b3b3;
      transition: all 0.4s;
    }

.ButtonSection button:hover {
  cursor: pointer;
  background-color: #00b8ff;
  color: #fff;
  cursor: pointer;
}

.ButtonSection button:disabled {
  cursor: not-allowed;
  background-color: #1e1e1e;
  color: grey;
}

@media (max-width: 480px) {

  .Response {
    /*border: 1px solid white;*/
    width: 80vw;
    padding: 40px 0px;
  }

  .ButtonSection {
    width: 100%;
    margin: auto;
    justify-content: space-around;
    margin-top: 30px;
   }
  
  .ButtonSection button {
    padding: 10px 10px;
    width: 120px;
  }

  /*tbody td:nth-child(2) {
    width: 50%;
  }*/
}
</style>

