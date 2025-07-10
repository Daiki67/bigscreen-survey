<script setup>
import axios from '@/utilities/axios.js';
import { onMounted, ref, watch } from 'vue';
import { useRouter } from 'vue-router';
import { getUrlToken } from '@/utilities/utils.js' ;

const openModal = ref(false);
const errorMessage = ref('');
const Questions = ref([]);
const answer = ref({});
const UrlToken = ref(null);
const accessUrl = ref(null);
const router = useRouter();


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

//Vérification de la validation de tous les champs
const validateAnswers = () => {
  //Boucle sur les 20 questions afin d'identifier un champ manquant
  for (let q of Questions.value) {
    if (!answer.value[q.id]) {
      errorMessage = 'Merci de répondre à toutes les questions';
      return false
    }
  }
  errorMessage = '';
  return true
};

watch(UrlToken, (newToken) => {

  if (newToken) {

    //Utilise le routeur VueJs pour générer l'URL
    accessUrl.value = router.resolve({
      name: 'answer',
      params: { token: newToken }
    }).href;

  }else {
    accessUrl.value = null;
  }

  return {
    UrlToken,
    accessUrl
  }

})

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

onMounted(fetchQuestions);

</script>

<template>
  <form @submit="SurveySubmitted">

    <section class="LogoContainer">
      <figure>
        <img src="" alt="">
      </figure>
      <div class="LogoContainerSpanDiv">
        <span>Merci de répondre à toutes les questions et de valider le formulaire en bas de page.</span>
      </div>
    </section>

    <section class="QuestionContainer">

      <article class="QuestionAnswer" v-for="Q in Questions" :key="Q.id">
        <div class="QuestionNumber"> {{ Q.title }} </div>
        <div class="QuestionBody"> {{ Q.body }} </div>

        <div class="QuestionRadioGroup" v-if="Q.type === 'A'">
          <div class="QuestionRadioOption" v-for="(item, index) in Q.options" :key="index"
            @click="answer[Q.id] = item"
          >
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
          <!-- <p>{{ answer[Q.id] }}</p> -->
        </div>

        <input
          type="email" v-if="Q.type === 'B' && Q.id === 1"
          :name="'answer.' + Q.id"
          placeholder="Votre adresse email ici ..."
          v-model="answer[Q.id]"
          required
        >
        <input
          type="text" v-if="Q.type === 'B' && Q.id !== 1"
          :name="'answer.' + Q.id"
          placeholder="Votre réponse ici ... "
          v-model="answer[Q.id]"
          required
        >

        <div class="QuestionRadioGroupSelect" v-if="Q.type === 'C'">
          <div class="QuestionRadioSelect">
            <div
              class="RadioCheckedDiv"
              v-for="n in Q.options"
              :key="n"
              :class="{ ischecked : answer[Q.id] >= n }"
            >
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

    <section class="SubmitButtonSection">
      <button type="submit">Finaliser</button>
    </section>

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
          <button @click="openModal = false"><a :href="accessUrl">{{ accessUrl }}</a></button>
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
</style>
