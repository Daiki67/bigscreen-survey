<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { getUrlToken } from '@/utilities/utils.js';

const PersonalAnswer = ref([]);
//const RadioNumber = ref(0);
const errorMessage = ref('');

const fetchUserAnswer = async () => {
  try {
    errorMessage.value = '';
    const response = await axios.get(`http://localhost:8000/api/survey/result/${getUrlToken()}`);
    PersonalAnswer.value = response.data.submission.answers;
    //RadioNumber.value = PersonalAnswer.value;
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
  <form>

    <section class="LogoContainer">
      <figure>
        <img src="" alt="">
      </figure>
      <div class="LogoContainerSpanDiv">
        <span>Nous vous remercions d'avoir eu à répondre à ce formulaire. Voici vos réponses.</span>
      </div>
    </section>

    <section class="QuestionContainer">

      <article class="QuestionAnswer" v-for="ans in PersonalAnswer" :key="ans.id">
        <div class="QuestionNumber"> {{ ans.question.title }} </div>
        <div class="QuestionBody"> {{ ans.question.body }} </div>
        <input type="text" v-if="ans.question.type === 'B'" :value='ans.value' disabled>

        <!-- Div pour les réponses concernant la question B -->
        <div v-if="ans.question.type === 'A'" class="QuestionRadioGroup">
          <div class="QuestionRadioOption">
          <input
          type="radio"
          name="gender"
          value="Homme"
          checked
          disabled
          >
          <span> {{ ans.value }} </span>
          </div>
        </div>

        <!-- Div contenant les input pour la réponse aux question de type C -->
         <div class="QuestionRadioGroupSelect">
          <div v-if="ans.question.type === 'C'" class="QuestionRadioSelect">
          <input
          type="radio"
          name="number1"
          value=1
          :checked="RadioNumber >= 1"
          >
          <span></span>
            <input
              type="radio"
              name="number2"
              value=2
              :checked="RadioNumber >= 2"
            >
            <span></span>
            <input
              type="radio"
              name="number3"
              value=3
              :checked="RadioNumber >= 3"
            >
            <span></span>
            <input
              type="radio"
              name="number4"
              value=4
              :checked="RadioNumber >= 4"
            >
            <span></span>
            <input
              type="radio"
              name="number5"
              value=5
              :checked="RadioNumber >= 5"
            >
            <span></span>
          </div>
          <p>{{ RadioNumber }}</p>
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
    align-items: center;
    justify-content: space-between;
    width: 80%;
    height: 280px;
    text-align: center;
  }

  .LogoContainer figure {
    border: 1px solid green;
    width: 35%;
    height: 80%;
  }

  .LogoContainerSpanDiv {
    color: #b3b3b3;
    font-size: 1rem;
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
    transform: scale(1);
    transition:transform 0.4s;
  }

  .QuestionRadioSelect input[type = 'radio']:checked + span::after {
    left: 0;
    top: 0;
    width: 23px;
    height: 23px;
  }
</style>
