<script setup>
// -----------------------------------------------------------------------------
// Composant : SurveyForm
// Type : Vue 3 - Composant de formulaire (Composition API, <script setup>)
// Rôle : Affiche le formulaire de sondage, gère la récupération des questions,
//        la validation des réponses et la soumission du formulaire.
// Librairies tierces utilisées :
//   - axios (import '@/utilities/axios.js')
//       Type : AxiosInstance
//       Usage : Requêtes HTTP pour récupérer et envoyer les données du sondage
//   - vue (import { onMounted, ref, watch } from 'vue')
//       Type : Framework réactif
//       Usage :
//         - ref : création de variables réactives
//         - onMounted : hook d’exécution au montage du composant
//         - watch : surveillance de variables réactives
//   - vue-router (import { useRouter } from 'vue-router')
//       Type : Gestionnaire de navigation SPA
//       Usage : useRouter pour la navigation et la génération d’URL
// -----------------------------------------------------------------------------

// Import de l’instance Axios personnalisée pour les requêtes HTTP
import axios from '@/utilities/axios.js'; // Type : AxiosInstance
// Import des fonctions de Vue pour la réactivité et les hooks
import { onMounted, ref, watch } from 'vue'; // ref<T>, onMounted(fn), watch(source, cb)
// Import du composable useRouter pour la navigation
import { useRouter } from 'vue-router'; // Type : () => Router

// -----------------------------------------------------------------------------
// État local (variables réactives)
// -----------------------------------------------------------------------------
// openModal : Ref<boolean> - Affiche ou masque la modal de confirmation
const openModal = ref(false);
// errorMessage : Ref<string> - Message d’erreur affiché à l’utilisateur
const errorMessage = ref('');
// Questions : Ref<Array> - Liste des questions du sondage
const Questions = ref([]);
// answer : Ref<Object> - Réponses de l’utilisateur, indexées par id de question
const answer = ref({});
// UrlToken : Ref<string|null> - Token d’accès généré après soumission
const UrlToken = ref(null);
// accessUrl : Ref<string|null> - URL d’accès générée pour consulter les réponses
const accessUrl = ref(null);
// router : Router - Instance du routeur Vue pour la navigation
const router = useRouter();

// -----------------------------------------------------------------------------
// Méthodes principales
// -----------------------------------------------------------------------------
/**
 * fetchQuestions
 * Type : Fonction asynchrone
 * Rôle : Récupère la liste des questions du sondage via l’API
 * Utilise : axios.get('/survey/question')
 */
const fetchQuestions = async () => {
  try {
    errorMessage.value = '';
    const response = await axios.get('/survey/question');
    Questions.value = response.data.data;
    //console.log(Questions.value);
  } catch (e) {
    console.error('Erreur de récupération des questions:', e);
    errorMessage.value = 'Erreur lors de la récupération des questions';
    alert(errorMessage.value);
  }
}

/**
 * validateAnswers
 * Type : Fonction
 * Rôle : Vérifie que toutes les questions ont une réponse
 * Retour : boolean (true si toutes les réponses sont présentes)
 */
const validateAnswers = () => {
  // Boucle sur les questions pour identifier un champ manquant
  for (const q of Questions.value) {
    if (!answer.value[q.id]) {
      errorMessage.value = 'Merci de répondre à toutes les questions';
      return false
    }
  }
  errorMessage.value = '';
  return true
};

// -----------------------------------------------------------------------------
// Surveillance du token d’accès pour générer l’URL de consultation
// -----------------------------------------------------------------------------
watch(UrlToken, (newToken) => {
  if (newToken) {
    // Utilise le routeur VueJs pour générer l’URL
    accessUrl.value = router.resolve({
      name: 'answer',
      params: { token: newToken }
    }).href;
  } else {
    accessUrl.value = null;
  }
  return {
    UrlToken,
    accessUrl
  }
})

/**
 * SurveySubmitted
 * Type : Fonction asynchrone
 * Rôle : Soumet les réponses du formulaire à l’API
 * Paramètres :
 *   - e : Event - Événement de soumission du formulaire
 * Utilise :
 *   - axios.post('/survey/store', { answer })
 *   - Affiche la modal de confirmation en cas de succès
 */
const SurveySubmitted = async(e) => {
  e.preventDefault();
  if (!validateAnswers) return;
  try {
    errorMessage.value = '';
    const response = await axios.post('/survey/store', {
      answer: answer.value
    });
    UrlToken.value = response.data.urlToken
    openModal.value = true;
  } catch (e) {
    console.error('Erreur lors de la sauvegarde des réponses du formulaire:', e);
    errorMessage.value = 'Erreur survenue lors de la sauvegarde des réponses du formulaire';
    alert(errorMessage.value);
  }
};

// -----------------------------------------------------------------------------
// Hook d’exécution au montage du composant
// -----------------------------------------------------------------------------
onMounted(fetchQuestions);
</script>

<template>
  <!-- -------------------------------------------------------------------------- -->
  <!-- Composant : SurveyForm                                                    -->
  <!-- Type : Composant Vue 3 (formulaire)                                       -->
  <!-- Rôle : Affiche le formulaire de sondage, gère la saisie et la soumission  -->
  <!-- Méthode principale : SurveySubmitted (soumission du formulaire)           -->
  <!-- État local : openModal, errorMessage, Questions, answer, UrlToken, accessUrl -->
  <!-- Librairies tierces utilisées :                                            -->
  <!--   - axios : requêtes HTTP                                                 -->
  <!--   - vue : ref, onMounted, watch                                           -->
  <!--   - vue-router : useRouter                                                -->
  <!-- -------------------------------------------------------------------------- -->
  <form @submit="SurveySubmitted">

    <!--
      Section : LogoContainer
      - Type : Section de présentation
      - Contenu :
        - figure : Affiche le logo principal (texte "bigscreen")
        - LogoContainerSpanDiv : Message d’introduction
    -->
    <section class="LogoContainer">
      <figure>
        <h1>bigscreen</h1>
      </figure>
      <div class="LogoContainerSpanDiv">
        <span>Merci de répondre à toutes les questions et de valider le formulaire en bas de page.</span>
      </div>
    </section>

    <!--
      Section : QuestionContainer
      - Type : Section principale
      - Rôle : Affiche la liste des questions du sondage
      - Source : Questions (Array)
      - Pour chaque question (Q) :
        - Q.id : identifiant unique (Number)
        - Q.title : titre de la question (String)
        - Q.body : texte de la question (String)
        - Q.type : type de question ('A', 'B', 'C')
        - Q.options : options de réponse (Array, si applicable)
    -->
    <section class="QuestionContainer">
      <!-- Pour chaque question (Q) de Questions -->
      <article class="QuestionAnswer" v-for="Q in Questions" :key="Q.id">
        <!-- Titre de la question (Q.title : String) -->
        <div class="QuestionNumber"> {{ Q.title }} </div>
        <!-- Corps/texte de la question (Q.body : String) -->
        <div class="QuestionBody"> {{ Q.body }} </div>

        <!--
          Groupe de boutons radio (type A)
          - Q.type === 'A'
          - Q.options : Array d’options (String)
          - answer[Q.id] : valeur sélectionnée (String)
        -->
        <div class="QuestionRadioGroup" v-if="Q.type === 'A'">
          <!-- Pour chaque option (item) de Q.options (Array<String>) -->
          <div class="QuestionRadioOption" v-for="(item, index) in Q.options" :key="index"
            @click="answer[Q.id] = item"
          >
            <!--
              Composant : input (radio)
              - Type : Champ de sélection unique
              - Props :
                - type : 'radio'
                - name : String - Nom unique par question (ex: 'answer.1')
                - value : String - Valeur de l’option
                - v-model : Liaison bidirectionnelle avec answer[Q.id]
                - checked : Boolean - État sélectionné
                - required : Champ obligatoire
            -->
            <input
              type="radio"
              :name="'answer.'+ Q.id"
              :value="item"
              v-model="answer[Q.id]"
              :checked="answer[Q.id] === item"
              required
            >
            <span> {{ item }} </span>
          </div>
        </div>

        <!--
          Composant : input (email)
          - Type : Champ de saisie email
          - Props :
            - type : 'email'
            - v-if : Q.type === 'B' && Q.id === 1
            - name : String - Nom unique par question
            - placeholder : String
            - v-model : Liaison avec answer[Q.id]
            - required : Champ obligatoire
        -->
        <input
          type="email" v-if="Q.type === 'B' && Q.id === 1"
          :name="'answer.' + Q.id"
          placeholder="Votre adresse email ici ..."
          v-model="answer[Q.id]"
          required
        >
        <!--
          Composant : input (text)
          - Type : Champ de saisie texte
          - Props :
            - type : 'text'
            - v-if : Q.type === 'B' && Q.id !== 1 && Q.id !== 2
            - name : String
            - placeholder : String
            - v-model : Liaison avec answer[Q.id]
            - required : Champ obligatoire
        -->
        <input
          type="text" v-if="Q.type === 'B' && Q.id !== 1 && Q.id !== 2"
          :name="'answer.' + Q.id"
          placeholder="Votre réponse ici ... "
          v-model="answer[Q.id]"
          required
        >
        <!--
          Composant : input (number)
          - Type : Champ de saisie numérique
          - Props :
            - type : 'number'
            - v-if : Q.type === 'B' && Q.id === 2
            - min : 18
            - max : 90
            - placeholder : String
            - name : String
            - v-model : Liaison avec answer[Q.id]
            - required : Champ obligatoire
        -->
        <input
          type="number" v-if="Q.type === 'B' && Q.id === 2"
          min="18"
          max="90"
          placeholder="Votre âge ici ..."
          :name="'answer.' + Q.id"
          v-model="answer[Q.id]"
          required
        >

        <!--
          Groupe de sélection radio (type C)
          - Q.type === 'C'
          - Q.options : Array d’options (Number)
          - answer[Q.id] : valeur sélectionnée (Number)
        -->
        <div class="QuestionRadioGroupSelect" v-if="Q.type === 'C'">
          <div class="QuestionRadioSelect">
            <!-- Pour chaque option (n) de Q.options (Array<Number>) -->
            <div
              class="RadioCheckedDiv"
              v-for="n in Q.options"
              :key="n"
              :class="{ ischecked : answer[Q.id] >= n }"
            >
              <!--
                Composant : input (radio)
                - Type : Champ de sélection unique
                - Props :
                  - type : 'radio'
                  - name : String - Nom unique par question
                  - value : Number
                  - v-model : Liaison avec answer[Q.id]
              -->
              <input
                type="radio"
                :name="'answer.'+ Q.id"
                :value='n'
                v-model="answer[Q.id]"
              >
              <span></span>
            </div>
          </div>
          <p> {{ answer[Q.id] }} </p>
        </div>

        <hr>
      </article>

    </section>

    <!--
      Section : SubmitButtonSection
      - Type : Section de soumission
      - Contenu :
        - button : Bouton de soumission du formulaire
    -->
    <section class="SubmitButtonSection">
      <button type="submit">Finaliser</button>
    </section>

    <!--
      Section : Modal de confirmation
      - Type : Section affichée conditionnellement (openModal)
      - Contenu :
        - modal-overlay : Fond semi-transparent
        - modal-content : Contenu de la modal
          - h1 : Titre de remerciement
          - p : Message de confirmation et lien d’accès
          - button : Bouton de fermeture et lien vers l’URL d’accès
    -->
    <section>
      <div v-if="openModal" class="modal-overlay">
        <div class="modal-content">
          <h1>Merci pour votre engagement !</h1>
          <p>
            Toute l’équipe de Bigscreen vous remercie. Grâce à votre investissement, nous vous préparons une application toujours plus facile à utiliser,
             seul ou en famille.
             <br>
             <br>
              Si vous désirez consulter vos réponse ultérieurement, voici votre lien unique :
          </p>
          <button @click="openModal = false"><a :href="accessUrl">http://localhost:5173/{{ accessUrl }}</a></button>
        </div>
      </div>
    </section>

  </form>
</template>

<style scoped>
  form {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 70%;
    height: auto;
    background-color: #1e1e1e;
    border-radius: 12px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
  }

  /*Pour le bloc logo*/
  .LogoContainer {
    /*border: 1px solid white;*/
    display: flex;
    flex-direction: column;
    align-items: start;
    justify-content: space-between;
    width: 97%;
    height: 180px;
    text-align: left;
  }

  .LogoContainer figure {
    /*border: 1px solid green;*/
    width: 35%;
    height: 20%;
    color: #fff;
    font-size: 2.5rem;
  }

  .LogoContainerSpanDiv {
    /*border: 1px solid white;*/
    color: #b3b3b3;
    font-size: 1.2rem;
  }

  /*Pour le bloc des questions*/
  .QuestionContainer {
    /*border: 1px solid white;*/
    width: 98%;
    display: flex;
    flex-direction: column;
    height: auto;
    margin: 30px 0px ;
  }

  .QuestionContainer hr {
    border: 1px solid #2c2c2c;
  }

  .QuestionAnswer {
    width: 100%;
    height: auto;
    font-size: 1.4rem;
    margin: 20px 0px ;
  }

  .QuestionNumber {
    color: #00b8ff;
    font-weight: 700;
  }

  .QuestionBody {
    color: #ffffff;
    font-weight: 500;
    margin: 15px 0 0 0px;
    font-size: 1.2rem;
  }

  .QuestionAnswer input[type = 'text'],
  .QuestionAnswer input[type = 'number'],
  .QuestionAnswer input[type = 'email'] {
    width: 97%;
    padding: 12px 15px;
    margin: 25px 0px;
    background-color: #121212;
    border: 1px solid #2c2c2c;
    border-radius: 6px;
    color: #ffffff;
    font-size: 1rem;
    border-style: dotted;
    border-width: 2px;
    border-color: #00b8ff
  }

  .QuestionAnswer input[type = 'text']:focus,
  .QuestionAnswer input[type = 'number']:focus,
  .QuestionAnswer input[type = 'email']:focus {
    outline: none;
    border-style:double;
    border-color: #00b8ff;
    transition: border-color 0.4s;
  }

  .QuestionRadioGroup {
    /*border: 1px solid white;*/
    margin: 25px 0px;
  }

  .QuestionRadioOption,
  .QuestionRadioSelect {
    margin: 25px 0px;
    padding: 12px 0px 12px 10px;
    border-radius: 6px;
    font-size: 1.1rem;
    color: #ffffff;
    border-style: dotted;
    border-width: 2px;
    border-color: #00b8ff
  }

  .QuestionRadioSelect {
    display: flex;
  }

  .QuestionRadioOption:hover {
    background-color: #2c2c2c;
    transition: 0.3s;
    cursor: pointer;
  }

  .QuestionRadioOption:first-of-type {
    margin-top: 0px;
  }

  .QuestionRadioOption:last-of-type {
    margin-bottom: 0px;
  }

  .QuestionRadioOption input[type = 'radio'],
  .QuestionRadioSelect input[type = 'radio'] {
    position: absolute;
    display: none;
    opacity: 0;
    width: 0;
    height:0;
  }

  /*.QuestionRadioOption input[type = 'radio'],*/
  .QuestionRadioSelect input[type = 'radio'] {
    cursor: pointer;
    position: absolute;
    opacity: 0;
    z-index: 2;
    display: flex;
    width: 25px;
    height: 25px;
  }

  .QuestionRadioOption span,
  .QuestionRadioSelect span {
    position: relative;
    padding-left: 35px;
    display: inline-block;
    line-height: 25px;
    transition: background-color 0.3s;
  }

  .QuestionRadioSelect span {
    margin-bottom: 20px;
    cursor: pointer;
  }

  .QuestionRadioOption span::before,
  .QuestionRadioSelect span::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 20px;
    height: 20px;
    border: 2px solid #00b8ff;
    border-radius: 50%;
    transition: border-color 0.3s ease;
  }
  .QuestionRadioSelect span::before {
    border: 2px solid #2c2c2c;
    background-color: #2c2c2c;
  }

  .QuestionRadioOption span::after,
  .QuestionRadioSelect span::after {
    content: '';
    position: absolute;
    left: 6px;
    top: 6px;
    width: 12px;
    height: 12px;
    background-color: #00b8ff;
    border-radius:50%;
    transform: scale(0);
    transition: transform 0.4s;
  }

  .QuestionRadioSelect span::after {
    left: 0;
    top: 0;
    width: 23px;
    height: 23px;
    background-color: red;
  }

  .QuestionRadioOption input[type = 'radio']:checked + span::after,
  .QuestionRadioSelect input[type = 'radio']:checked + span::after {
    content: '';
    position: absolute;
    left: 6px;
    top: 6px;
    width: 12px;
    height: 12px;
    background-color: #00b8ff;
    border-radius:50%;
    transform: scale(1.05);
    transition:transform 0.4s;
  }

  .QuestionRadioSelect input[type = 'radio']:checked + span::after {
    left: 0;
    top: 0;
    width: 23px;
    height: 23px;
  }

  .QuestionRadioGroupSelect {
    display: flex;
    align-items: center;
  }

  .QuestionRadioGroupSelect p {
    display: inline-flex;
    /*border: 1px solid white;*/
    height: auto;
    margin: 0px 0px 0px 20px;
    color: #00b8ff;
    font-family: 'Times New Roman', Times, serif;
    font-size: 2rem;
  }

  /*Pour le bloc du bouton*/
  .SubmitButtonSection {
    /*border: 1px solid white;*/
    width: 100%;
    height: auto;
    margin-top: 30px;
  }

  .SubmitButtonSection button {
    background-color: #00b8ff;
    color: #121212;
    border: none;
    border-radius: 8px;
    width: 30%;
    margin-left: 70%;
    padding: 10px 0px;
    font-size: 1.2rem;
    font-weight: bold;
    cursor: pointer;
  }

  /*Pour le teleport, modal*/
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background-color: rgba(0, 0, 0, 0.6);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }

  .modal-content {
    background-color: #1e1e1e;
    padding: 50px;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0,0,0, 0.1);
    border: 1px solid #00b8ff;
    max-width: 500px;
    width: 90%;
    text-align: center;
    color: #ffffff;

  }

  .modal-content h1 {
    margin-bottom: 40px;
    color: #00b8ff;
  }

  .modal-content button {
    background: none;
    border: none;
    margin-top: 20px;
    font-size: 1.2rem;
    color: #00b8ff;
    cursor: pointer;
  }

  .router-link{
    color: #00b8ff;
  }

  .RadioCheckedDiv {
    display: flex;
  }

  .ischecked span::after {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 23px;
    height: 23px;
    background-color: #00b8ff;
    border-radius:50%;
    transform: scale(1.05);
    transition:transform 0.4s;
  }

  @media (min-width: 320px) and (max-width: 426px) {

    form {
      padding: 30px 40px 30px 20px;
    }

   .SubmitButtonSection button {
    width: 100%;
    margin-left: 0;
   }  

   .QuestionContainer {
    width: 100%;
    margin: 0px;
   }

   .QuestionAnswer input[type = 'text'],
  .QuestionAnswer input[type = 'number'],
  .QuestionAnswer input[type = 'email'] {
    width: 90%;
  }

  }
</style>
