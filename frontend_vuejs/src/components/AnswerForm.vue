<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';

const props = defineProps(['token']);

const PersonalAnswer = ref([]);
const errorMessage = ref('');

const fetchUserAnswer = async () => {
  try {
    errorMessage.value = '';
    const response = await axios.get(`http://localhost:8000/api/survey/result/${props.token}`);
    PersonalAnswer.value = response.data.submission.answers;
    //console.log(PersonalAnswer.value);
  } catch (e) {
    console.error ('Erreur de récupération de la réponse', e);
    errorMessage.value = "Erreur lors de la récupération des réponses de l'utilisateur";
    alert(errorMessage.value);
  }
};

onMounted(fetchUserAnswer);
</script>

<template>
  <!-- -------------------------------------------------------------------------- -->
  <!-- Composant : AnswerForm                                                    -->
  <!-- Type : Composant Vue 3 (formulaire de consultation)                       -->
  <!-- Rôle : Affiche les réponses d’un utilisateur à un sondage                 -->
  <!-- Props :
         - token : String - Token d’accès unique (récupéré via defineProps)
  -->
  <!-- État local :
         - PersonalAnswer : Array<Object> - Réponses de l’utilisateur
         - errorMessage : String - Message d’erreur
  -->
  <!-- Librairies tierces utilisées :
         - axios : requêtes HTTP (récupération des réponses)
         - vue : ref, onMounted
  -->
  <!-- -------------------------------------------------------------------------- -->
  <form>
    <!-- Section : LogoContainer (présentation du logo et du message d’intro) -->
    <section class="LogoContainer">
      <figure>
        <h1>bigscreen</h1>
      </figure>
      <div class="LogoContainerSpanDiv">
        <span>Nous vous remercions d'avoir eu à répondre à ce formulaire. Voici vos réponses.</span>
      </div>
    </section>

    <!-- Section : QuestionContainer (liste des réponses) -->
    <section class="QuestionContainer">
      <!-- Pour chaque réponse (ans) de PersonalAnswer -->
      <article class="QuestionAnswer" v-for="ans in PersonalAnswer" :key="ans.id">
        <!-- Titre de la question -->
        <div class="QuestionNumber"> {{ ans.question.title }} </div>
        <!-- Corps/texte de la question -->
        <div class="QuestionBody"> {{ ans.question.body }} </div>

        <!--
          Composant : input (text)
          - Type : Champ texte désactivé
          - Props :
            - type : 'text'
            - v-if : ans.question.type === 'B'
            - value : String - Réponse saisie
            - disabled : Champ non modifiable
        -->
        <input type="text" v-if="ans.question.type === 'B'" :value='ans.value' disabled>

        <!--
          Groupe radio pour type A (réponse unique)
          - ans.question.type === 'A'
          - Affiche la valeur sélectionnée
        -->
        <div v-if="ans.question.type === 'A'" class="QuestionRadioGroup">
          <div class="QuestionRadioOption">
            <!--
              Composant : input (radio)
              - Type : Champ radio désactivé et coché
              - Props :
                - type : 'radio'
                - checked : Toujours coché
                - disabled : Toujours désactivé
            -->
            <input
              type="radio"
              checked
              disabled
            >
            <span> {{ ans.value }} </span>
          </div>
        </div>

        <!--
          Groupe radio pour type C (notation ou échelle)
          - ans.question.type === 'C'
          - Affiche une série de boutons radio désactivés
        -->
        <div v-if="ans.question.type === 'C'" class="QuestionRadioGroupSelect">
          <div class="QuestionRadioSelect">
            <!-- Pour chaque valeur de 1 à 5 (notation) -->
            <div class="RadioSelectedDiv" v-for="n in 5" :key="n">
              <!--
                Composant : input (radio)
                - Type : Champ radio désactivé
                - Props :
                  - type : 'radio'
                  - name : String unique par question et valeur
                  - value : Number
                  - checked : Sélectionné si ans.value >= n
              -->
              <input
                type="radio"
                :name="'number' + n + ans.question.id"
                :value='n'
                :checked="Number(ans.value) === n || Number(ans.value) >= n"
              >
              <span></span>
            </div>
          </div>
          <p>{{ Number(ans.value) }}</p>
        </div>
        <hr>
      </article>
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
    font-size: 1.1rem;
    margin: 20px 0px ;
  }

  .QuestionNumber {
    color: #00b8ff;
    font-weight: 700;
  }

  .QuestionBody {
    color: #ffffff;
    font-weight: 500;
  }

  .QuestionAnswer input[type = 'text'] {
    width: 97%;
    padding: 12px 15px;
    margin: 40px 0px;
    background-color: #121212;
    border: 1px solid #2c2c2c;
    border-radius: 6px;
    color: #ffffff;
    font-size: 1rem;
    border-style: dotted;
    border-width: 2px;
    border-color: #00b8ff;
  }

  /* Pour les réponses aux types C */
   .QuestionRadioGroup {
    /*border: 1px solid white;*/
    margin: 30px 0px;
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

  .QuestionRadioOption span::after {
    content: '';
    position: absolute;
    left: 6px;
    top: 6px;
    width: 12px;
    height: 12px;
    background-color: #00b8ff;
    border-radius:50%;
  }

  /*.QuestionRadioSelect span::after {
    left: 0;
    top: 0;
    width: 23px;
    height: 23px;
    background-color: red;
  }*/

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
    transform: scale(1);
    transition:transform 0.4s;
  }

  .QuestionRadioSelect input[type = 'radio']:checked + span::after {
    left: 0;
    top: 0;
    width: 23px;
    height: 23px;
  }

  /*.RadioSelectedDiv {
    display: flex;
  }*/

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
